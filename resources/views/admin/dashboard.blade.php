<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Admin
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-5">
                    <p class="text-sm text-gray-500">Total Proyek</p>
                    <p class="mt-1 text-3xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-5">
                    <p class="text-sm text-gray-500">Tayang (Available)</p>
                    <p class="mt-1 text-3xl font-bold text-cyan-600">{{ $stats['available'] }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-5">
                    <p class="text-sm text-gray-500">Segera Hadir</p>
                    <p class="mt-1 text-3xl font-bold text-amber-600">{{ $stats['soon'] }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-5">
                    <p class="text-sm text-gray-500">Ditampilkan di Beranda</p>
                    <p class="mt-1 text-3xl font-bold text-gray-900">{{ $stats['featured'] }}</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-800">Proyek Terbaru</h3>
                    <a href="{{ route('admin.projects.index') }}" class="text-sm text-cyan-600 hover:underline">Lihat semua →</a>
                </div>
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-500 text-left">
                        <tr>
                            <th class="px-6 py-3 font-medium">Judul</th>
                            <th class="px-6 py-3 font-medium">Kategori</th>
                            <th class="px-6 py-3 font-medium">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($recentProjects as $project)
                            <tr>
                                <td class="px-6 py-3 text-gray-900">{{ $project->title }}</td>
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
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-6 text-center text-gray-400">Belum ada proyek.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
