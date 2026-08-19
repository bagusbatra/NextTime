{{-- Home / Hero — $heroSlides: Collection<HeroSlide> --}}
<section class="hero" id="home">
  <div class="hero-slides">
    @forelse ($heroSlides as $slide)
      <div class="hero-slide @if ($loop->first) active @endif">
        <div class="badge">{{ $slide->badge }}</div>
        <h1>
          {{ $slide->title }}
          @if ($slide->title_highlight)
            <br><span class="highlight">{{ $slide->title_highlight }}</span>
          @endif
        </h1>
        <p>{{ $slide->description }}</p>
        <div class="hero-actions">
          <a href="{{ $slide->primary_cta_link }}" class="btn-primary">{{ $slide->primary_cta_text }}</a>
          @if ($slide->secondary_cta_text)
            <a href="{{ $slide->secondary_cta_link }}" class="btn-outline">{{ $slide->secondary_cta_text }}</a>
          @endif
        </div>
      </div>
    @empty
      <div class="hero-slide active">
        <div class="badge">Kami Siap Membantu Bisnis Anda</div>
        <h1>Wujudkan Ide Anda<br><span class="highlight">Bersama NextTime</span></h1>
        <p>Kami adalah tim kreatif yang berdedikasi menghadirkan solusi desain dan teknologi terbaik untuk pertumbuhan bisnis Anda.</p>
        <div class="hero-actions">
          <a href="#layanan" class="btn-primary">Lihat Layanan →</a>
          <a href="#kontak" class="btn-outline">Hubungi Kami</a>
        </div>
      </div>
    @endforelse
  </div>

  @if ($heroSlides->count() > 1)
    <!-- Indikator dot -->
    <div class="hero-dots">
      @foreach ($heroSlides as $slide)
        <button class="hero-dot @if ($loop->first) active @endif" aria-label="Slide {{ $loop->iteration }}"></button>
      @endforeach
    </div>
  @endif
</section>
