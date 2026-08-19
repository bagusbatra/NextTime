<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="md:col-span-2">
        <x-input-label for="name" value="Nama Klien" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                      :value="old('name', $client->name)" required autofocus placeholder="Contoh: Nexa" />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="icon" value="Ikon Lucide (fallback jika tanpa logo)" />
        <x-text-input id="icon" name="icon" type="text" class="mt-1 block w-full"
                      :value="old('icon', $client->icon)" placeholder="Contoh: hexagon" />
        <x-input-error :messages="$errors->get('icon')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="sort_order" value="Urutan Tampil" />
        <x-text-input id="sort_order" name="sort_order" type="number" class="mt-1 block w-full"
                      :value="old('sort_order', $client->sort_order ?? 0)" />
        <x-input-error :messages="$errors->get('sort_order')" class="mt-2" />
    </div>

    <div class="md:col-span-2">
        <x-input-label for="logo" value="Logo (opsional, menggantikan ikon)" />
        @if ($client->logo_path)
            <img src="{{ asset('storage/'.$client->logo_path) }}" alt="{{ $client->name }}" class="h-12 w-12 object-contain mt-1 mb-2 rounded bg-gray-50 p-1">
        @endif
        <input type="file" id="logo" name="logo" accept="image/*" class="mt-1 block w-full text-sm text-gray-500">
        <x-input-error :messages="$errors->get('logo')" class="mt-2" />
    </div>

    <div class="flex items-center gap-2 md:col-span-2">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" id="is_active" name="is_active" value="1"
               @checked(old('is_active', $client->exists ? $client->is_active : true))
               class="rounded border-gray-300 text-cyan-600 focus:ring-cyan-500">
        <label for="is_active" class="text-sm text-gray-700">Tampilkan di halaman utama</label>
    </div>
</div>

<div class="mt-6 flex items-center gap-3">
    <x-primary-button>Simpan</x-primary-button>
    <a href="{{ route('admin.clients.index') }}" class="text-sm text-gray-500 hover:underline">Batal</a>
</div>
