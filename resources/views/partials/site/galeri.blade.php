{{-- Galeri — $galleryItems: Collection<GalleryItem> --}}
<section class="galeri" id="galeri">
  <div class="section-head-center" style="margin-bottom:3rem">
    <span class="section-label">Proses Kreatif</span>
    <h2 class="section-title">Galeri</h2>
    <p class="section-sub" style="margin:0 auto 0">Dari ide ke kenyataan — sekilas pendekatan desain, tools, dan proses kreatif yang kami gunakan di setiap proyek.</p>
  </div>
  <div class="gallery-grid">

    @foreach ($galleryItems as $item)
      <div class="g-item @if ($item->size_variant === 'wide') wide @elseif ($item->size_variant === 'tall') tall @endif">
        <div class="g-thumb">
          <img src="{{ asset('storage/'.$item->image_path) }}" alt="{{ $item->title }}" style="width:100%;height:100%;object-fit:cover">
        </div>
        <div class="g-overlay"><span>{{ $item->title }}</span></div>
      </div>
    @endforeach

    <!-- Coming soon -->
    <div class="g-item g-item--soon">
      <div class="g-thumb g-thumb--soon">
        <i data-lucide="image-plus"></i>
        <span>Foto & karya proyek<br>akan segera hadir</span>
      </div>
    </div>

  </div>
</section>
