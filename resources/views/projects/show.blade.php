@extends('layouts.site')

@section('title', $project->title . ' — NextTime')

@section('content')

  <!-- PAGE HEADER -->
  <header class="page-header">
    <a href="{{ route('projects.index') }}" class="breadcrumb">
      <i data-lucide="arrow-left"></i> Kembali ke Semua Proyek
    </a>
  </header>

  <!-- DETAIL PROYEK -->
  <section class="project-detail">
    <div class="detail-layout">
      <div class="detail-thumb">
        @include('partials.site.mockup', ['type' => $project->mockup_type])
      </div>

      <div class="detail-info">
        <span class="porto-tag detail-tag">{{ $project->tag }}</span>
        <h1 class="detail-title">{{ $project->title }}</h1>
        <p class="detail-overview">{{ $project->overview }}</p>

        <h2 class="detail-features-title">Fitur Utama</h2>
        <ul class="detail-features">
          @foreach ($project->features as $feature)
            <li><i data-lucide="check"></i> <span>{{ $feature }}</span></li>
          @endforeach
        </ul>

        <div class="detail-actions">
          <a href="{{ route('home') }}#kontak" class="btn-primary">Konsultasi Sekarang →</a>
          <a href="{{ route('projects.index') }}" class="btn-outline">Lihat Proyek Lain</a>
        </div>
      </div>
    </div>
  </section>

@endsection
