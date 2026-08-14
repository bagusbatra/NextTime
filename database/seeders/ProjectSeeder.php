<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = [
            [
                'slug' => 'dapur-nusantara',
                'title' => 'Dapur Nusantara',
                'tag' => 'Web Restoran',
                'category' => 'umkm',
                'status' => 'available',
                'mockup_type' => 'resto',
                'icon' => null,
                'summary' => 'Website restoran dengan menu digital interaktif, sistem reservasi meja, dan galeri hidangan yang menggugah selera.',
                'overview' => 'Dapur Nusantara adalah konsep website restoran yang dirancang menghadirkan pengalaman digital hangat dan menggugah selera bagi calon pelanggan, dengan tata letak yang menonjolkan visual hidangan dan kemudahan reservasi.',
                'features' => [
                    'Menu digital interaktif lengkap dengan kategori dan harga',
                    'Sistem reservasi meja online secara real-time',
                    'Galeri hidangan dengan foto kualitas tinggi',
                    'Informasi lokasi, jam operasional, dan kontak cepat',
                ],
                'featured' => true,
                'sort_order' => 1,
            ],
            [
                'slug' => 'batik-elegan-store',
                'title' => 'Batik Elegan Store',
                'tag' => 'Toko Online',
                'category' => 'umkm',
                'status' => 'available',
                'mockup_type' => 'shop',
                'icon' => null,
                'summary' => 'Platform e-commerce UMKM fashion batik dengan katalog produk, keranjang belanja, dan integrasi pembayaran lokal.',
                'overview' => 'Batik Elegan Store adalah konsep platform e-commerce untuk UMKM fashion batik, dirancang agar produk tampil menarik sekaligus proses belanja tetap sederhana dan cepat bagi pelanggan.',
                'features' => [
                    'Katalog produk dengan tata letak grid yang rapi',
                    'Keranjang belanja dan alur checkout ringkas',
                    'Integrasi metode pembayaran lokal',
                    'Halaman promo dan koleksi musiman',
                ],
                'featured' => true,
                'sort_order' => 2,
            ],
            [
                'slug' => 'studio-kreatif-co',
                'title' => 'Studio Kreatif Co.',
                'tag' => 'Web Profil',
                'category' => 'company-profile',
                'status' => 'available',
                'mockup_type' => 'company',
                'icon' => null,
                'summary' => 'Website company profile modern dengan portofolio, profil tim, halaman layanan, dan formulir kontak yang elegan.',
                'overview' => 'Studio Kreatif Co. adalah konsep website company profile modern yang menonjolkan portofolio karya dan identitas tim secara elegan untuk membangun kepercayaan calon klien baru.',
                'features' => [
                    'Hero split dengan penekanan identitas brand',
                    'Halaman portofolio karya dan profil tim',
                    'Halaman layanan yang terstruktur jelas',
                    'Formulir kontak yang elegan dan responsif',
                ],
                'featured' => true,
                'sort_order' => 3,
            ],
            [
                'slug' => 'hotel-bintang-timur',
                'title' => 'Hotel Bintang Timur',
                'tag' => 'Web Hotel',
                'category' => 'umkm',
                'status' => 'soon',
                'mockup_type' => null,
                'icon' => 'building-2',
                'summary' => 'Website hotel dengan sistem booking kamar, galeri fasilitas, dan integrasi manajemen reservasi tamu online.',
                'overview' => null,
                'features' => [],
                'featured' => true,
                'sort_order' => 4,
            ],
            [
                'slug' => 'jelajah-wisata-nusa',
                'title' => 'Jelajah Wisata Nusa',
                'tag' => 'Web Travel',
                'category' => 'umkm',
                'status' => 'soon',
                'mockup_type' => null,
                'icon' => 'plane',
                'summary' => 'Biro perjalanan digital dengan katalog paket wisata, booking online, dan destinasi pilihan seluruh Indonesia.',
                'overview' => null,
                'features' => [],
                'featured' => true,
                'sort_order' => 5,
            ],
            [
                'slug' => 'dashboard-bisnis-pro',
                'title' => 'Dashboard Bisnis Pro',
                'tag' => 'Web App',
                'category' => 'company-profile',
                'status' => 'soon',
                'mockup_type' => null,
                'icon' => 'layout-dashboard',
                'summary' => 'Panel kontrol analitik bisnis dengan grafik real-time, laporan otomatis, dan manajemen pengguna berbasis peran.',
                'overview' => null,
                'features' => [],
                'featured' => true,
                'sort_order' => 6,
            ],
            [
                'slug' => 'promo-produk-cepat',
                'title' => 'Promo Produk Cepat',
                'tag' => 'Landing Page',
                'category' => 'landing-page',
                'status' => 'soon',
                'mockup_type' => null,
                'icon' => 'megaphone',
                'summary' => 'Landing page fokus konversi untuk peluncuran produk atau kampanye promo dengan copywriting dan CTA yang tajam.',
                'overview' => null,
                'features' => [],
                'featured' => true,
                'sort_order' => 7,
            ],
        ];

        foreach ($projects as $project) {
            Project::updateOrCreate(['slug' => $project['slug']], $project);
        }
    }
}
