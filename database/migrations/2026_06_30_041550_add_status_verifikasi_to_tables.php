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
    // Tambah ke tabel penerima_manfaats
    Schema::table('penerima_manfaats', function (Blueprint $table) {
        if (!Schema::hasColumn('penerima_manfaats', 'status_verifikasi')) {
            $table->string('status_verifikasi')->default('pending');
        }
    });

    // Tambah ke tabel ueps
    Schema::table('ueps', function (Blueprint $table) {
        if (!Schema::hasColumn('ueps', 'status_verifikasi')) {
            $table->string('status_verifikasi')->default('pending');
        }
    });

    // Tambah ke tabel kube
    Schema::table('kube', function (Blueprint $table) {
        if (!Schema::hasColumn('kube', 'status_verifikasi')) {
            $table->string('status_verifikasi')->default('pending');
        }
    });
}

public function down()
{
    Schema::table('penerima_manfaats', function (Blueprint $table) { $table->dropColumn('status_verifikasi'); });
    Schema::table('ueps', function (Blueprint $table) { $table->dropColumn('status_verifikasi'); });
    Schema::table('kube', function (Blueprint $table) { $table->dropColumn('status_verifikasi'); });
}
};
