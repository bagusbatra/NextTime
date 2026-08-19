<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title.' — ' : '' }}{{ config('app.name', 'NextTime') }} Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900" x-data="{ sidebarOpen: false }">

    <div class="min-h-screen flex">

        <!-- Sidebar backdrop (mobile) -->
        <div x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen = false"
             class="fixed inset-0 z-30 bg-gray-900/50 lg:hidden" style="display: none;"></div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
               class="fixed inset-y-0 left-0 z-40 w-64 bg-gray-900 text-gray-300 flex flex-col transition-transform duration-200 ease-in-out lg:static lg:translate-x-0">

            <div class="h-16 flex items-center gap-2 px-6 shrink-0 border-b border-gray-800">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                    <x-application-logo class="h-7 w-7 fill-current text-cyan-400" />
                    <span class="font-semibold text-white tracking-tight">{{ config('app.name', 'NextTime') }}</span>
                </a>
            </div>

            <nav class="flex-1 overflow-y-auto py-6 px-3 space-y-6">
                @php
                    $menuGroups = [
                        'Menu' => [
                            ['icon' => 'layout-dashboard', 'label' => 'Dashboard', 'route' => 'admin.dashboard', 'active' => 'admin.dashboard'],
                        ],
                        'Konten Halaman Utama' => [
                            ['icon' => 'gallery-horizontal', 'label' => 'Hero / Slider', 'route' => 'admin.hero-slides.index', 'active' => 'admin.hero-slides.*'],
                            ['icon' => 'sparkles', 'label' => 'Layanan', 'route' => 'admin.services.index', 'active' => 'admin.services.*'],
                            ['icon' => 'tags', 'label' => 'Paket Harga', 'route' => 'admin.pricing-packages.index', 'active' => 'admin.pricing-packages.*'],
                            ['icon' => 'heart-handshake', 'label' => 'Kenapa Kami', 'route' => 'admin.why-us-items.index', 'active' => 'admin.why-us-items.*'],
                            ['icon' => 'briefcase', 'label' => 'Portofolio', 'route' => 'admin.projects.index', 'active' => 'admin.projects.*'],
                            ['icon' => 'building-2', 'label' => 'Klien & Partner', 'route' => 'admin.clients.index', 'active' => 'admin.clients.*'],
                            ['icon' => 'image', 'label' => 'Galeri', 'route' => 'admin.gallery-items.index', 'active' => 'admin.gallery-items.*'],
                        ],
                        'Kontak' => [
                            ['icon' => 'contact', 'label' => 'Info Kontak', 'route' => 'admin.contact-settings.edit', 'active' => 'admin.contact-settings.*'],
                            ['icon' => 'mail', 'label' => 'Pesan Masuk', 'route' => 'admin.contact-messages.index', 'active' => 'admin.contact-messages.*'],
                        ],
                        'Pengaturan' => [
                            ['icon' => 'message-circle', 'label' => 'Widget WhatsApp', 'route' => 'admin.wa-widget-settings.edit', 'active' => 'admin.wa-widget-settings.*'],
                            ['icon' => 'settings', 'label' => 'Pengaturan Situs', 'route' => 'admin.settings.edit', 'active' => 'admin.settings.*'],
                            ['icon' => 'users', 'label' => 'Pengguna', 'route' => 'admin.users.index', 'active' => 'admin.users.*'],
                        ],
                    ];
                @endphp

                @foreach ($menuGroups as $groupLabel => $items)
                    <div class="space-y-1">
                        <p class="px-3 mb-2 text-xs font-semibold uppercase tracking-wider text-gray-500">{{ $groupLabel }}</p>

                        @foreach ($items as $item)
                            @php $isActive = request()->routeIs($item['active']); @endphp
                            <a href="{{ route($item['route']) }}"
                               @class([
                                   'flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition',
                                   'bg-cyan-600 text-white' => $isActive,
                                   'text-gray-300 hover:bg-gray-800 hover:text-white' => ! $isActive,
                               ])>
                                <i data-lucide="{{ $item['icon'] }}" class="h-4 w-4 shrink-0"></i>
                                {{ $item['label'] }}
                            </a>
                        @endforeach
                    </div>
                @endforeach
            </nav>

            <div class="p-3 border-t border-gray-800">
                <a href="{{ route('home') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium text-gray-300 hover:bg-gray-800 hover:text-white transition">
                    <i data-lucide="external-link" class="h-4 w-4 shrink-0"></i>
                    Lihat Situs
                </a>
            </div>
        </aside>

        <!-- Main column -->
        <div class="flex-1 flex flex-col min-w-0">

            <!-- Topbar -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between gap-4 px-4 sm:px-6 shrink-0">
                <div class="flex items-center gap-4 min-w-0">
                    <button @click="sidebarOpen = true" class="text-gray-500 hover:text-gray-700 lg:hidden">
                        <i data-lucide="menu" class="h-6 w-6"></i>
                    </button>

                    @isset($header)
                        <div class="min-w-0">{{ $header }}</div>
                    @endisset
                </div>

                <div class="flex items-center gap-3 shrink-0">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-2 px-2 py-1.5 rounded-md hover:bg-gray-100 transition">
                                <span class="h-8 w-8 rounded-full bg-cyan-600 text-white flex items-center justify-center text-sm font-semibold">
                                    {{ mb_strtoupper(mb_substr(Auth::user()->name, 0, 1)) }}
                                </span>
                                <span class="hidden sm:block text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
                                <i data-lucide="chevron-down" class="h-4 w-4 text-gray-400"></i>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto">
                {{ $slot }}
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => lucide.createIcons());
        document.addEventListener('livewire:navigated', () => lucide.createIcons());
    </script>
</body>
</html>
