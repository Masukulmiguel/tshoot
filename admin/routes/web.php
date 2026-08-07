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
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\SocialLinkController;
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

Route::get('/debug-env', function () {
    return response()->json([
        'DB_CONNECTION' => env('DB_CONNECTION'),
        'DB_HOST' => env('DB_HOST'),
        'DB_PORT' => env('DB_PORT'),
        'DB_DATABASE' => env('DB_DATABASE'),
        'DB_USERNAME' => env('DB_USERNAME'),
        'DB_PASSWORD' => env('DB_PASSWORD') ? '***SET***' : 'EMPTY',
        'DB_PASSWORD_LEN' => strlen(env('DB_PASSWORD', '')),
        'SUPABASE_URL' => env('SUPABASE_URL') ? '***SET***' : 'EMPTY',
    ]);
});

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/more-contacts', [DashboardController::class, 'moreContacts'])->name('dashboard.moreContacts');
    Route::get('/dashboard/more-visitors', [DashboardController::class, 'moreVisitors'])->name('dashboard.moreVisitors');

    Route::resource('contacts', ContactController::class);
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

    Route::resource('gallery', GalleryController::class)->except(['show']);
    Route::post('gallery/reorder', [GalleryController::class, 'reorder'])->name('gallery.reorder');
    Route::put('gallery-section', [GalleryController::class, 'updateSection'])->name('gallery.updateSection');

    Route::resource('partners', PartnerController::class)->except(['show']);
    Route::post('partners/{partner}/toggle', [PartnerController::class, 'toggle'])->name('partners.toggle');

    Route::resource('social-links', SocialLinkController::class)->except(['show'])->parameters(['social-links' => 'socialLink']);
    Route::post('social-links/{socialLink}/toggle', [SocialLinkController::class, 'toggle'])->name('social-links.toggle');
});
