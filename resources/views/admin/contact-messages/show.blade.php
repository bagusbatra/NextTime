<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Pesan</h2>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto space-y-6">

            @if (session('status'))
                <div class="rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white shadow-sm ring-1 ring-gray-200 rounded-xl p-6 space-y-5">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $message->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $message->created_at->format('d M Y, H:i') }} WIB</p>
                    </div>
                    <span @class([
                        'inline-block px-2 py-0.5 rounded-full text-xs font-medium',
                        'bg-cyan-50 text-cyan-700' => $message->status === 'new',
                        'bg-gray-100 text-gray-600' => $message->status === 'read',
                        'bg-emerald-50 text-emerald-700' => $message->status === 'replied',
                    ])>
                        {{ ['new' => 'Baru', 'read' => 'Dibaca', 'replied' => 'Dibalas'][$message->status] }}
                    </span>
                </div>

                <dl class="grid grid-cols-2 gap-4 text-sm border-t border-gray-100 pt-4">
                    <div>
                        <dt class="text-gray-400">Email</dt>
                        <dd class="text-gray-900 mt-0.5"><a href="mailto:{{ $message->email }}" class="hover:underline">{{ $message->email }}</a></dd>
                    </div>
                    <div>
                        <dt class="text-gray-400">Telepon</dt>
                        <dd class="text-gray-900 mt-0.5">{{ $message->phone ?? '—' }}</dd>
                    </div>
                    <div class="col-span-2">
                        <dt class="text-gray-400">Layanan Diminati</dt>
                        <dd class="text-gray-900 mt-0.5">{{ $message->service_interest ?? '—' }}</dd>
                    </div>
                </dl>

                <div class="border-t border-gray-100 pt-4">
                    <dt class="text-gray-400 text-sm mb-1">Pesan</dt>
                    <dd class="text-gray-800 whitespace-pre-line leading-relaxed">{{ $message->message }}</dd>
                </div>

                <div class="border-t border-gray-100 pt-4 flex items-center justify-between">
                    <form method="POST" action="{{ route('admin.contact-messages.status', $message) }}" class="flex items-center gap-2">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="text-sm border-gray-300 rounded-lg focus:border-cyan-500 focus:ring-cyan-500">
                            @foreach (['new' => 'Baru', 'read' => 'Dibaca', 'replied' => 'Dibalas'] as $value => $label)
                                <option value="{{ $value }}" @selected($message->status === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="px-3 py-2 text-sm font-medium bg-gray-900 text-white rounded-lg hover:bg-gray-700 transition">Ubah Status</button>
                    </form>

                    <form action="{{ route('admin.contact-messages.destroy', $message) }}" method="POST"
                          onsubmit="return confirm('Hapus pesan ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-sm text-red-600 hover:underline">Hapus Pesan</button>
                    </form>
                </div>
            </div>

            <a href="{{ route('admin.contact-messages.index') }}" class="text-sm text-gray-500 hover:underline">← Kembali ke daftar pesan</a>
        </div>
    </div>
</x-admin-layout>
