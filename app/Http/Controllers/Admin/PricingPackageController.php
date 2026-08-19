<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePricingPackageRequest;
use App\Http\Requests\Admin\UpdatePricingPackageRequest;
use App\Models\PricingPackage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PricingPackageController extends Controller
{
    public function index(Request $request): View
    {
        $packages = PricingPackage::query()
            ->when($request->filled('search'), fn ($query) => $query->where('name', 'like', "%{$request->string('search')}%"))
            ->when($request->filled('tier'), fn ($query) => $query->where('tier', $request->string('tier')))
            ->when($request->filled('status'), fn ($query) => $query->where('is_active', $request->string('status') === 'active'))
            ->ordered()
            ->paginate(10)
            ->withQueryString();

        return view('admin.pricing-packages.index', compact('packages'));
    }

    public function create(): View
    {
        return view('admin.pricing-packages.create', ['package' => new PricingPackage]);
    }

    public function store(StorePricingPackageRequest $request): RedirectResponse
    {
        PricingPackage::create($this->prepare($request->validated(), $request));

        return redirect()
            ->route('admin.pricing-packages.index')
            ->with('status', 'Paket harga berhasil ditambahkan.');
    }

    public function edit(PricingPackage $pricingPackage): View
    {
        return view('admin.pricing-packages.edit', ['package' => $pricingPackage]);
    }

    public function update(UpdatePricingPackageRequest $request, PricingPackage $pricingPackage): RedirectResponse
    {
        $pricingPackage->update($this->prepare($request->validated(), $request));

        return redirect()
            ->route('admin.pricing-packages.index')
            ->with('status', 'Paket harga berhasil diperbarui.');
    }

    public function destroy(PricingPackage $pricingPackage): RedirectResponse
    {
        $pricingPackage->delete();

        return redirect()
            ->route('admin.pricing-packages.index')
            ->with('status', 'Paket harga berhasil dihapus.');
    }

    public function toggle(PricingPackage $pricingPackage): RedirectResponse
    {
        $pricingPackage->update(['is_active' => ! $pricingPackage->is_active]);

        return back()->with('status', 'Status paket harga berhasil diubah.');
    }

    /**
     * Ubah textarea "satu fitur per baris" menjadi array, dan set default checkbox.
     */
    private function prepare(array $data, Request $request): array
    {
        $data['features'] = collect(explode("\n", $data['features'] ?? ''))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->values()
            ->all();

        $data['is_best_seller'] = $request->boolean('is_best_seller');
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
