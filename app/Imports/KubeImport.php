<?php

namespace App\Imports;

use App\Models\Kube;
use App\Models\PenerimaManfaat;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KubeImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
$ketua = PenerimaManfaat::where('nik', $row['nik_ketua'])->first();

    // Jika ketua tidak ditemukan, lempar pesan error agar impor berhenti
    if (!$ketua) {
        throw new \Exception("NIK Ketua '{$row['nik_ketua']}' tidak ditemukan di database. Pastikan data penerima manfaat sudah benar.");
    }

    return Kube::updateOrCreate(
        ['nama_kelompok_kube' => $row['nama_kelompok_kube']],
        [
            'ketua_penerima_manfaat_id' => $ketua->id,
                'jenis_usaha_kube'          => $row['jenis_usaha_kube'],
                'no_telp_kube'              => $row['no_telp_kube'],
                'kecamatan_kube'            => $row['kecamatan_kube'],
                'desa_kube'                 => $row['desa_kube'],
                'alamat_lengkap_kube'       => $row['alamat_lengkap_kube'],
                'jumlah_anggota'            => $row['jumlah_anggota'],
                'tahun_realisasi'           => $row['tahun_realisasi'],
                'sumber_anggaran'           => $row['sumber_anggaran'],
                'status_verifikasi'         => $row['status_verifikasi'] ?? 'pending',
            ]
        );
    }
}
