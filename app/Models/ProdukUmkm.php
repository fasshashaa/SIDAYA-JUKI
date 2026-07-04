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
        'foto_produk',
        'kube_id'
    ];

   public function uep() {
    return $this->belongsTo(Uep::class);
}

public function kube() {
    return $this->belongsTo(Kube::class);
}
// BENAR (mengembalikan 1 model)
public function penerimaManfaat()
{
    return $this->belongsTo(PenerimaManfaat::class);
}
public function user()
    {
        // Asumsi: Produk dimiliki oleh User (Pedagang)
        return $this->belongsTo(User::class, 'user_id'); 
    }

}