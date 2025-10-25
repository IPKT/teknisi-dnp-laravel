<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sparepart;
use App\Models\Peralatan;

class SparepartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
      public function index()
    {
        $spareparts = Sparepart::all();
        $jenis_peralatan = Peralatan::select('jenis')->distinct()->pluck('jenis');
        $jenisBarangList = Sparepart::select('jenis_barang')->distinct()->pluck('jenis_barang');
        $sumberPengadaanList = Sparepart::select('sumber_pengadaan')->distinct()->pluck('sumber_pengadaan');
        $lokasiPemasanganList = Peralatan::select('kode')->distinct()->pluck('kode');

        // dd($jenisPeralatan);
        return view('sparepart.index', compact('spareparts', 'jenis_peralatan','jenisBarangList', 'sumberPengadaanList','lokasiPemasanganList'));
    }

    public function filterByStatus($status)
    {
        if ($status === 'All') {
            $spareparts = Sparepart::all();
        } else {
            $spareparts = Sparepart::where('status', $status)->get();
        }
        $jenis_peralatan = Peralatan::select('jenis')->distinct()->pluck('jenis');
        $jenisBarangList = Sparepart::select('jenis_barang')->distinct()->pluck('jenis_barang');
        $sumberPengadaanList = Sparepart::select('sumber_pengadaan')->distinct()->pluck('sumber_pengadaan');
        $lokasiPemasanganList = Peralatan::select('kode')->distinct()->pluck('kode');

        return view('sparepart.index', compact('spareparts', 'status','jenis_peralatan','jenisBarangList', 'sumberPengadaanList','lokasiPemasanganList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    $validated = $request->validate([
        'jenis_barang' => 'required|string|max:100',
        'jenis_peralatan' => 'required|string|max:50',
        'sumber_pengadaan' => 'required|string|max:100',
        'tahun_masuk' => 'required|digits:4',
        'tanggal_masuk' => 'nullable|date',
        'merk' => 'required|string|max:50',
        'tipe' => 'required|string|max:50',
        'serial_number' => 'nullable|string|max:100',
        'status'=> 'required|string|max:50',
        'tanggal_keluar' => 'nullable|date',
        'lokasi_pemasangan' => 'nullable|string|max:100',
        'lokasi_pengiriman' => 'nullable|string|max:100',
        'berkas' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
    ]);
    $time = time();
    if ($request->hasFile('berkas')) {
            //  $validated['file_dokumen'] = $request->file('file_dokumen')->store('uploads/dokumen', 'public');
            
            $filename = $request['jenis_peralatan'] . '_' . $request['tahun_masuk'] .'_'.$time. '.' . $request->file('berkas')->getClientOriginalExtension();
            $validated['berkas'] = $request->file('berkas')->storeAs('uploads/sparepart', $filename, 'public');
        }

    $sparepart = Sparepart::create($validated);

    return response()->json([
        'success' => true,
        'sparepart' => $sparepart
    ]);
}

    /**
     * Display the specified resource.
     */
    public function show(Sparepart $sparepart)
    {
         return response()->json($sparepart);

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
        'jenis_barang' => 'required|string|max:100',
        'jenis_peralatan' => 'required|string|max:50',
        'sumber_pengadaan' => 'required|string|max:100',
        'tahun_masuk' => 'required|digits:4',
        'tanggal_masuk' => 'nullable|date',
        'merk' => 'required|string|max:50',
        'tipe' => 'required|string|max:50',
        'serial_number' => 'nullable|string|max:100',
        'status'=> 'required|string|max:50',
        'tanggal_keluar' => 'nullable|date',
        'lokasi_pemasangan' => 'nullable|string|max:100',
        'lokasi_pengiriman' => 'nullable|string|max:100',
        'berkas' => 'nullable|file|mimes:pdf,doc,docx,jpg,png,jpeg,webp|max:2048',
    ]);

   

    $sparepart = Sparepart::findOrFail($id);
    $time = time();
    if ($request->hasFile('berkas')) {
            //  $validated['file_dokumen'] = $request->file('file_dokumen')->store('uploads/dokumen', 'public');
        if ($sparepart->berkas && file_exists(storage_path('app/public/'.$sparepart->berkas))) {
            unlink(storage_path('app/public/'.$sparepart->berkas));
        }
            $filename = $request['jenis_peralatan'] . '_' . $request['tahun_masuk'] .'_'.$time. '.' . $request->file('berkas')->getClientOriginalExtension();
            $validated['berkas'] = $request->file('berkas')->storeAs('uploads/sparepart', $filename, 'public');
        }

    $sparepart->update($validated);

    return response()->json([
        'success' => true,
        // 'sparepart' => $sparepart
    ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}