<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class TellGeminiController extends Controller
{
    public function index() {
        return Inertia::render('TellmeGemini');
    }

    public function getFromGemini (Request $request) {

        return $request->question;
    }
}
