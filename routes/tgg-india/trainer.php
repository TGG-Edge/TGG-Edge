<?php

use App\Http\Controllers\DonationController;
use App\Http\Controllers\TggIndia\Admin\ApplicationController;
use App\Http\Controllers\TggIndia\Admin\FeatureLimitController;
use App\Http\Controllers\TggIndia\Admin\IncentiveController;
use App\Http\Controllers\TggIndia\LoginController;
use App\Http\Controllers\TggIndia\Admin\ModuleController;
use App\Http\Controllers\TggIndia\Admin\ProfileController;
use App\Http\Controllers\TggIndia\Admin\ReferralController;
use App\Http\Controllers\TggIndia\Admin\RewardController;
use App\Http\Controllers\TggIndia\Admin\ShowCaseController;
use App\Http\Controllers\TggIndia\RegisterController;
use App\Http\Controllers\TggIndia\Trainer\ChapterController;
use App\Http\Controllers\TggIndia\Trainer\LinkController;
use App\Http\Controllers\TggIndia\Trainer\LiteratureController;
use App\Http\Controllers\TggIndia\Trainer\PricingController;
use App\Http\Controllers\TggIndia\Trainer\SectionController;
use App\Http\Controllers\TggIndia\Trainer\VideoController;
use App\Models\Donation;
use App\Models\Incentive;
use App\Models\Reward;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->prefix('tgg-meta/tgg-india')->name('tgg-india.')->group(function () {
     // trainer routes 
  Route::middleware('trainer')->prefix('trainer')->name('trainer.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\TggIndia\Trainer\DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('profile')->name('profile.')->group(function () {
      Route::get('/', [\App\Http\Controllers\TggIndia\Trainer\ProfileController::class, 'show'])->name('index');
      Route::post('/profile', [\App\Http\Controllers\TggIndia\Trainer\ProfileController::class, 'update'])->name('update');
    });

    Route::prefix('literatures')->name('literatures.')->group(function () {

      Route::get('/index', [LiteratureController::class, 'index'])->name('index');
      Route::get('/create', [LiteratureController::class, 'create'])->name('create');
      Route::post('/store', [LiteratureController::class, 'store'])->name('store');
      Route::get('/edit/{id}', [LiteratureController::class, 'edit'])->name('edit');
      Route::put('/update/{id}', [LiteratureController::class, 'update'])->name('update');
      Route::delete('/delete/{id}', [LiteratureController::class, 'destroy'])->name('destroy');
    });

    Route::resource('sections', SectionController::class);
    Route::resource('chapters', ChapterController::class);
    Route::get('/chapters/aigen/{section_id}', [ChapterController::class, 'aigen'])
    ->name('chapters.aigen');

    Route::prefix('links')->name('links.')->group(function () {

      Route::get('/index', [LinkController::class, 'index'])->name('index');
      Route::get('/create', [LinkController::class, 'create'])->name('create');
      Route::get('/show', [LinkController::class, 'show'])->name('show');

      Route::post('/store', [LinkController::class, 'store'])->name('store');
      Route::get('/edit/{id}', [LinkController::class, 'edit'])->name('edit');
      Route::put('/update/{id}', [LinkController::class, 'update'])->name('update');
      Route::delete('/delete/{id}', [LinkController::class, 'destroy'])->name('destroy');
      Route::get('/aigen', [LinkController::class, 'aigen'])->name('aigen'); 
    });

    Route::prefix('videos')->name('videos.')->group(function () {

      Route::get('/index', [VideoController::class, 'index'])->name('index');
      Route::get('/create', [VideoController::class, 'create'])->name('create');
      Route::post('/store', [VideoController::class, 'store'])->name('store');
      Route::get('/edit/{id}', [VideoController::class, 'edit'])->name('edit');
      Route::get('/show', [VideoController::class, 'show'])->name('show');
      Route::put('/update/{id}', [VideoController::class, 'update'])->name('update');
      Route::delete('/delete/{id}', [VideoController::class, 'destroy'])->name('destroy');
      Route::get('/aigen', [VideoController::class, 'aigen'])->name('aigen');

    });

    Route::resource('feature-limits', \App\Http\Controllers\TggIndia\Trainer\FeatureLimitController::class);
    Route::post('feature-limits/set-price', [\App\Http\Controllers\TggIndia\Trainer\FeatureLimitController::class, 'setPrice'])
    ->name('feature-limits.setPrice');

  });
});


