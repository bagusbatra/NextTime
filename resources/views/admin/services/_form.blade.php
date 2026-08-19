<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <x-input-label for="icon" value="Ikon Lucide" />
        <x-text-input id="icon" name="icon" type="text" class="mt-1 block w-full"
                      :value="old('icon', $service->icon)" required autofocus placeholder="Contoh: briefcase" />
        <p class="mt-1 text-xs text-gray-400">Nama ikon dari <a href="https://lucide.dev/icons" target="_blank" class="underline">lucide.dev/icons</a></p>
        <x-input-error :messages="$errors->get('icon')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="sort_order" value="Urutan Tampil" />
        <x-text-input id="sort_order" name="sort_order" type="number" class="mt-1 block w-full"
                      :value="old('sort_order', $service->sort_order ?? 0)" />
        <x-input-error :messages="$errors->get('sort_order')" class="mt-2" />
    </div>

    <div class="md:col-span-2">
        <x-input-label for="title" value="Judul Layanan" />
        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                      :value="old('title', $service->title)" required placeholder="Contoh: Company Profile" />
        <x-input-error :messages="$errors->get('title')" class="mt-2" />
    </div>

    <div class="md:col-span-2">
        <x-input-label for="description" value="Deskripsi" />
        <textarea id="description" name="description" rows="3" required
                  class="mt-1 block w-full border-gray-300 focus:border-cyan-500 focus:ring-cyan-500 rounded-md shadow-sm">{{ old('description', $service->description) }}</textarea>
        <x-input-error :messages="$errors->get('description')" class="mt-2" />
    </div>

    <div class="flex items-center gap-2 md:col-span-2">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" id="is_active" name="is_active" value="1"
               @checked(old('is_active', $service->exists ? $service->is_active : true))
               class="rounded border-gray-300 text-cyan-600 focus:ring-cyan-500">
        <label for="is_active" class="text-sm text-gray-700">Tampilkan di halaman utama</label>
    </div>
</div>

<div class="mt-6 flex items-center gap-3">
    <x-primary-button>Simpan</x-primary-button>
    <a href="{{ route('admin.services.index') }}" class="text-sm text-gray-500 hover:underline">Batal</a>
</div>
