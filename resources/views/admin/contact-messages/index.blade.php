<x-admin-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pesan Masuk</h2>
            <p class="text-sm text-gray-500 mt-0.5">Pesan dari formulir kontak di halaman utama.</p>
        </div>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto space-y-6">

            @if (session('status'))
                <div class="rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <div class="grid grid-cols-3 gap-4">
                <div class="bg-white shadow-sm ring-1 ring-gray-200 rounded-xl p-4">
                    <p class="text-xs text-gray-500">Baru</p>
                    <p class="text-2xl font-semibold text-cyan-600 mt-1">{{ $counts['new'] }}</p>
                </div>
                <div class="bg-white shadow-sm ring-1 ring-gray-200 rounded-xl p-4">
                    <p class="text-xs text-gray-500">Dibaca</p>
                    <p class="text-2xl font-semibold text-gray-700 mt-1">{{ $counts['read'] }}</p>
                </div>
                <div class="bg-white shadow-sm ring-1 ring-gray-200 rounded-xl p-4">
                    <p class="text-xs text-gray-500">Dibalas</p>
                    <p class="text-2xl font-semibold text-emerald-600 mt-1">{{ $counts['replied'] }}</p>
                </div>
            </div>

            <form method="GET" class="bg-white shadow-sm ring-1 ring-gray-200 rounded-xl p-4 flex flex-wrap items-end gap-3">
                <div class="flex-1 min-w-[200px]">
                    <label class="text-xs font-medium text-gray-500">Cari</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..."
                           class="mt-1 block w-full text-sm border-gray-300 rounded-lg focus:border-cyan-500 focus:ring-cyan-500">
                </div>
                <div class="w-40">
                    <label class="text-xs font-medium text-gray-500">Status</label>
                    <select name="status" class="mt-1 block w-full text-sm border-gray-300 rounded-lg focus:border-cyan-500 focus:ring-cyan-500">
                        <option value="">Semua</option>
                        <option value="new" @selected(request('status') === 'new')>Baru</option>
                        <option value="read" @selected(request('status') === 'read')>Dibaca</option>
                        <option value="replied" @selected(request('status') === 'replied')>Dibalas</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="px-4 py-2 text-sm font-medium bg-gray-900 text-white rounded-lg hover:bg-gray-700 transition">Terapkan</button>
                    @if (request()->hasAny(['search', 'status']))
                        <a href="{{ route('admin.contact-messages.index') }}" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700">Reset</a>
                    @endif
                </div>
            </form>

            <div class="bg-white shadow-sm ring-1 ring-gray-200 rounded-xl overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-500 text-left">
                        <tr>
                            <th class="px-6 py-3 font-medium">Pengirim</th>
                            <th class="px-6 py-3 font-medium">Layanan</th>
                            <th class="px-6 py-3 font-medium">Status</th>
                            <th class="px-6 py-3 font-medium">Tanggal</th>
                            <th class="px-6 py-3 font-medium text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($messages as $message)
                            <tr class="reveal hover:bg-gray-50/60 transition-colors">
                                <td class="px-6 py-3">
                                    <div class="text-gray-900 font-medium">{{ $message->name }}</div>
                                    <div class="text-xs text-gray-400">{{ $message->email }}</div>
                                </td>
                                <td class="px-6 py-3 text-gray-500">{{ $message->service_interest ?? '—' }}</td>
                                <td class="px-6 py-3">
                                    <span @class([
                                        'inline-block px-2 py-0.5 rounded-full text-xs font-medium',
                                        'bg-cyan-50 text-cyan-700' => $message->status === 'new',
                                        'bg-gray-100 text-gray-600' => $message->status === 'read',
                                        'bg-emerald-50 text-emerald-700' => $message->status === 'replied',
                                    ])>
                                        {{ ['new' => 'Baru', 'read' => 'Dibaca', 'replied' => 'Dibalas'][$message->status] }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-gray-400">{{ $message->created_at->format('d M Y, H:i') }}</td>
                                <td class="px-6 py-3 text-right space-x-3">
                                    <a href="{{ route('admin.contact-messages.show', $message) }}" class="text-cyan-600 hover:underline">Lihat</a>
                                    <form action="{{ route('admin.contact-messages.destroy', $message) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Hapus pesan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-400">Belum ada pesan masuk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($messages->hasPages())
                <div>{{ $messages->links() }}</div>
            @endif

        </div>
    </div>
</x-admin-layout>
