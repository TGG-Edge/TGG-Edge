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

 

  Route::get('/login', [LoginController::class, 'show'])->name('show');
  Route::post('/login', [LoginController::class, 'login'])->name('login');
  Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
  Route::get('/switch/account/{id}', [LoginController::class, 'switchAccount'])->name('switch.account');
  Route::get('/referral', function () {
      return view('tgg-india.referral');
  })->name('referral');

 
  // Public registration routes
  Route::prefix('register')->name('register.')->group(function () {
    Route::get('{user_type}', [RegisterController::class, 'show'])->name('show');
    Route::post('{user_type}', [RegisterController::class, 'store'])->name('store');
    Route::get('/referral/{referral_code}', [RegisterController::class, 'showReferral']);
    Route::post('referral/{user_type}', [RegisterController::class, 'referralStore'])->name('referral.store');
    Route::post('/payment/verify', [RegisterController::class, 'verifyPayment'])->name('payment.verify');
  });

  Route::post('/donate', [DonationController::class, 'createOrder'])->name('donate.create');
  Route::post('/donate/verify', [DonationController::class, 'verifyDonation'])->name('donate.verify');

  Route::get('/dashboard', function () {
    return view('tgg-india.dashboard');
  });

  // trainer routes 
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
  });



















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
