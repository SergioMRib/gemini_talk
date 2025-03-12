<?php

use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GeminiController;
use App\Http\Controllers\TellGeminiController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/gemini', [GeminiController::class, 'index'])->name('gemini.index');
    Route::post('/gemini', [GeminiController::class, 'send'])->name('gemini.send');

    Route::get('/ask-gemini', [GeminiController::class, 'create'])->name('gemini.create');
    Route::post('/ask-gemini', [GeminiController::class, 'store'])->name('gemini.store');

    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');

    Route::get('/tell-gemini', [TellGeminiController::class, 'index'])->name('tell.index');
    Route::post('/tell-gemini', [TellGeminiController::class, 'getFromGemini'])->name('tell.get-from-gemini');
});

require __DIR__.'/auth.php';
require __DIR__.'/test.php';
