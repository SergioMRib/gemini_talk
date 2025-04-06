<?php

namespace App\Http\Controllers;

use App\Models\AskGeminiLog;
use App\Models\Note;
use App\Services\BasePromptService;
use App\Services\GeminiService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TellGeminiController extends Controller
{
    public function index() {

        return Inertia::render('TellmeGemini', [
            'geminiResponse' => session()->pull('response'),
            'total_token_count' => session()->pull('total_token_count')
        ]);
    }

    public function getFromGemini (BasePromptService $basePromptService, GeminiService $geminiService, Request $request) {

        $completePrompt = $basePromptService->buildPromptTellMeGemini(Note::all()->toArray(), AskGeminiLog::where('from_human', 0)->get()->toArray(), $request->question);

        // Send the request using the service
        $responseData = $geminiService->sendContent($completePrompt);
        $response = $responseData['text'];

        session()->put('response',$response);
        session()->put('total_token_count',$responseData['total_token_count']);
        return redirect()->back();
    }
}
