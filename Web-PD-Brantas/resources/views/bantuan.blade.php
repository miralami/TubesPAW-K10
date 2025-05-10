@extends('layouts.app')

@section('title','Bantuan')

@push('styles')
<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet"/>
<style>
/* ==== Hero glass card ==== */
.hero-wrap{
    background:#0d0d15;
    padding-top:120px;   /* jarak dari navbar */
    padding-bottom:80px;
}
.hero-card{
    position:relative;
    border-radius:22px;
    overflow:hidden;
    padding:80px 40px;
    color:#fff;
    text-align:center;
    backdrop-filter:blur(6px);
}
.hero-card::before{
    content:"";
    position:absolute;inset:0;
    background:radial-gradient(800px 600px at 80% 20%,rgba(75,132,255,.55),rgba(0,0,0,.4));
    mix-blend-mode:screen;           /* efek “glow” */
    pointer-events:none;
}
/* ==== FAQ card ==== */
.faq-card{
    border-radius:14px;
}
.accordion-button:not(.collapsed){
    background:#f5f7ff;
}
</style>
@endpush

@section('content')

{{-- ===== Hero ===== --}}
<section class="hero-wrap">
    <div class="container">
        <div class="hero-card shadow-lg mx-auto" style="max-width:980px" data-aos="zoom-out">
            <small class="text-uppercase fw-semibold text-info">PD. Brantas Help Center</small>
            <h1 class="display-5 fw-bold mb-3">Kami Siap Membantu</h1>
            <p class="lead mb-4">Temukan jawaban cepat atau hubungi tim kami.</p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="mailto:support@pdbrantas.co.id" class="btn btn-light fw-semibold px-4">
                    Kirim Email
                </a>
                <a href="https://wa.me/6281234567890" target="_blank"
                   class="btn btn-outline-light text-white px-4">
                    WhatsApp
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ===== FAQ ===== --}}
<section class="py-5 bg-light">
    <div class="container" data-aos="fade-up">
        <h2 class="fw-bold text-center mb-5">Frequently Asked Questions</h2>

        @php
            $faqs = [
                ['Bagaimana cara memesan produk?',  'Buka katalog, tambahkan ke keranjang, lalu proses checkout.'],
                ['Metode pembayaran apa saja?',     'Transfer bank & Virtual Account.'],
                ['Apakah bisa PO dalam jumlah besar?','Bisa, hubungi tim sales kami untuk penawaran khusus.'],
                ['Berapa lama pengiriman?',         '2-4 hari kerja untuk wilayah Jawa; luar Jawa menyesuaikan.'],
                ['Apakah produk bersertifikasi?',   'Semua item memenuhi standar institusi pemerintah.'],
                ['Bisakah saya mengambil barang sendiri?', 'Ya, pick-up di gudang Surabaya dengan janji temu.'],
            ];
            // Bagi jadi 2 kolom
            $chunks = array_chunk($faqs, ceil(count($faqs)/2));
        @endphp

        <div class="row g-4">
        @foreach($chunks as $col)
            <div class="col-md-6">
                <div class="accordion faq-card shadow-sm" id="faqCol{{ $loop->index }}">
                    @foreach($col as $i => $f)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="q{{ $loop->parent->index }}{{ $i }}">
                                <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#a{{ $loop->parent->index }}{{ $i }}">
                                    {{ $f[0] }}
                                </button>
                            </h2>
                            <div id="a{{ $loop->parent->index }}{{ $i }}" class="accordion-collapse collapse"
                                 data-bs-parent="#faqCol{{ $loop->parent->index }}">
                                <div class="accordion-body">{{ $f[1] }}</div>
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
