<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Home Page API
Route::get('/home-page', [App\Http\Controllers\Api\HomePageController::class, 'index']);

// About Us API
Route::get('/about-us', [App\Http\Controllers\Api\AboutUsController::class, 'index']);

// Contact API
Route::get('/contact', [App\Http\Controllers\Api\ContactController::class, 'index']);

// Terms & Conditions API
Route::get('/terms', [App\Http\Controllers\Api\TermsController::class, 'index']);

// FAQs API
Route::get('/faqs', [App\Http\Controllers\Api\FaqsController::class, 'index']);

// Partners API
Route::get('/partners', [App\Http\Controllers\Api\PartnersController::class, 'index']);

// Roles API
Route::get('/roles', [App\Http\Controllers\Api\RoleController::class, 'index']);

// Auth API
Route::post('/register', [App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout'])->middleware('auth:sanctum');

// Password Reset APIs
Route::post('/forgot-password', [App\Http\Controllers\Api\AuthController::class, 'forgotPassword']);
Route::post('/validate-otp', [App\Http\Controllers\Api\AuthController::class, 'validateOtp']);
Route::post('/reset-password', [App\Http\Controllers\Api\AuthController::class, 'resetPassword']);

