<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\ReservationController;

Route::get('/', [CarController::class, 'index'])->name('welcome');

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile',[AuthController::class, 'showProfile'])->name('showProfile');
    Route::delete('/profile', [AuthController::class, 'destroy'])->name('auth.destroy');
    Route::post('/reservation/{masina}', [ReservationController::class, 'store'])->name('reservation.store');
    Route::get('/reservations', [ReservationController::class, 'show'])->name('reservations.show');
    Route::delete('/reservations{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
});