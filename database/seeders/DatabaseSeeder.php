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
            'role' => 'admin',
        ]);

        $this->call(HeroSlideSeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(PricingPackageSeeder::class);
        $this->call(WhyUsItemSeeder::class);
        $this->call(ClientSeeder::class);
        $this->call(GalleryItemSeeder::class);
        $this->call(ProjectSeeder::class);
    }
}
