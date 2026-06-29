<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ueps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penerima_manfaat_id')->nullable()->constrained('penerima_manfaats')->onDelete('set null');
            
            // Data Identitas Pemilik Usaha
            $table->string('nik', 16)->nullable();
            $table->string('no_kk', 16)->nullable();
            $table->string('nama_lengkap')->nullable();
            $table->string('nama_ibu_kandung')->nullable();
            
            // Data Detail Usaha Ekonomi Produktif
            $table->string('nama_usaha');
            $table->string('no_operasional_wa')->nullable();
            $table->string('kecamatan_usaha');
            $table->string('desa_kelurahan_usaha');
            $table->text('alamat_lengkap');
            $table->string('kategori_produk');
            $table->string('status_usaha')->default('Aktif'); 
            
            // Widget Dashboard Status
            $table->enum('status_perkembangan', ['rintisan', 'berkembang', 'mandiri'])->default('rintisan');
            
            // Anggaran & Atribut Sistem
            $table->year('tahun_realisasi');
            $table->string('sumber_anggaran');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ueps');
    }
};