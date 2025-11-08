<?php

namespace App\Exports;

use App\Models\Hardware;
use App\Models\Peralatan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HardwareExport implements FromCollection, WithHeadings
{
    protected $peralatanId;

    // Terima parameter peralatan_id
    public function __construct($peralatanId)
    {
        $this->peralatanId = $peralatanId;
    }

    // Ambil data dari database
    public function collection()
    {

        $peralatan = Peralatan::where('id', $this->peralatanId)->first();
        $data = Hardware::where('lokasi_pemasangan', $this->peralatanId)
            ->select(
                'lokasi_pemasangan',
                'jenis_hardware',
                'jenis_peralatan',
                'tahun_masuk',
                'tanggal_masuk',
                'merk',
                'tipe',
                'serial_number',
                'sumber_pengadaan',
                'tanggal_keluar',
                'tanggal_dilepas',
                'status',
                'nomor_surat',
                'keterangan'
            )
            ->get();
            // dd($data);
            $peralatanKode = optional($peralatan)->kode; // Gunakan optional() untuk keamanan

            $data = $data->map(function ($item) use ($peralatanKode) {
                $item->lokasi_pemasangan = $peralatanKode;
                return $item;
            });
            // $data['lokasi_pemasangan'] = $peralatan->kode;
            return $data;
    }

    // Buat header kolom Excel
    public function headings(): array
    {
        // return [
        //     'Serial Number',
        //     'Jenis Hardware',
        //     'Jenis Peralatan',
        //     'Tahun Masuk',
        //     'Tanggal Masuk',
        //     'Merk',
        //     'Tipe',
        //     'Status',
        //     'Sumber Pengadaan',
        //     'Tanggal Keluar',
        //     'Tanggal Dilepas',
        //     'Lokasi Pengiriman',
        //     'Nomor Surat',
        //     'Keterangan',
        // ];
        return [
            'lokasi_pemasangan',
            'jenis_hardware',
            'jenis_peralatan',
            'tahun_masuk',
            'tanggal_masuk',
            'merk',
            'tipe',
            'serial_number',
            'sumber_pengadaan',
            'tanggal_pasang_kirim',
            'tanggal_dilepas',
            'status',
            'nomor_surat',
            'keterangan',
        ];
    }
}
