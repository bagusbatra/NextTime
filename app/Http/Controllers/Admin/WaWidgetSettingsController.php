<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WaWidgetSettingsController extends Controller
{
    public function edit(): View
    {
        $wa = [
            'phone' => Setting::get('wa_widget.phone', '6288228272679'),
            'default_message' => Setting::get('wa_widget.default_message', 'Halo NextTime, saya tertarik dengan promo website dan ingin konsultasi lebih lanjut.'),
            'promo_enabled' => (bool) Setting::get('wa_widget.promo_enabled', true),
            'promo_tag' => Setting::get('wa_widget.promo_tag', '🔥 Promo Bulan Ini'),
            'promo_title' => Setting::get('wa_widget.promo_title', 'Konsultasi Gratis & Diskon 10%!'),
            'promo_message' => Setting::get('wa_widget.promo_message', 'Dapatkan penawaran terbaik untuk website impian Anda. Chat langsung dengan tim kami sekarang — respon cepat!'),
        ];

        return view('admin.wa-widget-settings.edit', compact('wa'));
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'phone' => ['required', 'string', 'max:20'],
            'default_message' => ['required', 'string', 'max:500'],
            'promo_enabled' => ['boolean'],
            'promo_tag' => ['required', 'string', 'max:100'],
            'promo_title' => ['required', 'string', 'max:150'],
            'promo_message' => ['required', 'string', 'max:500'],
        ]);

        $data['promo_enabled'] = $request->boolean('promo_enabled');

        foreach ($data as $key => $value) {
            Setting::set('wa_widget', $key, $value, $key === 'promo_enabled' ? 'boolean' : 'text');
        }

        return redirect()
            ->route('admin.wa-widget-settings.edit')
            ->with('status', 'Pengaturan widget WhatsApp berhasil disimpan.');
    }
}
