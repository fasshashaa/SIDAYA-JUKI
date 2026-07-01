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
    Schema::table('produk_umkms', function (Blueprint $table) {
        $table->foreignId('uep_id')->nullable()->change();
        $table->foreignId('kube_id')->nullable()->change();
    });
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
