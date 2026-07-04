<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('riwayat_pesanans', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id'); // ID Pelanggan
        $table->string('nama_produk');
        $table->integer('jumlah');
        $table->decimal('total_harga', 12, 2);
        $table->string('status')->default('Menunggu Konfirmasi');
        $table->string('whatsapp_tujuan')->nullable(); // Biar pas checkout kesimpen nomor WA-nya
        $table->timestamps();

        // Opsional: bikin relasi ke user
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}

public function down()
{
    Schema::dropIfExists('riwayat_pesanans');
}
};
