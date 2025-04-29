@extends('layouts.app')

@section('title', 'Welcome to PD. Brantas')

@section('content')

@push('styles')
<style>
    .fancy-card {
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(6px);
}
    .fancy-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    }
    .fancy-image {
        object-fit: cover;
        width: 100%;
        height: 100%;
    }
</style>
@endpush

<!-- AOS CSS -->
<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" />

<!-- Hero Section -->
<section class="text-white text-center d-flex align-items-center justify-content-center"
         style="height: 100vh; background: linear-gradient(rgba(0,0,50,0.7), rgba(0,0,50,0.7)), url('/images/hero-pic.jpeg') center/cover no-repeat;">
    <div class="container" data-aos="fade-down" data-aos-delay="100">
        <h1 class="display-3 fw-bold mb-3">PD. Brantas</h1>
        <p class="lead mb-4">Your Trusted Supplier for Government Apparel and Equipment</p>
        <a href="{{ route('catalog.index') }}" class="btn btn-outline-light btn-lg shadow">View Products</a>
    </div>
</section>

<!-- About Section -->
<section class="py-5 bg-light">
    <div class="container" data-aos="fade-up">
        <h2 class="text-center mb-4">About Us</h2>
        <p class="text-center mx-auto mb-5" style="max-width: 800px;">
            PD. Brantas is a leading supplier of high-quality uniforms, tactical raincoats, safety footwear, and various apparel for government officials. Our commitment is to deliver trusted products that meet the demands of professional institutions.
        </p>
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <i class="bi bi-shield-lock fs-1 text-primary mb-2"></i>
                <h5>Trusted Quality</h5>
                <p class="small text-muted">Certified gear tailored for government standards.</p>
            </div>
            <div class="col-md-4 mb-4">
                <i class="bi bi-truck fs-1 text-primary mb-2"></i>
                <h5>Fast Delivery</h5>
                <p class="small text-muted">Reliable supply chain for urgent and bulk orders.</p>
            </div>
            <div class="col-md-4 mb-4">
                <i class="bi bi-award fs-1 text-primary mb-2"></i>
                <h5>Reputation</h5>
                <p class="small text-muted">Proudly serving institutional clients for over a decade.</p>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="py-5 bg-white position-relative">
    <div class="container" data-aos="fade-up">
        <h2 class="text-center mb-5 display-5 fw-bold text-dark">🔥 Featured Products</h2>
        <div class="row g-4 justify-content-center">
            @forelse($featuredProducts->take(8) as $product)
                <div class="col-md-3">
                    <div class="card h-100 border-0 shadow-sm fancy-card" data-aos="zoom-in-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="ratio ratio-1x1 overflow-hidden rounded-top">
                            <img src="{{ $product->image ?? '/images/default-product.png' }}"
                                 alt="{{ $product->name }}"
                                 class="img-fluid object-fit-cover fancy-image"
                                 style="transition: transform 0.4s ease;">
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title mb-1 fw-semibold">{{ $product->name }}</h5>
                            <p class="text-muted small mb-2">{{ Str::limit($product->description, 50) }}</p>
                            <div class="mb-3 fw-bold text-primary fs-6">Rp{{ number_format($product->price, 0, ',', '.') }}</div>
                            <a href="{{ route('catalog.index', $product->id) }}" class="btn btn-outline-primary btn-sm">Detail</a>
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
