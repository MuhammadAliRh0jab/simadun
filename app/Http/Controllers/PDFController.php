<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function show($filename)
    {
        $path = storage_path('app/private/' . $filename);
        return response()->file($path);
    }
}
