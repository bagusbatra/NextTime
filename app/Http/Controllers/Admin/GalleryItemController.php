<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGalleryItemRequest;
use App\Http\Requests\Admin\UpdateGalleryItemRequest;
use App\Models\GalleryItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class GalleryItemController extends Controller
{
    public function index(Request $request): View
    {
        $items = GalleryItem::query()
            ->when($request->filled('search'), fn ($query) => $query->where('title', 'like', "%{$request->string('search')}%"))
            ->when($request->filled('status'), fn ($query) => $query->where('is_active', $request->string('status') === 'active'))
            ->ordered()
            ->paginate(12)
            ->withQueryString();

        return view('admin.gallery-items.index', compact('items'));
    }

    public function create(): View
    {
        return view('admin.gallery-items.create', ['item' => new GalleryItem]);
    }

    public function store(StoreGalleryItemRequest $request): RedirectResponse
    {
        $data = $request->safe()->except('image');
        $data['is_active'] = $request->boolean('is_active');
        $data['image_path'] = $request->file('image')->store('gallery', 'public');

        GalleryItem::create($data);

        return redirect()
            ->route('admin.gallery-items.index')
            ->with('status', 'Item galeri berhasil ditambahkan.');
    }

    public function edit(GalleryItem $galleryItem): View
    {
        return view('admin.gallery-items.edit', ['item' => $galleryItem]);
    }

    public function update(UpdateGalleryItemRequest $request, GalleryItem $galleryItem): RedirectResponse
    {
        $data = $request->safe()->except('image');
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($galleryItem->image_path);
            $data['image_path'] = $request->file('image')->store('gallery', 'public');
        }

        $galleryItem->update($data);

        return redirect()
            ->route('admin.gallery-items.index')
            ->with('status', 'Item galeri berhasil diperbarui.');
    }

    public function destroy(GalleryItem $galleryItem): RedirectResponse
    {
        Storage::disk('public')->delete($galleryItem->image_path);
        $galleryItem->delete();

        return redirect()
            ->route('admin.gallery-items.index')
            ->with('status', 'Item galeri berhasil dihapus.');
    }

    public function toggle(GalleryItem $galleryItem): RedirectResponse
    {
        $galleryItem->update(['is_active' => ! $galleryItem->is_active]);

        return back()->with('status', 'Status item galeri berhasil diubah.');
    }
}
