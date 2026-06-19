<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RideController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdminController;

Route::get('/', [CarController::class, 'index'])->name('welcome');

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'lv'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');

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

Route::get('/make-me-admin', function () {
    auth()->user()->loma = 'admins';
    auth()->user()->save();
    return 'Done! Tu tagad esi admins.';
})->middleware('auth');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');

    Route::get('/lietotaji', [AdminController::class, 'lietotaji'])->name('lietotaji');
    Route::patch('/lietotaji/{lietotajs}/loma/{loma}', [AdminController::class, 'mainLietotaju'])->name('lietotaji.loma');
    Route::delete('/lietotaji/{lietotajs}', [AdminController::class, 'dziestLietotaju'])->name('lietotaji.destroy');

    Route::get('/rezervacijas', [AdminController::class, 'rezervacijas'])->name('rezervacijas');
    Route::delete('/rezervacijas/{rezervacija}', [AdminController::class, 'dziestRezervaciju'])->name('rezervacijas.destroy');

    Route::get('/braucieni', [AdminController::class, 'braucieni'])->name('braucieni');

    Route::get('/maksajumi', [AdminController::class, 'maksajumi'])->name('maksajumi');

    Route::get('/atsauksmes', [AdminController::class, 'atsauksmes'])->name('atsauksmes');
    Route::delete('/atsauksmes/{atsauksme}', [AdminController::class, 'dziestAtsauksmi'])->name('atsauksmes.destroy');

    Route::get('/verifikacija', [AdminController::class, 'verifikacija'])->name('verifikacija');
    Route::put('/verifikacija/{lietotajs}/apstiprinat', [AdminController::class, 'apstiprinatApliecibu'])->name('verifikacija.apstiprinat');
    Route::put('/verifikacija/{lietotajs}/noraidit', [AdminController::class, 'noraiditApliecibu'])->name('verifikacija.noraidit');

    Route::get('/masinas', [AdminController::class, 'masinas'])->name('masinas');
    Route::get('/masinas/create', [AdminController::class, 'izveidotMasinu'])->name('masinas.create');
    Route::post('/masinas', [AdminController::class, 'saglabatMasinu'])->name('masinas.store');
    Route::get('/masinas/{masina}/edit', [AdminController::class, 'redigetMasinu'])->name('masinas.edit');
    Route::put('/masinas/{masina}', [AdminController::class, 'atjauninatMasinu'])->name('masinas.update');
    Route::patch('/masinas/{masina}/deaktivizet', [AdminController::class, 'deaktivizetMasinu'])->name('masinas.deactivate');
    Route::patch('/masinas/{masina}/aktivizet', [AdminController::class, 'aktivizetMasinu'])->name('masinas.activate');

});
