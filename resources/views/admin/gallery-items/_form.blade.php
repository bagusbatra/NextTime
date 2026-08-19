<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="md:col-span-2">
        <x-input-label for="title" value="Judul / Keterangan" />
        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                      :value="old('title', $item->title)" required autofocus placeholder="Contoh: Alur Kerja Proyek Kami" />
        <x-input-error :messages="$errors->get('title')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="size_variant" value="Ukuran Kartu" />
        <select id="size_variant" name="size_variant" required
                class="mt-1 block w-full border-gray-300 focus:border-cyan-500 focus:ring-cyan-500 rounded-md shadow-sm">
            @foreach (['normal' => 'Normal', 'wide' => 'Lebar (2 kolom)', 'tall' => 'Tinggi (2 baris)'] as $value => $label)
                <option value="{{ $value }}" @selected(old('size_variant', $item->size_variant ?? 'normal') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('size_variant')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="sort_order" value="Urutan Tampil" />
        <x-text-input id="sort_order" name="sort_order" type="number" class="mt-1 block w-full"
                      :value="old('sort_order', $item->sort_order ?? 0)" />
        <x-input-error :messages="$errors->get('sort_order')" class="mt-2" />
    </div>

    <div class="md:col-span-2">
        <x-input-label for="image" value="Foto" />
        @if ($item->image_path)
            <img src="{{ asset('storage/'.$item->image_path) }}" alt="{{ $item->title }}" class="h-24 rounded-lg object-cover mt-1 mb-2">
        @endif
        <input type="file" id="image" name="image" accept="image/*" @required(! $item->exists) class="mt-1 block w-full text-sm text-gray-500">
        <p class="mt-1 text-xs text-gray-400">Kosongkan saat edit jika tidak ingin mengganti foto.</p>
        <x-input-error :messages="$errors->get('image')" class="mt-2" />
    </div>

    <div class="flex items-center gap-2 md:col-span-2">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" id="is_active" name="is_active" value="1"
               @checked(old('is_active', $item->exists ? $item->is_active : true))
               class="rounded border-gray-300 text-cyan-600 focus:ring-cyan-500">
        <label for="is_active" class="text-sm text-gray-700">Tampilkan di halaman utama</label>
    </div>
</div>

<div class="mt-6 flex items-center gap-3">
    <x-primary-button>Simpan</x-primary-button>
    <a href="{{ route('admin.gallery-items.index') }}" class="text-sm text-gray-500 hover:underline">Batal</a>
</div>
