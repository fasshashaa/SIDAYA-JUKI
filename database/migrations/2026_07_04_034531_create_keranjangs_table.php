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
    Schema::create('keranjangs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained(); // Pelanggan yang punya keranjang
        $table->foreignId('produk_umkm_id')->constrained(); // Produk yang dipilih
        $table->integer('jumlah')->default(1);
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keranjangs');
    }
};
