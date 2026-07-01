<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdukUmkm extends Model
{
    protected $table = 'produk_umkms';

   protected $fillable = [
        'uep_id', 
        'nama_produk', 
        'kategori', 
        'harga_jual', 
        'stok', 
        'deskripsi_produk', 
        'whatsapp_sales', 
        'status_publikasi', 
        'foto_produk'
    ];

    // Relasi ke UEP (jika diperlukan)
    public function uep()
    {
        return $this->belongsTo(Uep::class, 'uep_id');
    }
}