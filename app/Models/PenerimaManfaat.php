<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PenerimaManfaat extends Model
{
   protected $table = 'penerima_manfaats';

  protected $fillable = [
        'nik', 
        'nama_lengkap', 
        'nama_ibu_kandung', 
        'no_kk', 
        'no_wa', 
        'kecamatan', 
        'desa', 
        'alamat_detail', 
        'status_verifikasi'
    ];
    // Hubungan ke data UEP (Satu orang bisa punya beberapa UEP)
    public function uep(): HasMany
    {
        return $this->hasMany(Uep::class, 'penerima_manfaat_id');
    }

    // Hubungan ke data KUBE (Satu orang bisa menjadi ketua di beberapa kelompok)
    public function kube(): HasMany
    {
        return $this->hasMany(Kube::class, 'ketua_penerima_manfaat_id');
    }
}