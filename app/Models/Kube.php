<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kube extends Model
{
    protected $table = 'kube';

// app/Models/Kube.php
protected $fillable = [
    'ketua_penerima_manfaat_id',
    'nama_kelompok_kube',
    'jenis_usaha_kube',
    'no_telp_kube',
    'kecamatan_kube',
    'desa_kube',
    'alamat_lengkap_kube',
    'jumlah_anggota',
    'tahun_realisasi',
    'sumber_anggaran',
    'status_verifikasi'
];



public function user() {
    return $this->belongsTo(User::class);
}

public function penerimaManfaat() {
    return $this->hasMany(PenerimaManfaat::class, 'id'); // Pastikan FK-nya benar
}

public function produk() {
    return $this->hasMany(ProdukUmkm::class, 'kube_id');
}
public function anggota() {
        return $this->hasMany(PenerimaManfaat::class, 'kube_id');
    }

    // Relasi: KUBE punya satu ketua
    public function ketua() {
        return $this->belongsTo(PenerimaManfaat::class, 'ketua_penerima_manfaat_id');
    }
    public function ketuaPenerimaManfaat()
    {
        // Pastikan nama modelnya benar (misal: App\Models\PenerimaManfaat)
        return $this->belongsTo(PenerimaManfaat::class, 'ketua_penerima_manfaat_id');
    }
}