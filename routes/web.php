<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RideController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReviewController;

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
    Route::get('/edit-profile',[AuthController::class, 'edit'])->name('auth.edit');
    Route::put('/profile-update',[AuthController::class, 'update'])->name('auth.update');
    Route::delete('/profile', [AuthController::class, 'destroy'])->name('auth.destroy');
    Route::post('/reservation/{masina}', [ReservationController::class, 'store'])->name('reservation.store');
    Route::get('/reservations', [ReservationController::class, 'show'])->name('reservations.show');
    Route::delete('/reservations{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
    Route::post('/ride/{id}', [RideController::class, 'begin'])->name('ride.begin');
    Route::post('/ride/{id}/end', [RideController::class, 'end'])->name('ride.end');
});

Route::post('/ride/{id}/pay', [PaymentController::class, 'pay'])
    ->name('ride.pay')
    ->middleware('auth');

Route::get('/ride/{id}/payment-success', [PaymentController::class, 'success'])
    ->name('ride.payment.success')
    ->middleware('auth');

Route::get('/ride/{id}/payment-cancel', [PaymentController::class, 'cancel'])
    ->name('ride.payment.cancel')
    ->middleware('auth');

Route::get('/review/{ride}', [ReviewController::class, 'get'])
    ->name('review.get')
    ->middleware('auth');

Route::post('/review/{ride}', [ReviewController::class, 'submit'])
    ->name('review.submit')
    ->middleware('auth');