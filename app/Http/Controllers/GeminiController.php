<?php

namespace App\Http\Controllers;

use App\Models\AskGeminiLog;
use App\Models\Conversation;
use App\Models\Note;
use Illuminate\Http\Request;
use App\Services\GeminiService;
use App\Services\BasePromptService;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;



class GeminiController extends Controller
{

    protected $geminiService;

    public function __construct(GeminiService $geminiService)
    {
        $this->geminiService = $geminiService;
    }


    public function index(Request $request) {

        $conversations = Conversation::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();

//dd($conversations);
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
        $response = $this->geminiService->sendContent($request->question);

        Conversation::create([
            'message' => $response,
            'user_id' => Auth::id(),
            'is_ai' => true,
        ]);

        return redirect()->route('gemini.index');
    }

    public function create() {
        return Inertia::render('AskGemini');
    }

    public function store(BasePromptService $basePromptService, Request $request) {

        $validated = $request->validate([
            'question' => 'required',
        ]);

        // Send the request using the service
        $response = $this->geminiService->sendContent($basePromptService->getPrompt() . " " . $request->question);

        $start = strpos($response, '{');
        $end = strpos($response, '}');
        $json = substr($response, $start, $end + 1 - $start);
        $responseArray = json_decode($json, true);
//dd($response, $start, $end, $json, json_decode($json, true));

        if($responseArray['type'] == 'note') {
            Note::create($responseArray);
        }
        if($responseArray['type'] == 'event') {

        }

        AskGeminiLog::create([
            'log_entry' => $request->question,
            'from_human' => true
        ]);

        AskGeminiLog::create([
            'log_entry' => $json,
            'from_human' => false
        ]);

        return redirect()->back()->with('success', 'Response created');
    }
}
