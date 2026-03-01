<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::prefix('auth')->group(function () {
    Route::group(['middleware' => 'guest:mahasiswa,dosen'], function () {
        Route::get('login', [AuthController::class, 'login'])->name('auth.login');
        Route::post('login', [AuthController::class, 'store'])->name('auth.store');
    });
    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout'); // for testing only: get method

    Route::middleware('role:mahasiswa,dosen,eksternal,kaprodi')->group(function () {
        Route::get('password', [AuthController::class, 'password'])->name('auth.password');
        Route::post('password', [AuthController::class, 'updatePassword'])->name('auth.password.update');
    });
});

// change Pass mhs
Route::get('/change-pass-mhs/{nim}', [AuthController::class, 'ShowChangeMhs'])->name('change.password.mhs');
Route::post('/act-change-pass-mhs', [AuthController::class, 'saveChangePassMhs'])->name('new.password.mahasiswa');

// change Pass dsn
Route::get('/change-pass-dsn/{nim}', [AuthController::class, 'ShowChangeDsn'])->name('change.password.dsn');
Route::post('/act-change-pass-dsn', [AuthController::class, 'saveChangePassDsn'])->name('new.password.dosen');

// halaman find account
route::get('/forgot-password', [AuthController::class, 'lupaPassword'])->name('halaman.lupa-password');
route::post('/forgot-password-act', [AuthController::class, 'forgot_password_act'])->name('forgot.password.act');

route::get('/validasi-forgot-pass/{token}', [AuthController::class, 'val_forgot'])->name('val_forgot');
route::post('/validasi-forgot-pass-act', [AuthController::class, 'val_forgot_act'])->name('val_forgot.act');
