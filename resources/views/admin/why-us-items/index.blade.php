<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kenapa Kami</h2>
                <p class="text-sm text-gray-500 mt-0.5">Kelola alasan unggulan & CTA di section "Kenapa Harus Di NextTime".</p>
            </div>
            <a href="{{ route('admin.why-us-items.create') }}"
               class="inline-flex items-center gap-1.5 px-4 py-2 bg-cyan-600 text-white text-sm font-medium rounded-lg hover:bg-cyan-700 transition">
                <i data-lucide="plus" class="h-4 w-4"></i> Tambah Item
            </a>
        </div>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto space-y-6">

            @if (session('status'))
                <div class="rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Pengaturan gambar & CTA -->
            <div class="bg-white shadow-sm ring-1 ring-gray-200 rounded-xl p-5">
                <h3 class="font-semibold text-gray-900 mb-1">Gambar & Tombol CTA</h3>
                <p class="text-sm text-gray-500 mb-4">Tampil di sisi kanan section "Kenapa Kami" pada halaman utama.</p>
                <form method="POST" action="{{ route('admin.why-us-items.settings') }}" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label value="Gambar Saat Ini" />
                        <div class="mt-1 h-24 w-24 rounded-lg overflow-hidden bg-gray-100 flex items-center justify-center">
                            @if ($cta['image'])
                                <img src="{{ asset('storage/'.$cta['image']) }}" alt="CTA" class="h-full w-full object-cover">
                            @else
                                <i data-lucide="image" class="h-6 w-6 text-gray-300"></i>
                            @endif
                        </div>
                        <input type="file" name="cta_image" accept="image/*" class="mt-2 block w-full text-xs text-gray-500">
                    </div>

                    <div>
                        <x-input-label for="cta_text" value="Teks Tombol" />
                        <x-text-input id="cta_text" name="cta_text" type="text" class="mt-1 block w-full" value="{{ $cta['text'] }}" required />
                    </div>

                    <div>
                        <x-input-label for="cta_link" value="Tautan Tombol" />
                        <x-text-input id="cta_link" name="cta_link" type="text" class="mt-1 block w-full" value="{{ $cta['link'] }}" required />
                    </div>

                    <div class="md:col-span-3">
                        <x-primary-button>Simpan Pengaturan</x-primary-button>
                    </div>
                </form>
            </div>

            <form method="GET" class="bg-white shadow-sm ring-1 ring-gray-200 rounded-xl p-4 flex flex-wrap items-end gap-3">
                <div class="flex-1 min-w-[200px]">
                    <label class="text-xs font-medium text-gray-500">Cari</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul..."
                           class="mt-1 block w-full text-sm border-gray-300 rounded-lg focus:border-cyan-500 focus:ring-cyan-500">
                </div>
                <div class="w-40">
                    <label class="text-xs font-medium text-gray-500">Status</label>
                    <select name="status" class="mt-1 block w-full text-sm border-gray-300 rounded-lg focus:border-cyan-500 focus:ring-cyan-500">
                        <option value="">Semua</option>
                        <option value="active" @selected(request('status') === 'active')>Aktif</option>
                        <option value="inactive" @selected(request('status') === 'inactive')>Nonaktif</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="px-4 py-2 text-sm font-medium bg-gray-900 text-white rounded-lg hover:bg-gray-700 transition">Terapkan</button>
                    @if (request()->hasAny(['search', 'status']))
                        <a href="{{ route('admin.why-us-items.index') }}" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700">Reset</a>
                    @endif
                </div>
            </form>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse ($items as $item)
                    <div class="reveal bg-white shadow-sm ring-1 ring-gray-200 rounded-xl p-5 flex flex-col gap-3">
                        <div class="flex items-start justify-between">
                            <div class="h-10 w-10 rounded-lg bg-cyan-50 text-cyan-600 flex items-center justify-center">
                                <i data-lucide="{{ $item->icon }}" class="h-5 w-5"></i>
                            </div>
                            <x-admin.switch :action="route('admin.why-us-items.toggle', $item)" :on="$item->is_active" label="Aktifkan/nonaktifkan item" />
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">{{ $item->title }}</h3>
                            <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $item->description }}</p>
                        </div>
                        <div class="mt-auto pt-2 flex items-center justify-between text-sm border-t border-gray-100">
                            <span class="text-gray-400">Urutan: {{ $item->sort_order }}</span>
                            <div class="space-x-3">
                                <a href="{{ route('admin.why-us-items.edit', $item) }}" class="text-cyan-600 hover:underline">Edit</a>
                                <form action="{{ route('admin.why-us-items.destroy', $item) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Hapus item ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white shadow-sm ring-1 ring-gray-200 rounded-xl px-6 py-10 text-center text-gray-400">
                        Belum ada item. <a href="{{ route('admin.why-us-items.create') }}" class="text-cyan-600 hover:underline">Tambah item pertama</a>.
                    </div>
                @endforelse
            </div>

            @if ($items->hasPages())
                <div>{{ $items->links() }}</div>
            @endif

        </div>
    </div>
</x-admin-layout>
