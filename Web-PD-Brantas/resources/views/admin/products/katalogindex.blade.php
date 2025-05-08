@extends('layouts.admin')

@section('title', 'Produk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-0">Daftar Produk</h3>
        <small class="text-muted">Laman manajemen produk</small>
    </div>
</div>

<div class="mb-4">
    <form class="d-flex" role="search">
        <input class="form-control rounded-pill" type="search" placeholder="Ketik nama produk..." aria-label="Search">
    </form>
</div>

<div class="row row-cols-2 row-cols-md-4 g-3">
    @foreach($products as $product)
    <div class="col">
        <div class="card uk-card h-100">
            <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}">
            <div class="card-body">
                <h5 class="card-title mb-1">{{ $product->name }}</h5>
                <p class="fw-bold mb-1">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                <div class="d-flex justify-content-between text-muted small">
                    <span><i class="bi bi-cart"></i> 0</span>
                    <span><i class="bi bi-heart"></i> 0</span>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
