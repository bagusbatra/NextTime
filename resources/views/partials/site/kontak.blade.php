{{-- Kontak — $contactInfo: array{address, phone, email, work_hours} --}}
<section class="kontak" id="kontak">
  <div class="kontak-inner">
    <div class="kontak-info">
      <span class="section-label">Hubungi Kami</span>
      <h2 class="section-title">Mari Mulai<br>Proyek Bersama</h2>
      <p class="section-sub">Ceritakan kebutuhan Anda dan kami akan memberikan solusi terbaik. Konsultasi pertama gratis!</p>
      <div class="info-item">
        <div class="info-icon">📍</div>
        <div>
          <h4>Alamat</h4>
          <p>{{ $contactInfo['address'] }}</p>
        </div>
      </div>
      <div class="info-item">
        <div class="info-icon">📞</div>
        <div>
          <h4>Telepon</h4>
          <p>{{ $contactInfo['phone'] }}</p>
        </div>
      </div>
      <div class="info-item">
        <div class="info-icon">✉️</div>
        <div>
          <h4>Email</h4>
          <p>{{ $contactInfo['email'] }}</p>
        </div>
      </div>
      <div class="info-item">
        <div class="info-icon">🕐</div>
        <div>
          <h4>Jam Kerja</h4>
          <p>{{ $contactInfo['work_hours'] }}</p>
        </div>
      </div>
    </div>

    <form class="kontak-form" method="POST" action="{{ route('contact.store') }}">
      @csrf

      @if (session('contact_status') === 'success')
        <div class="form-alert form-alert--success">Pesan Anda berhasil terkirim. Tim kami akan segera menghubungi Anda.</div>
      @endif

      <div class="form-row">
        <div class="form-group">
          <label for="nama">Nama Lengkap</label>
          <input type="text" id="nama" name="name" value="{{ old('name') }}" placeholder="Contoh: Budi Santoso" />
          @error('name') <span class="form-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="email@perusahaan.com" />
          @error('email') <span class="form-error">{{ $message }}</span> @enderror
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label for="telepon">Nomor Telepon</label>
          <input type="tel" id="telepon" name="phone" value="{{ old('phone') }}" placeholder="+62 8xx-xxxx-xxxx" />
          @error('phone') <span class="form-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
          <label for="layanan">Layanan yang Diminati</label>
          <select id="layanan" name="service">
            <option value="" @selected(old('service') === null)>Pilih layanan...</option>
            @foreach (['Desain UI/UX', 'Pengembangan Web', 'Aplikasi Mobile', 'Fotografi & Videografi', 'Digital Marketing', 'Maintenance & Support', 'Lainnya'] as $option)
              <option value="{{ $option }}" @selected(old('service') === $option)>{{ $option }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="pesan">Pesan / Deskripsi Proyek</label>
        <textarea id="pesan" name="message" rows="5" placeholder="Ceritakan kebutuhan proyek Anda secara singkat...">{{ old('message') }}</textarea>
        @error('message') <span class="form-error">{{ $message }}</span> @enderror
      </div>
      <button type="submit" class="btn-submit">Kirim Pesan →</button>
    </form>
  </div>
</section>
