# Rencana Pengembangan — Admin Panel NextTime

> Status dokumen: **DRAFT — menunggu review**
> Dibuat: 2026-08-19
> Terakhir diperbarui: 2026-08-19

Dokumen ini adalah sumber kebenaran (source of truth) untuk pengembangan halaman admin NextTime secara ber-iterasi. Setiap iterasi dikerjakan **satu per satu**, dan pengembangan **berhenti otomatis** setelah satu iterasi selesai untuk menunggu review Anda sebelum lanjut ke iterasi berikutnya. Setelah iterasi disetujui, [`LOG-AKTIVITAS.md`](./LOG-AKTIVITAS.md) di-update otomatis, dan bila ada perubahan struktur database, [`ERD.md`](./ERD.md) juga di-update otomatis.

---

## 1. Ringkasan & Tujuan

Membuat halaman admin (CRUD) untuk **mengelola seluruh konten halaman publik `index` (home)**, dengan satu menu admin terpisah untuk setiap section di halaman index, ditambah halaman login yang selaras secara desain. Setelah seluruh iterasi admin selesai, pengembangan berlanjut ke **Fase 2**: merapikan data di halaman index, halaman `/projects`, dan halaman detail project.

### Prinsip desain admin (berlaku di semua iterasi)
- **Data lengkap & bisa diedit penuh** — semua field yang tampil di halaman publik bisa diubah dari admin.
- **Responsif** — layak dipakai di mobile, tablet, desktop (sidebar admin sudah punya pola collapsible, dilanjutkan konsisten).
- **Gaya modern** — konsisten dengan tema admin saat ini (Tailwind, aksen `cyan-600`, sidebar gelap `gray-900`).
- **Animasi scroll masuk/keluar** — item list (card/row) muncul dengan reveal animation saat discroll ke viewport, dan animasi keluar saat dihapus/difilter (pakai Alpine.js + `IntersectionObserver`, ditambahkan sebagai utility bersama di Iterasi 0).
- **Pagination** — setiap listing dengan data yang berpotensi banyak menggunakan pagination Laravel (`paginate()`), bukan `get()` semua.
- **Filter** — setiap listing punya filter relevan (status aktif/nonaktif, kategori, pencarian judul) tanpa reload penuh bila memungkinkan.
- **Switch modern untuk toggle** — status aktif/nonaktif, featured, best-seller, dan **tampil/sembunyikan section di halaman publik**, semua pakai komponen switch (bukan checkbox biasa), dengan update instan (AJAX) di iterasi lanjutan bila memungkinkan.

---

## 2. Kondisi Saat Ini (hasil audit codebase)

| Area | Kondisi |
|---|---|
| Stack | Laravel 13, Breeze (auth), Tailwind 3, Alpine.js, Vite, MySQL |
| DB | `.env` sudah mengarah ke MySQL Laragon: `DB_DATABASE=nexttime`, `root`, tanpa password |
| Auth | Breeze standar (login/register/reset), **tidak ada kolom role** — semua user login otomatis bisa akses `/admin` (hanya middleware `auth`,`verified`) |
| Admin sudah ada | Dashboard (statistik ringkas), CRUD **Projects/Portofolio** penuh (create/edit/delete, tanpa pagination & filter saat ini), listing **Users** (index-only, belum CRUD) |
| Halaman index | `home.blade.php` merender 6 section via `@include`: `hero`, `layanan` (+ paket harga di file yang sama), `kenapa`, `portofolio` (dari DB), `klien`, `galeri`, `kontak`. Ditambah `nav`, `footer`, `wa-widget` yang tampil di semua halaman site. |
| Data section selain Portofolio | **Seluruhnya hardcoded di Blade** (bukan dari database) → itulah scope utama pekerjaan ini. |
| Form kontak | Ada di `kontak.blade.php` tapi **belum ada `action`/`method`/controller** — submit belum berfungsi. |
| Keamanan admin | ⚠️ Tidak ada pembatasan role admin — akan diusulkan perbaikan di Iterasi 0 (lihat §5). |

---

## 3. Pemetaan Section Index → Menu Admin

| # | Section di `index` | Partial view | Menu Admin Baru | Jenis data |
|---|---|---|---|---|
| 1 | Hero / Slider | `partials.site.hero` | **Hero / Slider** | CRUD (banyak slide) |
| 2 | Layanan (grid layanan) | `partials.site.layanan` (blok atas) | **Layanan** | CRUD (banyak item) |
| 3 | Paket Harga | `partials.site.layanan` (blok bawah) | **Paket Harga** | CRUD (banyak item) |
| 4 | Kenapa Harus NextTime | `partials.site.kenapa` | **Kenapa Kami** | CRUD (item) + 1 pengaturan (gambar & CTA) |
| 5 | Portofolio | `partials.site.portofolio`, `porto-card` | **Portofolio** *(sudah ada, dipoles)* | CRUD (sudah ada) |
| 6 | Klien / Partner | `partials.site.klien` | **Klien & Partner** | CRUD (banyak item) |
| 7 | Galeri | `partials.site.galeri` | **Galeri** | CRUD (banyak item, upload gambar) |
| 8 | Kontak (info + form) | `partials.site.kontak` | **Info Kontak** (pengaturan) + **Pesan Masuk** (CRUD read/status/delete) | Settings + CRUD |
| — | Navbar & Footer & branding | `partials.site.nav`, `footer` | **Pengaturan Situs** | Settings |
| — | Widget WA + Promo Modal | `partials.site.wa-widget` | **Widget WhatsApp** | Settings |
| — | Kontrol tampil/sembunyi section | (semua section di atas) | **Pengaturan Section** (switch modern) | Settings |
| — | Login | `auth/login.blade.php` | Halaman **Login** (restyle) | — |
| (opsional) | Pengguna admin | `admin/users` | **Pengguna** (lengkapi CRUD) | CRUD, di luar cakupan inti, lihat §6.12 |

---

## 4. Rancangan Skema Database (ringkas)

Tabel baru yang akan dibuat sepanjang iterasi (detail final selalu tercermin di `ERD.md`):

- `hero_slides` — badge, title, highlight, description, primary/secondary CTA (text+link), is_active, sort_order
- `services` — icon (nama ikon Lucide), title, description, is_active, sort_order
- `pricing_packages` — name, price_prefix, price_amount, tier, is_best_seller, icon, features (json), cta_text, cta_link, is_active, sort_order
- `why_us_items` — icon, title, description, is_active, sort_order
- `clients` — name, icon (Lucide) atau logo upload, is_active, sort_order
- `gallery_items` — title, image_path, size_variant (normal/wide/tall), is_active, sort_order
- `contact_messages` — name, email, phone, service_interest, message, status (new/read/replied), timestamps
- `settings` — tabel key-value fleksibel: `group`, `key`, `value`, `type` (text/textarea/image/boolean/url), unique(`group`,`key`). Dipakai untuk: info kontak, branding situs (logo/footer), widget WA & promo, CTA "Kenapa Kami", dan **toggle tampil/sembunyi tiap section**.

Tabel yang **sudah ada dan tidak diubah strukturnya**: `users`, `projects` (kecuali usulan penambahan kolom role, lihat §5).

---

## 5. Keputusan Teknis Penting (mohon dikonfirmasi saat review)

1. **Role admin**: menambahkan kolom `role` (enum `admin`,`user`, default `user`) di tabel `users`, lalu route group `admin.*` divalidasi lewat middleware baru `EnsureUserIsAdmin`, bukan hanya `auth`+`verified`. Ini memperbaiki celah bahwa saat ini siapa pun yang register via `/register` otomatis bisa mengakses seluruh CRUD admin.
2. **Registrasi publik**: karena ini situs company profile (bukan aplikasi multi-user), diusulkan `/register` **ditutup dari sisi public** (redirect ke login) dan pembuatan user baru dilakukan lewat menu **Pengguna** di admin. Ini bagian dari iterasi opsional §6.12 — bila belum dikerjakan, register tetap terbuka namun akun baru default `role=user` (tanpa akses admin) sehingga tetap aman.
3. **Pengaturan generik (`settings` table)** dipakai untuk semua data "satu-nilai" (bukan list) agar tidak menambah banyak tabel kecil bolak-balik migrasi.
4. **Animasi scroll** di admin memakai Alpine.js plugin `@alpinejs/intersect` (ditambahkan sebagai dependency npm di Iterasi 0) dikombinasikan dengan Tailwind transition classes — tanpa library eksternal berat.
5. **Galeri**: karena 8 item galeri saat ini murni ilustrasi CSS (bukan foto asli), pada Iterasi 7 akan diseed sebagai record kosong/placeholder agar admin bisa upload foto asli menyusul — bukan migrasi 1:1 dari CSS mockup ke gambar.
6. **Upload gambar** (logo klien, galeri, gambar CTA "Kenapa Kami", logo situs) disimpan di `storage/app/public` + `php artisan storage:link` (akan dijalankan/diverifikasi di Iterasi 0 bila belum ada).

---

## 6. Iterasi Pengembangan (Fase 1 — Admin Panel)

Setiap iterasi berhenti untuk review Anda sebelum lanjut. Struktur tiap iterasi: **Tujuan → Lingkup → Perubahan DB → Perubahan Backend → Perubahan Admin UI → Perubahan Halaman Publik → Definition of Done**.

### Iterasi 0 — Fondasi Sistem Admin & Halaman Login
- Verifikasi koneksi MySQL Laragon, buat database `nexttime` bila belum ada, jalankan migrasi existing.
- Tambah kolom `role` ke `users` + middleware `EnsureUserIsAdmin` (lihat §5.1).
- Buat tabel `settings` + model + helper akses (`Settings::get('group.key')`).
- Bangun **komponen UI admin bersama** yang dipakai semua iterasi berikutnya: tabel/list card modern, komponen pagination, komponen filter bar + search, komponen switch toggle, utility scroll-reveal (masuk/keluar).
- Restyle halaman **Login** (dan guest layout) agar senada dengan branding NextTime & tema admin.
- Update sidebar `layouts/admin.blade.php` agar daftar menu final sudah tercantum (tautan menu yang belum dikerjakan tetap nonaktif sampai iterasinya selesai).
- Inisialisasi `LOG-AKTIVITAS.md` dan `ERD.md`.
- **DoD**: login baru tampil modern & berfungsi, migrasi `settings`+`role` sukses, komponen bersama siap dipakai, tidak ada regresi di halaman publik.

### Iterasi 1 — Menu "Hero / Slider"
- Migrasi + model `HeroSlide`. Admin CRUD penuh (index dengan pagination+filter aktif/nonaktif+search, create, edit, delete, toggle switch aktif inline).
- Seed 3 slide hero yang sudah ada saat ini ke database.
- Update `HomeController` + `partials/site/hero.blade.php` agar render dari DB (urut `sort_order`, hanya yang aktif).
- **DoD**: hero di halaman publik identik hasilnya dengan sebelumnya, tapi datanya sudah dari DB dan bisa diedit dari admin.

### Iterasi 2 — Menu "Layanan"
- Migrasi + model `Service`. CRUD dengan preview ikon Lucide saat input nama ikon.
- Seed 10 layanan yang sudah ada.
- Update blok grid layanan di `layanan.blade.php` agar dari DB.
- **DoD**: grid layanan publik tetap sama secara visual, sumber data dari DB.

### Iterasi 3 — Menu "Paket Harga"
- Migrasi + model `PricingPackage`. CRUD termasuk daftar fitur per paket (repeatable input) dan switch "Best Seller".
- Seed 4 paket (Silver/Gold/Diamond/Custom).
- Update blok paket harga di `layanan.blade.php`.
- **DoD**: kartu paket harga publik identik, dari DB, badge best-seller ikut switch admin.

### Iterasi 4 — Menu "Kenapa Kami"
- Migrasi + model `WhyUsItem`. CRUD 6 item (icon, title, desc).
- Form pengaturan (grup `settings`: `why_us`) untuk gambar CTA (upload) + teks/link tombol CTA.
- Update `kenapa.blade.php`.
- **DoD**: section "Kenapa Kami" penuh dari DB + gambar CTA bisa diganti dari admin.

### Iterasi 5 — Menu "Portofolio" (poles CRUD yang sudah ada)
- Tambah pagination, filter (status/kategori/featured), search judul ke `admin/projects/index`.
- Terapkan komponen UI modern + animasi scroll dari Iterasi 0 (tanpa mengubah struktur data `projects`).
- **DoD**: listing project admin konsisten secara UX dengan menu-menu baru lainnya, tanpa mengubah perilaku publik.

### Iterasi 6 — Menu "Klien & Partner"
- Migrasi + model `Client`. CRUD (nama, ikon/logo, urutan, aktif).
- Seed 8 logo klien yang ada.
- Update `klien.blade.php` (marquee) agar dari DB, termasuk duplikasi list untuk animasi loop.
- **DoD**: marquee klien tetap mulus secara animasi, datanya dari DB.

### Iterasi 7 — Menu "Galeri"
- Migrasi + model `GalleryItem` (title, upload gambar, size_variant, aktif, urutan).
- CRUD dengan preview gambar & upload.
- Seed sebagai placeholder kosong/siap-isi (lihat §5.5) — dikonfirmasi ulang saat iterasi ini dimulai.
- Update `galeri.blade.php` agar render dari DB, kartu "segera hadir" muncul otomatis bila galeri kosong.
- **DoD**: admin bisa upload/hapus foto galeri, tampil responsif di grid publik.

### Iterasi 8 — Menu "Info Kontak" & "Pesan Masuk"
- Form pengaturan (grup `settings`: `contact`) untuk alamat, telepon, email, jam kerja.
- Migrasi + model `ContactMessage`. Buat `ContactController@store` publik + `StoreContactMessageRequest` (validasi), hubungkan `action`/`method` form di `kontak.blade.php` (saat ini belum berfungsi).
- Admin CRUD "Pesan Masuk": list dengan pagination+filter status (baru/dibaca/dibalas)+search, detail (modal), ubah status, hapus.
- **DoD**: form kontak publik benar-benar mengirim data & tersimpan; info kontak publik bisa diedit dari admin.

### Iterasi 9 — Menu "Widget WhatsApp"
- Form pengaturan (grup `settings`: `wa_widget`) — nomor WA, pesan default, judul/isi promo, switch aktifkan promo modal.
- Update `wa-widget.blade.php` agar pakai data dinamis.
- **DoD**: nomor WA & isi promo bisa diubah tanpa sentuh kode.

### Iterasi 10 — Menu "Pengaturan Situs" & "Pengaturan Section" (switch modern)
- Form pengaturan (grup `settings`: `site`) — nama situs, logo (light/dark), deskripsi footer, link sosial.
- Form pengaturan (grup `settings`: `sections`) — **switch modern per section**: hero, layanan, paket harga, kenapa, portofolio, klien, galeri, kontak, wa_widget.
- Update `layouts/site.blade.php`, `nav`, `footer`, dan `home.blade.php` agar section yang di-nonaktifkan otomatis tidak dirender.
- **DoD**: mematikan satu switch section langsung menyembunyikan section itu di halaman publik, sisanya tetap normal.

### 6.12 Iterasi Opsional — Menu "Pengguna" (lengkapi CRUD)
- Di luar permintaan inti (bukan bagian dari section index), tapi disebut di sidebar existing.
- Lengkapi create/edit/delete/role assignment untuk `admin/users`, tutup `/register` publik (lihat §5.2).
- Dikerjakan hanya bila diminta secara eksplisit setelah Iterasi 10 selesai.

---

## 7. Fase 2 — Rapikan Data Halaman Publik

Dimulai setelah seluruh Iterasi Fase 1 (§6) disetujui — **status: Fase 1 selesai 2026-08-19**. Pola kerja sama seperti Fase 1: satu iterasi, verifikasi, update log/ERD, berhenti untuk review.

### Kondisi Awal (hasil audit sebelum Fase 2)

- Halaman `home` sudah sepenuhnya dinamis dari DB (hasil Fase 1), tapi teaser Portofolio di beranda merender **seluruh** `featuredProjects` tanpa batas — akan makin panjang begitu admin menambah proyek.
- Data berikut masih **dummy/placeholder** peninggalan seed awal (bukan data asli bisnis): 8 nama klien contoh (Nexa, Vertex, dst — ikon generik, tanpa logo asli), 8 foto galeri placeholder (semua memakai gambar yang sama, `assets/why.png`), info kontak contoh (alamat/telepon/email contoh). **Ini bukan sesuatu yang bisa saya karang ulang jadi "data asli"** — saya hanya bisa menandai & memastikan admin panel-nya sudah siap dipakai Anda untuk mengisi data sebenarnya (sudah siap sejak Fase 1).
- Halaman `/projects`: query `Project::query()->ordered()->get()` tanpa pagination; filter kategori di UI (`data-filter`) murni client-side JS — tidak akan cocok lagi begitu ditambah pagination server-side.
- Halaman detail `/projects/{slug}`: hanya render `overview`+`features`+mockup CSS (`mockup_type`), tidak ada proyek terkait, tidak ada meta description, tidak ada opsi gambar asli (semua proyek memakai mockup CSS sintetis, termasuk yang sudah "Tayang").

### Iterasi A — Rapikan Halaman Index
1. Batasi jumlah kartu di teaser Portofolio beranda (mis. tampilkan maksimal 6 featured project terbaru, sisanya lewat tombol "Lihat Semua" ke `/projects`) — supaya beranda tidak makin panjang seiring admin menambah data.
2. Tambahkan **empty state** yang layak untuk tiap section yang bisa dikosongkan admin (Hero, Layanan, Paket Harga, Kenapa Kami, Portofolio, Klien, Galeri) — saat ini sebagian akan merender wrapper section kosong tanpa pesan bila datanya nol.
3. Audit visual tiap section dengan jumlah data ekstrem (kosong & banyak/20+) — pastikan grid/marquee tidak pecah layout.
4. Rapikan kembali style alert sukses/error form kontak (dibuat di Iterasi 8) langsung di halaman nyata, bukan cuma smoke test.
5. **Catatan untuk Anda** (bukan dikerjakan otomatis): daftar field yang masih berisi data contoh dan sebaiknya diganti data asli lewat admin — akan dirangkum di log setelah iterasi ini selesai.

### Iterasi B — Rapikan Halaman `/projects`
1. Tambah pagination server-side (`paginate()`) ke `Site\ProjectController@index`.
2. Ubah filter kategori dari client-side murni menjadi server-side via query string (`?category=umkm`), supaya konsisten dengan pagination sambil tetap accessible tanpa JS.
3. Selaraskan style pagination dengan tema publik (`site.css`), bukan style Tailwind admin.
4. Tambah empty-state bila filter tidak menghasilkan apa pun.

### Iterasi C — Rapikan Halaman Detail Project
1. Tambah kolom opsional `thumbnail_path` pada `projects` (migrasi) supaya admin bisa unggah gambar asli menggantikan/mendampingi mockup CSS — fallback ke mockup bila kosong. Update form admin Portofolio (create/edit) + kartu + halaman detail.
2. Tambah section "Proyek Terkait" (beberapa proyek lain, prioritas kategori sama) di bawah detail.
3. Tambah meta description dasar (dari `summary`) di `<head>` halaman detail (dan index bila belum ada).
4. Rapikan breadcrumb (link kembali sudah ada — pastikan style & trail konsisten).

---

## 8. Alur Kerja & Checklist Setiap Iterasi

1. Mulai iterasi → implementasi kode sesuai lingkup di §6/§7.
2. Jalankan migrasi, seeder (bila ada), cek tidak ada error.
3. Verifikasi manual: responsif (mobile/tablet/desktop), animasi scroll masuk/keluar, pagination, filter, switch toggle berfungsi.
4. Update `pengembangan/LOG-AKTIVITAS.md` (entri baru: tanggal, iterasi, ringkasan, file terdampak, status).
5. Bila ada perubahan skema DB → update `pengembangan/ERD.md`.
6. **Berhenti** dan laporkan ke Anda untuk review sebelum lanjut ke iterasi berikutnya.

---

## 9. Catatan

- Bahasa UI admin & seluruh dokumen: Bahasa Indonesia, konsisten dengan halaman publik yang sudah ada.
- Tidak ada perubahan pada `projects` table kecuali disepakati terpisah.
- Dokumen ini akan direvisi bila ada perubahan lingkup — riwayat revisi dicatat di `LOG-AKTIVITAS.md`, bukan dengan menghapus histori di file ini.
