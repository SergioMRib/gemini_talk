<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Services\GeminiService;
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
}
