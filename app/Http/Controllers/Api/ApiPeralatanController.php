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
        // $data = Peralatan::where('kode', $kode)->first();
        // return response()->json($data);
        $data = Peralatan::where('kode', $kode)
        ->with([
            'hardwares' => function($q) {
                $q->where('status', 'terpasang');     // hanya hardware terpasang
            },
            'pemeliharaans' => function($q) {
                $q->orderBy('tanggal', 'desc')->limit(1);               // ambil 2 terakhir
            }
        ])
        ->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Peralatan tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
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

    public function getMetadata($kode)
    {
        $peralatan = Peralatan::where('kode', $kode)->first();

        if (!$peralatan) {
            return response()->json(['message' => 'Peralatan tidak ditemukan'], 404);
        }

        return response()->json([
            'kode' => $peralatan->kode,
            'metadata' => $peralatan->metadata ?? [],
        ]);
    }

    public function getNetworkData($kode)
    {
        $peralatan = Peralatan::where('kode', $kode)->first();

        if (!$peralatan) {
            return response()->json(['message' => 'Peralatan tidak ditemukan'], 404);
        }

        return response()->json([
            'kode' => $peralatan->kode,
            'networkData' => $peralatan->networkData ?? [],
        ]);
    }

    public function getPemeliharaanByKode($kode)
{
    $peralatan = Peralatan::where('kode', $kode)->first();

    if (!$peralatan) {
        return response()->json(['error' => 'Peralatan tidak ditemukan'], 404);
    }

    $pemeliharaan_tahun_ini = $peralatan->pemeliharaans()
        ->whereYear('tanggal', \Carbon\Carbon::now()->year)
        ->count();
    // Ambil semua pemeliharaan terkait
    $pemeliharaans = $peralatan->pemeliharaans()
        ->orderBy('tanggal', 'desc')
        ->limit(1)
        ->get()
        ->map(function ($p) {
            return [
                'tanggal' => $p->tanggal,
                'jenis_pemeliharaan' => $p->jenis_pemeliharaan,
                'rekomendasi' => $p->rekomendasi,
                'kerusakan' => $p->kerusakan,
                'pelaksana' => $p->pelaksana,
                'gambar' => $p->gambar,
                'laporan' => $p->laporan,
                'laporan2' => $p->laporan2,
                'text_wa' => $p->text_wa,
                'catatan_pemeliharaan' => $p->catatan_pemeliharaan,
                'url_gambar' => $p->gambar ? url("storage/uploads/gambar_pemeliharaan/" . $p->gambar) : null,
                'url_laporan' => $p->laporan ? url("storage/uploads/laporan_pemeliharaan/" . $p->laporan) : null,
            ];
        });

    return response()->json([
        'kode' => $peralatan->kode,
        'lokasi' => $peralatan->lokasi,
        'pemeliharaan_' . \Carbon\Carbon::now()->year => $pemeliharaan_tahun_ini,
        'pemeliharaan_terbaru' => $pemeliharaans,
    ]);
}







}
