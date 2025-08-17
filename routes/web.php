<?php

use App\Http\Controllers\User\ResearchAssistanceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CkeditorUploadController;

Route::get('/', function () {
    return view('welcome');
});

// Add this at the bottom of your routes/web.php
Route::get('/login', fn () => redirect()->route('user.login'))->name('login');

Route::get('/cron/generate-ai-research-assistance', [ResearchAssistanceController::class, 'CronGenerateRA']);

Route::post('/ckeditor/upload', [CkeditorUploadController::class, 'store'])
    ->name('ckeditor.upload');
