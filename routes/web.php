<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MarketDataController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (No Auth Required)
|--------------------------------------------------------------------------
*/

Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/explore', [PublicController::class, 'explore'])->name('public.explore');
Route::get('/shared/{token}', [MarketDataController::class, 'publicView'])->name('shared.view');
Route::get('/intelligence', [App\Http\Controllers\IntelligenceController::class, 'index'])->name('public.intelligence');
Route::get('/api/intelligence/suggestions', [App\Http\Controllers\IntelligenceController::class, 'suggestions'])->name('api.intelligence.suggestions');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'check.blocked'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile (from Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Market Data CRUD
    Route::resource('market-data', MarketDataController::class)->parameters(['market-data' => 'market_data']);

    // Market Data Extra Actions
    Route::get('/export/csv', [MarketDataController::class, 'exportCsv'])->name('market-data.export.csv');
    Route::get('/export/json', [MarketDataController::class, 'exportJson'])->name('market-data.export.json');
    Route::post('/market-data/{market_data}/share', [MarketDataController::class, 'share'])->name('market-data.share');
    Route::get('/upload-csv', [MarketDataController::class, 'uploadForm'])->name('market-data.upload.form');
    Route::post('/upload-csv', [MarketDataController::class, 'uploadCsv'])->name('market-data.upload');

    // Bookmarks
    Route::post('/bookmarks/{market_data}/toggle', [BookmarkController::class, 'toggle'])->name('bookmarks.toggle');
    Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'check.blocked', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/data', [AdminController::class, 'manageData'])->name('data');
    Route::patch('/data/{market_data}/approve', [AdminController::class, 'approveData'])->name('data.approve');
    Route::patch('/data/{market_data}/reject', [AdminController::class, 'rejectData'])->name('data.reject');
    Route::get('/users', [AdminController::class, 'manageUsers'])->name('users');
    Route::patch('/users/{user}/block', [AdminController::class, 'blockUser'])->name('users.block');
    Route::patch('/users/{user}/unblock', [AdminController::class, 'unblockUser'])->name('users.unblock');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
});

require __DIR__.'/auth.php';
