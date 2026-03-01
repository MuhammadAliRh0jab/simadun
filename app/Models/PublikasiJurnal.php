<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublikasiJurnal extends Model
{
    use HasFactory;
    protected $guarded = [];

    // function to eager load the relationship on mahaasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function detail_mahasiswa()
    {
        return $this->belongsTo(DetailMahasiswa::class, 'nim', 'nim');
    }

    // public function getStatusAttribute($value)
    // {
    //     $status = [
    //         0 => '<span class="badge bg-label-secondary">Dalam Proses</span>',
    //         1 => '<span class="badge bg-label-success">Disetujui</span>',
    //         2 => '<span class="badge bg-label-warning">Revisi</span>',
    //     ];

    //     return $status[$value];

    // }
}
