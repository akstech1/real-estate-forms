<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\FaqBannerController;
use App\Http\Controllers\TermsController;
use App\Http\Controllers\TermsBannerController;
use App\Http\Controllers\ContactUsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard routes (protected by auth) - Shows admin panel
Route::middleware(['auth', 'verified'])->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('index');
    
    // Home menu
    Route::prefix('home')->name('home.')->group(function () {
        // Banners
        Route::get('banners', [BannerController::class, 'index'])->name('banners.index');
        Route::get('banners/create', [BannerController::class, 'create'])->name('banners.create');
        Route::post('banners', [BannerController::class, 'store'])->name('banners.store');
        Route::get('banners/{banner}/edit', [BannerController::class, 'edit'])->name('banners.edit');
        Route::put('banners/{banner}', [BannerController::class, 'update'])->name('banners.update');
        Route::delete('banners/{banner}', [BannerController::class, 'destroy'])->name('banners.destroy');
        
        // About Us
        Route::get('about', [AboutController::class, 'show'])->name('about');
        Route::put('about/header', [AboutController::class, 'updateHeader'])->name('about.header.update');
        Route::put('about/platform', [AboutController::class, 'updatePlatform'])->name('about.platform.update');
        Route::put('about/mission', [AboutController::class, 'updateMission'])->name('about.mission.update');
        Route::put('about/goals', [AboutController::class, 'updateGoals'])->name('about.goals.update');
        Route::put('about', [AboutController::class, 'update'])->name('about.update'); // Deprecated
    });
    
    // Partners
    Route::resource('partners', PartnerController::class);
    
    // FAQ Banner (must come BEFORE FAQ resource routes)
    Route::get('faqs/banner', [FaqBannerController::class, 'edit'])->name('faqs.banner.edit');
    Route::put('faqs/banner', [FaqBannerController::class, 'update'])->name('faqs.banner.update');
    
    // FAQs
    Route::resource('faqs', FaqController::class);
    Route::patch('faqs/{faq}/toggle-status', [FaqController::class, 'toggleStatus'])->name('faqs.toggle-status');
    
    // Terms & Conditions Banner (must come BEFORE Terms resource routes)
    Route::get('terms/banner', [TermsBannerController::class, 'edit'])->name('terms.banner.edit');
    Route::put('terms/banner', [TermsBannerController::class, 'update'])->name('terms.banner.update');
    
    // Terms & Conditions
    Route::resource('terms', TermsController::class);
    Route::patch('terms/{term}/toggle-status', [TermsController::class, 'toggleStatus'])->name('terms.toggle-status');
    
    // Contact Us
    Route::get('contact', [ContactUsController::class, 'edit'])->name('contact.edit');
    Route::put('contact', [ContactUsController::class, 'update'])->name('contact.update');
    Route::delete('contact/social-media/{id}', [ContactUsController::class, 'deleteSocialMediaLink'])->name('contact.social-media.delete');
});

// Default Breeze routes - This route is now handled by the dashboard group above

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
