@extends('layouts.site')

@section('title', 'NextTime')

@section('content')
  @if ($sections['hero'] ?? true)
    @include('partials.site.hero', ['heroSlides' => $heroSlides])
  @endif

  @if (($sections['layanan'] ?? true) || ($sections['paket_harga'] ?? true))
    @include('partials.site.layanan', [
      'services' => $services,
      'pricingPackages' => $pricingPackages,
      'showLayanan' => $sections['layanan'] ?? true,
      'showPaketHarga' => $sections['paket_harga'] ?? true,
    ])
  @endif

  @if ($sections['kenapa'] ?? true)
    @include('partials.site.kenapa', ['whyUsItems' => $whyUsItems, 'whyUsCta' => $whyUsCta])
  @endif

  @if ($sections['portofolio'] ?? true)
    @include('partials.site.portofolio', ['featuredProjects' => $featuredProjects])
  @endif

  @if ($sections['klien'] ?? true)
    @include('partials.site.klien', ['clients' => $clients])
  @endif

  @if ($sections['galeri'] ?? true)
    @include('partials.site.galeri', ['galleryItems' => $galleryItems])
  @endif

  @if ($sections['kontak'] ?? true)
    @include('partials.site.kontak', ['contactInfo' => $contactInfo])
  @endif
@endsection
