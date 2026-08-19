<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactSettingsController extends Controller
{
    public function edit(): View
    {
        $contact = [
            'address' => Setting::get('contact.address', 'Surabaya, Jawa Timur, Indonesia'),
            'phone' => Setting::get('contact.phone', '+62 882-2827-2679'),
            'email' => Setting::get('contact.email', 'bagusbatr@gmail.com'),
            'work_hours' => Setting::get('contact.work_hours', 'Senin – Jumat: 08.00 – 17.00 WIB'),
        ];

        return view('admin.contact-settings.edit', compact('contact'));
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'address' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'work_hours' => ['required', 'string', 'max:255'],
        ]);

        foreach ($data as $key => $value) {
            Setting::set('contact', $key, $value);
        }

        return redirect()
            ->route('admin.contact-settings.edit')
            ->with('status', 'Info kontak berhasil disimpan.');
    }
}
