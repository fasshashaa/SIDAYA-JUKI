<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produk_umkms', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel ueps (Foreign Key)
            $table->foreignId('uep_id')->constrained('ueps')->onDelete('cascade');
            $table->string('nama_produk');
            $table->string('kategori');
            $table->text('deskripsi_produk');
            $table->string('foto_produk')->nullable();
            $table->decimal('harga_jual', 12, 2);
            $table->integer('stok')->default(0);
            $table->string('whatsapp_sales');
            $table->enum('status_publikasi', ['Ditampilkan', 'Draft'])->default('Ditampilkan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk_umkms');
    }
};