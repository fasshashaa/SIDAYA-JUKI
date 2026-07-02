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
        // Tambahkan kolom user_id
        $table->unsignedBigInteger('user_id')->after('id')->nullable();
        
        // Opsional: Tambahkan foreign key agar rapi
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('penerima_manfaats', function (Blueprint $table) {
        $table->dropForeign(['user_id']);
        $table->dropColumn('user_id');
    });
}
};
