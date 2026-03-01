<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;

class DetailMahasiswa extends Model implements Authenticatable
{
    use AuthenticatableTrait;
    protected $table = 'detail_mahasiswas';
    protected $fillable = [
        'nama',
        'nim',
        'no_hp',
        'email_um',
        'email_lain',
        'alamat_malang',
        'alamat_asal',
        'asal_instansi',
        'PT_S1',
        'PT_S2',
        'skor_TPA',
        'skor_toefl',
    ];


}
