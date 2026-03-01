<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mahasiswa\LengkapiProfilController;

Route::group(['middleware' => 'role:mahasiswa'], function () {
    Route::resource('/lengkapi-profil', LengkapiProfilController::class)->names('mahasiswa.lengkapi-profil');
});

