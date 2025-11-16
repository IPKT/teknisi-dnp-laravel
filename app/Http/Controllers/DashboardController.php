<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peralatan;
use App\Models\Pemeliharaan;
  use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(){
        $seluruh_peralatan['jumlah'] = Peralatan::where('kelompok', 'aloptama')->count();
        $seluruh_peralatan['on'] = Peralatan::where('kondisi_terkini', 'ON')->where('kelompok', 'aloptama')->count();
        $seluruh_peralatan['off'] = Peralatan::where('kondisi_terkini', 'OFF')->where('kelompok', 'aloptama')->count();
        $jenis_peralatan = Peralatan::select('jenis')->where('kelompok', 'aloptama')->distinct()->pluck('jenis');
        foreach ($jenis_peralatan as $jp){
            $data['jumlah'] = Peralatan::where('jenis', $jp)->count();
            $data['on'] = Peralatan::where('jenis', $jp)->where('kondisi_terkini' , 'ON')->count();
            $data['off'] = Peralatan::where('jenis', $jp)->where('kondisi_terkini' , 'OFF')->count();
            $peralatan[$jp] = $data;
        }


        $tahunIni = Carbon::now()->year;

        $belumDikunjungiTahunIni = Peralatan::where('kelompok', 'aloptama')->whereDoesntHave('pemeliharaans', function ($query) use ($tahunIni) {
            $query->whereYear('tanggal', $tahunIni);
        })->count();

        //Pemeliharaan
        $pemeliharaan['total'] = Pemeliharaan::whereYear('tanggal', Carbon::now()->year)->whereHas('peralatan', function ($query) {$query->where('kelompok', 'aloptama');})->count();
        $pemeliharaan['site_dikunjungi'] = Pemeliharaan::whereYear('tanggal', Carbon::now()->year)->whereHas('peralatan', function ($query) {$query->where('kelompok', 'aloptama');})->distinct('id_peralatan')->count();
        $pemeliharaan['persen'] =  round(($pemeliharaan['site_dikunjungi'] / $seluruh_peralatan['jumlah'] ) * 100,1);
        $pemeliharaan['bulan_ini'] = Pemeliharaan::whereMonth('tanggal', Carbon::now()->month)->whereYear('tanggal', Carbon::now()->year)->whereHas('peralatan', function ($query) {$query->where('kelompok', 'aloptama');})->count();
        $pemeliharaan['bulan_lalu'] = Pemeliharaan::whereMonth('tanggal', Carbon::now()->subMonth())->whereYear('tanggal', Carbon::now()->year)->whereHas('peralatan', function ($query) {$query->where('kelompok', 'aloptama');})->count();
        // $grafikBulan = Pemeliharaan::selectRaw('MONTH(tanggal) as bulan, COUNT(*) as total')->groupBy('bulan')->get();
        $tahunIni = Carbon::now()->year;

        $grafikBulanRaw = Pemeliharaan::selectRaw('MONTH(tanggal) as bulan, COUNT(*) as total')
            ->whereYear('tanggal', $tahunIni)
            ->whereHas('peralatan', function ($query) {$query->where('kelompok', 'aloptama');})
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $grafikBulan = collect(range(1, 12))->map(function ($bulan) use ($grafikBulanRaw) {
            $data = $grafikBulanRaw->firstWhere('bulan', $bulan);
            return [
                'label' => Carbon::create()->month($bulan)->isoFormat('MMM'),
                'total' => $data ? $data->total : 0,
            ];
        });

        
        // dd($grafikBulan);
        // dd($seluruh_peralatan);
        return view('dashboard.index', compact('seluruh_peralatan', 'peralatan', 'belumDikunjungiTahunIni', 'pemeliharaan', 'grafikBulan'));
    }
}