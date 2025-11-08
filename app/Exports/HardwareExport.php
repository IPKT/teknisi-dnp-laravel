<?php

namespace App\Exports;

use App\Models\Hardware;
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
        return Hardware::where('lokasi_pemasangan', $this->peralatanId)
            ->select(
                'serial_number',
                'jenis_hardware',
                'jenis_peralatan',
                'tahun_masuk',
                'tanggal_masuk',
                'merk',
                'tipe',
                'status',
                'sumber_pengadaan',
                'tanggal_keluar',
                'tanggal_dilepas',
                'lokasi_pengiriman',
                'nomor_surat',
                'keterangan'
            )
            ->get();
    }

    // Buat header kolom Excel
    public function headings(): array
    {
        return [
            'Serial Number',
            'Jenis Hardware',
            'Jenis Peralatan',
            'Tahun Masuk',
            'Tanggal Masuk',
            'Merk',
            'Tipe',
            'Status',
            'Sumber Pengadaan',
            'Tanggal Keluar',
            'Tanggal Dilepas',
            'Lokasi Pengiriman',
            'Nomor Surat',
            'Keterangan',
        ];
    }
}
