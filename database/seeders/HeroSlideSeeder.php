<?php

namespace Database\Seeders;

use App\Models\HeroSlide;
use Illuminate\Database\Seeder;

class HeroSlideSeeder extends Seeder
{
    public function run(): void
    {
        $slides = [
            [
                'badge' => 'Kami Siap Membantu Bisnis Anda',
                'title' => 'Wujudkan Ide Anda',
                'title_highlight' => 'Bersama NextTime',
                'description' => 'Kami adalah tim kreatif yang berdedikasi menghadirkan solusi desain dan teknologi terbaik untuk pertumbuhan bisnis Anda.',
                'primary_cta_text' => 'Lihat Layanan →',
                'primary_cta_link' => '#layanan',
                'secondary_cta_text' => 'Hubungi Kami',
                'secondary_cta_link' => '#kontak',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'badge' => 'Desain · Teknologi · Pertumbuhan',
                'title' => 'Solusi Digital untuk',
                'title_highlight' => 'Bisnis Modern',
                'description' => 'Dari website, aplikasi dashboard, hingga strategi pemasaran digital — semua dikerjakan dengan standar kualitas tertinggi.',
                'primary_cta_text' => 'Lihat Portofolio →',
                'primary_cta_link' => '#portofolio',
                'secondary_cta_text' => 'Eksplorasi Layanan',
                'secondary_cta_link' => '#layanan',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'badge' => 'Jadilah Partner Awal Kami',
                'title' => 'Jasa Pembuatan Website',
                'title_highlight' => 'Terjangkau',
                'description' => 'Menghadirkan solusi kreatif dan teknologi yang mendorong pertumbuhan bisnis yang nyata dan berkelanjutan.',
                'primary_cta_text' => 'Mulai Proyek →',
                'primary_cta_link' => '#kontak',
                'secondary_cta_text' => 'Lihat Karya Kami',
                'secondary_cta_link' => '#portofolio',
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($slides as $slide) {
            HeroSlide::updateOrCreate(
                ['title' => $slide['title'], 'sort_order' => $slide['sort_order']],
                $slide
            );
        }
    }
}
