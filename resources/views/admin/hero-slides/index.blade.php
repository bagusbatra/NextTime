<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Hero / Slider</h2>
                <p class="text-sm text-gray-500 mt-0.5">Kelola slide yang tampil di bagian paling atas halaman utama.</p>
            </div>
            <a href="{{ route('admin.hero-slides.create') }}"
               class="inline-flex items-center gap-1.5 px-4 py-2 bg-cyan-600 text-white text-sm font-medium rounded-lg hover:bg-cyan-700 transition">
                <i data-lucide="plus" class="h-4 w-4"></i> Tambah Slide
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

            <form method="GET" class="bg-white shadow-sm ring-1 ring-gray-200 rounded-xl p-4 flex flex-wrap items-end gap-3">
                <div class="flex-1 min-w-[200px]">
                    <label class="text-xs font-medium text-gray-500">Cari</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul atau badge..."
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
                        <a href="{{ route('admin.hero-slides.index') }}" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700">Reset</a>
                    @endif
                </div>
            </form>

            <div class="bg-white shadow-sm ring-1 ring-gray-200 rounded-xl overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-500 text-left">
                        <tr>
                            <th class="px-6 py-3 font-medium">Urutan</th>
                            <th class="px-6 py-3 font-medium">Badge & Judul</th>
                            <th class="px-6 py-3 font-medium">CTA</th>
                            <th class="px-6 py-3 font-medium">Aktif</th>
                            <th class="px-6 py-3 font-medium text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($slides as $slide)
                            <tr class="reveal hover:bg-gray-50/60 transition-colors">
                                <td class="px-6 py-3 text-gray-400">{{ $slide->sort_order }}</td>
                                <td class="px-6 py-3">
                                    <span class="inline-block text-xs font-medium text-cyan-700 bg-cyan-50 px-2 py-0.5 rounded-full mb-1">{{ $slide->badge }}</span>
                                    <div class="text-gray-900 font-medium">
                                        {{ $slide->title }}
                                        @if ($slide->title_highlight)
                                            <span class="text-cyan-600">{{ $slide->title_highlight }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-3 text-gray-500">
                                    {{ $slide->primary_cta_text }}
                                    @if ($slide->secondary_cta_text)
                                        <span class="text-gray-300">·</span> {{ $slide->secondary_cta_text }}
                                    @endif
                                </td>
                                <td class="px-6 py-3">
                                    <x-admin.switch :action="route('admin.hero-slides.toggle', $slide)" :on="$slide->is_active" label="Aktifkan/nonaktifkan slide" />
                                </td>
                                <td class="px-6 py-3 text-right space-x-3">
                                    <a href="{{ route('admin.hero-slides.edit', $slide) }}" class="text-cyan-600 hover:underline">Edit</a>
                                    <form action="{{ route('admin.hero-slides.destroy', $slide) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Hapus slide ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-400">
                                    Belum ada slide hero. <a href="{{ route('admin.hero-slides.create') }}" class="text-cyan-600 hover:underline">Tambah slide pertama</a>.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($slides->hasPages())
                <div>{{ $slides->links() }}</div>
            @endif

        </div>
    </div>
</x-admin-layout>
