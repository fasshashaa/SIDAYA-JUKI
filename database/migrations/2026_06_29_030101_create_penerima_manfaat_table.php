<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('penerima_manfaats', function (Blueprint $table) {
        $table->id();
        $table->string('nik', 16)->unique();
        $table->string('nama_lengkap');
        $table->string('kecamatan');
        $table->string('desa'); // <-- Pastikan baris ini ada
        $table->string('whatsapp')->nullable();
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('penerima_manfaats');
    }
};