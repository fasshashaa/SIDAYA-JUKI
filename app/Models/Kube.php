<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kube extends Model
{
    protected $table = 'kube';

    protected $fillable = [
        'ketua_penerima_manfaat_id', 'nama_kelompok_kube', 'jenis_usaha_kube', 
        'no_telp_kube', 'kecamatan_kube', 'desa_kube', 'alamat_lengkap_kube', 
        'jumlah_anggota', 'tahun_realisasi', 'sumber_anggaran'
    ];

    // Balikan relasi ketua ke model Penerima Manfaat
    public function ketua(): BelongsTo
    {
        return $this->belongsTo(PenerimaManfaat::class, 'ketua_penerima_manfaat_id');
    }
}