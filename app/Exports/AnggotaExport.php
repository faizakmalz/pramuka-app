<?php

namespace App\Exports;

use App\Models\Anggota;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Font;

class AnggotaExport
{
    protected ?string $golongan;

    public function __construct(?string $golongan = null)
    {
        $this->golongan = $golongan;
    }

    public function download(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Anggota');

        // ===== HEADER =====
        $headers = [
            'A' => 'No.',
            'B' => 'Nomor Anggota',
            'C' => 'NIK',
            'D' => 'Nama',
            'E' => 'Jenis Kelamin',
            'F' => 'Agama',
            'G' => 'Golongan Pramuka',
            'H' => 'Golongan Darah',
            'I' => 'Tempat Lahir',
            'J' => 'Tanggal Lahir',
            'K' => 'Email',
            'L' => 'No. Telepon',
            'M' => 'Alamat',
        ];

        foreach ($headers as $col => $label) {
            $sheet->setCellValue("{$col}1", $label);
        }

        // Style header
        $sheet->getStyle('A1:M1')->applyFromArray([
            'font' => [
                'bold'  => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size'  => 11,
                'name'  => 'Arial',
            ],
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '7D2A26'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color'       => ['rgb' => 'FFFFFF'],
                ],
            ],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(22);

        // ===== DATA =====
        $query = Anggota::query()->orderBy('nama');
        if ($this->golongan) {
            $query->where('golongan_pramuka', $this->golongan);
        }

        $anggota = $query->get();
        $rowNum  = 2;

        foreach ($anggota as $i => $a) {
            $isEven = $rowNum % 2 === 0;

            $rowData = [
                'A' => $i + 1,
                'B' => $a->nomor_anggota,
                'C' => $a->nik,
                'D' => $a->nama,
                'E' => $a->jenis_kelamin,
                'F' => $a->agama,
                'G' => $a->golongan_pramuka,
                'H' => $a->golongan_darah,
                'I' => $a->tempat_lahir,
                'J' => $a->tanggal_lahir
                    ? \Carbon\Carbon::parse($a->tanggal_lahir)->format('d-m-Y')
                    : '',
                'K' => $a->email,
                'L' => $a->no_telp ?? '-',
                'M' => $a->alamat,
            ];

            foreach ($rowData as $col => $value) {
                $sheet->setCellValue("{$col}{$rowNum}", $value);
            }

            // Zebra striping
            $bgColor = $isEven ? 'FDF6F6' : 'FFFFFF';
            $sheet->getStyle("A{$rowNum}:M{$rowNum}")->applyFromArray([
                'font' => ['name' => 'Arial', 'size' => 10],
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => $bgColor],
                ],
                'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
                'borders'   => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color'       => ['rgb' => 'E5E7EB'],
                    ],
                ],
            ]);

            $rowNum++;
        }

        // Center kolom No., Jenis Kelamin, Gol Darah, Tanggal
        if ($rowNum > 2) {
            foreach (['A', 'E', 'H', 'J'] as $col) {
                $sheet->getStyle("{$col}2:{$col}" . ($rowNum - 1))
                    ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            }
        }

        // Auto size semua kolom
        foreach (array_keys($headers) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Freeze header
        $sheet->freezePane('A2');

        // ===== OUTPUT =====
        $filename = 'data-anggota';
        if ($this->golongan) {
            $filename .= '-' . \Illuminate\Support\Str::slug($this->golongan);
        }
        $filename .= '-' . now()->format('Ymd-His') . '.xlsx';

        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Cache-Control'       => 'max-age=0',
        ]);
    }
}