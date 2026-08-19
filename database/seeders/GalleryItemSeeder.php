<?php

namespace Database\Seeders;

use App\Models\GalleryItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GalleryItemSeeder extends Seeder
{
    /**
     * Data awal galeri belum punya foto asli (item lama di section Galeri murni
     * ilustrasi CSS). Sebagai titik awal, tiap item diseed dengan gambar
     * placeholder agar admin tinggal mengganti fotonya lewat form edit.
     */
    public function run(): void
    {
        $items = [
            ['title' => 'Alur Kerja Proyek Kami', 'size_variant' => 'wide', 'sort_order' => 1],
            ['title' => 'Wireframe & Sketsa Awal', 'size_variant' => 'tall', 'sort_order' => 2],
            ['title' => 'Sistem Palet Warna', 'size_variant' => 'normal', 'sort_order' => 3],
            ['title' => 'Typography & Font Pairing', 'size_variant' => 'normal', 'sort_order' => 4],
            ['title' => 'Tools yang Kami Gunakan', 'size_variant' => 'normal', 'sort_order' => 5],
            ['title' => 'UI Components Library', 'size_variant' => 'wide', 'sort_order' => 6],
            ['title' => 'Mobile-first Design', 'size_variant' => 'normal', 'sort_order' => 7],
            ['title' => 'Moodboard & Konsep Visual', 'size_variant' => 'tall', 'sort_order' => 8],
        ];

        $placeholder = public_path('assets/why.png');

        foreach ($items as $item) {
            $existing = GalleryItem::where('title', $item['title'])->first();

            if ($existing) {
                $existing->update($item);

                continue;
            }

            $path = 'gallery/placeholder-'.Str::slug($item['title']).'.png';

            if (file_exists($placeholder)) {
                Storage::disk('public')->put($path, file_get_contents($placeholder));
            }

            GalleryItem::create($item + ['image_path' => $path]);
        }
    }
}
