<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CulinaryPlaceController;
use App\Http\Controllers\EventPlaceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TourPlaceController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/tentang-kami', [HomeController::class, 'about'])->name('about');

Route::get('/event/{subCategory}/{slug}', [EventPlaceController::class, 'show'])->name('eventplace.show');

Route::get('/tempat-wisata', [TourPlaceController::class, 'index'])->name('tourplace.index');
Route::get('/tempat-wisata/{subCategory}/{slug}', [TourPlaceController::class, 'show'])->name('tourplace.show');
Route::post('/tempat-wisata/{subCategory}/{slug}/review', [TourPlaceController::class, 'storeReview'])->name('tourplace-review.store');
Route::put('/tempat-wisata/{subCategory}/{slug}/review', [TourPlaceController::class, 'updateReview'])->name('tourplace-review.update');

Route::get('/kuliner', [CulinaryPlaceController::class, 'index'])->name('culinaryplace.index');
Route::get('/kuliner/{subCategory}/{slug}', [CulinaryPlaceController::class, 'show'])->name('culinaryplace.show');
Route::post('/kuliner/{subCategory}/{slug}/review', [CulinaryPlaceController::class, 'storeReview'])->name('culinaryplace-review.store');
Route::put('/kuliner/{subCategory}/{slug}/review', [CulinaryPlaceController::class, 'updateReview'])->name('culinaryplace-review.update');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->middleware('throttle:5,5');

    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
