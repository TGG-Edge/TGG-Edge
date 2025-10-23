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
     //members
  Route::middleware('member')->prefix('member')->name('member.')->group(function () {
      Route::get('/dashboard', [\App\Http\Controllers\TggIndia\Member\DashboardController::class, 'index'])->name('dashboard');

    // Route::get('/dashboard', function () {
    //   return view('tgg-india.member.dashboard');
    // })->name('dashboard');
    Route::prefix('modules')->name('modules.')->group(function () {
      Route::get('/', [\App\Http\Controllers\TggIndia\Member\ModuleController::class, 'index'])->name('index');
      Route::get('/links', [\App\Http\Controllers\TggIndia\Member\ModuleController::class, 'links'])->name('links');
      Route::get('/videos', [\App\Http\Controllers\TggIndia\Member\ModuleController::class, 'videos'])->name('videos');
      Route::get('/chapters/{id}', [\App\Http\Controllers\TggIndia\Member\ModuleController::class, 'chapters'])->name('chapters');
    });

    Route::prefix('profile')->name('profile.')->group(function () {
      Route::get('/', [\App\Http\Controllers\TggIndia\Member\ProfileController::class, 'show'])->name('index');
      Route::post('/profile', [\App\Http\Controllers\TggIndia\Member\ProfileController::class, 'update'])->name('update');
    });

     Route::resource('assignments', \App\Http\Controllers\TggIndia\Member\AssignmentController::class);


     Route::prefix('referral')->name('referral.')->group(function () {
      Route::get('/program', [ReferralController::class, 'program'])->name('program');
      Route::get('/tracking', [ReferralController::class, 'tracking'])->name('tracking');
    });

    Route::prefix('rewards')->name('rewards.')->group(function () {
      Route::get('/', [\App\Http\Controllers\TggIndia\Member\RewardController::class, 'index'])->name('index');
      Route::post('/reward', [\App\Http\Controllers\TggIndia\Member\RewardController::class, 'contentUpdate'])->name('content.update');
    });

    Route::prefix('incentives')->name('incentives.')->group(function () {
      Route::get('/', [\App\Http\Controllers\TggIndia\Member\IncentiveController::class, 'index'])->name('index');
      Route::post('/incentive', [\App\Http\Controllers\TggIndia\Member\IncentiveController::class, 'update'])->name('update');
    });
  });
});


