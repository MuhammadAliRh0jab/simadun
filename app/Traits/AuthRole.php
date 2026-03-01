<?php
namespace App\Traits;

use App\Models\Dosen;
use App\Models\Mahasiswa;

trait AuthRole
{
    public function getAuthRoleAttribute() : ?string
    {
        // check if current model is instance of Dosen
        if ($this instanceof Dosen) {
            return 'dosen';
        } else if ($this instanceof Mahasiswa) {
            return 'mahasiswa';
        }

        return null;
    }
}