<?php

namespace App\Imports;

use App\Models\PenerimaManfaat;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PenerimaManfaatImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // dd($row);
        // 1. Filter: Jika NIK kosong, abaikan baris ini (daripada crash)
        $nik = isset($row['nik']) ? trim((string)$row['nik']) : null;
        if (empty($nik)) {
            return null; 
        }

        // 2. Gunakan updateOrCreate agar lebih ringkas
        // Kita gunakan 'nik' sebagai kunci pencarian
        return PenerimaManfaat::updateOrCreate(
            ['nik' => $nik], // Kunci untuk mencari data
            [
                'no_kk'             => $row['no_kk'] ?? null,
                'nama_lengkap'      => $row['nama_lengkap'] ?? null,
                'nama_ibu_kandung'  => $row['nama_ibu_kandung'] ?? null,
                'no_wa'             => isset($row['no_wa']) ? (string)$row['no_wa'] : null,
                'kecamatan'         => $row['kecamatan'] ?? null,
                'desa'              => $row['desa'] ?? null,
                'alamat_detail'     => $row['alamat_detail'] ?? null,
                'status_verifikasi' => $row['status_verifikasi'] ?? 'pending',
            ]
        );
    }
}