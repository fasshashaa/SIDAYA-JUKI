<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PenerimaManfaat extends Model
{
   protected $table = 'penerima_manfaats';

  protected $fillable = [
    'user_id',
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
  // Di dalam app/Models/Uep.php

public function penerimaManfaat()
{
    // Pastikan ini belongsTo agar mengembalikan objek tunggal
    return $this->belongsTo(\App\Models\PenerimaManfaat::class, 'penerima_manfaat_id');
}
}