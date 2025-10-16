<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BadgeController;
use App\Http\Controllers\BannerController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/register', [AuthController::class, 'register'])->name('api.register');
Route::post('/auth/login', [AuthController::class, 'login'])->name('api.login');
Route::post('/auth/logout', [AuthController::class, 'logout'])->name('api.logout');

Route::get('/banner-homepage', [BannerController::class, 'homepage'])->name('api.banner.homepage');
Route::get('/banner', [BannerController::class, 'index'])->name('api.banner');
Route::post('/banner', [BannerController::class, 'store'])->name('api.banner.store');
Route::put('/banner/{banner}', [BannerController::class, 'update'])->name('api.banner.update');
Route::delete('/banner/{banner}', [BannerController::class, 'destroy'])->name('api.banner.destroy');

Route::get('/badge', [BadgeController::class, 'index'])->name('api.badge');
Route::post('/badge', [BadgeController::class, 'store'])->name('api.badge.store');
Route::put('/badge/{badge}', [BadgeController::class, 'update'])->name('api.badge.update');
Route::delete('/badge/{badge}', [BadgeController::class, 'destroy'])->name('api.badge.destroy');
