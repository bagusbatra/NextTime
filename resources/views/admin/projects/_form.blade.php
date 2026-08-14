@php
    $featuresText = old('features', is_array($project->features ?? null) ? implode("\n", $project->features) : '');
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <x-input-label for="title" value="Judul Proyek" />
        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                      :value="old('title', $project->title)" required autofocus />
        <x-input-error :messages="$errors->get('title')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="slug" value="Slug (URL)" />
        <x-text-input id="slug" name="slug" type="text" class="mt-1 block w-full"
                      :value="old('slug', $project->slug)" required />
        <p class="mt-1 text-xs text-gray-400">Contoh: dapur-nusantara — dipakai di /projects/&lt;slug&gt;</p>
        <x-input-error :messages="$errors->get('slug')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="tag" value="Tag Tampilan" />
        <x-text-input id="tag" name="tag" type="text" class="mt-1 block w-full"
                      :value="old('tag', $project->tag)" required placeholder="Contoh: Web Restoran" />
        <x-input-error :messages="$errors->get('tag')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="category" value="Kategori Filter" />
        <select id="category" name="category" required
                class="mt-1 block w-full border-gray-300 focus:border-cyan-500 focus:ring-cyan-500 rounded-md shadow-sm">
            @foreach (['umkm' => 'UMKM', 'company-profile' => 'Company Profile', 'landing-page' => 'Landing Page'] as $value => $label)
                <option value="{{ $value }}" @selected(old('category', $project->category) === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('category')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="status" value="Status" />
        <select id="status" name="status" required
                class="mt-1 block w-full border-gray-300 focus:border-cyan-500 focus:ring-cyan-500 rounded-md shadow-sm">
            <option value="available" @selected(old('status', $project->status) === 'available')>Tayang (punya halaman detail)</option>
            <option value="soon" @selected(old('status', $project->status) === 'soon')>Segera Hadir (belum bisa diklik)</option>
        </select>
        <x-input-error :messages="$errors->get('status')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="mockup_type" value="Tipe Mockup (untuk status Tayang)" />
        <select id="mockup_type" name="mockup_type"
                class="mt-1 block w-full border-gray-300 focus:border-cyan-500 focus:ring-cyan-500 rounded-md shadow-sm">
            <option value="">— Pilih —</option>
            @foreach (['resto' => 'Resto', 'shop' => 'Shop', 'company' => 'Company'] as $value => $label)
                <option value="{{ $value }}" @selected(old('mockup_type', $project->mockup_type) === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('mockup_type')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="icon" value="Ikon Lucide (untuk status Segera Hadir)" />
        <x-text-input id="icon" name="icon" type="text" class="mt-1 block w-full"
                      :value="old('icon', $project->icon)" placeholder="Contoh: building-2" />
        <p class="mt-1 text-xs text-gray-400">Nama ikon dari <a href="https://lucide.dev/icons" target="_blank" class="underline">lucide.dev/icons</a></p>
        <x-input-error :messages="$errors->get('icon')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="sort_order" value="Urutan Tampil" />
        <x-text-input id="sort_order" name="sort_order" type="number" class="mt-1 block w-full"
                      :value="old('sort_order', $project->sort_order ?? 0)" />
        <x-input-error :messages="$errors->get('sort_order')" class="mt-2" />
    </div>

    <div class="flex items-center gap-2 md:col-span-2">
        <input type="hidden" name="featured" value="0">
        <input type="checkbox" id="featured" name="featured" value="1"
               @checked(old('featured', $project->featured))
               class="rounded border-gray-300 text-cyan-600 focus:ring-cyan-500">
        <label for="featured" class="text-sm text-gray-700">Tampilkan di beranda (section Portofolio)</label>
    </div>

    <div class="md:col-span-2">
        <x-input-label for="summary" value="Ringkasan Singkat (untuk kartu)" />
        <textarea id="summary" name="summary" rows="2" required
                  class="mt-1 block w-full border-gray-300 focus:border-cyan-500 focus:ring-cyan-500 rounded-md shadow-sm">{{ old('summary', $project->summary) }}</textarea>
        <x-input-error :messages="$errors->get('summary')" class="mt-2" />
    </div>

    <div class="md:col-span-2">
        <x-input-label for="overview" value="Deskripsi Lengkap (untuk halaman detail, status Tayang)" />
        <textarea id="overview" name="overview" rows="4"
                  class="mt-1 block w-full border-gray-300 focus:border-cyan-500 focus:ring-cyan-500 rounded-md shadow-sm">{{ old('overview', $project->overview) }}</textarea>
        <x-input-error :messages="$errors->get('overview')" class="mt-2" />
    </div>

    <div class="md:col-span-2">
        <x-input-label for="features" value="Fitur Utama (satu per baris, untuk status Tayang)" />
        <textarea id="features" name="features" rows="4"
                  class="mt-1 block w-full border-gray-300 focus:border-cyan-500 focus:ring-cyan-500 rounded-md shadow-sm">{{ $featuresText }}</textarea>
        <x-input-error :messages="$errors->get('features')" class="mt-2" />
    </div>
</div>

<div class="mt-6 flex items-center gap-3">
    <x-primary-button>Simpan</x-primary-button>
    <a href="{{ route('admin.projects.index') }}" class="text-sm text-gray-500 hover:underline">Batal</a>
</div>
