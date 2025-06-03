{{-- resources/views/bantuan.blade.php --}}
@extends('layouts.app')

@section('title', 'Bantuan')

@push('styles')
<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet"/>

<style>
/* ================================
   Variabel Warna (jika belum di styles.css, tambahkan di sini)
   ================================ */
:root {
  --br-navy:        #0D1A3F;   /* Oxford Blue */
  --br-light:       #F7F7FF;   /* Ghost White */
  --br-accent:      #20B2AA;   /* Light Sea Green */
  --br-accent-dark: #199E97;   /* Sea Green Lebih Gelap */
  --br-alert:       #C03221;   /* Engineering Orange */
}

/* ================================
   Hero Section (Redesign)
   ================================ */
.hero-wrap {
  background: linear-gradient(
    135deg,
    var(--br-navy),
    var(--br-accent)
  );
  padding-top: 120px;   /* jarak dari navbar */
  padding-bottom: 80px;
}

.hero-card {
  position: relative;
  background: rgba(255, 255, 255, 0.05);
  border-radius: 22px;
  overflow: hidden;
  padding: 80px 40px;
  color: var(--br-light);
  text-align: center;
  backdrop-filter: blur(8px);
  max-width: 900px;
  margin: 0 auto;
  box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.4);
  animation: fadeIn 1s ease forwards;
}

.hero-card::before {
  content: "";
  position: absolute;
  inset: 0;
  background: radial-gradient(
    800px 600px at 20% 30%,
    rgba(255, 255, 255, 0.15),
    transparent
  );
  mix-blend-mode: overlay;
  pointer-events: none;
}

.hero-card h1 {
  font-size: 2.5rem;
  margin-bottom: 1rem;
  color: var(--br-light);
}

.hero-card .lead {
  font-size: 1.125rem;
  margin-bottom: 2rem;
  color: rgba(255, 255, 255, 0.9);
}

/* Tombol di Hero */
.hero-card .btn-accent {
  background-color: var(--br-accent);
  color: var(--br-light);
  border: 2px solid var(--br-accent);
  transition: background-color 0.2s ease, color 0.2s ease;
}

.hero-card .btn-accent:hover {
  background-color: var(--br-accent-dark);
  color: var(--br-light);
}

.hero-card .btn-outline-light {
  color: var(--br-light);
  border: 2px solid var(--br-light);
  background: transparent;
  transition: background 0.2s ease, color 0.2s ease;
}

.hero-card .btn-outline-light:hover {
  background-color: var(--br-light);
  color: var(--br-navy);
}

/* ================================
   FAQ Section (Redesign)
   ================================ */
.faq-section {
  background-color: var(--br-light);
  padding: 3rem 0;
}

.faq-section h2 {
  color: var(--br-navy);
  font-size: 2rem;
  margin-bottom: 2rem;
  animation: fadeIn 0.8s ease forwards;
}

.accordion.faq-card {
  border-radius: 14px;
  overflow: hidden;
}

.accordion-item {
  border: none;
  margin-bottom: 0.5rem;
}

.accordion-button {
  background-color: var(--br-light);
  color: var(--br-navy);
  font-weight: 500;
  padding: 1rem;
  transition: background 0.2s ease, color 0.2s ease;
}

.accordion-button:not(.collapsed) {
  background-color: var(--br-accent);
  color: var(--br-light);
}

.accordion-button::after {
  filter: brightness(0.9);
}

/* Body answer */
.accordion-body {
  background-color: #fff;
  color: var(--br-navy);
  padding: 1rem 1.5rem;
  border-top: 1px solid #e2e2e2;
}

.accordion-body p {
  margin-bottom: 0;
}

/* Hover pada kartu FAQ */
.accordion-item:hover .accordion-button {
  background-color: rgba(32, 178, 170, 0.15);
}

/* Animasi Fade-In */
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to   { opacity: 1; transform: translateY(0); }
}

.fade-in {
  opacity: 0;
  animation: fadeIn 1s ease forwards;
}

/* ================================
   Responsive Adjustments
   ================================ */
@media (max-width: 768px) {
  .hero-card {
    padding: 60px 20px;
  }

  .hero-card h1 {
    font-size: 2rem;
  }

  .hero-card .lead {
    font-size: 1rem;
  }
}
</style>
@endpush

@section('content')

{{-- ===== Hero Redesigned ===== --}}
<section class="hero-wrap">
  <div class="container">
    <div class="hero-card">
      <small class="text-uppercase fw-semibold text-light-accent">
        PD. Brantas Help Center
      </small>
      <h1 class="display-5 fw-bold">Kami Siap Membantu</h1>
      <p class="lead">
        Temukan jawaban cepat atau hubungi tim kami.
      </p>
      <div class="d-flex justify-content-center gap-3 flex-wrap">
        <a href="mailto:afifnursena08@gmail.com" class="btn btn-light px-4 fw-semibold">
          Kirim Email
        </a>
        <a href="https://wa.me/6281533369512" target="_blank"
           class="btn btn-accent px-4">
          WhatsApp
        </a>
      </div>
    </div>
  </div>
</section>

{{-- ===== FAQ Redesigned ===== --}}
<section class="faq-section">
  <div class="container">

    <h2 class="text-center fade-in">Frequently Asked Questions</h2>

    @php
      $faqs = [
        ['Bagaimana cara memesan produk?', 'Buka katalog, tambahkan ke keranjang, lalu proses checkout.'],
        ['Metode pembayaran apa saja?', 'Transfer bank & Virtual Account.'],
        ['Apakah bisa PO dalam jumlah besar?', 'Bisa, hubungi tim sales kami untuk penawaran khusus.'],
        ['Berapa lama pengiriman?', '2-4 hari kerja untuk wilayah Jawa; luar Jawa menyesuaikan.'],
        ['Apakah produk bersertifikasi?', 'Semua item memenuhi standar institusi pemerintah.'],
        ['Bisakah saya mengambil barang sendiri?', 'Ya, pick-up di gudang Surabaya dengan janji temu.'],
      ];
      $chunks = array_chunk($faqs, ceil(count($faqs)/2));
    @endphp

    <div class="row g-4">
      @foreach($chunks as $col)
        <div class="col-md-6">
          <div class="accordion faq-card shadow-sm fade-in" id="faqCol{{ $loop->index }}">
            @foreach($col as $i => $f)
              <div class="accordion-item">
                <h2 class="accordion-header" id="q{{ $loop->parent->index }}{{ $i }}">
                  <button class="accordion-button collapsed" type="button"
                          data-bs-toggle="collapse"
                          data-bs-target="#a{{ $loop->parent->index }}{{ $i }}"
                          aria-expanded="false"
                          aria-controls="a{{ $loop->parent->index }}{{ $i }}">
                    {{ $f[0] }}
                  </button>
                </h2>
                <div id="a{{ $loop->parent->index }}{{ $i }}"
                     class="accordion-collapse collapse"
                     aria-labelledby="q{{ $loop->parent->index }}{{ $i }}"
                     data-bs-parent="#faqCol{{ $loop->parent->index }}">
                  <div class="accordion-body">
                    <p>{{ $f[1] }}</p>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>

@endsection

@push('scripts')
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
  AOS.init({ mirror: false, delay: 50, offset: 120 });
</script>
@endpush
