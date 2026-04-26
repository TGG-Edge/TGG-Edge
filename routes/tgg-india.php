<?php

use App\Http\Controllers\CampaignController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\EmailCheckController;
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
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TemplateController;
use App\Models\UserSecondary;

Route::middleware('web')->prefix('tgg-meta/tgg-india')->name('tgg-india.')->group(function () {

 
    Route::get('/report-builder', function () {
        return view('tgg-india.reports.builder');
    })->name('report-builder');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/models', [ReportController::class,'models']);
    Route::post('/reports/relations', [ReportController::class,'relations']);
    Route::post('/reports/generate', [ReportController::class,'generate']);


  Route::get('/onboarding/KJSDFH4839FRHCWH98E4UCN394FH8C3ENM0934E90N',function(){
    return view('tgg-india.onboarding');
  } )->name('onboarding');

  Route::get('/onboarding/DKJSFH3489SDFLSJDFPLKLDSJFL75934RU/{user_type}',function($user_type){

    $userTypes = UserSecondary::$user_types;

    // Allowed user types only
    $allowedTypes = [3, 6, 7, 8];

    // Check:
    // 1. Key exists in user_types
    if (!array_key_exists($user_type, $userTypes) || !in_array($user_type, $allowedTypes)) {
        abort(404, 'Invalid User Type Selected.');
    }
    
    return view('tgg-india.onboarding');
  } )->name('onboarding.user.type');

  Route::get('/login/XCJBDSNJK43RWEFSKDJCXNFL34KRN3DKL3MREFWLMNKL32M', [LoginController::class, 'show'])->name('show');
  Route::post('/login', [LoginController::class, 'login'])->name('login');
  Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
  Route::get('/switch/account/{id}', [LoginController::class, 'switchAccount'])->name('switch.account');
  Route::get('/referral', function () {
      return view('tgg-india.referral');
  })->name('referral');

 
  // Public registration routes
  Route::prefix('register')->name('register.')->group(function () {
    Route::get('{user_type}/DSLKFN43KREFWLDCMXKLWNEMR34RKL32NWMEDKQWJASNCKNRWDECNK3EW', [RegisterController::class, 'show'])->name('show');
    Route::post('{user_type}', [RegisterController::class, 'store'])->name('store');
    Route::get('/referral/{referral_code}', [RegisterController::class, 'showReferral']);
    Route::post('referral/{user_type}', [RegisterController::class, 'referralStore'])->name('referral.store');
    Route::post('/payment/verify', [RegisterController::class, 'verifyPayment'])->name('payment.verify');
  });

  Route::get('/enquiry/referral/{referral_code}', [RegisterController::class, 'showEnquiry']);
  Route::post('enquiry/referral/{referral_code}', [RegisterController::class, 'storeEnquiry'])->name('enquiry.referral.store');
   

  Route::post('/donate', [DonationController::class, 'createOrder'])->name('donate.create');
  Route::post('/donate/verify', [DonationController::class, 'verifyDonation'])->name('donate.verify');

  Route::get('/dashboard', function () {
    return view('tgg-india.dashboard');
  });

  Route::get('/download-excel/{model}', [ExportController::class, 'downloadExcel'])
    ->name('download.excel');

   Route::get('/{role}/venture-bench-services', function(){
      return view('tgg-india.venture-bench-services');
   })
    ->name('venture-bench-services.index');
    

   Route::get('/{role}/revenue-ready-kit/{slug}', function(){
      return view('tgg-india.revenue-ready-kit');
   })
    ->name('revenue-ready-kit.index');
  

  //dynamic routes based on modules
  Route::middleware(['dynamic_role:1,6,8'])
    ->get('/{role}/templates', [TemplateController::class, 'index'])->name('templates.index');
  Route::middleware(['dynamic_role:1,6,8'])
    ->get('/{role}/templates/create', [TemplateController::class, 'create'])->name('templates.create');
  Route::middleware(['dynamic_role:1,6,8'])
  ->get('/{role}/templates/edit', [TemplateController::class, 'edit'])->name('templates.edit');
  Route::middleware(['dynamic_role:1,6,8'])
  ->get('/{role}/templates/show', [TemplateController::class, 'show'])->name('templates.show');
  Route::middleware(['dynamic_role:1,6,8'])
  ->get('/templates/delete/{id}', [TemplateController::class, 'destroy'])->name('templates.destroy');
  Route::middleware(['dynamic_role:1,6,8'])
  ->post('/templates/store', [TemplateController::class, 'store'])->name('templates.store');
  Route::middleware(['dynamic_role:1,6,8'])
  ->post('/templates/update/{id}', [TemplateController::class, 'update'])->name('templates.update');

  Route::middleware(['dynamic_role:1,6,8'])
      ->get('/{role}/campaigns', [CampaignController::class, 'index'])
      ->name('campaigns.index');

  Route::middleware(['dynamic_role:1,6,8'])
      ->get('/{role}/campaigns/create', [CampaignController::class, 'create'])
      ->name('campaigns.create');

  Route::middleware(['dynamic_role:1,6,8'])
      ->post('/campaigns/store', [CampaignController::class, 'store'])
      ->name('campaigns.store');

  Route::middleware(['dynamic_role:1,6,8'])
      ->get('/{role}/campaigns/edit/{id}', [CampaignController::class, 'edit'])
      ->name('campaigns.edit');

  Route::middleware(['dynamic_role:1,6,8'])
      ->post('/campaigns/update/{id}', [CampaignController::class, 'update'])
      ->name('campaigns.update');

  Route::middleware(['dynamic_role:1,6,8'])
      ->get('/{role}/campaigns/show/{id}', [CampaignController::class, 'show'])
      ->name('campaigns.show');

  Route::middleware(['dynamic_role:1,6,8'])
      ->get('/campaigns/delete/{id}', [CampaignController::class, 'destroy'])
      ->name('campaigns.delete');
      
  Route::middleware(['dynamic_role:1,6,8'])
    ->get('/{role}/campaigns/{id}', [CampaignController::class, 'show'])
    ->name('campaigns.show');

  Route::middleware(['dynamic_role:1,6,8'])->group(function () {

      Route::get('/{role}/email-check', 
          [EmailCheckController::class, 'index']
      )->name('email-check.index');

      Route::get('/{role}/email-check/create', 
          [EmailCheckController::class, 'create']
      )->name('email-check.create');

      Route::post('/email-check/store', 
          [EmailCheckController::class, 'store']
      )->name('email-check.store');

      Route::get('/{role}/email-check/show/{id}', 
          [EmailCheckController::class, 'show']
      )->name('email-check.show');

      Route::get('/{role}/email-check/download', 
          [EmailCheckController::class, 'downloadValid']
      )->name('email-check.download');

      Route::get('/email-check/delete/{id}', [EmailCheckController::class, 'destroy'])
      ->name('email-check.delete');
  });


  

});
