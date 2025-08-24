<?php

use App\Http\Controllers\TggIndia\Admin\ApplicationController;
use App\Http\Controllers\TggIndia\Admin\FeatureLimitController;
use App\Http\Controllers\TggIndia\LoginController;
use App\Http\Controllers\TggIndia\Admin\ModuleController;
use App\Http\Controllers\TggIndia\Admin\ProfileController;
use App\Http\Controllers\TggIndia\Admin\ShowCaseController;
use App\Http\Controllers\TggIndia\RegisterController;
use App\Http\Controllers\TggIndia\Trainer\ChapterController;
use App\Http\Controllers\TggIndia\Trainer\LinkController;
use App\Http\Controllers\TggIndia\Trainer\LiteratureController;
use App\Http\Controllers\TggIndia\Trainer\SectionController;
use App\Http\Controllers\TggIndia\Trainer\videoController;
use Illuminate\Support\Facades\Route;



Route::middleware('web')->prefix('tgg-meta/tgg-india')->name('tgg-india.')->group(function () {

  Route::get('/login', [LoginController::class, 'show'])->name('show');
  Route::post('/login', [LoginController::class, 'login'])->name('login');


  // Public registration routes
  Route::prefix('register')->name('register.')->group(function () {
    Route::get('{user_type}', [RegisterController::class, 'show'])->name('show');
    Route::post('{user_type}', [RegisterController::class, 'store'])->name('store');
  });


  Route::get('/dashboard', function () {
    return view('tgg-india.dashboard');
  });

  // trainer routes 
  Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', function () {
      return view('tgg-india.admin.dashboard');
    })->name('dashboard');

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

    Route::prefix('/showcases')->group(function () {
    Route::get('/edit/{section}', [ShowCaseController::class, 'edit'])->name('showcases.edit');
    Route::post('/update/{section}',  [ShowCaseController::class, 'update'])->name('showcases.update');
    });
  });



















  // trainer routes 
  Route::middleware('trainer')->prefix('trainer')->name('trainer.')->group(function () {
    Route::get('/dashboard', function () {
      return view('tgg-india.trainer.dashboard');
    })->name('dashboard');

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

      Route::get('/index', [videoController::class, 'index'])->name('index');
      Route::get('/create', [VideoController::class, 'create'])->name('create');
      Route::post('/store', [VideoController::class, 'store'])->name('store');
      Route::get('/edit/{id}', [VideoController::class, 'edit'])->name('edit');
      Route::get('/show', [VideoController::class, 'show'])->name('show');
      Route::put('/update/{id}', [VideoController::class, 'update'])->name('update');
      Route::delete('/delete/{id}', [VideoController::class, 'destroy'])->name('destroy');
      Route::get('/aigen', [VideoController::class, 'aigen'])->name('aigen');

    });
  });






  //members
  Route::middleware('member')->prefix('member')->name('member.')->group(function () {
    Route::get('/dashboard', function () {
      return view('tgg-india.member.dashboard');
    })->name('dashboard');
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
  });
});
