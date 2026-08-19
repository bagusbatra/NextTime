{{-- Kenapa Harus Di NextTime — $whyUsItems: Collection<WhyUsItem>, $whyUsCta: array{image, text, link} --}}
<section class="kenapa" id="kenapa">
  <div class="section-head-center">
    <span class="section-label">Keunggulan Kami</span>
    <h2 class="section-title">Kenapa Harus Di NextTime</h2>
    <p class="section-sub">Alasan klien mempercayakan pembuatan website kepada NextTime.</p>
  </div>
  <div class="kenapa-layout">

    <div class="kenapa-list">
      @forelse ($whyUsItems as $item)
        <div class="kenapa-item">
          <div class="kenapa-icon"><i data-lucide="{{ $item->icon }}"></i></div>
          <div class="kenapa-item-body">
            <h3>{{ $item->title }}</h3>
            <p>{{ $item->description }}</p>
          </div>
        </div>
      @empty
        <p class="section-empty">Belum ada poin keunggulan yang ditambahkan.</p>
      @endforelse
    </div>

    <div class="kenapa-cta">
      <img src="{{ $whyUsCta['image'] ? asset('storage/'.$whyUsCta['image']) : asset('assets/why.png') }}" alt="Kenapa harus di NextTime" class="kenapa-cta-img">
      <a href="{{ $whyUsCta['link'] }}" class="btn-primary kenapa-cta-btn">{{ $whyUsCta['text'] }}</a>
    </div>

  </div>
</section>
