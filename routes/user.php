<?php

use App\Http\Controllers\Admin\TestController;
use App\Http\Controllers\User\KnowledgeResearchController;
use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\RegisterController;
use App\Http\Controllers\User\ResearchAssistanceController;
use App\Http\Controllers\User\UserApprovalController;
use Illuminate\Support\Facades\Route;

// Public routes (login and register)
Route::middleware('web')->prefix('user')->name('user.')->group(function () {

Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('dashboard');

    Route::get('/volunteer-dashboard', function () {
        return view('user.volunteer_dashboard');
    })->name('dashboard');

    // Public login routes
    Route::get('/login', [LoginController::class, 'show'])->name('show');
    Route::post('/login', [LoginController::class, 'login'])->name('login');

    // Public registration routes
    Route::prefix('register')->name('register.')->group(function () {
        Route::get('{user_type}', [RegisterController::class, 'show'])->name('show');
        Route::post('{user_type}', [RegisterController::class, 'store'])->name('store');
    });
});

// Protected routes (require login)
Route::middleware(['web', 'auth'])->prefix('user')->name('user.')->group(function () {

    // Route::get('/dashboard', function () {
    //     return view('user.dashboard');
    // })->name('dashboard');

    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::prefix('research-assistance')->name('research-assistance.')->group(function () {
        Route::get('/literature', [ResearchAssistanceController::class, 'literature'])->name('literature');
        Route::get('/videos', [ResearchAssistanceController::class, 'videos'])->name('videos');
        Route::get('/links', [ResearchAssistanceController::class, 'links'])->name('links');
        Route::get('/linkedin', [ResearchAssistanceController::class, 'linkedin'])->name('linkedin');
    });

    Route::get('/knowledge-research', [KnowledgeResearchController::class, 'knowledgeAndResearch'])->name('knowledge-research.index');
    Route::post('/search-knowledge', [KnowledgeResearchController::class, 'searchKnowledge'])->name('knowledge-research.search-knowledge');

    Route::get('/users/requests', [UserApprovalController::class, 'index'])->name('users.requests');
    Route::post('/users/{id}/approval', [UserApprovalController::class, 'updateApproval'])->name('users.update.approval');
    Route::post('/users/{id}/project', [UserApprovalController::class, 'updateProject'])->name('users.update.project');
});
