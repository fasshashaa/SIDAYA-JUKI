<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(WilayahDesaSeeder::class);
        User::create([
            'name' => 'Admin SIDAYA',
            'email' => 'admin@sidaya.com',
            'password' => bcrypt('admin123'),
        ]);
    }
    
}