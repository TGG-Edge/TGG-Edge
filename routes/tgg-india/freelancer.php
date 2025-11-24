<?php

use App\Http\Controllers\DonationController;
use App\Http\Controllers\TggIndia\Freelancer\ApplicationController;
use App\Http\Controllers\TggIndia\Freelancer\FeatureLimitController;
use App\Http\Controllers\TggIndia\Freelancer\IncentiveController;
use App\Http\Controllers\TggIndia\LoginController;
use App\Http\Controllers\TggIndia\Freelancer\ModuleController;
use App\Http\Controllers\TggIndia\Freelancer\ProfileController;
use App\Http\Controllers\TggIndia\Freelancer\ReferralController;
use App\Http\Controllers\TggIndia\Freelancer\RewardController;
use App\Http\Controllers\TggIndia\Freelancer\ShowCaseController;
use App\Http\Controllers\TggIndia\Freelancer\InvoiceController;
use App\Http\Controllers\TggIndia\Freelancer\ReceiptController;
use App\Http\Controllers\TggIndia\RegisterController;
use App\Http\Controllers\TggIndia\Freelancer\ChapterController;
use App\Http\Controllers\TggIndia\Freelancer\LinkController;
use App\Http\Controllers\TggIndia\Freelancer\LiteratureController;
use App\Http\Controllers\TggIndia\Freelancer\PricingController;
use App\Http\Controllers\TggIndia\Freelancer\SectionController;
use App\Http\Controllers\TggIndia\Freelancer\VideoController;
use App\Models\Donation;
use App\Models\Incentive;
use App\Models\Reward;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->prefix('tgg-meta/tgg-india')->name('tgg-india.')->group(function () {
     //members
  Route::middleware('freelancer')->prefix('freelancer')->name('freelancer.')->group(function () {
      Route::get('/dashboard', [\App\Http\Controllers\TggIndia\Freelancer\DashboardController::class, 'index'])->name('dashboard');

    // Route::get('/dashboard', function () {
    //   return view('tgg-india.Freelancer.dashboard');
    // })->name('dashboard');
    Route::prefix('modules')->name('modules.')->group(function () {
      Route::get('/', [\App\Http\Controllers\TggIndia\Freelancer\ModuleController::class, 'index'])->name('index');
      Route::get('/links', [\App\Http\Controllers\TggIndia\Freelancer\ModuleController::class, 'links'])->name('links');
      Route::get('/videos', [\App\Http\Controllers\TggIndia\Freelancer\ModuleController::class, 'videos'])->name('videos');
      Route::get('/chapters/{id}', [\App\Http\Controllers\TggIndia\Freelancer\ModuleController::class, 'chapters'])->name('chapters');
    });

    Route::prefix('profile')->name('profile.')->group(function () {
      Route::get('/', [\App\Http\Controllers\TggIndia\Freelancer\ProfileController::class, 'show'])->name('index');
      Route::post('/profile', [\App\Http\Controllers\TggIndia\Freelancer\ProfileController::class, 'update'])->name('update');
    });

     Route::resource('assignments', \App\Http\Controllers\TggIndia\Freelancer\AssignmentController::class);


    Route::prefix('referral')->name('referral.')->group(function () {
      Route::get('/program', [ReferralController::class, 'program'])->name('program');
      Route::get('/tracking', [ReferralController::class, 'tracking'])->name('tracking');
    });
    Route::get('enquiry/referral/tracking', [\App\Http\Controllers\TggIndia\Freelancer\ReferralController::class, 'enquiryReferralTracking'])->name('enquiry.referral.tracking');
    

    Route::prefix('rewards')->name('rewards.')->group(function () {
      Route::get('/', [\App\Http\Controllers\TggIndia\Freelancer\RewardController::class, 'index'])->name('index');
      Route::post('/reward', [\App\Http\Controllers\TggIndia\Freelancer\RewardController::class, 'contentUpdate'])->name('content.update');
    });

    Route::prefix('incentives')->name('incentives.')->group(function () {
      Route::get('/', [\App\Http\Controllers\TggIndia\Freelancer\IncentiveController::class, 'index'])->name('index');
      Route::post('/incentive', [\App\Http\Controllers\TggIndia\Freelancer\IncentiveController::class, 'update'])->name('update');
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


