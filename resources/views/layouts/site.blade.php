<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'NextTime')</title>
  <meta name="description" content="@yield('meta_description', 'NextTime — tim kreatif yang membangun website modern untuk pertumbuhan bisnis Anda.')" />
  <link rel="icon" href="{{ asset('assets/default-logo.png') }}" type="image/x-icon" />
  @vite(['resources/css/site.css', 'resources/js/site.js'])
</head>
<body>

@include('partials.site.nav')

@yield('content')

@include('partials.site.footer')
@include('partials.site.wa-widget')

<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
</body>
</html>
