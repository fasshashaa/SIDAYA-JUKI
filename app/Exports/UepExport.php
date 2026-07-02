<?php

namespace App\Exports;

use App\Models\Uep;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UepExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        // Mengambil kolom yang diinginkan saja agar tidak menampilkan id/timestamps
        return Uep::select('nama_usaha','nama_lengkap','nama_ibu_kandung', 'nik', 'no_kk','no_wa','kategori_produk','alamat_lengkap', 'kecamatan_usaha', 'desa_kelurahan_usaha',
        'tahun_realisasi', 'sumber_anggaran', 'status_perkembangan')->get();
    }

    // Memberi nama header yang rapi
    public function headings(): array
    {
        return [
                'Nama Usaha',
                'Nama Pemilik',
                'Nama Ibu Kandung',
                'NIK',
                'No. KK',
                'No. WA',
                'Kategori Produk',
                'Alamat',
                'Kecamatan',
                'Desa',
                'Tahun Realisasi',
                'Sumber Anggaran',
                'Status'
        ];
    }

    // Memberi style pada header
  public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]], // Menebalkan header
        ];
    }
}