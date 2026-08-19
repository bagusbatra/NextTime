{{--
  Klien & Partner — $clients: Collection<Client>
  Section ini murni strip marquee tanpa judul, jadi saat kosong section
  disembunyikan total (bukan tampil sebagai strip kosong).
--}}
@if ($clients->isNotEmpty())
  <section class="klien" id="klien">
    <div class="klien-marquee">
      <div class="klien-track">
        @foreach ($clients as $client)
          <div class="klien-logo">
            @if ($client->logo_path)
              <img src="{{ asset('storage/'.$client->logo_path) }}" alt="{{ $client->name }}" style="height:1.5rem;width:auto;object-fit:contain">
            @else
              <i data-lucide="{{ $client->icon ?? 'hexagon' }}"></i>
            @endif
            <span>{{ $client->name }}</span>
          </div>
        @endforeach

        {{-- duplikat untuk loop tanpa jeda --}}
        @foreach ($clients as $client)
          <div class="klien-logo" aria-hidden="true">
            @if ($client->logo_path)
              <img src="{{ asset('storage/'.$client->logo_path) }}" alt="" style="height:1.5rem;width:auto;object-fit:contain">
            @else
              <i data-lucide="{{ $client->icon ?? 'hexagon' }}"></i>
            @endif
            <span>{{ $client->name }}</span>
          </div>
        @endforeach
      </div>
    </div>
  </section>
@endif
