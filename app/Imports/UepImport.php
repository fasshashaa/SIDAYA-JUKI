<?php
namespace App\Imports;

use App\Models\Uep;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
   use App\Models\PenerimaManfaat; // Jangan lupa import modelnya

class UepImport implements ToModel, WithHeadingRow, WithValidation
{


public function model(array $row)
{
    // Cari ID penerima berdasarkan NIK yang ada di file Excel
    $penerima = PenerimaManfaat::where('nik', $row['nik'])->first();

    return Uep::updateOrCreate(
        ['nik' => $row['nik']], 
        [
            // Jika ketemu, masukkan ID-nya. Jika tidak, tetap null (atau sesuaikan logika bisnismu)
            'penerima_manfaat_id'  => $penerima ? $penerima->id : null,
                'nama_usaha'           => $row['nama_usaha'],
                'nama_lengkap'         => $row['nama_lengkap'],
                'nama_ibu_kandung'         => $row['nama_ibu_kandung'],
                'no_wa'                => $row['no_wa'],
                'no_kk'                => $row['no_kk'],
                'kecamatan_usaha'      => $row['kecamatan_usaha'],
                'desa_kelurahan_usaha' => $row['desa_kelurahan_usaha'],
                'alamat_lengkap'       => $row['alamat_lengkap'],
                'kategori_produk'      => $row['kategori_produk'],
                'status_perkembangan'  => $row['status_perkembangan'],
                'tahun_realisasi'      => $row['tahun_realisasi'],
                'sumber_anggaran'      => $row['sumber_anggaran'],
         'status_verifikasi' => $row['status_verifikasi'] ?? 'pending',
            ]
        );
    }

    public function rules(): array
    {
        return [
            'nik' => 'required|digits:16',
            'nama_usaha' => 'required|string',
            'status_perkembangan' => 'required|in:rintisan,berkembang,mandiri',
           'status_verifikasi' => 'nullable|in:pending,disetujui,ditolak',
        ];
    }
}