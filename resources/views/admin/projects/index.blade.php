<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Kelola Proyek
            </h2>
            <a href="{{ route('admin.projects.create') }}"
               class="inline-flex items-center px-4 py-2 bg-cyan-600 text-white text-sm font-medium rounded-md hover:bg-cyan-700">
                + Tambah Proyek
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
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
                            <tr>
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
                                <td class="px-6 py-3 text-gray-500">{{ $project->featured ? 'Ya' : '—' }}</td>
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
                                <td colspan="5" class="px-6 py-6 text-center text-gray-400">Belum ada proyek.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
