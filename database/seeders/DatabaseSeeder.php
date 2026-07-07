<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Akun Admin Default
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
            'email_verified_at' => now(), // Verifikasi otomatis
        ]);

        // Akun Kasir Default
        User::create([
            'name' => 'Kasir 1',
            'email' => 'kasir1@gmail.com',
            'password' => bcrypt('kasir123'),
            'role' => 'kasir',
            'email_verified_at' => now(), // Verifikasi otomatis
        ]);
    }
}
