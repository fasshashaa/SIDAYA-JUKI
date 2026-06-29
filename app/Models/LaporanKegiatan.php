<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaporanKegiatan extends Model
{
    protected $fillable = ['judul', 'isi', 'user_id', 'kecamatan', 'desa_kelurahan', 'tanggal'];

    // Relasi ke User yang mempublikasi laporan
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}