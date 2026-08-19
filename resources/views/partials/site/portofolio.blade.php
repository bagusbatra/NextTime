{{-- Portofolio teaser — $featuredProjects: Collection<Project> --}}
<section class="portofolio" id="portofolio">
  <div class="section-head-center">
    <span class="section-label">Proyek & Konsep</span>
    <h2 class="section-title">Portofolio</h2>
    <p class="section-sub">Kami baru memulai — berikut mockup dan konsep website yang kami bangun untuk menunjukkan kemampuan terbaik kami.</p>
  </div>
  <div class="porto-filter-row">
    <div class="porto-filter">
      <button class="filter-btn active" data-filter="all">Semua</button>
      <button class="filter-btn" data-filter="umkm">UMKM</button>
      <button class="filter-btn" data-filter="company-profile">Company Profile</button>
      <button class="filter-btn" data-filter="landing-page">Landing Page</button>
    </div>
    <a href="{{ route('projects.index') }}" class="porto-viewall">
      Lihat Semua <i data-lucide="arrow-right"></i>
    </a>
  </div>
  @if ($featuredProjects->isEmpty())
    <p class="section-empty">Belum ada proyek unggulan yang ditambahkan.</p>
  @else
    <div class="porto-grid">
      @foreach ($featuredProjects as $project)
        @include('partials.site.porto-card', ['project' => $project])
      @endforeach
    </div>
  @endif
</section>
