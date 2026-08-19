<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $clients = [
            ['icon' => 'hexagon', 'name' => 'Nexa', 'sort_order' => 1],
            ['icon' => 'triangle', 'name' => 'Vertex', 'sort_order' => 2],
            ['icon' => 'orbit', 'name' => 'Orbita', 'sort_order' => 3],
            ['icon' => 'sun', 'name' => 'Lumen', 'sort_order' => 4],
            ['icon' => 'mountain', 'name' => 'Astra', 'sort_order' => 5],
            ['icon' => 'zap', 'name' => 'Kinetic', 'sort_order' => 6],
            ['icon' => 'anchor', 'name' => 'Solace', 'sort_order' => 7],
            ['icon' => 'compass', 'name' => 'Vantage', 'sort_order' => 8],
        ];

        foreach ($clients as $client) {
            Client::updateOrCreate(['name' => $client['name']], $client);
        }
    }
}
