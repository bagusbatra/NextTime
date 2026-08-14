@extends('layouts.site')

@section('title', 'Semua Proyek — NextTime')

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
      <button class="filter-btn active" data-filter="all">Semua</button>
      <button class="filter-btn" data-filter="umkm">UMKM</button>
      <button class="filter-btn" data-filter="company-profile">Company Profile</button>
      <button class="filter-btn" data-filter="landing-page">Landing Page</button>
    </div>
    <div class="porto-grid">
      @foreach ($projects as $project)
        @include('partials.site.porto-card', ['project' => $project])
      @endforeach
    </div>
  </section>

@endsection
