<?php

namespace App\Http\Controllers;

use App\Models\Peralatan;
use Illuminate\Http\Request;
use App\Models\JenisHardware;
use Illuminate\Support\Facades\Auth;
use App\Exports\PeralatanExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
class PeralatanController extends Controller
{
    public function index()
    {
        $peralatans = Peralatan::where('kelompok', 'aloptama')->get();
        $kelompok = 'aloptama';
        return view('peralatan.index', compact('peralatans', 'kelompok'));
    }

    public function aloptama($jenis)
    {
        if ($jenis === 'All') {
            $peralatans = Peralatan::all();
        } else {
            $peralatans = Peralatan::where('jenis', $jenis)->get();
        }

        $kelompok = 'aloptama';
        return view('peralatan.index', compact('peralatans', 'jenis', 'kelompok'));
    }

        public function non_aloptama($jenis)
    {
        if ($jenis === 'All') {
            $peralatans = Peralatan::all();
        } else {
            $peralatans = Peralatan::where('jenis', $jenis)->get();
        }

        $kelompok = 'non-aloptama';
        return view('peralatan.index', compact('peralatans', 'jenis', 'kelompok'));
    }



    public function create()
    {
        if(!old('previous_url')) {
            session(['url_asal' => url()->previous()]);
        }
        return view('peralatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|max:50',
            'koordinat' => 'required|max:50',
            'lokasi' => 'required|max:50',
            'kondisi_terkini' => 'required',
            'kelompok' => 'required',
            'jenis' => 'required|max:100',
        ]);

        Peralatan::create($request->all());

        return redirect($request->previous_url ?? route('peralatan.index'))
            ->with('success', 'Data peralatan berhasil ditambahkan.');
    }

    public function edit(Peralatan $peralatan)

    {
        if (Auth::user()->role != 'teknisi' and Auth::user()->role != 'admin') {
            return redirect()->route('peralatan.index');
        }

        if(!old('previous_url')) {
            session(['url_asal' => url()->previous()]);
        }

        $jenisPeralatan = Peralatan::select('jenis')->distinct()->orderBy('jenis')->get();
        return view('peralatan.edit', compact('peralatan', 'jenisPeralatan'));
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

        return redirect($request->previous_url ?? route('peralatan.index'))
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

        $peralatans = Peralatan::where('jenis', $jenis)->orderBy('kode', 'asc')->get();

        return response()->json($peralatans);
    }

    public function show(Peralatan $peralatan)
    {

        $pemeliharaan = $peralatan->pemeliharaans->sortByDesc('tanggal');
        $hardware = $peralatan->hardwares->where('status', 'terpasang');
        $dokumen = $peralatan->dokumens;
        $jenis_hardware = JenisHardware::all();
        $jumlahPemeliharaan = $peralatan->pemeliharaans()->count();
        $terbaru = $peralatan->pemeliharaans()->orderByDesc('tanggal')->first();
        return view('peralatan.show', compact('peralatan', 'pemeliharaan', 'jumlahPemeliharaan', 'terbaru', 'hardware', 'dokumen', 'jenis_hardware'));
    }

    public function updateMetadata(Request $request, Peralatan $peralatan)
    {
        $metadata = [];

        if ($request->has('metadata_keys')) {
            foreach ($request->metadata_keys as $i => $key) {
                if ($key) {
                    $metadata[$key] = $request->metadata_values[$i] ?? null;
                }
            }
        }

        $peralatan->metadata = $metadata;
        $peralatan->save();

        return back()->with('success', 'Metadata berhasil diupdate.');
    }
    public function updateNetworkData(Request $request, Peralatan $peralatan)
    {
        $networkData = [];

        if ($request->has('networkData_keys')) {
            foreach ($request->networkData_keys as $i => $key) {
                if ($key) {
                    $networkData[$key] = $request->networkData_values[$i] ?? null;
                }
            }
        }

        $peralatan->networkData = $networkData;
        $peralatan->save();

        return back()->with('success', 'Network Data berhasil diupdate.');
    }


    public function download($jenis)
{

    $tanggal_sekarang = Carbon::now()->format('Y-m-d');
    $fileName = $jenis .'_'. $tanggal_sekarang .'_'. uniqid(). '.xlsx';

    return Excel::download(new PeralatanExport($jenis), $fileName);
}


}
