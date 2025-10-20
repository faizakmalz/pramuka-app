<?php

namespace App\Imports;

use App\Models\Anggota;
use PhpOffice\PhpSpreadsheet\IOFactory;

class AnggotaImport
{
    public function import($filePath)
    {
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, true);

        $batchData = [];

        foreach ($rows as $index => $row) {
            if ($index === 1) {
                continue;
            }

            if (empty($row['A'])) continue;

            $batchData[] = [
                'nik'               => $row['A'],
                'nama'              => $row['B'],
                'jenis_kelamin'     => $row['C'],
                'agama'             => $row['D'],
                'golongan_pramuka'  => $row['E'],
                'golongan_darah'    => $row['F'],
                'tempat_lahir'      => $row['G'],
                'tanggal_lahir'     => $row['H'],
                'email'             => $row['I'],
                'alamat'            => $row['J'],
                'no_telp'           => (int) $row['K'],
                'created_at'        => now(),
                'updated_at'        => now(),
            ];

            if (count($batchData) >= 500) {
                Anggota::insert($batchData);
                $batchData = [];
            }
        }

        // Simpan sisa batch terakhir
        if (!empty($batchData)) {
            Anggota::insert($batchData);
        }
    }
}
