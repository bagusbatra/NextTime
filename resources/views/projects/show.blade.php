@extends('layouts.site')

@section('title', $project->title . ' — NextTime')
@section('meta_description', str($project->summary)->limit(155))

@section('content')

  <!-- PAGE HEADER -->
  <header class="page-header page-header--detail">
    <a href="{{ route('projects.index') }}" class="breadcrumb">
      <i data-lucide="arrow-left"></i> Kembali ke Semua Proyek
    </a>

    @if ($relatedProjects->isNotEmpty())
      <div class="related-projects">
        <span class="related-projects-label">Proyek<br>Serupa</span>
        <div class="related-projects-list">
          @foreach ($relatedProjects as $related)
            @php
              $typeIcon = match ($related->mockup_type) {
                  'resto' => 'utensils',
                  'shop' => 'shopping-cart',
                  'company' => 'building-2',
                  default => $related->icon ?? 'layout-template',
              };
              $thumbType = $related->mockup_type ?? 'company';
            @endphp
            @if ($related->status === 'available')
              <a href="{{ route('projects.show', $related->slug) }}" class="related-card">
                <div class="related-card-thumb related-card-thumb--{{ $thumbType }}">
                  <i data-lucide="{{ $typeIcon }}"></i>
                </div>
                <div class="related-card-info">
                  <h4>{{ $related->title }}</h4>
                  <span>{{ $related->tag }}</span>
                </div>
              </a>
            @else
              <div class="related-card" style="cursor:default">
                <div class="related-card-thumb related-card-thumb--{{ $thumbType }}">
                  <i data-lucide="{{ $typeIcon }}"></i>
                </div>
                <div class="related-card-info">
                  <h4>{{ $related->title }}</h4>
                  <span>Segera Hadir</span>
                </div>
              </div>
            @endif
          @endforeach
        </div>
      </div>
    @endif
  </header>

  <!-- DETAIL PROYEK -->
  <section class="project-detail">
    <div class="detail-layout">
      <div class="detail-thumb @if ($project->thumbnail_path) detail-thumb--photo @endif">
        @if ($project->thumbnail_path)
          <img src="{{ asset('storage/'.$project->thumbnail_path) }}" alt="{{ $project->title }}" style="width:100%;height:100%;object-fit:cover;border-radius:10px">
        @else
          @include('partials.site.mockup', ['type' => $project->mockup_type])
        @endif
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
