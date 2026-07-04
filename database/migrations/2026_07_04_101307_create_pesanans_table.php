<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pesanan', 20)->unique();

            $table->foreignId('produk_umkm_id')->constrained('produk_umkms')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // pembeli

            $table->unsignedInteger('jumlah');
            $table->unsignedBigInteger('harga_saat_pesan'); // snapshot harga_jual saat pesan dibuat

            $table->enum('status', ['menunggu_konfirmasi', 'dikonfirmasi', 'ditolak'])
                  ->default('menunggu_konfirmasi');

            $table->foreignId('confirmed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('confirmed_at')->nullable();
            $table->text('catatan')->nullable(); // alasan tolak, dsb

            $table->timestamps();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};