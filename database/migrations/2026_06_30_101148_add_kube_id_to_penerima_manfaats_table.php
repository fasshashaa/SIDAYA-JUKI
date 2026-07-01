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
        // Menambahkan kolom kube_id
        $table->unsignedBigInteger('kube_id')->nullable()->after('uep_id');
        
        // Opsional: Foreign key
        // $table->foreign('kube_id')->references('id')->on('kube')->onDelete('set null');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penerima_manfaats', function (Blueprint $table) {
            //
        });
    }
};
