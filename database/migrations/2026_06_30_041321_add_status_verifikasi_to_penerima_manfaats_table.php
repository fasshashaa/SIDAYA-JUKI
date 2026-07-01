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
    Schema::table('penerima_manfaats', function (Blueprint $table) {
        // Menambahkan kolom status dengan default 'pending'
        $table->string('status_verifikasi')->default('pending')->after('alamat_detail'); 
    });
}

public function down()
{
    Schema::table('penerima_manfaats', function (Blueprint $table) {
        $table->dropColumn('status_verifikasi');
    });
}
};
