<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\RollController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('welcome'))->name('home');
Route::post('/register', [UserController::class, 'register'])->name('register');

Route::prefix('pages/{route}')->group(function () {
    Route::get('/', [PageController::class, 'show'])->name('pages.show');
    Route::post('/regenerate', [PageController::class, 'regenerate'])->name('pages.regenerate');
    Route::post('/deactivate', [PageController::class, 'deactivate'])->name('pages.deactivate');
    Route::post('/roll', [RollController::class, 'imFeelingLucky'])->name('rolls.lucky');
    Route::get('/history', [RollController::class, 'history'])->name('rolls.history');
});
