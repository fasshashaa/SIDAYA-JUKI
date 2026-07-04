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
    // Cek dulu apakah kolom user_id belum ada di tabel produk_umkms
    if (!Schema::hasColumn('produk_umkms', 'user_id')) {
        Schema::table('produk_umkms', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->nullable()->after('id');
        });
    }
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produk_umkms', function (Blueprint $table) {
            //
        });
    }
};
