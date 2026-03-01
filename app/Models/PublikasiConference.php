<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublikasiConference extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function detail_mahasiswa()
    {
        return $this->belongsTo(DetailMahasiswa::class, 'nim', 'nim');
    }
}
