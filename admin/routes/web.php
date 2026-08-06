<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContentApiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\SiteSettingController;
use App\Http\Controllers\TeamMemberController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $path = public_path('site.html');
    if (file_exists($path)) {
        return response()->file($path);
    }
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/api/track', [ApiController::class, 'trackVisitor'])->middleware('throttle:track');
Route::post('/api/contact', [ApiController::class, 'submitContact'])->middleware('throttle:contact');
Route::get('/api/content', [ContentApiController::class, 'getAll'])->middleware('throttle:api');

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/debug-cloudinary', function () {
        $cloudName = config('services.cloudinary.cloud_name') ?? 'NOT SET';
        $apiKey = config('services.cloudinary.api_key') ?? 'NOT SET';
        $apiSecret = config('services.cloudinary.api_secret') ?? 'NOT SET';
        $configured = !empty($cloudName) && $cloudName !== 'NOT SET';
        
        return response()->json([
            'cloud_name' => $cloudName,
            'api_key' => $apiKey ? substr($apiKey, 0, 6) . '...' : 'NOT SET',
            'api_secret' => $apiSecret ? '***hidden***' : 'NOT SET',
            'configured' => $configured,
            'app_url' => config('app.url'),
        ]);
    });

    Route::resource('contacts', ContactController::class)->only(['index', 'show', 'destroy']);
    Route::match(['post', 'patch'], 'contacts/{contact}/reply', [ContactController::class, 'reply'])->name('contacts.reply');
    Route::match(['post', 'patch'], 'contacts/{contact}/status', [ContactController::class, 'updateStatus'])->name('contacts.status');

    Route::resource('visitors', VisitorController::class)->only(['index', 'show', 'destroy']);
    Route::get('visitors-analytics', [VisitorController::class, 'analytics'])->name('visitors.analytics');

    Route::resource('banners', BannerController::class)->except(['show']);
    Route::resource('services', ServiceController::class)->except(['show']);
    Route::resource('team', TeamMemberController::class)->except(['show'])->parameters(['team' => 'member']);
    Route::resource('posts', PostController::class)->except(['show']);
    Route::get('settings', [SiteSettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [SiteSettingController::class, 'update'])->name('settings.update');

    Route::get('password', [AuthController::class, 'showPasswordForm'])->name('password');
    Route::put('password', [AuthController::class, 'updatePassword'])->name('password.update');

    Route::resource('images', ImageController::class)->except(['show']);
    Route::post('images/reorder', [ImageController::class, 'reorder'])->name('images.reorder');
});
