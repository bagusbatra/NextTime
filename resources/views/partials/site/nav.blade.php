<!-- NAV -->
<nav>
  <a href="{{ route('home') }}#home" class="logo">
    <span class="logo-mark">
      <img src="{{ asset('assets/default-logo.png') }}" alt="" class="logo-img logo-img--light">
      <img src="{{ asset('assets/white-logo.png') }}" alt="" class="logo-img logo-img--dark">
    </span>
    NextTi<span>me</span>
  </a>
  <button class="nav-toggle" id="navToggle" aria-label="Buka menu" aria-expanded="false">
    <i data-lucide="menu" class="nav-toggle-icon nav-toggle-icon--open"></i>
    <i data-lucide="x" class="nav-toggle-icon nav-toggle-icon--close"></i>
  </button>
  <ul>
    <li><a href="{{ route('home') }}#home">Home</a></li>
    <li><a href="{{ route('home') }}#layanan">Layanan</a></li>
    <li><a href="{{ route('home') }}#portofolio">Portofolio</a></li>
    <li><a href="{{ route('home') }}#galeri">Galeri</a></li>
    <li><a href="{{ route('home') }}#kontak" class="nav-cta">Konsultasi</a></li>
  </ul>
</nav>
