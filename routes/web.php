<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TweetController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', [TweetController::class, 'index'])->name('tweet.index');
Route::middleware('auth')->controller(TweetController::class)->group(function () {
    Route::post('/tweets', 'store')->name('tweet.store');
    Route::delete('/tweets/{tweetId}', 'destroy')->name('tweet.destroy');
});

require __DIR__ . '/auth.php';
