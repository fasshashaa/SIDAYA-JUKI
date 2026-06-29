<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenerimaManfaatSeeder extends Seeder
{
    public function run()
    {
        DB::table('penerima_manfaats')->insert([
            [
                'nik' => '3301051234567890',
                'nama_lengkap' => 'Agus Supriyanto',
                'kecamatan' => 'Kroya',
                'desa' => 'Kroya',
                'whatsapp' => '081234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nik' => '3301069876543210',
                'nama_lengkap' => 'Budi Santoso',
                'kecamatan' => 'Adipala',
                'desa' => 'Adipala',
                'whatsapp' => '082134567891',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}