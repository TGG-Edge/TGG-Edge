<?php

use Illuminate\Support\Facades\Route;



Route::middleware('web')->prefix('tgg-edge/tgg-india')->name('tgg-india.')->group(function () {
    Route::get('/dashboard', function () {
      return view('tgg-india.dashboard');
    });


    // trainer routes 
    Route::prefix('trainer')->name('trainer.')->group(function(){
        Route::get('/dashboard', function () {
          return view('tgg-india.trainer.dashboard');
        })->name('dashboard');
    });
    
});
