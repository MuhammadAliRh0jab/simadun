<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dosen;

class SearchController extends Controller
{
    public function searchDosen(Request $request)
    {
        $nipNikOrNama = $request->nipNikOrNama;
        $dosens = Dosen::select('id', 'no_induk', 'nama')
            ->where('no_induk', 'like', '%' . $nipNikOrNama . '%')
            ->orWhere('nama', 'like', '%' . $nipNikOrNama . '%')
            ->get();
        return response()->json($dosens);
    }
    
    public function searchDosenEksternal(Request $request)
    {
        $nipNikOrNama = $request->nipNikOrNama;
        $dosens = Dosen::select('id', 'no_induk', 'nama')
            ->where('role', 'eksternal')
            ->where(function ($query) use ($nipNikOrNama) {
                $query->where('no_induk', 'like', '%' . $nipNikOrNama . '%')
                    ->orWhere('nama', 'like', '%' . $nipNikOrNama . '%');
            })
            ->get();
        return response()->json($dosens);
    }
}
