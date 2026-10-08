<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LeadController as AdminLeadController;
use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SeoController;
use Illuminate\Support\Facades\Route;

/*
| Public site.
*/
Route::get('/', [PageController::class, 'home'])->name('home');

Route::controller(PageController::class)->group(function () {
    Route::get('/about-rachel-agostini', 'about')->name('about');
    Route::get('/get-a-quote', 'quote')->name('quote');
    Route::get('/faq', 'faq')->name('faq');
    Route::get('/contact', 'contact')->name('contact');
    Route::get('/privacy', 'privacy')->name('privacy');
});

Route::get('/insurance', [ProductController::class, 'index'])->name('products');
Route::get('/insurance/{product}', [ProductController::class, 'show'])->name('products.show');

Route::get('/calculators', [CalculatorController::class, 'index'])->name('calculators');
Route::get('/calculators/{calculator}', [CalculatorController::class, 'show'])->name('calculators.show');

Route::post('/leads/{type}', [LeadController::class, 'store'])->middleware('throttle:12,1')->name('leads.store');

Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [SeoController::class, 'robots'])->name('robots');

/*
| Lead tracker (admin).
*/
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/admin/login', [AuthController::class, 'login'])->middleware('throttle:10,1')->name('login.attempt');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::get('/leads', [AdminLeadController::class, 'index'])->name('leads');
    Route::get('/leads/export', [AdminLeadController::class, 'export'])->name('leads.export');
    Route::get('/leads/{lead}', [AdminLeadController::class, 'show'])->name('leads.show');
    Route::patch('/leads/{lead}', [AdminLeadController::class, 'update'])->name('leads.update');
    Route::delete('/leads/{lead}', [AdminLeadController::class, 'destroy'])->name('leads.destroy');
});
