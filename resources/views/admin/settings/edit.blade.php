<x-admin-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pengaturan Situs</h2>
            <p class="text-sm text-gray-500 mt-0.5">Branding, footer, dan kontrol tampilan section halaman utama.</p>
        </div>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto space-y-6">

            @if (session('status'))
                <div class="rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Branding -->
            <div class="bg-white shadow-sm ring-1 ring-gray-200 rounded-xl p-6">
                <h3 class="font-semibold text-gray-900 mb-1">Branding & Footer</h3>
                <p class="text-sm text-gray-500 mb-4">Logo, nama situs, dan deskripsi footer.</p>

                <form method="POST" action="{{ route('admin.settings.branding') }}" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="site_name" value="Nama Situs" />
                        <x-text-input id="site_name" name="site_name" type="text" class="mt-1 block w-full"
                                      :value="old('site_name', $site['site_name'])" required />
                        <x-input-error :messages="$errors->get('site_name')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-input-label value="Logo Terang (untuk latar gelap)" />
                            <div class="mt-1 h-16 w-16 rounded-lg bg-gray-900 flex items-center justify-center overflow-hidden">
                                <img src="{{ $site['logo_dark'] ? asset('storage/'.$site['logo_dark']) : asset('assets/white-logo.png') }}" alt="Logo" class="h-10 w-10 object-contain">
                            </div>
                            <input type="file" name="logo_dark" accept="image/*" class="mt-2 block w-full text-xs text-gray-500">
                            <x-input-error :messages="$errors->get('logo_dark')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label value="Logo Gelap (untuk latar terang)" />
                            <div class="mt-1 h-16 w-16 rounded-lg bg-gray-100 flex items-center justify-center overflow-hidden">
                                <img src="{{ $site['logo_light'] ? asset('storage/'.$site['logo_light']) : asset('assets/default-logo.png') }}" alt="Logo" class="h-10 w-10 object-contain">
                            </div>
                            <input type="file" name="logo_light" accept="image/*" class="mt-2 block w-full text-xs text-gray-500">
                            <x-input-error :messages="$errors->get('logo_light')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="footer_description" value="Deskripsi Footer" />
                        <textarea id="footer_description" name="footer_description" rows="3" required
                                  class="mt-1 block w-full border-gray-300 focus:border-cyan-500 focus:ring-cyan-500 rounded-md shadow-sm">{{ old('footer_description', $site['footer_description']) }}</textarea>
                        <x-input-error :messages="$errors->get('footer_description')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="social_instagram" value="Instagram" />
                            <x-text-input id="social_instagram" name="social_instagram" type="text" class="mt-1 block w-full"
                                          :value="old('social_instagram', $site['social_instagram'])" placeholder="https://instagram.com/..." />
                            <x-input-error :messages="$errors->get('social_instagram')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="social_github" value="GitHub" />
                            <x-text-input id="social_github" name="social_github" type="text" class="mt-1 block w-full"
                                          :value="old('social_github', $site['social_github'])" placeholder="https://github.com/..." />
                            <x-input-error :messages="$errors->get('social_github')" class="mt-2" />
                        </div>
                    </div>

                    <x-primary-button>Simpan Branding</x-primary-button>
                </form>
            </div>

            <!-- Tampilan Section -->
            <div class="bg-white shadow-sm ring-1 ring-gray-200 rounded-xl p-6">
                <h3 class="font-semibold text-gray-900 mb-1">Tampilan Section Halaman Utama</h3>
                <p class="text-sm text-gray-500 mb-4">Aktifkan atau sembunyikan section tertentu di halaman publik tanpa menghapus datanya.</p>

                <form method="POST" action="{{ route('admin.settings.sections') }}" class="space-y-1">
                    @csrf
                    @method('PUT')

                    @foreach ($sectionLabels as $key => $label)
                        <div class="flex items-center justify-between py-2.5 {{ ! $loop->last ? 'border-b border-gray-100' : '' }}">
                            <span class="text-sm text-gray-700">{{ $label }}</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="{{ $key }}" value="1" class="sr-only peer"
                                       @checked($sections[$key] ?? true)>
                                <div class="w-11 h-6 bg-gray-300 rounded-full peer peer-checked:bg-cyan-600 transition-colors"></div>
                                <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full shadow transition-transform peer-checked:translate-x-5"></div>
                            </label>
                        </div>
                    @endforeach

                    <div class="pt-4">
                        <x-primary-button>Simpan Tampilan Section</x-primary-button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-admin-layout>
