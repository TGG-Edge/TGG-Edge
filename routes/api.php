<?php

use App\Http\Controllers\Api\UserSecondaryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Chat\ChatController;
use App\Http\Controllers\Chat\OnboardingController;
use App\Http\Controllers\Chat\PaymentController;
use App\Http\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('chat')->group(function () {
    Route::post('/init', [ChatController::class, 'init']);
    Route::post('/message', [ChatController::class, 'message']);
});
Route::post('/chat/onboarding/submit', [OnboardingController::class, 'submit']);
Route::post('/chat/payment/create', [PaymentController::class, 'createOrder']);
Route::post('/chat/payment/verify', [PaymentController::class, 'verifyPayment']);
Route::post('/chat/onboarding/meta', [OnboardingController::class, 'meta']);
Route::post('/chat/onboarding/form', [OnboardingController::class, 'form']);
Route::prefix('chat')->group(function () {
    Route::post('/init', [ChatController::class, 'init']);
    Route::post('/welcome', [ChatController::class, 'welcome']);
    Route::post('/ask-email', [ChatController::class, 'askEmail']);
    Route::post('/message', [ChatController::class, 'message']);
     Route::post('/technolog/solution/message', [ChatController::class, 'technologSolutionMessage']);

    Route::post('/onboarding/form', [OnboardingController::class, 'form']);
    Route::post('/onboarding/submit', [OnboardingController::class, 'submit']);

    // Route::post('/payment/create', [PaymentController::class, 'create']);
    // Route::post('/payment/verify', [PaymentController::class, 'verify']);
});


Route::get('/get/user/facilitator', [UserSecondaryController::class, 'getUsersFacilitator']);

