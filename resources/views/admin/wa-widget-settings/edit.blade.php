<x-admin-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Widget WhatsApp</h2>
            <p class="text-sm text-gray-500 mt-0.5">Tombol WA melayang & modal promo yang tampil di semua halaman.</p>
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
                <form method="POST" action="{{ route('admin.wa-widget-settings.update') }}" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="phone" value="Nomor WhatsApp (format 62xxx, tanpa +/spasi)" />
                        <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full"
                                      :value="old('phone', $wa['phone'])" required autofocus placeholder="6288228272679" />
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="default_message" value="Pesan Default (saat tombol promo diklik)" />
                        <textarea id="default_message" name="default_message" rows="3" required
                                  class="mt-1 block w-full border-gray-300 focus:border-cyan-500 focus:ring-cyan-500 rounded-md shadow-sm">{{ old('default_message', $wa['default_message']) }}</textarea>
                        <x-input-error :messages="$errors->get('default_message')" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-2">
                        <input type="hidden" name="promo_enabled" value="0">
                        <input type="checkbox" id="promo_enabled" name="promo_enabled" value="1"
                               @checked(old('promo_enabled', $wa['promo_enabled']))
                               class="rounded border-gray-300 text-cyan-600 focus:ring-cyan-500">
                        <label for="promo_enabled" class="text-sm text-gray-700">Tampilkan modal promo otomatis</label>
                    </div>

                    <div>
                        <x-input-label for="promo_tag" value="Label Promo" />
                        <x-text-input id="promo_tag" name="promo_tag" type="text" class="mt-1 block w-full"
                                      :value="old('promo_tag', $wa['promo_tag'])" required placeholder="🔥 Promo Bulan Ini" />
                        <x-input-error :messages="$errors->get('promo_tag')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="promo_title" value="Judul Promo" />
                        <x-text-input id="promo_title" name="promo_title" type="text" class="mt-1 block w-full"
                                      :value="old('promo_title', $wa['promo_title'])" required />
                        <x-input-error :messages="$errors->get('promo_title')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="promo_message" value="Isi Promo" />
                        <textarea id="promo_message" name="promo_message" rows="3" required
                                  class="mt-1 block w-full border-gray-300 focus:border-cyan-500 focus:ring-cyan-500 rounded-md shadow-sm">{{ old('promo_message', $wa['promo_message']) }}</textarea>
                        <x-input-error :messages="$errors->get('promo_message')" class="mt-2" />
                    </div>

                    <x-primary-button>Simpan</x-primary-button>
                </form>
            </div>

        </div>
    </div>
</x-admin-layout>
