<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="md:col-span-2">
        <x-input-label for="badge" value="Badge (teks kecil di atas judul)" />
        <x-text-input id="badge" name="badge" type="text" class="mt-1 block w-full"
                      :value="old('badge', $slide->badge)" required autofocus placeholder="Contoh: Kami Siap Membantu Bisnis Anda" />
        <x-input-error :messages="$errors->get('badge')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="title" value="Judul" />
        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                      :value="old('title', $slide->title)" required placeholder="Contoh: Wujudkan Ide Anda" />
        <x-input-error :messages="$errors->get('title')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="title_highlight" value="Judul (bagian ditonjolkan, opsional)" />
        <x-text-input id="title_highlight" name="title_highlight" type="text" class="mt-1 block w-full"
                      :value="old('title_highlight', $slide->title_highlight)" placeholder="Contoh: Bersama NextTime" />
        <p class="mt-1 text-xs text-gray-400">Ditampilkan di baris baru dengan warna aksen.</p>
        <x-input-error :messages="$errors->get('title_highlight')" class="mt-2" />
    </div>

    <div class="md:col-span-2">
        <x-input-label for="description" value="Deskripsi" />
        <textarea id="description" name="description" rows="3" required
                  class="mt-1 block w-full border-gray-300 focus:border-cyan-500 focus:ring-cyan-500 rounded-md shadow-sm">{{ old('description', $slide->description) }}</textarea>
        <x-input-error :messages="$errors->get('description')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="primary_cta_text" value="Teks Tombol Utama" />
        <x-text-input id="primary_cta_text" name="primary_cta_text" type="text" class="mt-1 block w-full"
                      :value="old('primary_cta_text', $slide->primary_cta_text)" required placeholder="Contoh: Lihat Layanan →" />
        <x-input-error :messages="$errors->get('primary_cta_text')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="primary_cta_link" value="Tautan Tombol Utama" />
        <x-text-input id="primary_cta_link" name="primary_cta_link" type="text" class="mt-1 block w-full"
                      :value="old('primary_cta_link', $slide->primary_cta_link)" required placeholder="Contoh: #layanan" />
        <x-input-error :messages="$errors->get('primary_cta_link')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="secondary_cta_text" value="Teks Tombol Kedua (opsional)" />
        <x-text-input id="secondary_cta_text" name="secondary_cta_text" type="text" class="mt-1 block w-full"
                      :value="old('secondary_cta_text', $slide->secondary_cta_text)" placeholder="Contoh: Hubungi Kami" />
        <x-input-error :messages="$errors->get('secondary_cta_text')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="secondary_cta_link" value="Tautan Tombol Kedua" />
        <x-text-input id="secondary_cta_link" name="secondary_cta_link" type="text" class="mt-1 block w-full"
                      :value="old('secondary_cta_link', $slide->secondary_cta_link)" placeholder="Contoh: #kontak" />
        <x-input-error :messages="$errors->get('secondary_cta_link')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="sort_order" value="Urutan Tampil" />
        <x-text-input id="sort_order" name="sort_order" type="number" class="mt-1 block w-full"
                      :value="old('sort_order', $slide->sort_order ?? 0)" />
        <x-input-error :messages="$errors->get('sort_order')" class="mt-2" />
    </div>

    <div class="flex items-center gap-2">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" id="is_active" name="is_active" value="1"
               @checked(old('is_active', $slide->exists ? $slide->is_active : true))
               class="rounded border-gray-300 text-cyan-600 focus:ring-cyan-500">
        <label for="is_active" class="text-sm text-gray-700">Tampilkan di halaman utama</label>
    </div>
</div>

<div class="mt-6 flex items-center gap-3">
    <x-primary-button>Simpan</x-primary-button>
    <a href="{{ route('admin.hero-slides.index') }}" class="text-sm text-gray-500 hover:underline">Batal</a>
</div>
