@extends('layouts.app')

@section('content')

<!-- aos css -->
<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

<!-- bagian atas gede -->
<section class="text-white text-center d-flex align-items-center justify-content-center" style="height: 90vh; background-image: linear-gradient(rgba(0,0,50,0.9), rgba(0,0,50,0.7)); background-size: cover; background-position: center;">
    <div class="container" data-aos="fade-down">
        <h1 class="display-3 fw-bold mb-3">PD. Brantas</h1>
        <p class="lead mb-4">Your Trusted Supplier for Government Apparel and Equipment</p>
        <a href="{{ route('catalog.index') }}" class="btn btn-light btn-lg">View Products</a>
    </div>
</section>

<!-- bagian about us -->
<section class="py-5 bg-light">
    <div class="container" data-aos="fade-up">
        <h2 class="text-center mb-4">About Us</h2>
        <p class="text-center mx-auto" style="max-width: 800px;">
            PD. Brantas is a leading supplier of high-quality uniforms, tactical raincoats, safety footwear, and various apparel for government officials. Our commitment is to deliver trusted products that meet the demands of professional institutions.
        </p>
    </div>
</section>

<!-- produk top -->
<section class="py-5">
    <div class="container" data-aos="fade-up">
        <h2 class="text-center mb-5">Featured Products</h2>
        <div class="row g-4">
            @foreach($featuredProducts as $product)
                <div class="col-md-3">
                    <div class="card h-100 shadow-sm" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 100 }}">
                        <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ Str::limit($product->description, 50) }}</p>
                            <p class="fw-bold text-primary">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>


<!-- library aos js -->
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init();
</script>

@endsection
