@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="text-center mb-5">Product Catalog</h2>
    <div class="row g-4">
        @foreach($products as $product)
        <div class="col-md-3">
            <div class="card h-100 shadow-sm" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 100 }}">
                <!-- gambar -->
                <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}">
                <div class="card-body text-center">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">{{ Str::limit($product->description, 50) }}</p>
                    <p class="fw-bold text-primary">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                    <!-- tombol detail -->
                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">View Details</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
