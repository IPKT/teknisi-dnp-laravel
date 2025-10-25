<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hardware;
use App\Models\JenisHardware;
use App\Models\Peralatan;
use Illuminate\Support\Facades\Auth;

class HardwareController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hardwares = Hardware::all();
        $jenis_peralatan = Peralatan::select('jenis')->distinct()->pluck('jenis');
        $jenisHardwareList = Hardware::select('jenis_hardware')->distinct()->pluck('jenis_hardware');
        $sumberPengadaanList = Hardware::select('sumber_pengadaan')->distinct()->pluck('sumber_pengadaan');
        $lokasiPemasanganList = Peralatan::select('kode')->distinct()->pluck('kode');
        $peralatans  = Peralatan::all();
        // dd($jenisPeralatan);
        return view('hardware.index', compact('hardwares', 'jenis_peralatan','jenisHardwareList', 'sumberPengadaanList','lokasiPemasanganList', 'peralatans'));
        // return view('hardware.index', compact('hardwares'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jenis_hardware = JenisHardware::all();
        $peralatans = Peralatan::all();
        return view('hardware.create', compact('jenis_hardware', 'peralatans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'id_peralatan' => 'required|exists:peralatans,id',
        //     'jenis_hardware' => 'required|max:100',
        //     'merk' => 'required|max:100',
        //     'tipe' => 'required|max:100',
        //     'status' => 'required|max:100',
        // ]);

        // Hardware::create($request->all());
        // return redirect()->route('hardware.create')->with('success', 'Data Hardware berhasil ditambahkan.');

       
        $validated = $request->validate([
            'id_peralatan' => 'required|exists:peralatans,id',
            'jenis_hardware' => 'required|string|max:100',
            'merk' => 'required|string|max:100',
            'tipe' => 'required|string|max:100',
            'serial_number' => 'required|string|max:100',
            'tanggal_pemasangan' => 'required|date',
            'status' => 'required|string|max:100',
            'tanggal_pelepasan' => 'nullable|date',
        ]);
        $validated['author'] = $request->user()->id;
        $hardware = Hardware::create($validated);

        return response()->json([
            'success' => true,
            'hardware' => $hardware
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Hardware $hardware)
    {
        return response()->json($hardware);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
      $validated = $request->validate([
        // 'id_peralatan' => 'required|exists:peralatans,id',
        'jenis_hardware' => 'required|string|max:100',
        'merk' => 'required|string|max:100',
        'tipe' => 'required|string|max:100',
        'serial_number' => 'required|string|max:100',
        'tanggal_pemasangan' => 'required|date',
        'status' => 'required|string|max:100',
        'tanggal_pelepasan' => 'nullable|date',
    ]);

    $hardware = Hardware::findOrFail($id);
    $hardware->update($validated);

    return response()->json([
        'success' => true,
        'hardware' => $hardware
    ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
        $hardware = Hardware::findOrFail($id);
        if ($hardware->author != Auth::user()->id and Auth::user()->role != 'teknisi' and Auth::user()->role != 'admin' ) {
            return redirect()->route('pemeliharaan.index');
        }
        $hardware->delete();
        return response()->json([
            'success' => true
        ]);
    }
}