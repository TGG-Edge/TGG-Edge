<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Add this at the bottom of your routes/web.php
// Route::get('/login', fn () => redirect()->route('user.login'))->name('login');

Route::get('/csrf-token', function () {
    return response()->json([
        'csrf_token' => csrf_token(),
        'session_token' => session()->token(),
        'cookie' => request()->cookie('laravel_session'),
        'user' => auth()->user()
    ]);
});