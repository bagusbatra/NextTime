<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreWhyUsItemRequest;
use App\Http\Requests\Admin\UpdateWhyUsItemRequest;
use App\Models\Setting;
use App\Models\WhyUsItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WhyUsItemController extends Controller
{
    public function index(Request $request): View
    {
        $items = WhyUsItem::query()
            ->when($request->filled('search'), fn ($query) => $query->where('title', 'like', "%{$request->string('search')}%"))
            ->when($request->filled('status'), fn ($query) => $query->where('is_active', $request->string('status') === 'active'))
            ->ordered()
            ->paginate(10)
            ->withQueryString();

        $cta = [
            'image' => Setting::get('why_us.cta_image'),
            'text' => Setting::get('why_us.cta_text', 'Konsultasi Gratis →'),
            'link' => Setting::get('why_us.cta_link', '#kontak'),
        ];

        return view('admin.why-us-items.index', compact('items', 'cta'));
    }

    public function create(): View
    {
        return view('admin.why-us-items.create', ['item' => new WhyUsItem]);
    }

    public function store(StoreWhyUsItemRequest $request): RedirectResponse
    {
        WhyUsItem::create($request->validated() + ['is_active' => $request->boolean('is_active')]);

        return redirect()
            ->route('admin.why-us-items.index')
            ->with('status', 'Item "Kenapa Kami" berhasil ditambahkan.');
    }

    public function edit(WhyUsItem $whyUsItem): View
    {
        return view('admin.why-us-items.edit', ['item' => $whyUsItem]);
    }

    public function update(UpdateWhyUsItemRequest $request, WhyUsItem $whyUsItem): RedirectResponse
    {
        $whyUsItem->update($request->validated() + ['is_active' => $request->boolean('is_active')]);

        return redirect()
            ->route('admin.why-us-items.index')
            ->with('status', 'Item "Kenapa Kami" berhasil diperbarui.');
    }

    public function destroy(WhyUsItem $whyUsItem): RedirectResponse
    {
        $whyUsItem->delete();

        return redirect()
            ->route('admin.why-us-items.index')
            ->with('status', 'Item "Kenapa Kami" berhasil dihapus.');
    }

    public function toggle(WhyUsItem $whyUsItem): RedirectResponse
    {
        $whyUsItem->update(['is_active' => ! $whyUsItem->is_active]);

        return back()->with('status', 'Status item berhasil diubah.');
    }

    /**
     * Simpan pengaturan gambar & CTA section "Kenapa Kami" (grup settings: why_us).
     */
    public function updateSettings(Request $request): RedirectResponse
    {
        $request->validate([
            'cta_image' => ['nullable', 'image', 'max:4096'],
            'cta_text' => ['required', 'string', 'max:100'],
            'cta_link' => ['required', 'string', 'max:255'],
        ]);

        if ($request->hasFile('cta_image')) {
            $path = $request->file('cta_image')->store('why-us', 'public');
            Setting::set('why_us', 'cta_image', $path, 'image');
        }

        Setting::set('why_us', 'cta_text', $request->string('cta_text'), 'text');
        Setting::set('why_us', 'cta_link', $request->string('cta_link'), 'url');

        return redirect()
            ->route('admin.why-us-items.index')
            ->with('status', 'Pengaturan CTA "Kenapa Kami" berhasil disimpan.');
    }
}
