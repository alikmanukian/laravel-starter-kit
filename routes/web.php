<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ModalController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

// show modal example
Route::get('/modal/{type}', [ModalController::class, 'index'])->name('modal');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
});
