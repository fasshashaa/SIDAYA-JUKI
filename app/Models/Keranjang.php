<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Keranjang extends Model
{
    // Pastikan fillable diisi agar bisa melakukan mass assignment
    protected $fillable = [
        'user_id',
        'produk_umkm_id',
        'jumlah'
    ];

    // Relasi ke User (Pemilik keranjang)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Produk (Barang yang ada di keranjang)
    public function produkUmkm(): BelongsTo
    {
        return $this->belongsTo(ProdukUmkm::class, 'produk_umkm_id');
    }
}