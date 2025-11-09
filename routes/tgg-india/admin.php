<?php

use App\Http\Controllers\DonationController;
use App\Http\Controllers\TggIndia\Admin\ApplicationController;
use App\Http\Controllers\TggIndia\Admin\FeatureLimitController;
use App\Http\Controllers\TggIndia\Admin\IncentiveController;
use App\Http\Controllers\TggIndia\Admin\InvoiceController;
use App\Http\Controllers\TggIndia\LoginController;
use App\Http\Controllers\TggIndia\Admin\ModuleController;
use App\Http\Controllers\TggIndia\Admin\ProfileController;
use App\Http\Controllers\TggIndia\Admin\ReceiptController;
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
    // admin routes 
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', function () {
      return view('tgg-india.admin.dashboard');
    })->name('dashboard');

    Route::resource('assignments', \App\Http\Controllers\TggIndia\Admin\AssignmentController::class);


    Route::prefix('profile')->name('profile.')->group(function () {
      Route::get('/', [ProfileController::class, 'show'])->name('index');
      Route::post('/profile', [ProfileController::class, 'update'])->name('update');
    });

    Route::prefix('modules')->name('modules.')->group(function () {
      Route::get('/', [ModuleController::class, 'index'])->name('index');
      Route::get('/create', [ModuleController::class, 'create'])->name('create');
      Route::post('/store', [ModuleController::class, 'store'])->name('store');
      Route::get('/edit/{id}', [ModuleController::class, 'edit'])->name('edit');
      Route::put('/update/{id}', [ModuleController::class, 'update'])->name('update');
      Route::delete('/delete/{id}', [ModuleController::class, 'destroy'])->name('destroy');
    });

    Route::get('/new-applications', [ApplicationController::class, 'newApplication'])->name('new-applications');
    Route::get('/processed-applications', [ApplicationController::class, 'processedApplication'])->name('processed-applications');
    Route::get('/user-profile/{id}', [ApplicationController::class, 'userProfile'])->name('user-profile');
    Route::post('/users/{id}/userProfileUpdate', [ApplicationController::class, 'userProfileUpdate'])->name('users.profile.update');
    Route::get('/users/{id}/approval', [ApplicationController::class, 'updateApproval'])->name('users.update.approval');
    Route::resource('feature-limits', FeatureLimitController::class);

    Route::prefix('/showcases')->name('showcases.')->group(function () {
     Route::get('/edit', [ShowcaseController::class, 'edit'])->name('edit');
     Route::get('/welcome-notes/edit', [ShowCaseController::class, 'editWelcomeNotes'])
        ->name('welcome-notes.edit');
    Route::get('/collaborative-projects/edit', [ShowCaseController::class, 'editCollaborativeProjects'])
        ->name('collaborative-projects.edit');
    Route::get('/main-projects/edit', [ShowCaseController::class, 'editMainProjects'])
        ->name('main-projects.edit');
    Route::get('/freelance-opportunities/edit', [ShowCaseController::class, 'editFreelanceOpportunities'])
        ->name('freelance-opportunities.edit');
    Route::post('/update', [ShowcaseController::class, 'update'])->name('update');
    
    Route::get('/referral/edit', [ShowCaseController::class, 'editReferral'])
        ->name('referral.edit');
    Route::get('/reward/edit', [ShowCaseController::class, 'editReward'])
        ->name('reward.edit');
    Route::get('/lead-referral/edit', [ShowCaseController::class, 'editLeadReferral'])
        ->name('lead-referral.edit');
    Route::get('/spouse-referral/edit', [ShowCaseController::class, 'editSpouseReferral'])
        ->name('spouse-referral.edit');
    Route::post('/content-update/{source_type}', [ShowcaseController::class, 'updateContent'])->name('content.update');
    });

    Route::prefix('referral')->name('referral.')->group(function () {
      Route::get('/', [ReferralController::class, 'content'])->name('content.index');
      Route::post('/referral', [ReferralController::class, 'contentUpdate'])->name('content.update');
    });

    Route::prefix('rewards')->name('rewards.')->group(function () {
      Route::get('/', [RewardController::class, 'index'])->name('index');
      Route::post('/reward', [RewardController::class, 'contentUpdate'])->name('content.update');
    });

    Route::prefix('incentives')->name('incentives.')->group(function () {
      Route::get('/', [IncentiveController::class, 'index'])->name('index');
      Route::post('/incentive', [IncentiveController::class, 'update'])->name('update');
      Route::post('/status-update/{id}', [IncentiveController::class, 'updateStatus'])->name('update.status');

    });

    Route::prefix('donations')->name('donations.')->group(function () {
      Route::get('/', [\App\Http\Controllers\TggIndia\Admin\DonationController::class, 'index'])->name('index');
    });

    Route::prefix('payments')->name('payments.')->group(function () {
      Route::get('/', [\App\Http\Controllers\TggIndia\Admin\PaymentController::class, 'index'])->name('index');
    });

    Route::prefix('invoices')->name('invoices.')->group(function () {
      Route::get('/', [InvoiceController::class, 'index'])->name('index');
      Route::get('/create', [InvoiceController::class, 'create'])->name('create');
      Route::post('/store', [InvoiceController::class, 'store'])->name('store');
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

    Route::prefix('referral')->name('referral.')->group(function () {
      Route::get('/program', [ReferralController::class, 'program'])->name('program');
      Route::get('/tracking', [ReferralController::class, 'tracking'])->name('tracking');
    });
    Route::get('enquiry/referral/tracking', [ReferralController::class, 'enquiryReferralTracking'])->name('enquiry.referral.tracking');
    

  });
});


