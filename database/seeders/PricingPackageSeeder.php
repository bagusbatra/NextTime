<?php

namespace Database\Seeders;

use App\Models\PricingPackage;
use Illuminate\Database\Seeder;

class PricingPackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            [
                'name' => 'Silver',
                'tier' => 'silver',
                'icon' => 'shield',
                'price_prefix' => 'mulai dari',
                'price_amount' => '800',
                'price_unit' => 'rb',
                'features' => [
                    'Design responsif modern',
                    'Up to 3 halaman',
                    'Domain 1 tahun (id)',
                    'Revisi 2x',
                ],
                'cta_text' => 'Mulai Sekarang',
                'cta_link' => '#kontak',
                'is_best_seller' => false,
                'sort_order' => 1,
            ],
            [
                'name' => 'Gold',
                'tier' => 'gold',
                'icon' => 'star',
                'price_prefix' => 'mulai dari',
                'price_amount' => '1.800',
                'price_unit' => 'rb',
                'features' => [
                    'Design premium custom',
                    'Up to 12 halaman',
                    'Domain & hosting 1 tahun',
                    'SEO dasar & integrasi CMS',
                    'Revisi 5x',
                ],
                'cta_text' => 'Pilih Paket Ini',
                'cta_link' => '#kontak',
                'is_best_seller' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Diamond',
                'tier' => 'diamond',
                'icon' => 'gem',
                'price_prefix' => 'mulai dari',
                'price_amount' => '2.900',
                'price_unit' => 'rb',
                'features' => [
                    'Design eksklusif full custom',
                    'Halaman tidak terbatas',
                    'Domain & hosting 1 tahun',
                    'SEO lanjutan + integrasi CMS',
                    'Revisi unlimited',
                    'Maintenance 3 bulan',
                ],
                'cta_text' => 'Mulai Sekarang',
                'cta_link' => '#kontak',
                'is_best_seller' => false,
                'sort_order' => 3,
            ],
            [
                'name' => 'Custom',
                'tier' => 'custom',
                'icon' => 'settings-2',
                'price_prefix' => 'harga',
                'price_amount' => 'Fleksibel',
                'price_unit' => null,
                'features' => [
                    'Kebutuhan spesifik Anda',
                    'Fitur & integrasi khusus',
                    'Timeline fleksibel',
                    'Konsultasi gratis',
                    'Support jangka panjang',
                ],
                'cta_text' => 'Konsultasi Gratis',
                'cta_link' => '#kontak',
                'is_best_seller' => false,
                'sort_order' => 4,
            ],
        ];

        foreach ($packages as $package) {
            PricingPackage::updateOrCreate(['name' => $package['name']], $package);
        }
    }
}
