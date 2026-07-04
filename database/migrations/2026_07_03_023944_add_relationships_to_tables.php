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
        // 1. KONDISIONAL UNTUK TABEL UEPS
        if (Schema::hasTable('ueps')) {
            Schema::table('ueps', function (Blueprint $table) {
                if (!Schema::hasColumn('ueps', 'user_id')) {
                    $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
                }
            });
        }

        // 2. KONDISIONAL UNTUK TABEL KUBES
        if (Schema::hasTable('kubes')) {
            Schema::table('kubes', function (Blueprint $table) {
                if (!Schema::hasColumn('kubes', 'user_id')) {
                    $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
                }
            });
        }

        // 3. KONDISIONAL UNTUK TABEL PENERIMA_MANFAAT
        if (Schema::hasTable('penerima_manfaat')) {
            Schema::table('penerima_manfaat', function (Blueprint $table) {
                if (!Schema::hasColumn('penerima_manfaat', 'uep_id')) {
                    $table->foreignId('uep_id')->nullable()->constrained()->onDelete('set null');
                }
                if (!Schema::hasColumn('penerima_manfaat', 'kube_id')) {
                    $table->foreignId('kube_id')->nullable()->constrained()->onDelete('set null');
                }
            });
        }

        // 4. KONDISIONAL UNTUK TABEL PRODUKS
        if (Schema::hasTable('produks')) {
            Schema::table('produks', function (Blueprint $table) {
                if (!Schema::hasColumn('produks', 'uep_id')) {
                    $table->foreignId('uep_id')->nullable()->constrained()->onDelete('set null');
                }
                if (!Schema::hasColumn('produks', 'kube_id')) {
                    $table->foreignId('kube_id')->nullable()->constrained()->onDelete('set null');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rollback tabel 'produks' jika tabelnya ada
        if (Schema::hasTable('produks')) {
            Schema::table('produks', function (Blueprint $table) {
                if (Schema::hasColumn('produks', 'uep_id')) $table->dropForeign(['uep_id']);
                if (Schema::hasColumn('produks', 'kube_id')) $table->dropForeign(['kube_id']);
            });
        }

        // Rollback tabel 'penerima_manfaat' jika tabelnya ada
        if (Schema::hasTable('penerima_manfaat')) {
            Schema::table('penerima_manfaat', function (Blueprint $table) {
                if (Schema::hasColumn('penerima_manfaat', 'uep_id')) $table->dropForeign(['uep_id']);
                if (Schema::hasColumn('penerima_manfaat', 'kube_id')) $table->dropForeign(['kube_id']);
            });
        }

        // Rollback tabel 'kubes' jika tabelnya ada
        if (Schema::hasTable('kubes')) {
            Schema::table('kubes', function (Blueprint $table) {
                if (Schema::hasColumn('kubes', 'user_id')) {
                    try { $table->dropForeign(['user_id']); } catch (\Exception $e) {}
                }
            });
        }

        // Rollback tabel 'ueps' jika tabelnya ada
        if (Schema::hasTable('ueps')) {
            Schema::table('ueps', function (Blueprint $table) {
                if (Schema::hasColumn('ueps', 'user_id')) {
                    try { $table->dropForeign(['user_id']); } catch (\Exception $e) {}
                }
            });
        }
    }
};