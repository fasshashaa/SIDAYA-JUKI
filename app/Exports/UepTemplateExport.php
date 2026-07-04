<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UepTemplateExport implements FromArray, WithHeadings, WithStyles, WithColumnWidths
{
    /**
     * Header kolom HARUS sama persis (lowercase, underscore)
     * dengan key yang dibaca di UepImport.php
     */
    public function headings(): array
    {
        return [
            'nik',
            'nama_usaha',
            'nama_lengkap',
            'nama_ibu_kandung',
            'no_wa',
            'no_kk',
            'kecamatan_usaha',
            'desa_kelurahan_usaha',
            'alamat_lengkap',
            'kategori_produk',
            'status_perkembangan',
            'tahun_realisasi',
            'sumber_anggaran',
        
        ];
    }

    /**
     * Baris contoh biar user paham format & nilai yang valid
     * (boleh dihapus manual sebelum isi data asli)
     */
    public function array(): array
{
    return [
        [
            '3301234567890001',
            'Warung Contoh Sejahtera',
            'Contoh Nama Lengkap',
            'Contoh Nama Ibu Kandung',
            '081234567890',
            '3301234567890000',
            'Cilacap Tengah',
            'Sidanegara',
            'Jl. Contoh No. 1, RT 01/RW 02',
            'Kuliner',
            'rintisan',
            '2026',
            'APBD',
           
        ],
        [
            '(wajib 16 digit)',
            '(wajib diisi)',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            'Kuliner/Makanan Olahan, Kerajinan/Craft, Fashion/Konveksi, Pertanian/Perternakan, Jasa/Service',
            'rintisan/berkembang/mandiri',
            'APBD, APBN, CSR, Lainnya',
            '',
           
        ],
    ];
}

    public function columnWidths(): array
    {
        return [
            'A' => 20, // nik
            'B' => 28, // nama_usaha
            'C' => 28, // nama_lengkap
            'D' => 28, // nama_ibu_kandung
            'E' => 18, // no_wa
            'F' => 20, // no_kk
            'G' => 20, // kecamatan_usaha
            'H' => 20, // desa_kelurahan_usaha
            'I' => 35, // alamat_lengkap
            'J' => 20, // kategori_produk
            'K' => 20, // status_perkembangan
            'L' => 16, // tahun_realisasi
            'M' => 18, // sumber_anggaran
        
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
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