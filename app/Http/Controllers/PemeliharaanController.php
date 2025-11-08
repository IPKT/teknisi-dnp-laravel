<?php

namespace App\Http\Controllers;

use App\Models\Pemeliharaan;
use App\Models\Peralatan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class PemeliharaanController extends Controller
{
    public function index()
    {
        // $pemeliharaans = Pemeliharaan::with('peralatan')->latest()->get()->sortByDesc('tanggal');
        // return view('pemeliharaan.index', compact('pemeliharaans'));
        $jenis_peralatan = Peralatan::select('jenis')->distinct()->pluck('jenis');

        // $tahun_sekarang = Carbon::now()->startOfYear()->format('Y-m-d');
        $tahun_kemarin = Carbon::now()->subYear()->startOfYear()->format('Y-m-d');

        foreach ($jenis_peralatan as $jenis) {
            $pemeliharaansByJenis[$jenis] = Pemeliharaan::whereHas('peralatan', function ($query) use ($jenis) {
                $query->where('jenis', $jenis);
            })->with('peralatan')->where('tanggal', '>=', $tahun_kemarin)->latest()->get()->sortByDesc('tanggal');
        }

        $date = Carbon::createFromFormat('Y-m-d', $tahun_kemarin);
        $tahun_awal_data = $date->format('Y');

        // dd($pemeliharaansByJenis);

        return view('pemeliharaan.index', compact( 'pemeliharaansByJenis', 'tahun_awal_data'));
        
    }

    public function create()
    {
        $peralatans = Peralatan::all();
        return view('pemeliharaan.create', compact('peralatans'));
    }

 public function store(Request $request)
    {
        $request['author'] = $request->user()->id;
        $request->validate([
            'id_peralatan' => 'required|exists:peralatans,id',
            'kondisi_awal' => 'required|max:20',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'laporan' => 'nullable|mimes:pdf|max:4096',
            'laporan2' => 'nullable|mimes:pdf|max:4096',
        ]);

        $peralatan = Peralatan::where('id', $request['id_peralatan'])->first();
        $kode = $peralatan->kode;
        $data = $request->all();
        $time = time();


        if ($request->hasFile('gambar')) {
            // $file = $request->file('gambar');
            $filename = $kode . '_' . $request['tanggal'] .'_'.$time. '.' . $request->file('gambar')->getClientOriginalExtension();
            $data['gambar'] = $request->file('gambar')->storeAs('uploads/gambar', $filename, 'public');

            // $data['gambar'] = $request->file('gambar')->store('uploads/gambar', 'public');
        }

        if ($request->hasFile('laporan')) {
            $filename = $kode . '_' . $request['tanggal'].'_'.$time . '.' . $request->file('laporan')->getClientOriginalExtension();
            $data['laporan'] = $request->file('laporan')->storeAs('uploads/laporan', $filename, 'public');
        }

        if ($request->hasFile('laporan2')) {
            $filename = $kode . '_' . $request['tanggal'] .'_'.$time .'_laporan2'. '.' . $request->file('laporan2')->getClientOriginalExtension();
            $data['laporan2'] = $request->file('laporan2')->storeAs('uploads/laporan', $filename, 'public');
            // $data['laporan2'] = $request->file('laporan2')->store('uploads/laporan', 'public');
        }

        Pemeliharaan::create($data);
        return redirect()->route('pemeliharaan.index')->with('success', 'Data pemeliharaan berhasil ditambahkan.');
    }

    public function edit(Pemeliharaan $pemeliharaan)
    {
        if ($pemeliharaan->author != Auth::user()->id and Auth::user()->role != 'teknisi' and Auth::user()->role != 'admin' ) {
            return redirect()->route('pemeliharaan.index');
        }
        $peralatans = Peralatan::all();
        return view('pemeliharaan.edit', compact('pemeliharaan', 'peralatans'));
    }

   public function update(Request $request, Pemeliharaan $pemeliharaan)
    {
        $request->validate([
            'id_peralatan' => 'required|exists:peralatans,id',
            'kondisi_awal' => 'required|max:20',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'laporan' => 'nullable|mimes:pdf|max:4096',
            'laporan2' => 'nullable|mimes:pdf|max:4096',
        ]);

        $data = $request->all();
        $peralatan = Peralatan::where('id', $request['id_peralatan'])->first();
        $kode = $peralatan->kode;
        $time = time();
        // Upload baru jika ada file baru
        if ($request->hasFile('gambar')) {
            if ($pemeliharaan->gambar && file_exists(storage_path('app/public/'.$pemeliharaan->gambar))) {
                unlink(storage_path('app/public/'.$pemeliharaan->gambar));
            }
            // $data['gambar'] = $request->file('gambar')->store('uploads/gambar', 'public');
            $filename = $kode . '_' . $request['tanggal'] .'_'.$time.'.' . $request->file('gambar')->getClientOriginalExtension();
            $data['gambar'] = $request->file('gambar')->storeAs('uploads/gambar', $filename, 'public');
        }

        if ($request->hasFile('laporan')) {
            if ($pemeliharaan->laporan && file_exists(storage_path('app/public/'.$pemeliharaan->laporan))) {
                unlink(storage_path('app/public/'.$pemeliharaan->laporan));
            }
            // $data['laporan'] = $request->file('laporan')->store('uploads/laporan', 'public');
            $filename = $kode . '_' . $request['tanggal'].'_'.$time . '.' . $request->file('laporan')->getClientOriginalExtension();
            $data['laporan'] = $request->file('laporan')->storeAs('uploads/laporan', $filename, 'public');
        }

        if ($request->hasFile('laporan2')) {
            if ($pemeliharaan->laporan2 && file_exists(storage_path('app/public/'.$pemeliharaan->laporan2))) {
                unlink(storage_path('app/public/'.$pemeliharaan->laporan2));
            }
            // $data['laporan2'] = $request->file('laporan2')->store('uploads/laporan', 'public');
            $filename = $kode . '_' . $request['tanggal'].'_'.$time .'_laporan2'. '.' . $request->file('laporan2')->getClientOriginalExtension();
            $data['laporan2'] = $request->file('laporan2')->storeAs('uploads/laporan', $filename, 'public');
        }

        $pemeliharaan->update($data);
        return redirect()->route('pemeliharaan.show', $pemeliharaan->id )->with('success', "Data pemeliharaan $kode berhasil diperbarui.");
    }

    public function destroy(Pemeliharaan $pemeliharaan)
    {
        if ($pemeliharaan->gambar && file_exists(storage_path('app/public/'.$pemeliharaan->gambar))) {
            unlink(storage_path('app/public/'.$pemeliharaan->gambar));
        }
        if ($pemeliharaan->laporan && file_exists(storage_path('app/public/'.$pemeliharaan->laporan))) {
                unlink(storage_path('app/public/'.$pemeliharaan->laporan));
            }
        if ($pemeliharaan->laporan2 && file_exists(storage_path('app/public/'.$pemeliharaan->laporan2))) {
                unlink(storage_path('app/public/'.$pemeliharaan->laporan2));
            }
        
        $kode = $pemeliharaan->peralatan->kode;
        $pemeliharaan->delete();
        return redirect()->route('pemeliharaan.index')->with('success', "Data pemeliharaan $kode berhasil dihapus.");
    }

    public function show(Pemeliharaan $pemeliharaan){

        // $pemeliharaan = $peralatan->pemeliharaans;
        // $hardware = $peralatan->hardwares;
        // $dokumen = $peralatan->dokumens;
        // $jenis_hardware = JenisHardware::all();
        // $jumlahPemeliharaan = $peralatan->pemeliharaans()->count();
        // $terbaru = $peralatan->pemeliharaans()->orderByDesc('tanggal')->first();
        $user = User::where('id', $pemeliharaan->author)->first();
        $author = $user->nama_lengkap;
        return view('pemeliharaan.show', compact('pemeliharaan', 'author') );
    }
}