{{--
  Layanan — $services: Collection<Service>, $pricingPackages: Collection<PricingPackage>
  $showLayanan / $showPaketHarga: toggle independen dari menu "Pengaturan Section"
--}}
@php
    $showLayanan = $showLayanan ?? true;
    $showPaketHarga = $showPaketHarga ?? true;
@endphp
<section class="layanan" id="layanan">
  @if ($showLayanan)
    <div class="section-head-center">
      <span class="section-label">Apa yang Kami Kerjakan</span>
      <h2 class="section-title">Layanan Kami</h2>
      <p class="section-sub">Kami spesialis pembuatan website profesional untuk berbagai kebutuhan bisnis Anda.</p>
    </div>
    @if ($services->isEmpty())
      <p class="section-empty">Belum ada layanan yang ditambahkan.</p>
    @else
      <div class="layanan-grid">
        @foreach ($services as $service)
          <div class="layanan-card">
            <div class="layanan-icon"><i data-lucide="{{ $service->icon }}"></i></div>
            <h3>{{ $service->title }}</h3>
            <p>{{ $service->description }}</p>
          </div>
        @endforeach
      </div>
      <div class="layanan-more">
        <span>dan website lainnya sesuai kebutuhan bisnis Anda</span>
      </div>
    @endif
  @endif

  @if ($showPaketHarga)
    <!-- ── PAKET HARGA ── -->
    <div class="paket-head" data-anim="up">
      <h3 class="paket-title">Paket Jasa Website</h3>
      <p class="paket-sub">Pilih paket yang sesuai kebutuhan, atau konsultasikan proyek custom Anda.</p>
    </div>
    @if ($pricingPackages->isEmpty())
      <p class="section-empty">Belum ada paket harga yang ditambahkan.</p>
    @else
      <div class="paket-grid">
      @foreach ($pricingPackages as $package)
        @php
          $cardClass = match ($package->tier) {
              'gold' => 'paket-card paket-card--gold',
              'custom' => 'paket-card paket-card--custom',
              default => 'paket-card',
          };
          $ctaClass = $package->is_best_seller ? 'paket-cta paket-cta--gold' : 'paket-cta paket-cta--outline';
        @endphp
        <div class="{{ $cardClass }}" data-anim="up">
          <div class="paket-badge-wrap">
            @if ($package->is_best_seller)
              <span class="paket-best">⭐ Best Seller</span>
            @endif
          </div>
          <div class="paket-icon paket-icon--{{ $package->tier }}">
            <i data-lucide="{{ $package->icon }}"></i>
          </div>
          <h4 class="paket-name">{{ $package->name }}</h4>
          <div class="paket-price">
            <span class="paket-from">{{ $package->price_prefix }}</span>
            <span class="paket-num @if ($package->tier === 'custom') paket-num--custom @endif">
              {{ $package->price_amount }}@if ($package->price_unit)<span class="paket-unit">{{ $package->price_unit }}</span>@endif
            </span>
          </div>
          <ul class="paket-features">
            @foreach ($package->features as $feature)
              <li><i data-lucide="check"></i> {{ $feature }}</li>
            @endforeach
          </ul>
          <a href="{{ $package->cta_link }}" class="{{ $ctaClass }}">{{ $package->cta_text }}</a>
        </div>
      @endforeach
      </div>
    @endif
  @endif
</section>
