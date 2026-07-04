<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PenerimaManfaatTemplateExport implements FromArray, WithHeadings, WithStyles, WithColumnWidths
{
    /**
     * Header kolom HARUS sama persis (lowercase, underscore)
     * dengan yang dibaca di PenerimaManfaatImport.php
     */
    public function headings(): array
    {
        return [
            'nik',
            'no_kk',
            'nama_lengkap',
            'nama_ibu_kandung',
            'no_wa',
            'kecamatan',
            'desa',
            'alamat_detail',
        
        ];
    }

    /**
     * Baris contoh, biar user paham format yang benar
     * (baris ini boleh dihapus manual sama user sebelum isi data asli)
     */
    public function array(): array
    {
        return [
            [
                '3301234567890001',
                '3301234567890000',
                'Contoh Nama Lengkap',
                'Contoh Nama Ibu Kandung',
                '081234567890',
                'Cilacap Tengah',
                'Sidanegara',
                'Jl. Contoh No. 1, RT 01/RW 02',
           
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20, // nik
            'B' => 20, // no_kk
            'C' => 30, // nama_lengkap
            'D' => 30, // nama_ibu_kandung
            'E' => 18, // no_wa
            'F' => 20, // kecamatan
            'G' => 20, // desa
            'H' => 35, // alamat_detail
       
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Bold + background abu-abu buat baris header
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType'   => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E5E7EB'],
                ],
            ],
        ];
    }
}