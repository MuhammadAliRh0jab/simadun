<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected $fillable = [
        'directories',
        'judul',
        'filename',
        'mimetype',
        'filesize',

        'created_by',
        'updated_by',
        'activations'
    ];
}
