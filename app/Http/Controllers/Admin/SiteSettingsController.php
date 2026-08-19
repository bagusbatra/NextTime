<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SiteSettingsController extends Controller
{
    /**
     * Daftar section halaman utama yang bisa ditampilkan/disembunyikan admin.
     */
    public const SECTIONS = [
        'hero' => 'Hero / Slider',
        'layanan' => 'Layanan',
        'paket_harga' => 'Paket Harga',
        'kenapa' => 'Kenapa Kami',
        'portofolio' => 'Portofolio',
        'klien' => 'Klien & Partner',
        'galeri' => 'Galeri',
        'kontak' => 'Kontak',
        'wa_widget' => 'Widget WhatsApp',
    ];

    public function edit(): View
    {
        $site = [
            'site_name' => Setting::get('site.site_name', 'NextTime'),
            'logo_light' => Setting::get('site.logo_light'),
            'logo_dark' => Setting::get('site.logo_dark'),
            'footer_description' => Setting::get('site.footer_description', 'Tim kreatif yang berdedikasi menghadirkan solusi desain dan teknologi terbaik untuk pertumbuhan bisnis Anda.'),
            'social_instagram' => Setting::get('site.social_instagram', 'https://instagram.com/bagusbatra'),
            'social_github' => Setting::get('site.social_github', 'https://github.com/bagusbatra'),
        ];

        $sections = Setting::group('sections');

        return view('admin.settings.edit', [
            'site' => $site,
            'sections' => $sections,
            'sectionLabels' => self::SECTIONS,
        ]);
    }

    public function updateBranding(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'site_name' => ['required', 'string', 'max:100'],
            'logo_light' => ['nullable', 'image', 'max:2048'],
            'logo_dark' => ['nullable', 'image', 'max:2048'],
            'footer_description' => ['required', 'string', 'max:500'],
            'social_instagram' => ['nullable', 'url', 'max:255'],
            'social_github' => ['nullable', 'url', 'max:255'],
        ]);

        foreach (['logo_light', 'logo_dark'] as $field) {
            if ($request->hasFile($field)) {
                $oldPath = Setting::get("site.{$field}");
                if ($oldPath) {
                    Storage::disk('public')->delete($oldPath);
                }

                $path = $request->file($field)->store('site', 'public');
                Setting::set('site', $field, $path, 'image');
            }
        }

        foreach (['site_name', 'footer_description', 'social_instagram', 'social_github'] as $field) {
            Setting::set('site', $field, $data[$field] ?? '');
        }

        return redirect()
            ->route('admin.settings.edit')
            ->with('status', 'Pengaturan branding situs berhasil disimpan.');
    }

    public function updateSections(Request $request): RedirectResponse
    {
        foreach (array_keys(self::SECTIONS) as $key) {
            Setting::set('sections', $key, $request->boolean($key), 'boolean');
        }

        return redirect()
            ->route('admin.settings.edit')
            ->with('status', 'Pengaturan tampilan section berhasil disimpan.');
    }
}
