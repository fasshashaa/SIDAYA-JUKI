<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint; // <-- Pastikan class ini ter-import di atas
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) { // <-- Diubah ke Blueprint
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('activity'); // Contoh: 'CREATE_PENERIMA_MANFAAT'
            $table->string('model_type'); // Nama Class Model
            $table->unsignedBigInteger('model_id'); // ID data
            $table->json('before_changes')->nullable(); // Data lama sebelum diubah
            $table->json('after_changes')->nullable();  // Data baru setelah diubah
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};