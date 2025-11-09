<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hardware;
use App\Models\JenisHardware;
use App\Models\Peralatan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Imports\HardwareImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\HardwareExport;

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
        return view('hardware.index', compact('hardwares', 'jenis_peralatan', 'jenisHardwareList', 'sumberPengadaanList', 'lokasiPemasanganList', 'peralatans'));
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
            'status' => 'required|string|max:50',
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
        if ($validated['serial_number'] == null) {
            $validated['serial_number'] = $validated['tahun_masuk'] . '_' . uniqid();
        }


        // $validated['author'] = $request->user()->id;
        if ($request->hasFile('gambar')) {
            //  $validated['file_dokumen'] = $request->file('file_dokumen')->store('uploads/dokumen', 'public');

            $filename = $request['jenis_hardware'] . '_' . $time . '.' . $request->file('gambar')->getClientOriginalExtension();
            $request->file('gambar')->storeAs('uploads/gambar_hardware', $filename, 'public');
            $validated['gambar'] = $filename;
        }
        if ($request->hasFile('berkas')) {
            //  $validated['file_dokumen'] = $request->file('file_dokumen')->store('uploads/dokumen', 'public');

            $filename = $request['jenis_hardware'] . '_' . $time . '.' . $request->file('berkas')->getClientOriginalExtension();
            $request->file('berkas')->storeAs('uploads/berkas_hardware', $filename, 'public');
            $validated['berkas'] = $filename;
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
        // return response()->json($hardware);
        // return response()->json([
        //     'hardware' => $hardware,
        //     'peralatan' => $hardware->peralatan,
        // ]);

        $hardware->load('peralatan'); // pastikan relasi dimuat
        $data = $hardware->toArray();
        $data['kode_lokasi_pemasangan'] = $hardware->peralatan?->kode;
        $data['lokasi_pemasangan_url'] = $hardware->peralatan
            ? route('peralatan.show', $hardware->peralatan->id)
            : null;


        return response()->json($data);
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
            'jenis_hardware' => 'required|string|max:100',
            'jenis_peralatan' => 'required|string|max:50',
            'tahun_masuk' => 'required|digits:4',
            'tanggal_masuk' => 'nullable|date',
            'merk' => 'required|string|max:50',
            'tipe' => 'required|string|max:50',
            'serial_number' => '|string|max:100',
            'status' => 'required|string|max:50',
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

        $hardware = Hardware::findOrFail($id);
        $time = time();

        if ($validated['status'] == 'ready') {
            $validated['tanggal_keluar'] = null;
            $validated['tanggal_dilepas'] = null;
            $validated['lokasi_pemasangan'] = null;
            $validated['lokasi_pengiriman'] = null;
            $validated['nomor_surat'] = null;
            $validated['berkas'] = null;
            if ($hardware->berkas && file_exists(storage_path('app/public/' . $hardware->berkas))) {
                unlink(storage_path('app/public/' . $hardware->berkas));
            }
        } elseif ($validated['status'] == 'terpasang') {
            $validated['tanggal_dilepas'] = null;
            $validated['lokasi_pengiriman'] = null;
        } elseif ($validated['status'] == 'dilepas') {
            $validated['lokasi_pengiriman'] = null;
        }

        if ($request->hasFile('berkas')) {
            if ($hardware->berkas && file_exists(storage_path('app/public/uploads/berkas_hardware/' . $hardware->berkas))) {
                unlink(storage_path('app/public/uploads/berkas_hardware/' . $hardware->berkas));
            }
            $filename = 'berkas' . '_' . $request['jenis_hardware'] . '_' . $time . '.' . $request->file('berkas')->getClientOriginalExtension();
            $request->file('berkas')->storeAs('uploads/berkas_hardware', $filename, 'public');
            $validated['berkas'] = $filename;
        
        }

           if ($request->hasFile('gambar')) {
            if ($hardware->gambar && file_exists(storage_path('app/public/uploads/gambar_hardware/' . $hardware->gambar))) {
                unlink(storage_path('app/public/uploads/gambar_hardware/' . $hardware->gambar));
            }
            $filename = 'gambar' . '_' . $request['jenis_hardware'] . '_' . $time . '.' . $request->file('gambar')->getClientOriginalExtension();
            $request->file('gambar')->storeAs('uploads/gambar_hardware', $filename, 'public');
            $validated['gambar'] = $filename;
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
        if (Auth::user()->role != 'teknisi' and Auth::user()->role != 'admin') {
            return redirect()->route('hardware.index');
        }
        if ($hardware->berkas && file_exists(storage_path('app/public/' . $hardware->berkas))) {
            unlink(storage_path('app/public/' . $hardware->berkas));
        }
        $hardware->delete();
        return response()->json([
            'success' => true
        ]);
    }

    public function hardwarePeralatan($id, $kode)
    {
        $peralatan_id = $id;
        $hardwares = Hardware::where('lokasi_pemasangan', $id)
            ->orderBy('status', 'desc')
            ->get();
        $jenis_peralatan = Peralatan::select('jenis')->distinct()->pluck('jenis');
        $jenisHardwareList = Hardware::select('jenis_hardware')->distinct()->pluck('jenis_hardware');
        $sumberPengadaanList = Hardware::select('sumber_pengadaan')->distinct()->pluck('sumber_pengadaan');
        $lokasiPemasanganList = Peralatan::select('kode')->distinct()->pluck('kode');
        $peralatans  = Peralatan::all();
        // dd($jenisPeralatan);
        return view('hardware.index', compact('hardwares', 'jenis_peralatan', 'jenisHardwareList', 'sumberPengadaanList', 'lokasiPemasanganList', 'peralatans', 'kode', 'peralatan_id'));
    }

    public function filterByStatus($status)
    {
        if ($status === 'All') {
            $hardwares = Hardware::all();
        } else {
            $hardwares = Hardware::where('status', $status)->get();
        }

        $jenis_peralatan = Peralatan::select('jenis')->distinct()->pluck('jenis');
        $jenisHardwareList = Hardware::select('jenis_hardware')->distinct()->pluck('jenis_hardware');
        $sumberPengadaanList = Hardware::select('sumber_pengadaan')->distinct()->pluck('sumber_pengadaan');
        $lokasiPemasanganList = Peralatan::select('kode')->distinct()->pluck('kode');
        $peralatans  = Peralatan::all();
        // dd($jenisPeralatan);
        return view('hardware.index', compact('hardwares', 'jenis_peralatan', 'jenisHardwareList', 'sumberPengadaanList', 'lokasiPemasanganList', 'peralatans'));
    }

    public function rekapPengadaan($tahun){
        $jenis_peralatan = Hardware::select('jenis_peralatan')->distinct()->pluck('jenis_peralatan');

        $rekap_peralatan = [];

        foreach ($jenis_peralatan as $jenis) {
            $rekap = Hardware::select(
                'jenis_hardware',
                DB::raw("SUM(CASE WHEN status = 'ready' THEN 1 ELSE 0 END) as ready"),
                DB::raw("SUM(CASE WHEN status = 'terpasang' THEN 1 ELSE 0 END) as terpasang"),
                DB::raw("SUM(CASE WHEN status = 'terkirim' THEN 1 ELSE 0 END) as terkirim"),
                DB::raw("SUM(CASE WHEN status = 'dilepas' THEN 1 ELSE 0 END) as dilepas"),
                DB::raw("COUNT(*) as total")
            )
            ->when($tahun !== 'All', function ($query) use ($tahun) {
                return $query->where('tahun_masuk', $tahun);
            })
            ->where('jenis_peralatan', $jenis)
            ->where('sumber_pengadaan', 'Pengadaan DNP')
            ->groupBy('jenis_hardware')
            ->get();

            if ($rekap->isEmpty()) {
                continue;
            }

            $rekap_peralatan[$jenis] = $rekap;
        }

        return view('hardware.rekap_pengadaan', compact('rekap_peralatan', 'tahun'));
    }

    public function detailPengadaan($tahun)
    {
        $jenis_peralatan_yang_ada = Hardware::when($tahun !== 'All', function ($query) use ($tahun) {
                return $query->where('tahun_masuk', $tahun);
            })
            ->select('jenis_peralatan')
            ->distinct()
            ->pluck('jenis_peralatan');

        foreach ($jenis_peralatan_yang_ada as $jenis) {
            $data = Hardware::when($tahun !== 'All', function ($query) use ($tahun) {
                return $query->where('tahun_masuk', $tahun);
            })
            ->where('sumber_pengadaan', 'Pengadaan DNP')
            ->where('jenis_peralatan', $jenis)
                ->get();

            if($data->isEmpty()){
                continue;
            }
            $hardwares[$jenis] = $data;
        }


        // $hardwares = Hardware::where('tahun_masuk', $tahun)->get();
        $jenis_peralatan = Peralatan::select('jenis')->distinct()->pluck('jenis');
        $jenisHardwareList = Hardware::select('jenis_hardware')->distinct()->pluck('jenis_hardware');
        $sumberPengadaanList = Hardware::select('sumber_pengadaan')->distinct()->pluck('sumber_pengadaan');
        $lokasiPemasanganList = Peralatan::select('kode')->distinct()->pluck('kode');
        $peralatans  = Peralatan::all();
        // dd($jenisPeralatan);
        return view('hardware.detail_pengadaan', compact('hardwares', 'jenis_peralatan', 'jenisHardwareList', 'sumberPengadaanList', 'lokasiPemasanganList', 'peralatans' , 'tahun'));
        // return view('hardware.index', compact('hardwares'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);
        try {
            Excel::import(new HardwareImport, $request->file('excel_file'));
            return redirect()->back()->with('success', 'Data hardware berhasil diimport!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat import: ' . $e->getMessage());
        }
    }

    
    // public function download($peralatanId)
    // {
    //     $peralatan = Peralatan::find($peralatanId);

    //     if (!$peralatan) {
    //         return redirect()->back()->with('error', 'Peralatan tidak ditemukan!');
    //     }

    //     $fileName = 'hardware_' . $peralatan->kode . '.xlsx';

    //     return Excel::download(new HardwareExport($peralatanId), $fileName);
    // }
    // public function download($key, $value)
    // {
    //     // $peralatan = Peralatan::find($value);

    //     // if (!$peralatan) {
    //     //     return redirect()->back()->with('error', 'Peralatan tidak ditemukan!');
    //     // }

    //     $fileName = 'hardware_' . $key . '_' . $value . '.xlsx';
    //     $where_query = [$key => $value];

    //     return Excel::download(new HardwareExport($where_query), $fileName);
    // }

    public function download(Request $request)
{
     dd('Route works!', $request->all());

    
    $where_query = $request->only([
        'lokasi_pemasangan',
        'sumber_pengadaan',
        'tahun_masuk',
        'status',
        // tambahkan key lain jika perlu
    ]);

    // Optional: validasi minimal 1 filter
    if (empty($where_query)) {
        return redirect()->back()->with('error', 'Minimal satu filter harus diisi!');
    }

    // Ambil salah satu untuk nama file
    // $peralatan = Peralatan::find($request->lokasi_pemasangan);
    // $kode = $peralatan ? $peralatan->kode : 'filtered';

    $fileName = 'hardware_' . uniqid() . '.xlsx';

    return Excel::download(new HardwareExport($where_query), $fileName);
}
}
