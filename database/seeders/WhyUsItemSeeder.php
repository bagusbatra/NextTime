<?php

namespace Database\Seeders;

use App\Models\WhyUsItem;
use Illuminate\Database\Seeder;

class WhyUsItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['icon' => 'wallet', 'title' => 'Harga Terjangkau', 'description' => 'Paket fleksibel dengan kualitas premium tanpa membebani budget bisnis Anda.', 'sort_order' => 1],
            ['icon' => 'sparkles', 'title' => 'Desain Modern & Responsif', 'description' => 'Tampilan up-to-date yang tetap optimal di semua perangkat, dari desktop hingga mobile.', 'sort_order' => 2],
            ['icon' => 'zap', 'title' => 'Pengerjaan Cepat', 'description' => 'Proses pengembangan efisien dengan timeline jelas tanpa mengorbankan kualitas.', 'sort_order' => 3],
            ['icon' => 'headset', 'title' => 'Support Berkelanjutan', 'description' => 'Pendampingan dan bantuan teknis setelah website Anda live, bukan sekadar selesai proyek.', 'sort_order' => 4],
            ['icon' => 'users', 'title' => 'Tim Berpengalaman', 'description' => 'Ditangani langsung oleh tim yang memahami kebutuhan digital berbagai jenis bisnis.', 'sort_order' => 5],
            ['icon' => 'heart-handshake', 'title' => 'Kepuasan Klien', 'description' => 'Komunikasi transparan dan revisi sesuai paket demi hasil yang benar-benar sesuai harapan.', 'sort_order' => 6],
        ];

        foreach ($items as $item) {
            WhyUsItem::updateOrCreate(['title' => $item['title']], $item);
        }
    }
}
