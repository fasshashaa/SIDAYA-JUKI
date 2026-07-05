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
        'kube_id',
    ];

    protected $casts = [
        'harga_jual' => 'decimal:2',
        'stok'       => 'integer',
    ];

    /**
     * Folder tempat foto produk disimpan di disk "public".
     * Harus sama persis dengan UPLOAD_DIR di ProdukUmkmController::secureStoreImage().
     */
    private const FOTO_DIR = 'produk';

    public function uep()
    {
        return $this->belongsTo(Uep::class);
    }

    public function kube()
    {
        return $this->belongsTo(Kube::class);
    }

    public function penerimaManfaat()
    {
        return $this->belongsTo(PenerimaManfaat::class);
    }

    public function user()
    {
        // Catatan: relasi ini butuh kolom user_id di tabel produk_umkms.
        // Berdasarkan alur di ProdukUmkmController, kepemilikan produk
        // sebenarnya ditentukan lewat uep()->user_id atau kube()->user_id,
        // bukan lewat kolom user_id langsung di produk. Cek dulu apakah
        // kolom ini benar-benar ada sebelum memakai relasi ini di tempat lain.
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * 🔒 Mutator hardening (Kontrol A.8.24, defense-in-depth).
     *
     * ProdukUmkmController::secureStoreImage() sudah menghasilkan path yang
     * aman (nama acak, tanpa input pengguna). Mutator ini adalah lapisan
     * jaga-jaga tambahan di level model: kalau suatu saat ada kode lain
     * (seeder, import, endpoint lain) yang menulis ke foto_produk tanpa
     * lewat controller tsb., path yang mengandung "../" atau yang
     * mengarah keluar folder produk/ tetap akan ditolak di sini.
     */
    public function setFotoProdukAttribute(?string $value): void
    {
        if ($value === null || $value === '') {
            $this->attributes['foto_produk'] = null;
            return;
        }

        // Normalisasi separator & buang karakter path traversal.
        $normalized = str_replace('\\', '/', $value);

        if (str_contains($normalized, '..') || str_starts_with($normalized, '/')) {
            throw new \InvalidArgumentException('Path foto_produk tidak valid.');
        }

        if (!str_starts_with($normalized, self::FOTO_DIR . '/')) {
            throw new \InvalidArgumentException('Path foto_produk harus berada di dalam folder "' . self::FOTO_DIR . '".');
        }

        $this->attributes['foto_produk'] = $normalized;
    }

    /**
     * Satu-satunya tempat resmi untuk membangun URL publik foto produk.
     * Pakai ini di controller/view/API, jangan bangun asset('storage/...')
     * secara manual di banyak tempat.
     */
    public function getFotoUrlAttribute(): ?string
    {
        if (!$this->foto_produk) {
            return null;
        }

        return asset('storage/' . $this->foto_produk);
    }
}