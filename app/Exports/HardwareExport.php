<?php

namespace App\Exports;

use App\Models\Hardware;
use App\Models\Peralatan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Illuminate\Support\Collection;


class HardwareExport implements FromCollection, WithHeadings , WithStyles, WithColumnFormatting
{
    // protected $peralatanId;
    protected $where_query;

    // Terima parameter peralatan_id
    public function __construct($where_query)
    {
        // $this->peralatanId = $peralatanId;
        $this->where_query = $where_query;
    }

    // Ambil data dari database
    public function collection()
    {        
        // $peralatan = Peralatan::find($this->peralatanId);
        // $peralatanKode = optional($peralatan)->kode;
        // $data = Hardware::where($this->where_query)->get();
        $data = Hardware::where($this->where_query)->get();

        // Tambah kolom 'no' dan 'lokasi_pemasangan'
        $numbered = new Collection();
        foreach ($data as $index => $item) {
            $numbered->push([
                'no' => $index + 1,
                'lokasi_pemasangan' => $item->peralatan ? $item->peralatan->kode : '',
                'jenis_hardware' => $item->jenis_hardware,
                'jenis_peralatan' => $item->jenis_peralatan,
                'tahun_masuk' => $item->tahun_masuk,
                'tanggal_masuk' => $item->tanggal_masuk,
                'merk' => $item->merk,
                'tipe' => $item->tipe,
                'serial_number' => $item->serial_number,
                'sumber_pengadaan' => $item->sumber_pengadaan,
                'tanggal_keluar' => $item->tanggal_keluar,
                'tanggal_dilepas' => $item->tanggal_dilepas,
                'status' => $item->status,
                'lokasi_pengiriman' => $item->lokasi_pengiriman,
                'nomor_surat' => $item->nomor_surat,
                'nomor_surat_keluar' => $item->nomor_surat_keluar,
                'keterangan' => $item->keterangan,
            ]);
        }

        return $numbered;
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
            'no',
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
            'lokasi_pengiriman',
            'nomor_surat',
            'nomor_surat_keluar',
            'keterangan',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Styling untuk baris pertama (heading)
        $sheet->getStyle('A1:N1')->getFont()->setBold(true);

        // Warna oranye untuk kolom tertentu (misalnya B, C, D)
        $orangeFill = [
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'FFA500'], // kode warna oranye
            ],
        ];

        $sheet->getStyle('C1')->applyFromArray($orangeFill);
        $sheet->getStyle('D1')->applyFromArray($orangeFill);
        $sheet->getStyle('E1')->applyFromArray($orangeFill);
        $sheet->getStyle('G1')->applyFromArray($orangeFill);
        $sheet->getStyle('H1')->applyFromArray($orangeFill);
        $sheet->getStyle('J1')->applyFromArray($orangeFill);
        $sheet->getStyle('M1')->applyFromArray($orangeFill);

        return [];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT, // kolom 'no'
            'B' => NumberFormat::FORMAT_TEXT, // lokasi_pemasangan
            'C' => NumberFormat::FORMAT_TEXT, // jenis_hardware
            'D' => NumberFormat::FORMAT_TEXT,
            'E' => NumberFormat::FORMAT_TEXT,
            'F' => NumberFormat::FORMAT_TEXT,
            'G' => NumberFormat::FORMAT_TEXT,
            'H' => NumberFormat::FORMAT_TEXT,
            'I' => NumberFormat::FORMAT_TEXT,
            'J' => NumberFormat::FORMAT_TEXT,
            'K' => NumberFormat::FORMAT_TEXT,
            'L' => NumberFormat::FORMAT_TEXT,
            'M' => NumberFormat::FORMAT_TEXT,
            'N' => NumberFormat::FORMAT_TEXT,
            'O' => NumberFormat::FORMAT_TEXT,
            'P' => NumberFormat::FORMAT_TEXT,
            'Q' => NumberFormat::FORMAT_TEXT,
            'R' => NumberFormat::FORMAT_TEXT,
        ];
    }



}