<?php

use App\Http\Controllers\User\ResearchAssistanceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Add this at the bottom of your routes/web.php
Route::get('/login', fn () => redirect()->route('user.login'))->name('login');

Route::get('/cron/generate-ai-research-assistance', [ResearchAssistanceController::class, 'CronGenerateRA']);