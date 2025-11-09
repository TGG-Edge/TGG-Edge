<?php

use App\Http\Controllers\DonationController;
use App\Http\Controllers\TggIndia\CoCreator\ApplicationController;
use App\Http\Controllers\TggIndia\CoCreator\FeatureLimitController;
use App\Http\Controllers\TggIndia\CoCreator\IncentiveController;
use App\Http\Controllers\TggIndia\LoginController;
use App\Http\Controllers\TggIndia\CoCreator\ModuleController;
use App\Http\Controllers\TggIndia\CoCreator\ProfileController;
use App\Http\Controllers\TggIndia\CoCreator\ReferralController;
use App\Http\Controllers\TggIndia\CoCreator\RewardController;
use App\Http\Controllers\TggIndia\CoCreator\ShowCaseController;
use App\Http\Controllers\TggIndia\CoCreator\InvoiceController;
use App\Http\Controllers\TggIndia\CoCreator\ReceiptController;
use App\Http\Controllers\TggIndia\RegisterController;
use App\Http\Controllers\TggIndia\CoCreator\ChapterController;
use App\Http\Controllers\TggIndia\CoCreator\LinkController;
use App\Http\Controllers\TggIndia\CoCreator\LiteratureController;
use App\Http\Controllers\TggIndia\CoCreator\PricingController;
use App\Http\Controllers\TggIndia\CoCreator\SectionController;
use App\Http\Controllers\TggIndia\CoCreator\VideoController;
use App\Models\Donation;
use App\Models\Incentive;
use App\Models\Reward;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->prefix('tgg-meta/tgg-india')->name('tgg-india.')->group(function () {
     //members
  Route::middleware('co-creator')->prefix('co-creator')->name('co-creator.')->group(function () {
      Route::get('/dashboard', [\App\Http\Controllers\TggIndia\CoCreator\DashboardController::class, 'index'])->name('dashboard');

    // Route::get('/dashboard', function () {
    //   return view('tgg-india.CoCreator.dashboard');
    // })->name('dashboard');
    Route::prefix('modules')->name('modules.')->group(function () {
      Route::get('/', [\App\Http\Controllers\TggIndia\CoCreator\ModuleController::class, 'index'])->name('index');
      Route::get('/links', [\App\Http\Controllers\TggIndia\CoCreator\ModuleController::class, 'links'])->name('links');
      Route::get('/videos', [\App\Http\Controllers\TggIndia\CoCreator\ModuleController::class, 'videos'])->name('videos');
      Route::get('/chapters/{id}', [\App\Http\Controllers\TggIndia\CoCreator\ModuleController::class, 'chapters'])->name('chapters');
    });

    Route::prefix('profile')->name('profile.')->group(function () {
      Route::get('/', [\App\Http\Controllers\TggIndia\CoCreator\ProfileController::class, 'show'])->name('index');
      Route::post('/profile', [\App\Http\Controllers\TggIndia\CoCreator\ProfileController::class, 'update'])->name('update');
    });

     Route::resource('assignments', \App\Http\Controllers\TggIndia\CoCreator\AssignmentController::class);


    Route::prefix('referral')->name('referral.')->group(function () {
      Route::get('/program', [ReferralController::class, 'program'])->name('program');
      Route::get('/tracking', [ReferralController::class, 'tracking'])->name('tracking');
    });

    Route::prefix('rewards')->name('rewards.')->group(function () {
      Route::get('/', [\App\Http\Controllers\TggIndia\CoCreator\RewardController::class, 'index'])->name('index');
      Route::post('/reward', [\App\Http\Controllers\TggIndia\CoCreator\RewardController::class, 'contentUpdate'])->name('content.update');
    });

    Route::prefix('incentives')->name('incentives.')->group(function () {
      Route::get('/', [\App\Http\Controllers\TggIndia\CoCreator\IncentiveController::class, 'index'])->name('index');
      Route::post('/incentive', [\App\Http\Controllers\TggIndia\CoCreator\IncentiveController::class, 'update'])->name('update');
    });

    Route::prefix('invoices')->name('invoices.')->group(function () {
      Route::get('/', [InvoiceController::class, 'index'])->name('index');
      Route::get('/create', [InvoiceController::class, 'create'])->name('create');
      Route::post('/store', [InvoiceController::class, 'store'])->name('store');
      Route::get('/global-store', [InvoiceController::class, 'globalStore'])->name('global-store');
      Route::get('/edit/{id}', [InvoiceController::class, 'edit'])->name('edit');
      Route::put('/update/{id}', [InvoiceController::class, 'update'])->name('update');
      Route::get('/show/{id}', [InvoiceController::class, 'show'])->name('show');
      Route::get('/download/{id}', [InvoiceController::class, 'download'])->name('download');
      Route::delete('/delete/{id}', [InvoiceController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('receipts')->name('receipts.')->group(function () {
      Route::get('/', [ReceiptController::class, 'index'])->name('index');
      Route::get('/create', [ReceiptController::class, 'create'])->name('create');
      Route::post('/store', [ReceiptController::class, 'store'])->name('store');
      Route::get('/global-store', [ReceiptController::class, 'globalStore'])->name('global-store');
      Route::get('/edit/{id}', [ReceiptController::class, 'edit'])->name('edit');
      Route::put('/update/{id}', [ReceiptController::class, 'update'])->name('update');
      Route::get('/show/{id}', [ReceiptController::class, 'show'])->name('show');
      Route::get('/download/{id}', [ReceiptController::class, 'download'])->name('download');
      Route::delete('/delete/{id}', [ReceiptController::class, 'destroy'])->name('destroy');
    });
    
  });
});


