<?php

namespace App\Models;

use App\Traits\AuthRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Mahasiswa extends Model implements Authenticatable
{
    use AuthenticatableTrait, AuthRole;

    protected $guarded = [];
    protected $hidden = ['password'];

    public function pendaftaranUjian()
    {
        return $this->hasMany(PendaftaranUjian::class, 'nim', 'nim');
    }

    /**
     * Get detail mahasiswa
     *
     * @return HasOne
     */
    public function detail() : HasOne {
        return $this->hasOne(DetailMahasiswa::class, 'nim', 'nim');
    }
}
