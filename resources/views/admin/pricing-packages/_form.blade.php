@php
    $featuresText = old('features', is_array($package->features ?? null) ? implode("\n", $package->features) : '');
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <x-input-label for="name" value="Nama Paket" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                      :value="old('name', $package->name)" required autofocus placeholder="Contoh: Gold" />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="tier" value="Tier" />
        <select id="tier" name="tier" required
                class="mt-1 block w-full border-gray-300 focus:border-cyan-500 focus:ring-cyan-500 rounded-md shadow-sm">
            @foreach (['silver' => 'Silver', 'gold' => 'Gold', 'diamond' => 'Diamond', 'custom' => 'Custom'] as $value => $label)
                <option value="{{ $value }}" @selected(old('tier', $package->tier ?? 'silver') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('tier')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="icon" value="Ikon Lucide" />
        <x-text-input id="icon" name="icon" type="text" class="mt-1 block w-full"
                      :value="old('icon', $package->icon)" required placeholder="Contoh: star" />
        <x-input-error :messages="$errors->get('icon')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="sort_order" value="Urutan Tampil" />
        <x-text-input id="sort_order" name="sort_order" type="number" class="mt-1 block w-full"
                      :value="old('sort_order', $package->sort_order ?? 0)" />
        <x-input-error :messages="$errors->get('sort_order')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="price_prefix" value="Awalan Harga" />
        <x-text-input id="price_prefix" name="price_prefix" type="text" class="mt-1 block w-full"
                      :value="old('price_prefix', $package->price_prefix ?? 'mulai dari')" required placeholder="mulai dari / harga" />
        <x-input-error :messages="$errors->get('price_prefix')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="price_amount" value="Nominal Harga" />
        <x-text-input id="price_amount" name="price_amount" type="text" class="mt-1 block w-full"
                      :value="old('price_amount', $package->price_amount)" required placeholder="800 atau Fleksibel" />
        <x-input-error :messages="$errors->get('price_amount')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="price_unit" value="Satuan Harga (opsional)" />
        <x-text-input id="price_unit" name="price_unit" type="text" class="mt-1 block w-full"
                      :value="old('price_unit', $package->price_unit)" placeholder="rb" />
        <p class="mt-1 text-xs text-gray-400">Kosongkan untuk paket Custom (misal nominal "Fleksibel").</p>
        <x-input-error :messages="$errors->get('price_unit')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="cta_text" value="Teks Tombol" />
        <x-text-input id="cta_text" name="cta_text" type="text" class="mt-1 block w-full"
                      :value="old('cta_text', $package->cta_text)" required placeholder="Mulai Sekarang" />
        <x-input-error :messages="$errors->get('cta_text')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="cta_link" value="Tautan Tombol" />
        <x-text-input id="cta_link" name="cta_link" type="text" class="mt-1 block w-full"
                      :value="old('cta_link', $package->cta_link ?? '#kontak')" required placeholder="#kontak" />
        <x-input-error :messages="$errors->get('cta_link')" class="mt-2" />
    </div>

    <div class="md:col-span-2">
        <x-input-label for="features" value="Daftar Fitur (satu per baris)" />
        <textarea id="features" name="features" rows="5" required
                  class="mt-1 block w-full border-gray-300 focus:border-cyan-500 focus:ring-cyan-500 rounded-md shadow-sm">{{ $featuresText }}</textarea>
        <x-input-error :messages="$errors->get('features')" class="mt-2" />
    </div>

    <div class="flex items-center gap-2">
        <input type="hidden" name="is_best_seller" value="0">
        <input type="checkbox" id="is_best_seller" name="is_best_seller" value="1"
               @checked(old('is_best_seller', $package->is_best_seller ?? false))
               class="rounded border-gray-300 text-cyan-600 focus:ring-cyan-500">
        <label for="is_best_seller" class="text-sm text-gray-700">Tandai sebagai Best Seller</label>
    </div>

    <div class="flex items-center gap-2">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" id="is_active" name="is_active" value="1"
               @checked(old('is_active', $package->exists ? $package->is_active : true))
               class="rounded border-gray-300 text-cyan-600 focus:ring-cyan-500">
        <label for="is_active" class="text-sm text-gray-700">Tampilkan di halaman utama</label>
    </div>
</div>

<div class="mt-6 flex items-center gap-3">
    <x-primary-button>Simpan</x-primary-button>
    <a href="{{ route('admin.pricing-packages.index') }}" class="text-sm text-gray-500 hover:underline">Batal</a>
</div>
