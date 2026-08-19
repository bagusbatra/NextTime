<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Layanan</h2>
                <p class="text-sm text-gray-500 mt-0.5">Kelola grid layanan yang tampil di section "Layanan Kami".</p>
            </div>
            <a href="{{ route('admin.services.create') }}"
               class="inline-flex items-center gap-1.5 px-4 py-2 bg-cyan-600 text-white text-sm font-medium rounded-lg hover:bg-cyan-700 transition">
                <i data-lucide="plus" class="h-4 w-4"></i> Tambah Layanan
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
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul layanan..."
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
                        <a href="{{ route('admin.services.index') }}" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700">Reset</a>
                    @endif
                </div>
            </form>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse ($services as $service)
                    <div class="reveal bg-white shadow-sm ring-1 ring-gray-200 rounded-xl p-5 flex flex-col gap-3">
                        <div class="flex items-start justify-between">
                            <div class="h-10 w-10 rounded-lg bg-cyan-50 text-cyan-600 flex items-center justify-center">
                                <i data-lucide="{{ $service->icon }}" class="h-5 w-5"></i>
                            </div>
                            <x-admin.switch :action="route('admin.services.toggle', $service)" :on="$service->is_active" label="Aktifkan/nonaktifkan layanan" />
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">{{ $service->title }}</h3>
                            <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $service->description }}</p>
                        </div>
                        <div class="mt-auto pt-2 flex items-center justify-between text-sm border-t border-gray-100">
                            <span class="text-gray-400">Urutan: {{ $service->sort_order }}</span>
                            <div class="space-x-3">
                                <a href="{{ route('admin.services.edit', $service) }}" class="text-cyan-600 hover:underline">Edit</a>
                                <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Hapus layanan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white shadow-sm ring-1 ring-gray-200 rounded-xl px-6 py-10 text-center text-gray-400">
                        Belum ada layanan. <a href="{{ route('admin.services.create') }}" class="text-cyan-600 hover:underline">Tambah layanan pertama</a>.
                    </div>
                @endforelse
            </div>

            @if ($services->hasPages())
                <div>{{ $services->links() }}</div>
            @endif

        </div>
    </div>
</x-admin-layout>
