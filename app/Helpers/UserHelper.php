<?php
namespace App\Helpers;

class UserHelper
{
    public static function getMahasiswaPicture($nim)
    {
        $nim_year = substr($nim, 0, 2);
        $year = date('Y');
        $year = substr($year, 0, 2);
        $nim_year = $year . $nim_year;

        return "https://api.um.ac.id/akademik/operasional/GetFoto.ptikUM?nim=" . $nim . '&angkatan=' . $nim_year;
    }

    public static function getDosenPicture($nip)
    {
        return "https://simpega.um.ac.id/util/pegawai/foto/" . $nip;
    }

    public static function isKaprodi(){
        return auth()->guard('dosen')->user()->role == 'kaprodi';
    }

    public static function isDosen(){
        return auth()->guard('dosen')->user()->role == 'dosen';
    }

    public static function isDosenEks(){
        return auth()->guard('dosen')->user()->role == 'eksternal';
    }
}