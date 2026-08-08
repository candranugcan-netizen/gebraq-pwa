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
    \App\Models\User::create([
        'name' => 'Admin Gebraq',
        'email' => 'admin@alfutuh.com',
        'password' => bcrypt('alfutuh123'), // Ini kata sandi login kamu
    ]);
}
}
