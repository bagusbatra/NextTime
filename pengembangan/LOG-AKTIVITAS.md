# Log Aktivitas Pengembangan

> File ini di-update otomatis setiap kali satu iterasi (lihat [`RENCANA-PENGEMBANGAN.md`](./RENCANA-PENGEMBANGAN.md)) selesai dikerjakan. Entri terbaru ditambahkan di paling atas.

---

## 2026-08-19 — Iterasi 11 (Opsional): CRUD Pengguna + Tutup Registrasi Publik

**Iterasi**: 11 (opsional, §6.12)
**Status**: ✅ Selesai — dengan ini **seluruh item di `RENCANA-PENGEMBANGAN.md` (Fase 1, Fase 2, dan iterasi opsional) sudah tuntas dikerjakan.**

**Ringkasan**:
- `Admin\UserController` dilengkapi dari index-only jadi **CRUD penuh**: create/store, edit/update, destroy — dengan pagination, filter role, dan pencarian nama/email di index (`routes/admin.php` diubah dari `Route::get('/users', ...)` tunggal menjadi `Route::resource('users', ...)->except(['show'])`, nama route `admin.users.index` tetap sama sehingga tidak mengubah link yang sudah ada).
- Form Pengguna (`admin/users/_form.blade.php`) mencakup nama, email, **role** (Admin / Pengguna Biasa), dan kata sandi (wajib saat tambah, opsional saat edit — dikosongkan berarti tidak diubah).
- **Guard keamanan** ditambahkan di `UserController`:
  1. Tidak bisa menghapus akun sendiri.
  2. Tidak bisa menghapus admin terakhir yang tersisa.
  3. Tidak bisa menurunkan role admin terakhir jadi "Pengguna Biasa" (mencegah situs kehilangan akses admin sepenuhnya).
- **Registrasi publik ditutup** (`routes/auth.php`) sesuai §5.2 — `/register` (GET & POST) sekarang redirect ke `/login`. Nama route `register` sengaja dipertahankan (bukan dihapus) untuk kompatibilitas dengan `Route::has('register')` di tempat lain. Pembuatan akun baru sekarang hanya lewat menu **Pengguna** di admin.

**Verifikasi yang sudah dilakukan** (paling menyeluruh dari semua iterasi, karena menyangkut guard keamanan):
- `npm run build` sukses, `php artisan view:cache` sukses (semua Blade valid).
- `GET /register` mengembalikan 302 ke `/login` (dikonfirmasi via header `Location`).
- **Uji CRUD nyata**: buat pengguna baru role "Pengguna Biasa" → login sebagai pengguna itu → akses `/admin/dashboard` ditolak **403** (middleware role bekerja untuk akun baru, bukan cuma akun seed).
- **Uji guard "hapus diri sendiri"**: admin yang sedang login mencoba hapus akunnya sendiri → diblokir (redirect dengan pesan error), akun tetap ada.
- **Uji guard "admin terakhir"** (skenario penuh): naikkan pengguna uji jadi admin (2 admin) → turunkan admin awal jadi "Pengguna Biasa" berhasil (karena masih ada 1 admin lain) → coba turunkan admin uji (kini satu-satunya admin) jadi "Pengguna Biasa" → **diblokir**, role tetap "admin" → admin awal dikembalikan ke role admin → akun uji dihapus (berhasil, karena bukan lagi admin terakhir).
- Semua data uji dihapus, database kembali ke 1 pengguna (`admin@nexttime.test`, role admin) seperti semula.
- Regresi penuh: 3 halaman publik + 14 halaman admin semua tetap 200.

**File terdampak**:
- Request: `Store/UpdateUserRequest` (baru)
- Controller: `Admin\UserController` (index-only → CRUD penuh + guard)
- Routes: `routes/admin.php` (resource `users`), `routes/auth.php` (`register` → redirect ke login)
- View admin: `admin/users/index.blade.php` (redesain: filter/search/pagination/aksi), `create.blade.php`, `edit.blade.php`, `_form.blade.php` (baru)

**Status akhir rencana**: Fase 1 (11 menu admin), Fase 2 (rapikan index/projects/detail), dan Iterasi 11 opsional — **semuanya selesai**. Tidak ada lagi item terjadwal di `RENCANA-PENGEMBANGAN.md` kecuali permintaan baru dari Anda.

---

## 2026-08-19 — Fase 2, Iterasi C: Rapikan Halaman Detail Project

**Iterasi**: Fase 2 / C
**Status**: ✅ Selesai — **seluruh Fase 2 (Iterasi A–C) sudah tuntas.** Menunggu review Anda.

**Ringkasan**:
- Tambah kolom opsional `projects.thumbnail_path` (migrasi) — admin sekarang bisa unggah **gambar asli** menggantikan mockup CSS sintetis, lewat form Portofolio (create/edit) yang sudah ada. Fallback otomatis ke mockup CSS bila kosong (perilaku lama tidak berubah untuk proyek yang belum diberi gambar).
- `partials/site/porto-card.blade.php` (dipakai di teaser beranda & listing `/projects`) dan `projects/show.blade.php` (halaman detail) diperbarui agar merender thumbnail asli bila ada; label "✦ Mockup Konsep" otomatis disembunyikan saat gambar asli dipakai.
- **Proyek Terkait**: `Site\ProjectController@show` mengambil hingga 3 proyek lain — prioritas kategori yang sama, dilengkapi dari kategori lain bila kurang. Ternyata ada CSS `.related-projects`/`.related-card` **peninggalan template statis asli** (`detailproject.html`) yang belum pernah dipakai di versi Blade — saya pakai struktur itu apa adanya (strip kartu ringkas di sebelah breadcrumb) alih-alih membuat komponen baru dari nol, supaya konsisten dengan desain yang sudah dirancang sejak awal.
- Meta description (`<meta name="description">`) ditambahkan ke `layouts/site.blade.php` (fallback generik) — halaman detail proyek pakai `summary` proyek (dipotong 155 karakter), halaman `/projects` pakai deskripsi ringkas khusus listing.
- Breadcrumb ("Kembali ke Semua Proyek") sudah konsisten sejak awal — tidak perlu perubahan struktural, hanya kini berdampingan dengan strip "Proyek Serupa" di `page-header--detail`.

**Verifikasi yang sudah dilakukan**:
- `npm run build` sukses, `php artisan view:cache` sukses (semua Blade valid).
- **Uji nyata proyek terkait**: halaman detail "Dapur Nusantara" (kategori umkm) menampilkan tepat 3 kartu terkait dari kategori sama (Batik Elegan Store, Hotel Bintang Timur, Jelajah Wisata Nusa).
- **Uji nyata meta description**: tag `<meta name="description">` di halaman detail terisi otomatis dari `summary` proyek.
- **Uji nyata upload thumbnail**: unggah gambar via admin (form multipart, route model binding proyek pakai **slug**, bukan id — dicatat karena sempat salah pakai id numerik saat testing dan dapat 404) → gambar langsung tampil di kartu teaser beranda, kartu listing `/projects`, dan halaman detail secara konsisten → thumbnail dihapus lagi setelah verifikasi, proyek otomatis kembali memakai mockup CSS & label "Mockup Konsep" muncul lagi.
- Regresi penuh: 5 halaman publik + 14 halaman admin semua tetap 200.

**File terdampak**:
- Migrasi: `add_thumbnail_path_to_projects_table`
- Model: `Project` (fillable `thumbnail_path`)
- Request: `Store/UpdateProjectRequest` (validasi `thumbnail`)
- Controller: `Admin\ProjectController` (upload/hapus file thumbnail), `Site\ProjectController` (query proyek terkait)
- View admin: `admin/projects/_form.blade.php` (field upload), `create.blade.php`/`edit.blade.php` (`enctype`)
- View publik: `partials/site/porto-card.blade.php`, `projects/show.blade.php` (proyek terkait, meta description, thumbnail), `projects/index.blade.php` (meta description), `layouts/site.blade.php` (yield meta description)
- CSS: `.detail-thumb--photo` (baru, untuk thumbnail asli)

**Catatan status Fase 2**: Iterasi A, B, C sudah selesai semua sesuai rencana di `RENCANA-PENGEMBANGAN.md` §7. Ini menandai **seluruh rencana pengembangan awal (Fase 1 + Fase 2) sudah tuntas**, kecuali Iterasi 11 opsional (CRUD Pengguna) yang memang di luar cakupan inti.

**Selanjutnya**: menunggu review Anda. Tidak ada iterasi terjadwal berikutnya kecuali Anda memberi arahan baru (mis. Iterasi 11 opsional, atau permintaan pengembangan tambahan).

---

## 2026-08-19 — Fase 2, Iterasi B: Rapikan Halaman `/projects`

**Iterasi**: Fase 2 / B
**Status**: ✅ Selesai — menunggu review Anda sebelum lanjut ke Iterasi C

**Ringkasan**:
- `Site\ProjectController@index` diubah dari `Project::query()->ordered()->get()` (tanpa batas) menjadi **pagination server-side** (`paginate(9)->withQueryString()`).
- Filter kategori diubah dari **client-side JS murni** (`data-filter` + toggle `.is-hidden`, hanya menyaring kartu yang sudah dimuat) menjadi **server-side via query string** (`?category=umkm`) — supaya kompatibel dengan pagination. Kategori tidak valid otomatis di-fallback ke "Semua" (whitelist di `ProjectController::CATEGORIES`).
- Filter kini berupa tautan `<a>` biasa (bukan `<button>` + JS), tetap accessible tanpa JavaScript. `resources/js/site.js` disesuaikan agar handler filter client-side (dipakai teaser Portofolio di beranda, yang tetap tidak dipaginasi & tetap client-side dengan sengaja) melewati tombol berupa `<a>`.
- Pagination memakai view kustom `partials/site/pagination.blade.php` bergaya tema publik (`.pagination`, `.pagination-link`), bukan pagination Tailwind bawaan Laravel yang dipakai admin — supaya tidak clash dengan desain non-Tailwind di `site.css`.
- Tambah empty-state saat filter kategori tidak menghasilkan proyek apa pun, dengan tautan "Lihat semua proyek".

**Verifikasi yang sudah dilakukan**:
- `npm run build` sukses, `php artisan view:cache` sukses (semua Blade valid).
- **Uji filter nyata**: `?category=landing-page` menampilkan hanya 1 proyek yang sesuai & tombol filter aktif ter-highlight benar; `?category=invalid` fallback ke "Semua" (7 proyek).
- **Uji pagination nyata**: menambah sementara 6 proyek uji (total 13, 10 di antaranya kategori UMKM) → halaman 1 menampilkan 9 kartu + navigasi pagination muncul, halaman 2 menampilkan sisa 4 kartu, kombinasi filter+pagination bekerja benar (`?category=umkm&page=2` konsisten, query string filter ikut terbawa berkat `withQueryString()`) → seluruh data uji dihapus, halaman `/projects` kembali menampilkan 7 proyek tanpa pagination.
- Regresi penuh: halaman publik & admin terkait tetap 200 setelah perubahan.

**File terdampak**:
- `app/Http/Controllers/Site/ProjectController.php` (pagination + filter server-side)
- `resources/views/projects/index.blade.php` (filter jadi `<a>`, empty-state, pagination)
- `resources/views/partials/site/pagination.blade.php` (baru)
- `resources/css/site.css` (`.pagination*`)
- `resources/js/site.js` (guard filter client-side untuk tombol `<a>`)

**Selanjutnya**: menunggu review Anda. Setelah disetujui, lanjut ke **Iterasi C — Rapikan Halaman Detail Project** (thumbnail gambar asli opsional, proyek terkait, meta description, breadcrumb).

---

## 2026-08-19 — Fase 2, Iterasi A: Rapikan Halaman Index

**Iterasi**: Fase 2 / A
**Status**: ✅ Selesai — menunggu review Anda sebelum lanjut ke Iterasi B

**Ringkasan**:
- Detail rencana Fase 2 (Iterasi A/B/C) ditulis lengkap di `RENCANA-PENGEMBANGAN.md` §7 (sebelumnya masih garis besar).
- Teaser Portofolio di beranda dibatasi maksimal **6 proyek featured terbaru** (`HomeController::FEATURED_PROJECTS_LIMIT`) — sebelumnya menampilkan semua proyek featured tanpa batas, akan makin panjang seiring admin menambah data.
- Tambah **empty state** (`.section-empty`, style dashed border senada tema situs) untuk section yang bisa dikosongkan admin: Layanan, Paket Harga, Kenapa Kami, Portofolio (teaser beranda). Section Klien disembunyikan total saat kosong (bukan tampil sebagai strip marquee kosong, karena section ini tidak punya heading). Section Hero & Galeri sudah punya fallback graceful sejak Fase 1 (Hero: fallback slide statis; Galeri: kartu "segera hadir" selalu tampil), tidak perlu perubahan.
- Tidak ada perubahan skema database pada iterasi ini.

**Catatan data dummy untuk Anda (bukan dikerjakan otomatis — di luar kewenangan saya mengarang data bisnis)**:
- 8 nama **Klien & Partner** masih contoh generik (Nexa, Vertex, Orbita, dst) dengan ikon, bukan logo asli — kelola di menu admin **Klien & Partner**.
- 8 foto **Galeri** masih placeholder (semua memakai gambar yang sama) — ganti satu per satu lewat menu admin **Galeri**.
- **Info Kontak** (alamat/telepon/email/jam kerja) masih data contoh dari desain awal — perbarui lewat menu admin **Info Kontak** bila belum sesuai data bisnis sebenarnya.

**Verifikasi yang sudah dilakukan**:
- `npm run build` sukses, `php artisan view:cache` sukses (semua Blade valid).
- **Uji empty-state nyata**: menonaktifkan sementara seluruh data Layanan, Paket Harga, Kenapa Kami, Klien, dan featured Portofolio → pesan/empty-state yang benar tampil di masing-masing section, section Klien hilang total, section Galeri tetap menampilkan kartu "segera hadir" → seluruh data dikembalikan aktif setelah verifikasi, dicek ulang tampil normal.
- Regresi penuh: 3 halaman publik (`/`, `/projects`, `/projects/dapur-nusantara`) dan 12 halaman admin semua tetap 200 setelah perubahan.

**File terdampak**:
- `pengembangan/RENCANA-PENGEMBANGAN.md` (§7 detail Fase 2)
- `app/Http/Controllers/Site/HomeController.php` (limit featured projects)
- `resources/views/partials/site/layanan.blade.php`, `kenapa.blade.php`, `portofolio.blade.php`, `klien.blade.php` (empty state)
- `resources/css/site.css` (`.section-empty`)

**Selanjutnya**: menunggu review Anda. Setelah disetujui, lanjut ke **Iterasi B — Rapikan Halaman `/projects`** (pagination server-side + filter kategori via query string).

---

## 2026-08-19 — Iterasi 8–10: Info Kontak + Pesan Masuk + Widget WhatsApp + Pengaturan Situs & Section

**Iterasi**: 8, 9, 10
**Status**: ✅ Selesai — Fase 1 (Admin Panel) inti sudah lengkap. Menunggu review Anda sebelum lanjut ke Fase 2 (lihat `RENCANA-PENGEMBANGAN.md` §7), atau ke Iterasi 11 opsional (CRUD Pengguna) bila diminta.

**Ringkasan Iterasi 8 (Info Kontak & Pesan Masuk)**:
- Tabel + model `ContactMessage` (name, email, phone, service_interest, message, status new/read/replied).
- **Form kontak publik disambungkan untuk pertama kali** — sebelumnya `kontak.blade.php` tidak punya `action`/`method`/`name` sama sekali (murni tampilan statis). Sekarang: `POST /kontak` → `Site\ContactController@store` (validasi via `StoreContactMessageRequest`), redirect kembali ke `#kontak` dengan pesan sukses, plus tampilan error & `old()` per field.
- Admin "Info Kontak": form pengaturan (grup `settings`: `contact` — alamat, telepon, email, jam kerja), dipakai baik oleh halaman admin maupun `partials/site/kontak.blade.php`.
- Admin "Pesan Masuk": index dengan kartu ringkasan (Baru/Dibaca/Dibalas), pagination, filter status + pencarian, halaman detail (`show`) yang otomatis menandai pesan "Baru"→"Dibaca" saat dibuka, ubah status manual, dan hapus.

**Ringkasan Iterasi 9 (Widget WhatsApp)**:
- Form pengaturan (grup `settings`: `wa_widget` — nomor WA, pesan default, label/judul/isi promo, switch aktifkan modal promo).
- `partials/site/wa-widget.blade.php` dirender dari `Setting` langsung di partial (bukan lewat controller, karena widget ini tampil di semua halaman lewat `layouts/site.blade.php`, bukan cuma beranda). Saat "modal promo" dimatikan admin, FAB otomatis jadi tautan langsung ke chat WhatsApp (bukan `<button>` pembuka modal) — `resources/js/site.js` disesuaikan agar logika tampil/sembunyikan FAB saat scroll tidak lagi bergantung pada elemen modal yang mungkin tidak dirender.

**Ringkasan Iterasi 10 (Pengaturan Situs & Pengaturan Section)**:
- Satu halaman admin "Pengaturan Situs" berisi dua form independen:
  1. **Branding & Footer** (grup `settings`: `site` — nama situs, logo terang/gelap upload, deskripsi footer, link Instagram/GitHub). Logo dipakai dinamis di `partials/site/nav.blade.php`; deskripsi footer, tahun copyright, dan link sosial dipakai dinamis di `partials/site/footer.blade.php`.
  2. **Tampilan Section** (grup `settings`: `sections`) — 9 switch modern (checkbox + Tailwind `peer`) untuk show/hide independen: hero, layanan, paket_harga, kenapa, portofolio, klien, galeri, kontak, wa_widget. `home.blade.php` membungkus tiap `@include` section dengan pengecekan flag ini; `partials/site/layanan.blade.php` menerima dua flag terpisah (`showLayanan`/`showPaketHarga`) karena grid layanan & paket harga berbagi satu file partial tapi perlu di-toggle independen; `wa_widget` mengontrol partial WA secara site-wide.
- Sidebar admin dirombak jadi berkelompok: **Menu** (Dashboard), **Konten Halaman Utama** (7 menu), **Kontak** (2 menu), **Pengaturan** (Widget WhatsApp, Pengaturan Situs, Pengguna). Grup "Segera Hadir" sudah kosong dan dihapus — seluruh section halaman index kini punya menu admin.

**Verifikasi yang sudah dilakukan**:
- `npm run build` sukses, `php artisan view:cache` sukses (semua Blade valid), lalu di-clear lagi.
- Smoke test via `php artisan serve` + `curl`: seluruh halaman admin baru (`contact-settings`, `contact-messages`, `wa-widget-settings`, `settings`) 200; halaman publik (`/`, `/projects`) tetap 200.
- **Uji end-to-end form kontak publik**: submit dari halaman beranda (dengan token CSRF dari form itu sendiri, karena `layouts/site.blade.php` memang tidak memuat meta `csrf-token` global — form kontak sudah mandiri dengan `@csrf`) → pesan langsung muncul di admin "Pesan Masuk", status otomatis berubah "Baru"→"Dibaca" saat dibuka.
- **Uji toggle Pengaturan Section**: mematikan switch "Klien & Partner" → section `#klien` hilang dari HTML beranda, section lain (`#kenapa`, `#galeri`, `#home`) tetap tampil → dinyalakan lagi, section kembali muncul.
- **Uji upload branding**: ganti logo situs + deskripsi footer via admin → langsung berubah di halaman publik.
- Semua data & pengaturan hasil uji (pesan kontak, file logo upload, deskripsi footer) dibersihkan/direset kembali ke kondisi semula setelah verifikasi.

**File terdampak (ringkas)**:
- Migrasi: `create_contact_messages_table`
- Model: `ContactMessage`
- Controller: `Site\ContactController` (baru), `Admin\ContactMessageController`, `Admin\ContactSettingsController`, `Admin\WaWidgetSettingsController`, `Admin\SiteSettingsController`
- Request: `StoreContactMessageRequest`
- Routes: `routes/web.php` (`contact.store`), `routes/admin.php` (contact-settings, contact-messages, wa-widget-settings, settings/branding, settings/sections)
- View admin: `admin/contact-settings/edit.blade.php`, `admin/contact-messages/{index,show}.blade.php`, `admin/wa-widget-settings/edit.blade.php`, `admin/settings/edit.blade.php`, `layouts/admin.blade.php` (sidebar dirombak jadi grouped)
- View publik: `partials/site/kontak.blade.php` (form disambungkan), `partials/site/wa-widget.blade.php`, `partials/site/nav.blade.php`, `partials/site/footer.blade.php`, `partials/site/layanan.blade.php` (flag show/hide), `home.blade.php` (wrapper toggle section), `HomeController`
- Asset: `resources/css/site.css` (`.form-error`, `.form-alert`), `resources/js/site.js` (fab visibility decoupled dari modal)

**Selanjutnya**: Fase 1 (Admin Panel) untuk seluruh section halaman index sudah selesai. Menunggu arahan Anda: lanjut ke **Fase 2 — rapikan data halaman index/projects/detail project** (`RENCANA-PENGEMBANGAN.md` §7), atau kerjakan dulu **Iterasi 11 opsional** (lengkapi CRUD Pengguna + tutup registrasi publik) bila diinginkan.

---

## 2026-08-19 — Iterasi 4–7: Kenapa Kami + Portofolio (poles) + Klien & Partner + Galeri

**Iterasi**: 4, 5, 6, 7
**Status**: ✅ Selesai — menunggu review Anda sebelum lanjut ke Iterasi 8

**Ringkasan Iterasi 4 (Kenapa Kami)**:
- Tabel + model `WhyUsItem` (icon, title, description, is_active, sort_order).
- Admin CRUD di `/admin/why-us-items` (grid card, pagination, filter status + pencarian, toggle aktif).
- Form pengaturan gambar & tombol CTA (grup `settings`: `why_us` — upload gambar, teks & tautan tombol) di halaman index yang sama, disimpan via `PUT /admin/why-us-items-settings`.
- Seeder 6 item existing dipindah ke DB. `partials/site/kenapa.blade.php` dirender dari DB, gambar CTA fallback ke `assets/why.png` bila admin belum unggah gambar sendiri.
- **Bug ditemukan & diperbaiki**: method `Setting::all(string $group)` (dibuat di Iterasi 0) bentrok dengan method bawaan Eloquent `Model::all()` — menyebabkan fatal error di seluruh halaman yang memuat `Setting` (termasuk beranda publik). Di-rename jadi `Setting::group()`, sudah diverifikasi ulang lewat smoke test penuh setelah perbaikan.

**Ringkasan Iterasi 5 (Portofolio — poles CRUD existing)**:
- Tidak ada perubahan skema. `Admin\ProjectController@index` ditambah pagination 10/hal, filter kategori + status + featured, pencarian judul.
- Tambah aksi `toggle-featured` (switch modern, menggantikan checkbox lama) untuk kolom "Beranda". View `admin/projects/index.blade.php` disamakan gaya dengan modul-modul baru (animasi `.reveal`, filter bar, pagination).

**Ringkasan Iterasi 6 (Klien & Partner)**:
- Tabel + model `Client` (name, icon Lucide, logo_path upload opsional, is_active, sort_order).
- Admin CRUD di `/admin/clients` dengan upload logo (fallback ke ikon Lucide bila tanpa logo), pagination, filter status + pencarian, toggle aktif.
- Seeder 8 klien existing (ikon Lucide) dipindah ke DB. `partials/site/klien.blade.php` (marquee) dirender dari DB, termasuk duplikasi list untuk animasi loop tanpa jeda.

**Ringkasan Iterasi 7 (Galeri)**:
- Tabel + model `GalleryItem` (title, image_path upload wajib, size_variant normal/wide/tall, is_active, sort_order).
- Admin CRUD di `/admin/gallery-items` (grid thumbnail, pagination 12/hal, filter status + pencarian, toggle aktif, ganti foto saat edit tanpa wajib re-upload).
- Seeder: karena 8 item lama murni ilustrasi CSS (bukan foto asli), diseed dengan gambar placeholder (`assets/why.png` disalin ke `storage/gallery/placeholder-*.png` per item, sesuai keputusan §5.5 rencana) — admin tinggal mengganti fotonya lewat form edit. Kartu "segera hadir" di ujung grid tetap statis (permanen) seperti desain asli.
- `partials/site/galeri.blade.php` dirender dari DB dengan class ukuran (`wide`/`tall`) mengikuti `size_variant`.

**Verifikasi yang sudah dilakukan**:
- `npm run build` sukses. `php artisan view:cache` sukses (semua Blade valid), lalu di-clear lagi.
- Smoke test penuh via `php artisan serve` + `curl` setelah perbaikan bug `Setting::all()`: halaman publik (`/`, `/projects`) 200; seluruh index/create/edit untuk `why-us-items`, `clients`, `gallery-items`, `projects`, `hero-slides`, `services`, `pricing-packages`, `dashboard` 200.
- Uji fungsional end-to-end: toggle switch (PATCH via header CSRF) berhasil ubah status; create Client baru (icon only) berhasil (302); create Gallery Item dengan upload gambar multipart berhasil (302) dan file tersimpan di `storage/app/public/gallery`. Data uji dihapus lagi setelah verifikasi, state DB kembali ke hasil seed (6 why-us-items, 8 clients, 8 gallery-items).
- Konten dinamis halaman utama diverifikasi tampil ("Harga Terjangkau", "Nexa"/"Vertex"/"Kinetic" ×2 untuk marquee loop, judul galeri ×2 untuk alt+overlay, 8 referensi `storage/gallery`).

**File terdampak (ringkas)**:
- Migrasi: `create_why_us_items_table`, `create_clients_table`, `create_gallery_items_table`
- Model: `WhyUsItem`, `Client`, `GalleryItem`, `Setting` (fix method `all`→`group`)
- Controller: `Admin\WhyUsItemController` (+ `updateSettings`), `Admin\ClientController`, `Admin\GalleryItemController`, `Admin\ProjectController` (update: filter+pagination+`toggleFeatured`)
- Request: `Store/UpdateWhyUsItemRequest`, `Store/UpdateClientRequest`, `Store/UpdateGalleryItemRequest`
- Routes: `routes/admin.php` (resource + toggle untuk 3 modul baru, `why-us-items-settings`, `projects.toggle-featured`)
- View admin: `admin/why-us-items/*`, `admin/clients/*`, `admin/gallery-items/*`, `admin/projects/index.blade.php` (redesain), `layouts/admin.blade.php` (menu: Kenapa Kami/Klien & Partner/Galeri pindah ke aktif)
- View publik: `partials/site/kenapa.blade.php`, `partials/site/klien.blade.php`, `partials/site/galeri.blade.php`, `home.blade.php`, `HomeController`
- Seeder: `WhyUsItemSeeder`, `ClientSeeder`, `GalleryItemSeeder`, `DatabaseSeeder` (update)

**Selanjutnya**: menunggu review Anda. Setelah disetujui, lanjut ke **Iterasi 8 — Menu "Info Kontak" & "Pesan Masuk"** (termasuk menghubungkan form kontak publik yang saat ini belum punya `action`/controller).

---

## 2026-08-19 — Iterasi 0–3: Fondasi Admin + Hero + Layanan + Paket Harga

**Iterasi**: 0, 1, 2, 3
**Status**: ✅ Selesai — menunggu review Anda sebelum lanjut ke Iterasi 4

**Ringkasan Iterasi 0 (Fondasi)**:
- Tambah kolom `role` (`user`/`admin`, default `user`) di tabel `users` + middleware `EnsureUserIsAdmin` (alias `admin`), diterapkan ke seluruh `routes/admin.php`. User seed `admin@nexttime.test` dipromosikan jadi `role=admin`.
- Tabel `settings` (key-value: `group`,`key`,`value`,`type`) + model `Setting` dengan helper `get()`/`set()`/`all()` (di-cache), siap dipakai iterasi lanjutan (Info Kontak, Widget WA, Pengaturan Situs, Pengaturan Section).
- Komponen bersama: `<x-admin.switch>` (toggle switch modern, submit via form PATCH) dan utility scroll-reveal (`resources/js/app.js` + class `.reveal` di `resources/css/app.css`) — elemen list muncul saat discroll masuk viewport dan tersembunyi lagi saat keluar.
- Restyle halaman Login & `layouts/guest.blade.php` (split panel branding NextTime, konsisten dengan tema admin).
- Update sidebar `layouts/admin.blade.php`: menu final (Dashboard, Hero/Slider, Layanan, Paket Harga, Portofolio, Pengguna aktif; Kenapa Kami, Klien & Partner, Galeri, Pesan Masuk, Pengaturan Situs masih "Segera Hadir").
- `php artisan storage:link` dijalankan untuk kebutuhan upload gambar di iterasi mendatang.

**Ringkasan Iterasi 1 (Hero / Slider)**:
- Tabel + model `HeroSlide` (badge, title, title_highlight, description, CTA utama & kedua, is_active, sort_order).
- Admin CRUD penuh di `/admin/hero-slides` (index dengan pagination 10/hal, filter status + pencarian, create, edit, delete, toggle aktif via switch).
- Seeder 3 slide existing dipindah ke DB. `HomeController` & `partials/site/hero.blade.php` dirender dari DB (fallback statis jika kosong).

**Ringkasan Iterasi 2 (Layanan)**:
- Tabel + model `Service` (icon, title, description, is_active, sort_order).
- Admin CRUD di `/admin/services` (grid card, pagination, filter status + pencarian, toggle aktif).
- Seeder 10 layanan existing dipindah ke DB. Grid layanan di `partials/site/layanan.blade.php` dirender dari DB.

**Ringkasan Iterasi 3 (Paket Harga)**:
- Tabel + model `PricingPackage` (name, tier, icon, price_prefix/amount/unit, features json, cta_text/link, is_best_seller, is_active, sort_order).
- Admin CRUD di `/admin/pricing-packages` (filter tier + status + pencarian, form fitur "satu per baris", toggle Best Seller & aktif).
- Seeder 4 paket existing (Silver/Gold/Diamond/Custom) dipindah ke DB. Blok paket harga di `partials/site/layanan.blade.php` dirender dari DB, termasuk styling per tier & badge Best Seller.

**Verifikasi yang sudah dilakukan**:
- `npm run build` sukses tanpa error.
- `php artisan view:cache` sukses (semua Blade tervalidasi tanpa error sintaks), lalu di-clear lagi untuk dev.
- Smoke test via `php artisan serve` + `curl`: halaman publik (`/`, `/login`, `/projects`) 200; `/admin/*` redirect (302) untuk tamu; setelah login admin, seluruh index/create/edit `hero-slides`, `services`, `pricing-packages`, `projects` 200; user dengan `role=user` mendapat **403** saat akses `/admin/dashboard` (middleware admin berfungsi).
- Konten dinamis halaman utama diverifikasi tampil ("Wujudkan Ide Anda", "Company Profile", "Gold", 4 kartu paket harga).

**File terdampak (ringkas)**:
- Migrasi: `add_role_to_users_table`, `create_settings_table`, `create_hero_slides_table`, `create_services_table`, `create_pricing_packages_table`
- Model: `User` (update), `Setting`, `HeroSlide`, `Service`, `PricingPackage`
- Middleware: `EnsureUserIsAdmin` (+ alias di `bootstrap/app.php`)
- Controller: `Admin\HeroSlideController`, `Admin\ServiceController`, `Admin\PricingPackageController`
- Request: `Store/UpdateHeroSlideRequest`, `Store/UpdateServiceRequest`, `Store/UpdatePricingPackageRequest`
- Routes: `routes/admin.php` (resource + toggle untuk 3 modul baru)
- View admin: `admin/hero-slides/*`, `admin/services/*`, `admin/pricing-packages/*`, `components/admin/switch.blade.php`, `layouts/admin.blade.php` (menu), `layouts/guest.blade.php`, `auth/login.blade.php`
- View publik: `partials/site/hero.blade.php`, `partials/site/layanan.blade.php`, `home.blade.php`
- Seeder: `HeroSlideSeeder`, `ServiceSeeder`, `PricingPackageSeeder`, `DatabaseSeeder` (update)
- Asset: `resources/css/app.css`, `resources/js/app.js`

**Selanjutnya**: menunggu review Anda. Setelah disetujui, lanjut ke **Iterasi 4 — Menu "Kenapa Kami"**.

---

## 2026-08-19 — Perencanaan

**Iterasi**: — (pra-iterasi)
**Status**: ✅ Selesai — menunggu review rencana

**Ringkasan**:
- Audit codebase awal (struktur Laravel 13 + Breeze + Tailwind + Alpine, konfigurasi MySQL Laragon di `.env`, seluruh section `home.blade.php`, CRUD Projects yang sudah ada, layout admin & site).
- Dibuat folder `pengembangan/` di root beserta 3 dokumen: `RENCANA-PENGEMBANGAN.md`, `LOG-AKTIVITAS.md` (file ini), `ERD.md`.
- Rencana pengembangan Fase 1 (Admin Panel, 11 iterasi + 1 opsional) dan garis besar Fase 2 (rapikan data publik, 3 iterasi) tersusun.

**File terdampak**:
- `pengembangan/RENCANA-PENGEMBANGAN.md` (baru)
- `pengembangan/LOG-AKTIVITAS.md` (baru)
- `pengembangan/ERD.md` (baru)

**Belum ada perubahan kode aplikasi** (migrasi, model, controller, view) pada tahap ini — menunggu persetujuan rencana dari Anda.

**Selanjutnya**: menunggu review & persetujuan `RENCANA-PENGEMBANGAN.md`, termasuk konfirmasi keputusan teknis di §5 (kolom `role`, penutupan `/register` publik, dsb) sebelum Iterasi 0 dimulai.
