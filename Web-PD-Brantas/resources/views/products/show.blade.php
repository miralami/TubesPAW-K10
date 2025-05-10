@extends('layouts.app')

@section('content')
{{--  ▸ Flash success --}}
@if(session('success'))
    <div class="alert alert-success text-center mb-0">{{ session('success') }}</div>
@endif

<div class="container py-5">

    {{-- ===== Breadcrumb ===== --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('catalog.index') }}">Catalog</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-5 align-items-start">

        {{-- ===== Foto produk ===== --}}
        <div class="col-lg-5 text-center">
            <div class="border rounded shadow-sm p-2 bg-white">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                     class="img-fluid" style="max-height:420px;object-fit:contain">
            </div>
        </div>

        {{-- ===== Deskripsi & aksi ===== --}}
        <div class="col-lg-7">
            {{-- Kategori badge --}}
            <span class="badge bg-secondary mb-2">{{ $product->category }}</span>

            <h2 class="fw-semibold">{{ $product->name }}</h2>

            <p class="text-muted">{{ $product->description }}</p>

            {{-- Harga --}}
            <h4 class="text-primary fw-bold mb-3">
                Rp{{ number_format($product->price, 0, ',', '.') }}
            </h4>

            {{-- Detail stok & terjual --}}
            <p>
                <span class="me-3">Stok: <strong>{{ $product->stock }}</strong></span>
                <span class="text-muted">Terjual: {{ $product->sold }}</span>
            </p>

            {{-- Form add-to-cart --}}
            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-4">
                @csrf
                <div class="input-group" style="max-width:200px">
                    <input type="number" name="qty" value="1" min="1"
                           max="{{ $product->stock }}"
                           class="form-control text-center" aria-label="Quantity">
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-cart-plus me-1"></i> Add to Cart
                    </button>
                </div>
            </form>

            {{-- Back button --}}
            <a href="{{ route('catalog.index') }}" class="btn btn-outline-secondary mt-4">
                ← Back to Catalog
            </a>
        </div>
    </div>
</div>
@endsection
