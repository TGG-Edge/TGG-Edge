<?php

use Illuminate\Support\Facades\Route;



Route::middleware('web')->prefix('tgg-india')->name('tgg-india.')->group(function () {
    Route::get('/dashboard', function () {
    return view('tgg-india.dashboard');
});
});
