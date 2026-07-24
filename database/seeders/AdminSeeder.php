<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mengecek apakah email admin sudah ada, jika belum buat baru
        if (!User::where('email', 'admin@museum.com')->exists()) {
            User::create([
                'nama_lengkap' => 'Administrator',
                'email' => 'admin@museum.com',
                'password' => Hash::make('password123'),
                'role' => 'admin'
            ]);
        }
    }
}
