<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Portofolio</h2>
                <p class="text-sm text-gray-500 mt-0.5">Kelola proyek/mockup yang tampil di section "Portofolio" & halaman /projects.</p>
            </div>
            <a href="{{ route('admin.projects.create') }}"
               class="inline-flex items-center gap-1.5 px-4 py-2 bg-cyan-600 text-white text-sm font-medium rounded-lg hover:bg-cyan-700 transition">
                <i data-lucide="plus" class="h-4 w-4"></i> Tambah Proyek
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
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul proyek..."
                           class="mt-1 block w-full text-sm border-gray-300 rounded-lg focus:border-cyan-500 focus:ring-cyan-500">
                </div>
                <div class="w-44">
                    <label class="text-xs font-medium text-gray-500">Kategori</label>
                    <select name="category" class="mt-1 block w-full text-sm border-gray-300 rounded-lg focus:border-cyan-500 focus:ring-cyan-500">
                        <option value="">Semua</option>
                        @foreach (['umkm' => 'UMKM', 'company-profile' => 'Company Profile', 'landing-page' => 'Landing Page'] as $value => $label)
                            <option value="{{ $value }}" @selected(request('category') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-36">
                    <label class="text-xs font-medium text-gray-500">Status</label>
                    <select name="status" class="mt-1 block w-full text-sm border-gray-300 rounded-lg focus:border-cyan-500 focus:ring-cyan-500">
                        <option value="">Semua</option>
                        <option value="available" @selected(request('status') === 'available')>Tayang</option>
                        <option value="soon" @selected(request('status') === 'soon')>Segera Hadir</option>
                    </select>
                </div>
                <div class="w-36">
                    <label class="text-xs font-medium text-gray-500">Beranda</label>
                    <select name="featured" class="mt-1 block w-full text-sm border-gray-300 rounded-lg focus:border-cyan-500 focus:ring-cyan-500">
                        <option value="">Semua</option>
                        <option value="yes" @selected(request('featured') === 'yes')>Featured</option>
                        <option value="no" @selected(request('featured') === 'no')>Tidak</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="px-4 py-2 text-sm font-medium bg-gray-900 text-white rounded-lg hover:bg-gray-700 transition">Terapkan</button>
                    @if (request()->hasAny(['search', 'category', 'status', 'featured']))
                        <a href="{{ route('admin.projects.index') }}" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700">Reset</a>
                    @endif
                </div>
            </form>

            <div class="bg-white shadow-sm ring-1 ring-gray-200 rounded-xl overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-500 text-left">
                        <tr>
                            <th class="px-6 py-3 font-medium">Judul</th>
                            <th class="px-6 py-3 font-medium">Kategori</th>
                            <th class="px-6 py-3 font-medium">Status</th>
                            <th class="px-6 py-3 font-medium">Beranda</th>
                            <th class="px-6 py-3 font-medium text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($projects as $project)
                            <tr class="reveal hover:bg-gray-50/60 transition-colors">
                                <td class="px-6 py-3 text-gray-900">
                                    {{ $project->title }}
                                    <div class="text-xs text-gray-400">/{{ $project->slug }}</div>
                                </td>
                                <td class="px-6 py-3 text-gray-500">{{ $project->category }}</td>
                                <td class="px-6 py-3">
                                    <span @class([
                                        'inline-block px-2 py-0.5 rounded-full text-xs font-medium',
                                        'bg-cyan-50 text-cyan-700' => $project->status === 'available',
                                        'bg-amber-50 text-amber-700' => $project->status === 'soon',
                                    ])>
                                        {{ $project->status === 'available' ? 'Tayang' : 'Segera Hadir' }}
                                    </span>
                                </td>
                                <td class="px-6 py-3">
                                    <x-admin.switch :action="route('admin.projects.toggle-featured', $project)" :on="$project->featured" label="Tampilkan/sembunyikan di beranda" />
                                </td>
                                <td class="px-6 py-3 text-right space-x-3">
                                    <a href="{{ route('admin.projects.edit', $project) }}" class="text-cyan-600 hover:underline">Edit</a>
                                    <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Hapus proyek ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-400">
                                    Tidak ada proyek yang cocok dengan filter. <a href="{{ route('admin.projects.index') }}" class="text-cyan-600 hover:underline">Reset filter</a>.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($projects->hasPages())
                <div>{{ $projects->links() }}</div>
            @endif

        </div>
    </div>
</x-admin-layout>
