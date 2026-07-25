<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/api/track', [ApiController::class, 'trackVisitor']);
Route::post('/api/contact', [ApiController::class, 'submitContact']);

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('contacts', ContactController::class)->only(['index', 'show', 'destroy']);
    Route::post('contacts/{contact}/reply', [ContactController::class, 'reply'])->name('contacts.reply');
    Route::post('contacts/{contact}/status', [ContactController::class, 'updateStatus'])->name('contacts.status');

    Route::resource('visitors', VisitorController::class)->only(['index', 'show', 'destroy']);
    Route::get('visitors-analytics', [VisitorController::class, 'analytics'])->name('visitors.analytics');

    Route::resource('images', ImageController::class);
    Route::post('images-reorder', [ImageController::class, 'reorder'])->name('images.reorder');
});
