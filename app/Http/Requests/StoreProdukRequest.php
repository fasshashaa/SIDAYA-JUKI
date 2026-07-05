<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProdukRequest extends FormRequest
{
    /**
     * Mengizinkan request ini dijalankan jika user sudah login.
     * Otorisasi kepemilikan usaha (uep/kube milik siapa & status verifikasinya)
     * TETAP dicek manual di controller, karena butuh query DB berdasarkan
     * role user yang tidak praktis dilakukan di sini.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * 🔒 Aturan Validasi Ketat Sesuai ISO 27001 - Kontrol A.8.24
     */
    public function rules(): array
    {
        return [
            // Format wajib "uep_<id>" atau "kube_<id>" — divalidasi di sini
            // supaya controller tidak perlu menebak-nebak hasil explode().
            'pemilik_id' => ['required', 'string', 'regex:/^(uep|kube)_[0-9]+$/'],

            'nama_produk'      => 'required|string|max:255',
            'kategori'         => 'required|string|max:100',
            'harga_jual'       => 'required|numeric|min:0',
            'stok'             => 'required|integer|min:0',
            'deskripsi_produk' => 'nullable|string|max:5000',
            'whatsapp_sales'   => 'nullable|string|max:20|regex:/^[0-9+\-\s]+$/',
            'status_publikasi' => 'required|in:Ditampilkan,Draft',

            // 🛑 VALIDASI PROTEKSI FILE UPLOAD HARDENING
            'foto_produk' => [
                'required',                   // Wajib diisi saat tambah baru
                'file',                       // Memastikan ini benar-benar file, bukan string payload
                'image',                      // Laravel menolak jika bukan gambar yang bisa diproses
                'mimes:jpeg,jpg,png',         // Kunci ekstensi berdasarkan MIME yang terdeteksi dari isi file
                'mimetypes:image/jpeg,image/png', // Lapis kedua: cek langsung string MIME asli (fileinfo)
                'max:2048',                   // Maksimal berkas 2MB (2048 KB)
                'dimensions:max_width=4000,max_height=4000', // Cegah "decompression bomb"
            ],
        ];
    }

    /**
     * Kustomisasi pesan error bahasa Indonesia agar informatif
     */
    public function messages(): array
    {
        return [
            'pemilik_id.required'   => 'Pemilik usaha (UEP/KUBE) wajib dipilih.',
            'pemilik_id.regex'      => 'Format pemilik usaha tidak valid.',

            'whatsapp_sales.regex'  => 'Nomor WhatsApp hanya boleh berisi angka, spasi, + dan -.',

            'foto_produk.required'   => 'Foto produk wajib diunggah.',
            'foto_produk.file'       => 'Berkas yang diunggah harus berupa file valid.',
            'foto_produk.image'      => 'Berkas yang diunggah harus berupa gambar.',
            'foto_produk.mimes'      => 'Ekstensi file ditolak! Hanya file berekstensi (jpeg, jpg, png) yang diizinkan demi keamanan.',
            'foto_produk.mimetypes'  => 'Tipe file tidak dikenali sebagai gambar JPG/PNG yang sah.',
            'foto_produk.max'        => 'Ukuran berkas terlalu besar! Maksimal ukuran file adalah 2MB.',
            'foto_produk.dimensions' => 'Dimensi gambar terlalu besar! Maksimal 4000x4000 piksel.',
        ];
    }

    /**
     * Bersihkan whitespace di awal/akhir input teks sebelum divalidasi.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'nama_produk' => trim((string) $this->input('nama_produk', '')),
            'kategori'    => trim((string) $this->input('kategori', '')),
        ]);
    }
}