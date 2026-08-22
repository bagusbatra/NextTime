<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto space-y-6">

            @if (session('status'))
                <div class="rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            @if ($newMessagesCount > 0)
                <a href="{{ route('admin.contact-messages.index', ['status' => 'new']) }}"
                   class="flex items-center justify-between bg-cyan-600 text-white rounded-lg px-5 py-4 shadow-sm hover:bg-cyan-700 transition">
                    <span class="flex items-center gap-2 font-medium">
                        <i data-lucide="mail" class="h-5 w-5"></i>
                        {{ $newMessagesCount }} pesan baru belum dibaca
                    </span>
                    <span class="text-sm">Lihat Pesan Masuk →</span>
                </a>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
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
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-5">
                    <p class="text-sm text-gray-500">Total Pengguna</p>
                    <p class="mt-1 text-3xl font-bold text-gray-900">{{ $stats['users'] }}</p>
                </div>
            </div>

            <div>
                <h3 class="font-semibold text-gray-800 mb-3">Konten Halaman Utama</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                    @foreach ($content as $item)
                        <a href="{{ route($item['route']) }}" class="bg-white shadow-sm rounded-lg p-4 hover:shadow-md transition">
                            <div class="h-8 w-8 rounded-lg bg-cyan-50 text-cyan-600 flex items-center justify-center mb-2">
                                <i data-lucide="{{ $item['icon'] }}" class="h-4 w-4"></i>
                            </div>
                            <p class="text-xl font-bold text-gray-900">{{ $item['count'] }}</p>
                            <p class="text-xs text-gray-500">{{ $item['label'] }}</p>
                        </a>
                    @endforeach
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

            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-800">Pengguna Terbaru</h3>
                    <a href="{{ route('admin.users.index') }}" class="text-sm text-cyan-600 hover:underline">Lihat semua →</a>
                </div>
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-500 text-left">
                        <tr>
                            <th class="px-6 py-3 font-medium">Nama</th>
                            <th class="px-6 py-3 font-medium">Email</th>
                            <th class="px-6 py-3 font-medium">Bergabung</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($recentUsers as $user)
                            <tr>
                                <td class="px-6 py-3 text-gray-900">{{ $user->name }}</td>
                                <td class="px-6 py-3 text-gray-500">{{ $user->email }}</td>
                                <td class="px-6 py-3 text-gray-500">{{ $user->created_at->translatedFormat('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-6 text-center text-gray-400">Belum ada pengguna.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-admin-layout>
