@extends('layouts.app')

@section('title', 'Welcome to PD. Brantas')

@push('styles')
<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" />
<style>
    /* hover card */
    .fancy-card{
        transition:.3s ease;
        background:#fff;
    }
    .fancy-card:hover{
        transform:translateY(-6px);
        box-shadow:0 12px 28px rgba(0,0,0,.15);
    }
    .hero{
        height:100vh;
        background:
            linear-gradient(rgba(0,0,60,.65),rgba(0,0,60,.65)),
            url('/images/hero-pic.jpeg') center/cover no-repeat;
    }
</style>
@endpush

@section('content')

{{-- ===== Hero ===== --}}
<section class="hero d-flex align-items-center text-white text-center">
    <div class="container" data-aos="fade-down">
        <h1 class="display-3 fw-bold mb-3">PD. Brantas</h1>
        <p class="lead mb-4">Supplier perlengkapan aparatur negara terpercaya</p>
        <a href="{{ route('catalog.index') }}" class="btn btn-outline-light btn-lg shadow">
            Lihat Katalog
        </a>
    </div>
</section>

{{-- ===== About ===== --}}
<section class="py-5 bg-light">
    <div class="container" data-aos="fade-up">
        <h2 class="text-center mb-4 fw-bold">Tentang Kami</h2>
        <p class="text-center mx-auto mb-5" style="max-width:760px">
    PD. Brantas menyediakan produk-produk dengan kualitas terbaik dan harga bersaing.
    Kami berkomitmen untuk memberikan pelayanan yang terbaik kepada pelanggan kami.
    Kami memiliki pengalaman lebih dari
    <br> <br>
    <b
        class="d-inline-block"
        style="font-size: 2rem; color: #dc3545; background: #ffeaea; padding: 4px 10px; border-radius: 6px;"
        data-aos="zoom-in"
        data-aos-delay="500">
        10 TAHUN
    </b><br> <br>
    dalam melayani pelanggan institusi pemerintah dan swasta.
</p>


        <div class="row text-center gy-4">
            <div class="col-md-4" data-aos="zoom-in" data-aos-delay="100">
                <i class="bi bi-shield-lock fs-1 text-primary mb-2"></i>
                <h6 class="fw-semibold">Kualitas Terjamin</h6>
                <p class="small text-muted">Produknya sesuai standar yang berlaku.</p>
            </div>
            <div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
                <i class="bi bi-truck fs-1 text-primary mb-2"></i>
                <h6 class="fw-semibold">Antar Barang Cepat</h6>
                <p class="small text-muted">Logistik yang kami pakai cepat dan menjangkau ke seluruh Indonesia.</p>
            </div>
            <div class="col-md-4" data-aos="zoom-in" data-aos-delay="300">
                <i class="bi bi-award fs-1 text-primary mb-2"></i>
                <h6 class="fw-semibold">Reputasi Yang Baik</h6>
                <p class="small text-muted">Sering menjadi langganan institusi.</p>
            </div>
        </div>
    </div>
</section>

{{-- ===== Featured Products ===== --}}
<section class="py-5">
    <div class="container" data-aos="fade-up">
        <h2 class="text-center mb-5 display-6 fw-bold">Produk Yang Sering di Beli</h2>

        <div class="row g-4">
            @forelse($featuredProducts->take(8) as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card h-100 border-0 fancy-card" data-aos="zoom-in-up"
                         data-aos-delay="{{ $loop->index * 80 }}">
                        <div class="ratio ratio-1x1">
                            <img src="{{ asset('storage/'.$product->image) }}"
                                 alt="{{ $product->name }}"
                                 class="rounded-top object-fit-cover">
                        </div>
                        <div class="card-body text-center d-flex flex-column">
                            <h6 class="fw-semibold mb-1">{{ $product->name }}</h6>
                            <small class="text-muted d-block mb-2">
                                {{ Str::limit($product->description, 45) }}
                            </small>
                            <div class="fw-bold text-primary mb-3">
                                Rp{{ number_format($product->price,0,',','.') }}
                            </div>
                            <a href="{{ route('products.show', $product->id) }}"
                               class="btn btn-outline-primary btn-sm mt-auto">
                                Detail
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-muted">No featured products available right now.</p>
            @endforelse
        </div>
    </div>
</section>

@endsection
