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
        // Akun admin default untuk development lokal.
        // Ganti/hapus sebelum deploy ke production.
        User::factory()->create([
            'name' => 'Admin NextTime',
            'email' => 'admin@nexttime.test',
            'password' => bcrypt('password'),
        ]);

        $this->call(ProjectSeeder::class);
    }
}
