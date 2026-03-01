<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory;

    protected $connection = 'second_db';
    protected $table = 'user';

    protected $fillable = ['password'];
    protected $primaryKey = 'user_id';
    public $incrementing = false; // Tambahkan ini
    protected $keyType = 'string'; // Atur sesuai tipe data di database

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */

}
