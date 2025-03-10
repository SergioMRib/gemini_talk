<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/create-event', [TestController::class, 'store'])->middleware(['auth', 'verified'])->name('test-create-event');

