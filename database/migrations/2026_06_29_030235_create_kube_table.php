<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kube', function (Blueprint $table) {
            $table->id();
            // Relasi ke Ketua Kelompok (diambil dari data Penerima Manfaat)[cite: 1]
            $table->foreignId('ketua_penerima_manfaat_id')->constrained('penerima_manfaats')->onDelete('cascade');
            
            // Informasi Kelompok Usaha Bersama
            $table->string('nama_kelompok_kube');
            $table->string('jenis_usaha_kube');
            $table->string('no_telp_kube', 15)->nullable();
            $table->string('kecamatan_kube');
            $table->string('desa_kube');
            $table->text('alamat_lengkap_kube');

            // Klasifikasi & Anggaran[cite: 1]
            $table->integer('jumlah_anggota')->default(0);
            $table->year('tahun_realisasi');
            $table->string('sumber_anggaran');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kube');
    }
};