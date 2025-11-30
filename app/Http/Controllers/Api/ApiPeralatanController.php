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
    // PUT /api/peralatan/update-kondisi/{kode}
    public function updateKondisi(Request $request, $kode)
    {
        $request->validate([
            'kondisi_terkini' => 'required|string|max:255',
        ]);

        $peralatan = Peralatan::where('kode', $kode)->first();

        if (!$peralatan) {
            return response()->json([
                'message' => 'Peralatan tidak ditemukan'
            ], 404);
        }

        $peralatan->kondisi_terkini = $request->kondisi_terkini;
        $peralatan->save();

        return response()->json([
            'message' => 'Kondisi terkini berhasil diupdate',
            'data' => $peralatan
        ]);
    }

    public function updateKondisiBulk(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.kode' => 'required|string',
            'items.*.kondisi_terkini' => 'required|string|max:255',
        ]);

        $updated = [];
        $notFound = [];

        foreach ($request->items as $item) {
            $peralatan = Peralatan::where('kode', $item['kode'])->first();

            if ($peralatan) {
                $peralatan->kondisi_terkini = $item['kondisi_terkini'];
                $peralatan->save();

                $updated[] = [
                    'kode' => $peralatan->kode,
                    'kondisi_terkini' => $peralatan->kondisi_terkini
                ];
            } else {
                $notFound[] = $item['kode'];
            }
        }

        return response()->json([
            'message' => 'Bulk update selesai',
            'updated' => $updated,
            'not_found' => $notFound
        ]);
    }




}
