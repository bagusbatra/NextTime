<x-admin-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Info Kontak</h2>
            <p class="text-sm text-gray-500 mt-0.5">Data yang tampil di section "Kontak" halaman utama.</p>
        </div>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto space-y-6">

            @if (session('status'))
                <div class="rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white shadow-sm ring-1 ring-gray-200 rounded-xl p-6">
                <form method="POST" action="{{ route('admin.contact-settings.update') }}" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="address" value="Alamat" />
                        <x-text-input id="address" name="address" type="text" class="mt-1 block w-full"
                                      :value="old('address', $contact['address'])" required autofocus />
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="phone" value="Telepon" />
                        <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full"
                                      :value="old('phone', $contact['phone'])" required />
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="email" value="Email" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                                      :value="old('email', $contact['email'])" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="work_hours" value="Jam Kerja" />
                        <x-text-input id="work_hours" name="work_hours" type="text" class="mt-1 block w-full"
                                      :value="old('work_hours', $contact['work_hours'])" required />
                        <x-input-error :messages="$errors->get('work_hours')" class="mt-2" />
                    </div>

                    <x-primary-button>Simpan</x-primary-button>
                </form>
            </div>

        </div>
    </div>
</x-admin-layout>
