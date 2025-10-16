<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::middleware('auth')->group(function () {
    Route::post('/profile/update', [UserController::class, 'update'])->name('profile.update');
});

Route::get('/{any}', function () {
    return view('app');
})->where('any', '^(?!api).*$');
