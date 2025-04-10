<?php

namespace App\Http\Controllers;

use App\Models\AskGeminiLog;
use App\Models\Conversation;
use App\Models\Note;
use Illuminate\Http\Request;
use App\Services\GeminiService;
use App\Services\BasePromptService;
use App\Services\NewEventGoogleCalendarService;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;



class GeminiController extends Controller
{

    protected $geminiService;
    protected $newEventService;

    public function __construct(GeminiService $geminiService, NewEventGoogleCalendarService $newEventService)
    {
        $this->geminiService = $geminiService;
        $this->newEventService = $newEventService;
    }


    public function index(Request $request) {

        $conversations = Conversation::where('user_id', Auth::id())->orderBy('created_at', 'desc')->limit(2)->get();

        return inertia::render('Gemini', [
            'conversation' => $conversations
        ]);

    }

    public function send(Request $request) {

        $validated = $request->validate([
            'question' => 'required',
        ]);

        Conversation::create([
            'message' => $request->question,
            'user_id' => Auth::id(),
            'is_ai' => false
        ]);

        // Send the request using the service
        $responseData = $this->geminiService->sendContent($request->question);
        $response = $responseData['text'];

        Conversation::create([
            'message' => $response,
            'user_id' => Auth::id(),
            'is_ai' => true,
        ]);

        return redirect()->route('gemini.index');
    }

    public function create() {
        return Inertia::render('AskGemini',
            [
                'logs' => AskGeminiLog::orderBy('created_at', 'desc')->get(),
                'notes' => Note::orderBy('created_at', 'desc')->get()
            ]);
    }

    public function store(BasePromptService $basePromptService, Request $request) {

        $validated = $request->validate([
            'question' => 'required',
        ]);

        // Send the request using the service
        $responseData = $this->geminiService->sendContent($basePromptService->getPrompt() . " " . $request->question);
        $response = $responseData['text'];

        $start = strpos($response, '{');
        $end = strpos($response, '}');
        $json = substr($response, $start, $end + 1 - $start);
        $responseArray = json_decode($json, true);
//dd($response, $start, $end, $json, json_decode($json, true));

        $responseType = $responseArray['type'];

        if($responseArray['type'] == 'note') {
            Note::create($responseArray);
        }
        if($responseArray['type'] == 'event') {
            $eventLink = $this->newEventService->createEvent(
                $responseArray['title'],
                $responseArray['description'],
                $responseArray['startAt'],
                $responseArray['endAt']);

            $json = $json . " Event link: " . $eventLink;
        }

        AskGeminiLog::create([
            'log_entry' => $request->question,
            'from_human' => true,
            'token_count' => $responseData['token_count'],
            'total_token_count' => $responseData['total_token_count'],
        ]);

        AskGeminiLog::create([
            'log_entry' => $json,
            'from_human' => false,
            'token_count' => $responseData['candidates_token_count'],
            'total_token_count' => $responseData['total_token_count'],
        ]);
        if($responseType == 'invalid') {
            return redirect()->back()->with('error', 'Your prompt was considered invalid');
        }
        return redirect()->back()->with('success', $responseType . ' created successfully.');
    }
}

