<?php

namespace App\Exports;

use App\Models\Hardware;
use App\Models\Peralatan;
use App\Models\Pemeliharaan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Illuminate\Support\Collection;
use Carbon\Carbon;


class PeralatanExport implements FromCollection, WithHeadings , WithStyles, WithColumnFormatting
{
    // protected $peralatanId;
    protected $jenis_peralatan;

    // Terima parameter peralatan_id
    public function __construct($jenis_peralatan)
    {
        // $this->peralatanId = $peralatanId;
        $this->jenis_peralatan = $jenis_peralatan;
    }

    // Ambil data dari database
    public function collection()
    {
        // $peralatan = Peralatan::find($this->peralatanId);
        // $peralatanKode = optional($peralatan)->kode;
        // $data = Hardware::where($this->where_query)->get();
        // $data = Hardware::where($this->where_query)->get();
        if ($this->jenis_peralatan == 'aloptama') {
            $data = Peralatan::where('kelompok', 'aloptama')->get();
        } else{
            $data = Peralatan::where('jenis', $this->jenis_peralatan)->get();
        }


        // Tambah kolom 'no' dan 'lokasi_pemasangan'
        $numbered = new Collection();
        $tahun_sekarang = Carbon::now()->startOfYear()->format('Y-m-d');
        foreach ($data as $index => $item) {
            $numbered->push([
                'no' => $index + 1,
                'kode'=>$item->kode,
                'jenis'=> $item->jenis,
                'kondisi' => $item->kondisi_terkini,
                'kunjungan_tahun_ini' => ($item->pemeliharaans()->where('tanggal', '>=', $tahun_sekarang)->count() ) == 0 ? '0' : $item->pemeliharaans()->where('tanggal', '>=', $tahun_sekarang)->count(),
                'kunjungan_terbaru' => optional($item->pemeliharaans()->orderByDesc('tanggal')->first())->tanggal,
                'rekomendasi'=> optional($item->pemeliharaans()->orderByDesc('tanggal')->first())->rekomendasi,
                'kerusakan' => optional($item->pemeliharaans()->orderByDesc('tanggal')->first())->kerusakan,
            ]);
        }

        return $numbered;
    }

    // Buat header kolom Excel
    public function headings(): array
    {
        return [
            'no',
            'kode',
            'jenis',
            'kondisi',
            'kunjungan_tahun_ini',
            'kunjungan_terbaru',
            'rekomendasi',
            'kerusakan',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Styling untuk baris pertama (heading)
        $sheet->getStyle('A1:N1')->getFont()->setBold(true);

        // Warna oranye untuk kolom tertentu (misalnya B, C, D)
        // $orangeFill = [
        //     'fill' => [
        //         'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        //         'startColor' => ['rgb' => 'FFA500'], // kode warna oranye
        //     ],
        // ];

        // $sheet->getStyle('C1')->applyFromArray($orangeFill);
        // $sheet->getStyle('D1')->applyFromArray($orangeFill);
        // $sheet->getStyle('E1')->applyFromArray($orangeFill);
        // $sheet->getStyle('G1')->applyFromArray($orangeFill);
        // $sheet->getStyle('H1')->applyFromArray($orangeFill);
        // $sheet->getStyle('J1')->applyFromArray($orangeFill);
        // $sheet->getStyle('M1')->applyFromArray($orangeFill);

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
        ];
    }



}