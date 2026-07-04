<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatPesanan extends Model
{
    protected $fillable = [
        'user_id', 
        'nama_produk', 
        'jumlah', 
        'total_harga', 
        'status',
        'whatsapp_tujuan' // Penting untuk menyimpan kemana user checkout
    ];

    // Relasi ke User (Pembeli)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // Tambahkan di dalam model RiwayatPesanan.php
public function scopeMenungguKonfirmasi($query)
{
    return $query->where('status', 'Menunggu Konfirmasi');
}
}