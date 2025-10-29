<?php

namespace App\Http\Controllers;

use App\Models\Peralatan;
use Illuminate\Http\Request;
use App\Models\JenisHardware;
use Illuminate\Support\Facades\Auth;

class PeralatanController extends Controller
{
    public function index()
    {
        $peralatans = Peralatan::all();
        return view('peralatan.index', compact('peralatans'));
    }

    public function filterByJenis($jenis)
    {
        if ($jenis === 'All') {
            $peralatans = Peralatan::all();
        } else {
            $peralatans = Peralatan::where('jenis', $jenis)->get();
        }

        return view('peralatan.index', compact('peralatans', 'jenis'));
    }



    public function create()
    {
        return view('peralatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|max:50',
            'koordinat' => 'required|max:50',
            'lokasi' => 'required|max:50',
            'kondisi_terkini' => 'required',
            'jenis' => 'required|max:100',
        ]);

        Peralatan::create($request->all());

        return redirect()->route('peralatan.index')
            ->with('success', 'Data peralatan berhasil ditambahkan.');
    }

    public function edit(Peralatan $peralatan)

    {
        if (Auth::user()->role != 'teknisi' and Auth::user()->role != 'admin') {
            return redirect()->route('peralatan.index');
        }
        return view('peralatan.edit', compact('peralatan'));
    }

    public function update(Request $request, Peralatan $peralatan)
    {
        $request->validate([
            'kode' => 'required|max:50',
            'koordinat' => 'required|max:50',
            'lokasi' => 'required|max:50',
            'kondisi_terkini' => 'required',
            'jenis' => 'required|max:100',
        ]);

        $peralatan->update($request->all());

        return redirect()->route('peralatan.index')
            ->with('success', 'Data peralatan berhasil diperbarui.');
    }

    public function destroy(Peralatan $peralatan)
    {
        // $peralatan->delete();
        return redirect()->route('peralatan.index')
            ->with('success', 'DILARANG MENGHAPUS PERALATAN !!!');
    }


    public function detailPeralatan(Peralatan $peralatan)
    {

        $pemeliharaan = $peralatan->pemeliharaans;
        // $hardware = $peralatan->hardwares;
        $hardware = $peralatan->hardwares()
            ->where('status', 'terpasang')
            ->orderBy('tanggal_keluar', 'desc')
            ->get();
        $dokumen = $peralatan->dokumens;
        $jenis_hardware = JenisHardware::all();
        $jumlahPemeliharaan = $peralatan->pemeliharaans()->count();
        $terbaru = $peralatan->pemeliharaans()->orderByDesc('tanggal')->first();
        return view('peralatan.detail', compact('peralatan', 'pemeliharaan', 'jumlahPemeliharaan', 'terbaru', 'hardware', 'dokumen', 'jenis_hardware'));
    }

    public function getByJenis(Request $request)
    {
        $jenis = $request->jenis;

        $peralatans = Peralatan::where('jenis', $jenis)->get();

        return response()->json($peralatans);
    }

    public function show(Peralatan $peralatan)
    {

        $pemeliharaan = $peralatan->pemeliharaans;
        $hardware = $peralatan->hardwares->where('status', 'terpasang');
        $dokumen = $peralatan->dokumens;
        $jenis_hardware = JenisHardware::all();
        $jumlahPemeliharaan = $peralatan->pemeliharaans()->count();
        $terbaru = $peralatan->pemeliharaans()->orderByDesc('tanggal')->first();
        return view('peralatan.show', compact('peralatan', 'pemeliharaan', 'jumlahPemeliharaan', 'terbaru', 'hardware', 'dokumen', 'jenis_hardware'));
    }
}
