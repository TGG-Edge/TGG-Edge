<?php

use App\Http\Controllers\DonationController;
use App\Http\Controllers\TggIndia\Spouse\ApplicationController;
use App\Http\Controllers\TggIndia\Spouse\FeatureLimitController;
use App\Http\Controllers\TggIndia\Spouse\IncentiveController;
use App\Http\Controllers\TggIndia\LoginController;
use App\Http\Controllers\TggIndia\Spouse\ModuleController;
use App\Http\Controllers\TggIndia\Spouse\ProfileController;
use App\Http\Controllers\TggIndia\Spouse\ReferralController;
use App\Http\Controllers\TggIndia\Spouse\RewardController;
use App\Http\Controllers\TggIndia\Spouse\ShowCaseController;
use App\Http\Controllers\TggIndia\Spouse\InvoiceController;
use App\Http\Controllers\TggIndia\Spouse\ReceiptController;
use App\Http\Controllers\TggIndia\RegisterController;
use App\Http\Controllers\TggIndia\Spouse\ChapterController;
use App\Http\Controllers\TggIndia\Spouse\LinkController;
use App\Http\Controllers\TggIndia\Spouse\LiteratureController;
use App\Http\Controllers\TggIndia\Spouse\PricingController;
use App\Http\Controllers\TggIndia\Spouse\SectionController;
use App\Http\Controllers\TggIndia\Spouse\VideoController;
use App\Models\Donation;
use App\Models\Incentive;
use App\Models\Reward;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->prefix('tgg-meta/tgg-india')->name('tgg-india.')->group(function () {
     //Spouses
  Route::middleware('spouse')->prefix('spouse')->name('spouse.')->group(function () {
      Route::get('/dashboard', [\App\Http\Controllers\TggIndia\Spouse\DashboardController::class, 'index'])->name('dashboard');

    // Route::get('/dashboard', function () {
    //   return view('tgg-india.Spouse.dashboard');
    // })->name('dashboard');
    Route::prefix('modules')->name('modules.')->group(function () {
      Route::get('/', [\App\Http\Controllers\TggIndia\Spouse\ModuleController::class, 'index'])->name('index');
      Route::get('/links', [\App\Http\Controllers\TggIndia\Spouse\ModuleController::class, 'links'])->name('links');
      Route::get('/videos', [\App\Http\Controllers\TggIndia\Spouse\ModuleController::class, 'videos'])->name('videos');
      Route::get('/chapters/{id}', [\App\Http\Controllers\TggIndia\Spouse\ModuleController::class, 'chapters'])->name('chapters');
    });

    Route::prefix('profile')->name('profile.')->group(function () {
      Route::get('/', [\App\Http\Controllers\TggIndia\Spouse\ProfileController::class, 'show'])->name('index');
      Route::post('/profile', [\App\Http\Controllers\TggIndia\Spouse\ProfileController::class, 'update'])->name('update');
    });

     Route::resource('assignments', \App\Http\Controllers\TggIndia\Spouse\AssignmentController::class);


    Route::prefix('referral')->name('referral.')->group(function () {
      Route::get('/program', [\App\Http\Controllers\TggIndia\Spouse\ReferralController::class, 'program'])->name('program');
      Route::get('/tracking', [\App\Http\Controllers\TggIndia\Spouse\ReferralController::class, 'tracking'])->name('tracking');
    });

    Route::prefix('rewards')->name('rewards.')->group(function () {
      Route::get('/', [\App\Http\Controllers\TggIndia\Spouse\RewardController::class, 'index'])->name('index');
      Route::post('/reward', [\App\Http\Controllers\TggIndia\Spouse\RewardController::class, 'contentUpdate'])->name('content.update');
    });

    Route::prefix('incentives')->name('incentives.')->group(function () {
      Route::get('/', [\App\Http\Controllers\TggIndia\Spouse\IncentiveController::class, 'index'])->name('index');
      Route::post('/incentive', [\App\Http\Controllers\TggIndia\Spouse\IncentiveController::class, 'update'])->name('update');
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


