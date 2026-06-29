<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penerima_manfaats', function (Blueprint $table) {
            if (!Schema::hasColumn('penerima_manfaats', 'no_kk')) {
                $table->string('no_kk', 16)->after('nik')->nullable();
            }
            if (!Schema::hasColumn('penerima_manfaats', 'nama_ibu_kandung')) {
                $table->string('nama_ibu_kandung')->after('nama_lengkap')->nullable();
            }
            if (!Schema::hasColumn('penerima_manfaats', 'no_wa')) {
                $table->string('no_wa', 20)->after('nama_ibu_kandung')->nullable();
            }
            if (!Schema::hasColumn('penerima_manfaats', 'alamat_detail')) {
                $table->text('alamat_detail')->after('desa')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('penerima_manfaats', function (Blueprint $table) {
            $table->dropColumn(['no_kk', 'nama_ibu_kandung', 'no_wa', 'alamat_detail']);
        });
    }
};