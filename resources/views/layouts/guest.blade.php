<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ isset($title) ? $title.' — ' : '' }}{{ config('app.name', 'NextTime') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <link rel="icon" href="{{ asset('assets/default-logo.png') }}" type="image/x-icon" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex">

            <!-- Panel brand (desktop only) -->
            <div class="hidden lg:flex lg:w-1/2 relative bg-gray-900 text-white flex-col justify-between p-12 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-cyan-600/30 via-gray-900 to-gray-900"></div>
                <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-cyan-500/20 blur-3xl"></div>
                <div class="absolute -bottom-24 -left-24 w-96 h-96 rounded-full bg-cyan-500/10 blur-3xl"></div>

                <a href="{{ route('home') }}" class="relative flex items-center gap-3">
                    <img src="{{ asset('assets/white-logo.png') }}" alt="NextTime" class="h-9 w-9">
                    <span class="text-xl font-semibold tracking-tight">Next<span class="text-cyan-400">Time</span></span>
                </a>

                <div class="relative max-w-md">
                    <h1 class="text-3xl font-semibold leading-tight mb-4">
                        Kelola konten situs Anda dengan mudah.
                    </h1>
                    <p class="text-gray-300 leading-relaxed">
                        Panel admin NextTime untuk mengatur setiap bagian halaman utama — dari hero, layanan,
                        portofolio, hingga pesan masuk pelanggan — dalam satu tempat.
                    </p>
                </div>

                <p class="relative text-sm text-gray-400">© {{ date('Y') }} NextTime. Semua hak dilindungi.</p>
            </div>

            <!-- Panel form -->
            <div class="flex-1 flex flex-col items-center justify-center px-6 py-12 bg-gray-50">
                <div class="w-full sm:max-w-md">

                    <a href="{{ route('home') }}" class="lg:hidden flex items-center justify-center gap-2 mb-8">
                        <img src="{{ asset('assets/default-logo.png') }}" alt="NextTime" class="h-8 w-8">
                        <span class="text-lg font-semibold text-gray-900">Next<span class="text-cyan-600">Time</span></span>
                    </a>

                    <div class="bg-white shadow-sm ring-1 ring-gray-200 rounded-2xl px-6 py-8 sm:px-10">
                        {{ $slot }}
                    </div>

                    <p class="mt-6 text-center text-xs text-gray-400">
                        <a href="{{ route('home') }}" class="hover:text-gray-600 transition">← Kembali ke situs utama</a>
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>
