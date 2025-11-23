<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Peralatan;
use Illuminate\Http\Request;

class ApiPeralatanController extends Controller
{
    // GET /api/peralatan
    public function index()
    {
        return response()->json(Peralatan::all());
    }

    public function getByKode($kode){
        $data = Peralatan::where('kode', $kode)->first();
        return response()->json($data);
    }


}
