{{-- resources/views/landing.blade.php --}}
@extends('layouts.app')

@section('title', 'Welcome to PD. Brantas')

@push('styles')
<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" />
{{--
  Apabila Anda belum menaruh semua potongan CSS di styles.css,
  Anda bisa memindahkan potongan di atas ke sini.
--}}
@endpush

@section('content')

{{-- ===== Hero ===== --}}
<section class="hero">
    <div class="container hero-content">
        <h1 class="display-3 fw-bold mb-3">PD. Brantas</h1>
        <p class="lead mb-4">Supplier perlengkapan aparatur negara terpercaya</p>
        <div class="d-flex justify-content-center gap-3">
            <a href="{{ route('catalog.index') }}"
               class="btn btn-outline-light btn-lg shadow">
                Lihat Katalog
            </a>
        </div>
    </div>
</section>

{{-- ===== About ===== --}}
<section class="about-section">
    <div class="container text-center" data-aos="fade-up">
        <h2 class="fw-bold mb-4">Tentang Kami</h2>
        <p class="mx-auto mb-5" style="max-width: 760px; color: var(--br-navy);">
            PD. Brantas menyediakan produk‐produk dengan kualitas terbaik dan harga bersaing.
            Kami berkomitmen untuk memberikan pelayanan yang terbaik kepada pelanggan kami.
            Kami memiliki pengalaman lebih dari
        </p>
        <div class="text-center mb-5">
            <span class="highlight-year" data-aos="zoom-in" data-aos-delay="500">
                10 TAHUN
            </span>
        </div>
        <p class="mx-auto mb-4" style="max-width: 760px; color: var(--br-navy);">
            dalam melayani pelanggan institusi pemerintah dan swasta.
        </p>

        <div class="row gy-4">
            <div class="col-md-4" data-aos="zoom-in" data-aos-delay="100">
                <div class="feature-card">
                    <i class="bi bi-shield-lock fs-1 mb-2"></i>
                    <h6 class="fw-semibold">Kualitas Terjamin</h6>
                    <p class="small text-muted">Produknya sesuai standar yang berlaku.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
                <div class="feature-card">
                    <i class="bi bi-truck fs-1 mb-2"></i>
                    <h6 class="fw-semibold">Antar Barang Cepat</h6>
                    <p class="small text-muted">Logistik yang kami pakai cepat dan menjangkau seluruh Indonesia.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="zoom-in" data-aos-delay="300">
                <div class="feature-card">
                    <i class="bi bi-award fs-1 mb-2"></i>
                    <h6 class="fw-semibold">Reputasi yang Baik</h6>
                    <p class="small text-muted">Sering menjadi langganan institusi.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== Featured Products ===== --}}
<section class="featured-section">
    <div class="container" data-aos="fade-up">
        <h2 class="text-center mb-5 display-6 fw-bold" data-aos="fade-in">Produk yang Sering di Beli</h2>

        <div class="row g-4">
            @forelse($featuredProducts->take(8) as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card fancy-card h-100" data-aos="zoom-in-up" data-aos-delay="{{ $loop->index * 80 }}">
                        {{-- Container untuk membuat rasio 1:1 --}}
                        <div class="ratio ratio-1x1">
                            <img src="{{ asset($product->image) }}"
                                 alt="{{ $product->name }}"
                                 class="rounded-top object-fit-cover">
                        </div>
                        <div class="card-body d-flex flex-column text-center">
                            <h6 class="card-title mb-1">{{ $product->name }}</h6>
                            <small class="text-muted d-block mb-2">
                                {{ Str::limit($product->description, 45) }}
                            </small>
                            <div class="fw-bold text-primary mb-3">
                                Rp{{ number_format($product->price, 0, ',', '.') }}
                            </div>
                            <a href="{{ route('products.show', $product->id) }}"
                               class="btn btn-sm btn-outline-accent mt-auto">
                                Detail
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-muted">Belum ada produk unggulan.</p>
                </div>
            @endforelse
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
