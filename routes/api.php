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

