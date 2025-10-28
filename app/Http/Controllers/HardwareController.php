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
            'jenis_hardware' => 'required|string|max:100',
            'jenis_peralatan' => 'required|string|max:50',
            'tahun_masuk' => 'required|digits:4',
            'tanggal_masuk' => 'nullable|date',
            'merk' => 'required|string|max:50',
            'tipe' => 'required|string|max:50',
            'serial_number' => 'nullable|string|max:100',
            'status'=> 'required|string|max:50',
            'sumber_pengadaan' => 'required|string|max:100',
            'tanggal_keluar' => 'nullable|date',
            'tanggal_dilepas' => 'nullable|date',
            'lokasi_pemasangan' => 'nullable|string|max:100',
            'lokasi_pengiriman' => 'nullable|string|max:100',
            'nomor_surat' => 'nullable|string|max:100',
            'keterangan' => 'nullable|string|max:200',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'berkas' => 'nullable|file|mimes:pdf|max:2048',
            
            // 'tanggal_pelepasan' => 'nullable|date',
        ]);
        $time = time();
        if ($validated['serial_number'] == null){
            $validated['serial_number'] = $validated['jenis_peralatan'].'_'.$validated['jenis_hardware'].'_'.$time;
        } 

        
        // $validated['author'] = $request->user()->id;
        if ($request->hasFile('berkas')) {
            //  $validated['file_dokumen'] = $request->file('file_dokumen')->store('uploads/dokumen', 'public');
            
            $filename = 'berkas' . '_' . $request['jenis_hardware'] .'_'.$time. '.' . $request->file('berkas')->getClientOriginalExtension();
            $validated['berkas'] = $request->file('berkas')->storeAs('uploads/hardware', $filename, 'public');
        }
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

    $hardware = Hardware::findOrFail($id);

      $validated = $request->validate([
            'jenis_hardware' => 'required|string|max:100',
            'jenis_peralatan' => 'required|string|max:50',
            'tahun_masuk' => 'required|digits:4',
            'tanggal_masuk' => 'nullable|date',
            'merk' => 'required|string|max:50',
            'tipe' => 'required|string|max:50',
            'serial_number' => 'nullable|string|max:100',
            'status'=> 'required|string|max:50',
            'sumber_pengadaan' => 'required|string|max:100',
            'tanggal_keluar' => 'nullable|date',
            'tanggal_dilepas' => 'nullable|date',
            'lokasi_pemasangan' => 'nullable|string|max:100',
            'lokasi_pengiriman' => 'nullable|string|max:100',
            'nomor_surat' => 'nullable|string|max:100',
            'keterangan' => 'nullable|string|max:200',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'berkas' => 'nullable|file|mimes:pdf|max:2048',
    ]);
    
    
    $time = time();
    
    if($validated['status'] == 'ready'){
        $validated['tanggal_keluar'] = null;
        $validated['tanggal_dilepas'] = null;
        $validated['lokasi_pemasangan'] = null;
        $validated['lokasi_pengiriman'] = null;
        $validated['nomor_surat'] = null;
        $validated['berkas'] = null;
        if ($hardware->berkas && file_exists(storage_path('app/public/'.$hardware->berkas))) {
            unlink(storage_path('app/public/'.$hardware->berkas));
        }
    } elseif ($validated['status'] == 'terpasang') {
        $validated['tanggal_dilepas'] = null;
        $validated['lokasi_pengiriman'] = null;
    } elseif ($validated['status'] == 'dilepas') {
        $validated['lokasi_pengiriman'] = null;
    } 

    if ($request->hasFile('berkas')) {
            if ($hardware->berkas && file_exists(storage_path('app/public/'.$hardware->berkas))) {
            unlink(storage_path('app/public/'.$hardware->berkas));
            }
            $filename = 'berkas' . '_' . $request['jenis_hardware'] .'_'.$time. '.' . $request->file('berkas')->getClientOriginalExtension();
            $validated['berkas'] = $request->file('berkas')->storeAs('uploads/hardware', $filename, 'public');
        }
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