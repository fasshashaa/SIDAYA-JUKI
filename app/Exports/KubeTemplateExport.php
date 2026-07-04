<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KubeTemplateExport implements FromArray, WithHeadings, WithStyles, WithColumnWidths
{
    /**
     * Header kolom HARUS sama persis (lowercase, underscore)
     * dengan key yang dibaca di KubeImport.php
     */
    public function headings(): array
    {
        return [
            'nik_ketua',
            'nama_kelompok_kube',
            'jenis_usaha_kube',
            'no_telp_kube',
            'kecamatan_kube',
            'desa_kube',
            'alamat_lengkap_kube',
            'jumlah_anggota',
            'tahun_realisasi',
            'sumber_anggaran',
            
        ];
    }

    /**
     * Baris contoh + baris keterangan, biar user paham format & syarat data
     * (boleh dihapus manual sebelum isi data asli)
     */
    public function array(): array
    {
        return [
            [
                '3301234567890001',
                'KUBE Sejahtera Bersama',
                'Kerajinan Bambu',
                '081234567890',
                'Cilacap Tengah',
                'Sidanegara',
                'Jl. Contoh No. 1, RT 01/RW 02',
                '10',
                '2026',
                'APBD',
             
            ],
            [
                'WAJIB sudah terdaftar di data Penerima Manfaat',
                'wajib diisi',
                'wajib diisi',
                '',
                '',
                '',
                '',
                'angka',
                 'Kuliner/Makanan Olahan, Kerajinan/Craft, Fashion/Konveksi, Pertanian/Perternakan, Jasa/Service',
            'rintisan/berkembang/mandiri',
            'APBD, APBN, Mandiri',
             
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 22, // nik_ketua
            'B' => 28, // nama_kelompok_kube
            'C' => 22, // jenis_usaha_kube
            'D' => 18, // no_telp_kube
            'E' => 20, // kecamatan_kube
            'F' => 20, // desa_kube
            'G' => 35, // alamat_lengkap_kube
            'H' => 14, // jumlah_anggota
            'I' => 16, // tahun_realisasi
            'J' => 18, // sumber_anggaran
          
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