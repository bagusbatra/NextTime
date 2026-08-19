@extends('layouts.site')

@section('title', 'Semua Proyek — NextTime')
@section('meta_description', 'Lihat seluruh mockup dan konsep website yang dibangun NextTime untuk UMKM, company profile, dan landing page.')

@section('content')

  <!-- PAGE HEADER -->
  <header class="page-header">
    <span class="section-label">Proyek & Konsep</span>
    <h1 class="section-title">Semua Proyek</h1>
    <p class="section-sub">Kami baru memulai — berikut seluruh mockup dan konsep website yang kami bangun untuk menunjukkan kemampuan terbaik kami.</p>
  </header>

  <!-- SEMUA PROYEK -->
  <section class="portofolio">
    <div class="porto-filter">
      <a href="{{ route('projects.index') }}" class="filter-btn @if (! $activeCategory) active @endif">Semua</a>
      @foreach ($categories as $value => $label)
        <a href="{{ route('projects.index', ['category' => $value]) }}"
           class="filter-btn @if ($activeCategory === $value) active @endif">{{ $label }}</a>
      @endforeach
    </div>

    @if ($projects->isEmpty())
      <p class="section-empty">
        Belum ada proyek untuk kategori ini.
        @if ($activeCategory)
          <a href="{{ route('projects.index') }}" class="hover:underline" style="color:var(--cyan);text-decoration:underline">Lihat semua proyek</a>.
        @endif
      </p>
    @else
      <div class="porto-grid">
        @foreach ($projects as $project)
          @include('partials.site.porto-card', ['project' => $project])
        @endforeach
      </div>

      {{ $projects->onEachSide(1)->links('partials.site.pagination') }}
    @endif
  </section>

@endsection
