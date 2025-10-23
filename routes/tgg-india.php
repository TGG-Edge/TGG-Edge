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

});
