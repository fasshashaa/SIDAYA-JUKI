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
    Schema::table('penerima_manfaats', function (Blueprint $table) {
        // Menambahkan kolom uep_id (nullable karena PM mungkin belum punya UEP)
        $table->unsignedBigInteger('uep_id')->nullable()->after('id');
        
        // Opsional: Jika ingin membuat foreign key agar rapi
        // $table->foreign('uep_id')->references('id')->on('ueps')->onDelete('set null');
    });
}

public function down(): void
{
    Schema::table('penerima_manfaats', function (Blueprint $table) {
        $table->dropColumn('uep_id');
    });
}
};
