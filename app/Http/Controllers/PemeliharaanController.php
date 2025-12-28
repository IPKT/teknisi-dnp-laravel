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
    public function index_lama()
    {
        // $pemeliharaans = Pemeliharaan::with('peralatan')->latest()->get()->sortByDesc('tanggal');
        // return view('pemeliharaan.index', compact('pemeliharaans'));
        $jenis_peralatan = Peralatan::where('kelompok', 'aloptama')->select('jenis')->distinct()->pluck('jenis');

        // $tahun_sekarang = Carbon::now()->startOfYear()->format('Y-m-d');
        $tahun_kemarin = Carbon::now()->subYear()->startOfYear()->format('Y-m-d');

        foreach ($jenis_peralatan as $jenis) {
            $pemeliharaansByJenis[$jenis] = Pemeliharaan::whereHas('peralatan', function ($query) use ($jenis) {
                $query->where([
                    'jenis'    => $jenis,
                    'kelompok' => 'aloptama',
                ]);
            })->with('peralatan')->where('tanggal', '>=', $tahun_kemarin)->latest()->get()->sortByDesc('tanggal');
        }

        $date = Carbon::createFromFormat('Y-m-d', $tahun_kemarin);
        $tahun_awal_data = $date->format('Y');

        // dd($pemeliharaansByJenis);

        return view('pemeliharaan.index', compact( 'pemeliharaansByJenis', 'tahun_awal_data'));

    }

    public function index(){


        $jenis = 'Seluruh Aloptama';
        $tahun_kemarin = Carbon::now()->subYear()->startOfYear()->format('Y-m-d');
        $date = Carbon::createFromFormat('Y-m-d', $tahun_kemarin);
        $tahun_awal_data = $date->format('Y');
        $pemeliharaan = Pemeliharaan::whereHas('peralatan', function ($query) {
                $query->where([
                    'kelompok' => 'aloptama',
                ]);
            })->where('tanggal', '>=', $tahun_kemarin)->latest()->get()->sortByDesc('tanggal');

        return view('pemeliharaan.index', compact( 'pemeliharaan', 'tahun_awal_data', 'jenis'));
    }

    public function showByJenis($jenis){
        $jenis = $jenis;
        $tahun_kemarin = Carbon::now()->subYear()->startOfYear()->format('Y-m-d');
        $date = Carbon::createFromFormat('Y-m-d', $tahun_kemarin);
        $tahun_awal_data = $date->format('Y');
        $pemeliharaan = Pemeliharaan::where('tanggal', '>=', $tahun_kemarin)->whereHas('peralatan', function ($query) use ($jenis) {
                $query->where([
                    'jenis'    => $jenis,
                    // 'kelompok' => 'aloptama',
                ]);
            })->latest()->get()->sortByDesc('tanggal');

        return view('pemeliharaan.index', compact( 'pemeliharaan', 'tahun_awal_data', 'jenis'));
    }

    public function create()
    {
        // $peralatans = Peralatan::all();
        $jenis_peralatan = Peralatan::select('jenis')->distinct()->pluck('jenis');

        if(!old('previous_url')) {
            session(['url_asal' => url()->previous()]);
        }

        return view('pemeliharaan.create', compact('jenis_peralatan'));

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
            $request->file('gambar')->storeAs('uploads/gambar_pemeliharaan', $filename, 'public');
            $data['gambar'] = $filename;
            // $data['gambar'] = $request->file('gambar')->store('uploads/gambar', 'public');
        }

        if ($request->hasFile('laporan')) {
            $filename = $kode . '_' . $request['tanggal'].'_'.$time . '.' . $request->file('laporan')->getClientOriginalExtension();
            $request->file('laporan')->storeAs('uploads/laporan_pemeliharaan', $filename, 'public');
            $data['laporan'] = $filename;
        }

        if ($request->hasFile('laporan2')) {
            $filename = $kode . '_' . $request['tanggal'] .'_'.$time .'_laporan2'. '.' . $request->file('laporan2')->getClientOriginalExtension();
            $request->file('laporan2')->storeAs('uploads/laporan_pemeliharaan', $filename, 'public');
            // $data['laporan2'] = $request->file('laporan2')->store('uploads/laporan', 'public');
             $data['laporan2'] = $filename;
        }

        Pemeliharaan::create($data);
        // return back()->with('success', 'Data pemeliharaan berhasil ditambahkan');
        return redirect($request->previous_url ?? route('pemeliharaan.index'))
            ->with('success', 'Data pemeliharaan berhasil diperbarui.');
        // return redirect()->route('pemeliharaan.index')->with('success', 'Data pemeliharaan berhasil ditambahkan.');
    }

    public function edit(Pemeliharaan $pemeliharaan)
    {
        if ($pemeliharaan->author != Auth::user()->id and Auth::user()->role != 'teknisi' and Auth::user()->role != 'admin' ) {
            return redirect()->route('pemeliharaan.index');
        }

           if(!old('previous_url')) {
            session(['url_asal' => url()->previous()]);
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
            if ($pemeliharaan->gambar && file_exists(storage_path('app/public/uploads/gambar_pemeliharaan/'.$pemeliharaan->gambar))) {
                unlink(storage_path('app/public/uploads/gambar_pemeliharaan/'.$pemeliharaan->gambar));
            }
            // $data['gambar'] = $request->file('gambar')->store('uploads/gambar', 'public');
            $filename = $kode . '_' . $request['tanggal'] .'_'.$time.'.' . $request->file('gambar')->getClientOriginalExtension();
            $request->file('gambar')->storeAs('uploads/gambar_pemeliharaan/', $filename, 'public');
            $data['gambar'] = $filename;
        }

        if ($request->hasFile('laporan')) {
            if ($pemeliharaan->laporan && file_exists(storage_path('app/public/uploads/laporan_pemeliharaan/'.$pemeliharaan->laporan))) {
                unlink(storage_path('app/public/uploads/laporan_pemeliharaan/'.$pemeliharaan->laporan));
            }
            // $data['laporan'] = $request->file('laporan')->store('uploads/laporan', 'public');
            $filename = $kode . '_' . $request['tanggal'].'_'.$time . '.' . $request->file('laporan')->getClientOriginalExtension();
            $request->file('laporan')->storeAs('uploads/laporan_pemeliharaan/', $filename, 'public');
            $data['laporan'] = $filename;
        }

        if ($request->hasFile('laporan2')) {
            if ($pemeliharaan->laporan2 && file_exists(storage_path('app/public/uploads/laporan_pemeliharaan/'.$pemeliharaan->laporan2))) {
                unlink(storage_path('app/public/uploads/laporan_pemeliharaan/'.$pemeliharaan->laporan2));
            }
            // $data['laporan2'] = $request->file('laporan2')->store('uploads/laporan', 'public');
            $filename = $kode . '_' . $request['tanggal'].'_'.$time .'_laporan2'. '.' . $request->file('laporan2')->getClientOriginalExtension();
            $request->file('laporan2')->storeAs('uploads/laporan_pemeliharaan/', $filename, 'public');
            $data['laporan2'] = $filename;
        }

        $pemeliharaan->update($data);
        // return back()->with('success', "Data pemeliharaan $kode berhasil diperbarui.");
        return redirect($request->previous_url ?? route('pemeliharaan.index'))
            ->with('success', "Data pemeliharaan $kode berhasil diperbarui.");
        // return redirect()->route('pemeliharaan.show', $pemeliharaan->id )->with('success', "Data pemeliharaan $kode berhasil diperbarui.");
    }

    public function destroy(Pemeliharaan $pemeliharaan)
    {
        if ($pemeliharaan->gambar && file_exists(storage_path('app/public/uploads/gambar_pemeliharaan/'.$pemeliharaan->gambar))) {
            unlink(storage_path('app/public/uploads/gambar_pemeliharaan/'.$pemeliharaan->gambar));
        }
        if ($pemeliharaan->laporan && file_exists(storage_path('app/public/uploads/laporan_pemeliharaan/'.$pemeliharaan->laporan))) {
                unlink(storage_path('app/public/uploads/laporan_pemeliharaan/'.$pemeliharaan->laporan));
            }
        if ($pemeliharaan->laporan2 && file_exists(storage_path('app/public/uploads/laporan_pemeliharaan/'.$pemeliharaan->laporan2))) {
                unlink(storage_path('app/public/uploads/laporan_pemeliharaan/'.$pemeliharaan->laporan2));
            }

        $kode = $pemeliharaan->peralatan->kode;
        $pemeliharaan->delete();
        return response()->json(['success' => true, 'message' => "Data pemeliharaan $kode berhasil dihapus."]);
        // return redirect()->route('pemeliharaan.index')->with('success', "Data pemeliharaan $kode berhasil dihapus.");
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