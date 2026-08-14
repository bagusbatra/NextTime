// ── LUCIDE ICONS ──
lucide.createIcons();

// ── HERO CAROUSEL ──
(function () {
  const slides = document.querySelectorAll('.hero-slide');
  const dots   = document.querySelectorAll('.hero-dot');
  if (!slides.length) return; // halaman tanpa hero (mis. projects.html, detailproject.html)

  const DURATION = 10000; // 10 detik per slide
  const TRANSITION = 850; // cocok dengan durasi CSS (ms)
  let current = 0;
  let timer;

  function goTo(next) {
    if (next === current) return;

    const prev = current;
    current = next;

    // Slide keluar: tambah .exiting, hapus .active
    slides[prev].classList.remove('active');
    slides[prev].classList.add('exiting');
    dots[prev].classList.remove('active');

    // Setelah transisi selesai, bersihkan .exiting
    setTimeout(() => slides[prev].classList.remove('exiting'), TRANSITION);

    // Slide masuk
    slides[current].classList.add('active');
    dots[current].classList.add('active');
  }

  function next() {
    goTo((current + 1) % slides.length);
  }

  function startTimer() {
    timer = setInterval(next, DURATION);
  }

  function resetTimer() {
    clearInterval(timer);
    startTimer();
  }

  // Klik dot untuk navigasi manual
  dots.forEach((dot, i) => {
    dot.addEventListener('click', () => { goTo(i); resetTimer(); });
  });

  startTimer();
})();

// ── NAVBAR SCROLL STATE ──
const nav  = document.querySelector('nav');
const hero = document.querySelector('.hero');

function updateNav() {
  // Halaman dengan hero: gelap setelah melewati hero. Halaman tanpa hero (mis.
  // projects.html, detailproject.html): gelap setelah scroll sedikit.
  const scrolled = hero ? hero.getBoundingClientRect().bottom <= 0 : window.scrollY > 60;
  nav.classList.toggle('scrolled', scrolled);
}

if (nav) {
  window.addEventListener('scroll', updateNav, { passive: true });
  updateNav(); // cek posisi awal saat halaman dimuat
}

// ── FILTER BUTTONS (Portofolio) ──
// Setiap tombol punya data-filter ("all" atau slug kategori), setiap kartu
// punya data-category. Klik tombol menampilkan hanya kartu yang cocok.
document.querySelectorAll('.porto-filter').forEach(filterBar => {
  const grid = filterBar.closest('section')?.querySelector('.porto-grid');
  if (!grid) return;

  filterBar.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      filterBar.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');

      const filter = btn.dataset.filter || 'all';
      grid.querySelectorAll('.porto-card').forEach(card => {
        const match = filter === 'all' || card.dataset.category === filter;
        card.classList.toggle('is-hidden', !match);
      });
    });
  });
});

// ── SCROLL ANIMATIONS ──
// Peta elemen → tipe animasi & delay/stagger (ms)
const ANIM = [
  // Hero
  { sel: '.badge',          type: 'up',    delay: 0   },
  { sel: '.hero h1',        type: 'up',    delay: 120 },
  { sel: '.hero-slide > p', type: 'up',    delay: 230 },
  { sel: '.hero-actions',   type: 'up',    delay: 340 },
  { sel: '.stat',           type: 'up',    stagger: 90 },
  // Header section (muncul sebelum konten kartu)
  { sel: '.section-label',  type: 'up',    delay: 0   },
  { sel: '.section-title',  type: 'up',    delay: 110 },
  { sel: '.section-sub',    type: 'up',    delay: 200 },
  // Layanan
  { sel: '.layanan-card',   type: 'up',    stagger: 80 },
  // Paket
  { sel: '.paket-head',     type: 'up',    delay: 0   },
  { sel: '.paket-card',     type: 'up',    stagger: 90 },
  // Kenapa Kami
  { sel: '.kenapa-item',    type: 'left',  stagger: 80 },
  { sel: '.kenapa-cta',     type: 'right', delay: 100  },
  // Portofolio
  { sel: '.porto-filter',   type: 'up',    delay: 260 },
  { sel: '.porto-viewall',  type: 'up',    delay: 260 },
  { sel: '.porto-card',     type: 'up',    stagger: 80 },
  // Galeri
  { sel: '.g-item',         type: 'up',    stagger: 55 },
  // Kontak
  { sel: '.info-item',      type: 'left',  stagger: 90 },
  { sel: '.kontak-form',    type: 'right', delay: 0   },
  // Footer
  { sel: '.footer-grid',    type: 'up',    delay: 0   },
];

// Terapkan atribut data-anim ke elemen yang cocok
// Guard: tiap elemen hanya mendapat satu animasi (match pertama)
ANIM.forEach(({ sel, type, delay, stagger }) => {
  document.querySelectorAll(sel).forEach((el, i) => {
    if (el.dataset.animDone) return;
    el.setAttribute('data-anim', type);
    el.dataset.animDone = '1';

    const ms = stagger != null ? i * stagger : (delay ?? 0);
    el.dataset.animDelay = ms;
    if (ms > 0) el.style.transitionDelay = ms + 'ms';
  });
});

// IntersectionObserver: animasi masuk & keluar
const observer = new IntersectionObserver(entries => {
  entries.forEach(entry => {
    const el = entry.target;

    if (entry.isIntersecting) {
      // Kembalikan delay asli saat masuk
      const d = Number(el.dataset.animDelay ?? 0);
      el.style.transitionDelay = d + 'ms';
      el.classList.add('visible');
      el.classList.remove('exit-top');
    } else {
      // Keluar tanpa delay agar terasa responsif
      el.style.transitionDelay = '0ms';
      el.classList.remove('visible');

      // Tentukan arah keluar berdasarkan posisi elemen
      if (entry.boundingClientRect.top < 0) {
        // Elemen keluar di atas viewport (scroll ke bawah melewatinya)
        el.classList.add('exit-top');
      } else {
        // Elemen masih di bawah viewport (belum terjangkau)
        el.classList.remove('exit-top');
      }
    }
  });
}, {
  threshold: 0.1,
  rootMargin: '0px 0px -30px 0px',
});

document.querySelectorAll('[data-anim]').forEach(el => observer.observe(el));

// ── WA FAB + MODAL ──
(function () {
  const fab     = document.getElementById('waFab');
  const overlay = document.getElementById('waOverlay');
  const closeBtn = document.getElementById('waModalClose');
  if (!fab || !overlay) return;

  // Tampilkan FAB saat section layanan masuk viewport
  // (halaman tanpa section #layanan, mis. projects.html, langsung menampilkan FAB)
  const layanan = document.getElementById('layanan');
  if (layanan) {
    const fabObserver = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        fab.hidden = !entry.isIntersecting;
      });
    }, { threshold: 0.15 });
    fabObserver.observe(layanan);
  } else {
    fab.hidden = false;
  }

  function openModal() {
    overlay.setAttribute('aria-hidden', 'false');
    overlay.classList.add('open');
    overlay.classList.remove('closing');
  }

  function closeModal() {
    overlay.classList.add('closing');
    overlay.addEventListener('animationend', () => {
      overlay.classList.remove('open', 'closing');
      overlay.setAttribute('aria-hidden', 'true');
    }, { once: true });
  }

  fab.addEventListener('click', openModal);
  closeBtn.addEventListener('click', closeModal);

  // Klik overlay di luar modal = tutup
  overlay.addEventListener('click', e => {
    if (e.target === overlay) closeModal();
  });

  // ESC = tutup
  document.addEventListener('keydown', e => {
    if (e.key === 'Escape' && overlay.classList.contains('open')) closeModal();
  });
})();
