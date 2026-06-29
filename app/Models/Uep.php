<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Uep extends Model
{
    protected $table = 'ueps';

    protected $fillable = [
        'penerima_manfaat_id', 'nama_usaha', 'no_operasional_usaha', 
        'kecamatan_usaha', 'desa_usaha', 'alamat_lengkap_usaha', 
        'kategori_produk', 'status_usaha', 'tahun_realisasi', 'sumber_anggaran'
    ];

    // Balikan relasi ke model Penerima Manfaat
    public function penerimaManfaat(): BelongsTo
    {
        return $this->belongsTo(PenerimaManfaat::class, 'penerima_manfaat_id');
    }
}