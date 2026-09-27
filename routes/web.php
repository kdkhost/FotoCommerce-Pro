<?php

use App\Http\Controllers\Admin\AlbumCategoryController;
use App\Http\Controllers\Admin\AlbumController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PhotoController;
use App\Http\Controllers\Admin\PhotographerProfileController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->middleware('throttle:30,1');
});

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:Super Admin|Admin Assistente'])
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('categories', AlbumCategoryController::class)->except('show');
        Route::resource('albums', AlbumController::class)->except('show');

        Route::get('albums/{album}/photos', [PhotoController::class, 'index'])->name('albums.photos.index');
        Route::post('albums/{album}/photos', [PhotoController::class, 'store'])->name('albums.photos.store');
        Route::patch('albums/{album}/photos/{photo}/toggle-featured', [PhotoController::class, 'toggleFeatured'])->name('albums.photos.toggle-featured');
        Route::delete('albums/{album}/photos/{photo}', [PhotoController::class, 'destroy'])->name('albums.photos.destroy');

        Route::get('profile', [PhotographerProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [PhotographerProfileController::class, 'update'])->name('profile.update');

        Route::get('settings', [SiteSettingController::class, 'edit'])->name('settings.edit');
        Route::put('settings', [SiteSettingController::class, 'update'])->name('settings.update');
    });
