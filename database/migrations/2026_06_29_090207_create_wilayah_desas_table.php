<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wilayah_desas', function (Blueprint $table) {
            $table->id();
            $table->string('kecamatan_nama')->index(); 
            $table->string('nama_desa');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wilayah_desas');
    }
};