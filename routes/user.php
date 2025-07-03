<?php

use App\Http\Controllers\Admin\TestController;
use App\Http\Controllers\User\KnowledgeResearchController;
use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\User\RegisterController;
use App\Http\Controllers\User\ResearchAssistanceController;
use App\Http\Controllers\User\UserApprovalController;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Admin\DashboardController;

Route::middleware('web')->prefix('user')->name('user.')->group(function () {
    
   Route::get('/dashboard', function () {
    return view('user.dashboard');
    })->middleware('auth')->name('dashboard');

    Route::prefix('research-assistance')->name('research-assistance.')->group(function () {
    Route::get('/literature', [ResearchAssistanceController::class, 'literature'])->name('literature');
    Route::get('/videos', [ResearchAssistanceController::class, 'videos'])->name('videos');
    Route::get('/links', [ResearchAssistanceController::class, 'links'])->name('links');
    Route::get('/linkedin', [ResearchAssistanceController::class, 'linkedin'])->name('linkedin');
    });

    Route::get('/knowledge-research', [KnowledgeResearchController::class, 'knowledge-research'])->name('knowledge-research.index');




    Route::get('/login', [LoginController::class, 'show'])->name('show');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');



    Route::prefix('register')->name('register.')->group(function () {

    // GET: Show Registration Form with user_type (1 = RHM Club, 2 = NCRH, 3 = Freelance)
    Route::get('{user_type}', [RegisterController::class, 'show'])->name('show');
    // POST: Store Registration Data
    Route::post('{user_type}', [RegisterController::class, 'store'])->name('store');

    });


//    Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users/requests', [UserApprovalController::class, 'index'])->name('users.requests');
    Route::post('/users/{id}/approval', [UserApprovalController::class, 'updateApproval'])->name('users.update.approval');
    Route::post('/users/{id}/project', [UserApprovalController::class, 'updateProject'])->name('users.update.project');
// });

});
