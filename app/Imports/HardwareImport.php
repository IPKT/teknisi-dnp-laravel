<?php

namespace App\Imports;

use App\Models\Hardware;
use App\Models\Peralatan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class HardwareImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // dd($row);
           // Bersihkan kolom kosong (index numerik tanpa nama header)
        $row = collect($row)->filter(function ($value, $key) {
            return !is_int($key); // hanya simpan kolom yang punya nama header
        });

        // dd($row->all());
        // dd($row);
        // Cari id peralatan berdasarkan kode_peralatan dari Excel
            $peralatan = Peralatan::where('kode', $row['lokasi_pemasangan'])->first();

            // Tentukan serial_number
            $serialNumber = $row['serial_number'] ?? $row['tahun_masuk'] . '_' . uniqid();
            // dd($row['serial_number']);
            $jenis_hardware = $row['jenis_hardware'] ?? null;

            if (!$jenis_hardware) {
                // skip baris ini atau isi default
                continue;
            }

            // dd($row);
            Hardware::updateOrCreate(
                ['serial_number' => $serialNumber],
                [
                    'jenis_hardware' => $jenis_hardware,
                    'jenis_peralatan' => $row['jenis_peralatan'] ?? null,
                    'tahun_masuk' => $row['tahun_masuk'] ?? null,
                    'tanggal_masuk' => $row['tanggal_masuk'] ?? null,
                    'merk' => $row['merk'] ?? null,
                    'tipe' => $row['tipe'] ?? null,
                    'status' => $row['status'] ?? null,
                    'sumber_pengadaan' => $row['sumber_pengadaan'] ?? null,
                    'tanggal_keluar' => $row['tanggal_pasang_kirim'] ?? null,
                    'tanggal_dilepas' => $row['tanggal_dilepas'] ?? null,
                    'lokasi_pemasangan' => $peralatan ? $peralatan->id : null,
                    'lokasi_pengiriman' => $row['lokasi_pengiriman'] ?? null,
                    'nomor_surat' => $row['nomor_surat'] ?? null,
                    'nomor_surat_keluar' => $row['nomor_surat_keluar'] ?? null,
                    'keterangan' => $row['keterangan'] ?? null,
                ]
            );
        }
    }
}
