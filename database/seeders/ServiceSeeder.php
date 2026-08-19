<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['icon' => 'briefcase', 'title' => 'Company Profile', 'description' => 'Tampilkan identitas dan keunggulan perusahaan secara profesional kepada calon klien dan mitra bisnis.', 'sort_order' => 1],
            ['icon' => 'store', 'title' => 'Website UMKM', 'description' => 'Kehadiran digital representatif untuk usaha kecil dan menengah agar lebih dipercaya pelanggan.', 'sort_order' => 2],
            ['icon' => 'layout-template', 'title' => 'Landing Page', 'description' => 'Halaman fokus untuk produk atau kampanye tertentu yang dirancang memaksimalkan konversi pengunjung.', 'sort_order' => 3],
            ['icon' => 'shopping-cart', 'title' => 'Toko Online', 'description' => 'Platform jual beli lengkap dengan manajemen produk, keranjang belanja, dan integrasi pembayaran.', 'sort_order' => 4],
            ['icon' => 'palette', 'title' => 'Web Portofolio', 'description' => 'Showcase karya dan pencapaian Anda dengan tampilan kreatif yang menonjolkan personal branding.', 'sort_order' => 5],
            ['icon' => 'graduation-cap', 'title' => 'Web Sekolah / Kampus', 'description' => 'Profil institusi, program studi, berita akademik, dan portal informasi yang lengkap dan mudah dikelola.', 'sort_order' => 6],
            ['icon' => 'utensils', 'title' => 'Web Restoran', 'description' => 'Menu digital interaktif, sistem reservasi meja, dan profil restoran yang menggugah selera pelanggan.', 'sort_order' => 7],
            ['icon' => 'building-2', 'title' => 'Web Hotel', 'description' => 'Informasi fasilitas, galeri kamar, sistem booking online, dan integrasi manajemen reservasi tamu.', 'sort_order' => 8],
            ['icon' => 'plane', 'title' => 'Web Travel', 'description' => 'Paket wisata, booking perjalanan, dan destinasi lengkap untuk biro perjalanan modern.', 'sort_order' => 9],
            ['icon' => 'layout-dashboard', 'title' => 'Web Dashboard', 'description' => 'Panel kontrol data bisnis dengan visualisasi, laporan otomatis, dan manajemen pengguna berbasis peran.', 'sort_order' => 10],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(['title' => $service['title']], $service);
        }
    }
}
