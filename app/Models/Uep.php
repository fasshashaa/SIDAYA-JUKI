<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Uep extends Model
{
    protected $table = 'ueps';

  protected $fillable = [
    'user_id',
        'penerima_manfaat_id',
        'nama_lengkap',
        'status_verifikasi',
        'nama_ibu_kandung',
        'nik',
        'no_kk',
        'no_wa',
        'nama_usaha',
        'kategori_produk',
        'status_perkembangan',
        'kecamatan_usaha',
        'desa_kelurahan_usaha',
        'alamat_lengkap',
        'tahun_realisasi',
        'sumber_anggaran',
        'status_usaha',
         'catatan_penolakan',
    ];

// public function penerimaManfaat()
// {
//     return $this->hasOne(PenerimaManfaat::class, 'uep_id');
// }
public function penerimaManfaat()
{
    return $this->belongsTo(\App\Models\PenerimaManfaat::class, 'penerima_manfaat_id');
}
public function user() { return $this->belongsTo(User::class); }
public function produk() { return $this->hasMany(ProdukUmkm::class); }
// public function penerimaManfaat() { return $this->hasMany(PenerimaManfaat::class); }
}