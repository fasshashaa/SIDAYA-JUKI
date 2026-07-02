<?php

namespace App\Exports;

use App\Models\PenerimaManfaat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PenerimaManfaatExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        // Pilih kolom yang ingin ditampilkan di Excel
        return PenerimaManfaat::select('nama_lengkap', 'nama_ibu_kandung', 'nik', 'no_kk', 'kecamatan', 'desa', 'alamat_detail', 'no_wa', 'status_verifikasi')->get();
    }

    public function headings(): array
    {
        return [
            'Nama Lengkap',
            'Nama Ibu Kandung',
            'NIK',
            'No. KK',
            'Kecamatan',
            'Desa',
            'Alamat Detail',
            'No. WA',
            'Status Verifikasi'
        ];
    }
    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]], // Menebalkan header
        ];
    }
}