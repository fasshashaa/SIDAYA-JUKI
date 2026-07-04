<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_pesanan',
        'produk_umkm_id',
        'user_id',
        'jumlah',
        'harga_saat_pesan',
        'status',
        'confirmed_by',
        'confirmed_at',
        'catatan',
    ];

    protected $casts = [
        'confirmed_at' => 'datetime',
    ];

    public function produk()
    {
        return $this->belongsTo(ProdukUmkm::class, 'produk_umkm_id');
    }

    public function pembeli()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function confirmer()
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    public function getTotalHargaAttribute(): int
    {
        return $this->harga_saat_pesan * $this->jumlah;
    }

    public static function generateKode(): string
    {
        do {
            $kode = 'PSN' . now()->format('ymd') . strtoupper(\Illuminate\Support\Str::random(4));
        } while (self::where('kode_pesanan', $kode)->exists());

        return $kode;
    }
}