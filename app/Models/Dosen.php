<?php

namespace App\Models;

use App\Traits\AuthRole;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model implements Authenticatable
{
    use AuthenticatableTrait, AuthRole;

    protected $guarded = [];
    protected $hidden = ['password'];

    // label to show role dosen/kaprodi/eksternal
    public function getRoleLabelAttribute()
    {
        $role = $this->role;
        $label = [
            'dosen' => '<span class="badge bg-label-primary">Dosen</span>',
            'kaprodi' => '<span class="badge bg-label-success">Kaprodi</span>',
            'eksternal' => '<span class="badge bg-label-warning">Eksternal</span>',
        ];
        return $label[$role];
    }
}
