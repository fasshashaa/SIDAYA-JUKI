<?php
namespace App\Exports;

use App\Models\Kube;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KubeExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        // Mengambil data dan relasi ketua
        return Kube::with('ketuaPenerimaManfaat')->get()->map(function($kube) {
            return [
                'nama_kelompok' => $kube->nama_kelompok_kube,
                'ketua'         => $kube->ketuaPenerimaManfaat->nama_lengkap ?? '-',
                'jenis_usaha'   => $kube->jenis_usaha_kube,
                'no_telp'       => $kube->no_telp_kube,
                'kecamatan'     => $kube->kecamatan_kube,
                'desa'          => $kube->desa_kube,
                'alamat'        => $kube->alamat_lengkap_kube,
                'anggota'       => $kube->jumlah_anggota,
                'tahun'         => $kube->tahun_realisasi,
                'anggaran'      => $kube->sumber_anggaran,
                'status'        => $kube->status_verifikasi,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'NAMA KELOMPOK', 'KETUA', 'JENIS USAHA', 'NO TELP', 
            'KECAMATAN', 'DESA', 'ALAMAT', 'JUMLAH ANGGOTA', 
            'TAHUN REALISASI', 'SUMBER ANGGARAN', 'STATUS VERIFIKASI'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]], // Menebalkan header
        ];
    }
}