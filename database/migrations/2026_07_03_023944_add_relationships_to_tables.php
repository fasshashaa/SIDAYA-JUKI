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
    Schema::table('ueps', function (Blueprint $table) {
        $table->foreignId('user_id')->unique()->constrained();
    });
    Schema::table('kubes', function (Blueprint $table) {
        $table->foreignId('user_id')->unique()->constrained();
    });
    Schema::table('penerima_manfaat', function (Blueprint $table) {
        $table->foreignId('uep_id')->nullable()->constrained();
        $table->foreignId('kube_id')->nullable()->constrained();
    });
    Schema::table('produks', function (Blueprint $table) {
        $table->foreignId('uep_id')->nullable()->constrained();
        $table->foreignId('kube_id')->nullable()->constrained();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tables', function (Blueprint $table) {
            //
        });
    }
};
