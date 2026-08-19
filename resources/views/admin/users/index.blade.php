<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pengguna
        </h2>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto space-y-6">

            @if (session('status'))
                <div class="rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-500 text-left">
                        <tr>
                            <th class="px-6 py-3 font-medium">Nama</th>
                            <th class="px-6 py-3 font-medium">Email</th>
                            <th class="px-6 py-3 font-medium">Status</th>
                            <th class="px-6 py-3 font-medium">Bergabung</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($users as $user)
                            <tr>
                                <td class="px-6 py-3 text-gray-900 flex items-center gap-3">
                                    <span class="h-8 w-8 rounded-full bg-cyan-600 text-white flex items-center justify-center text-xs font-semibold shrink-0">
                                        {{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}
                                    </span>
                                    {{ $user->name }}
                                </td>
                                <td class="px-6 py-3 text-gray-500">{{ $user->email }}</td>
                                <td class="px-6 py-3">
                                    @if ($user->email_verified_at)
                                        <span class="inline-block px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">Terverifikasi</span>
                                    @else
                                        <span class="inline-block px-2 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700">Belum Verifikasi</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3 text-gray-500">{{ $user->created_at->translatedFormat('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-6 text-center text-gray-400">Belum ada pengguna.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($users->hasPages())
                <div>
                    {{ $users->links() }}
                </div>
            @endif

        </div>
    </div>
</x-admin-layout>
