@extends('layouts.admin')

@section('content')
    <!-- suskses -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="container py-5">
        <div class="row">
            <div class="col-md-6">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid">
            </div>
            <div class="col-md-6">
                <h2>{{ $product->name }}</h2>
                <p class="lead">{{ $product->description }}</p>
                <p class="fw-bold text-primary">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                <p>Stock: {{ $product->stock }}</p>
                <a href="{{ route('catalog.index') }}" class="btn btn-secondary">Back to Catalog</a>

                <!-- tombol add to cart -->
                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary mt-3">Add to Cart</button>
                </form>
            </div>
        </div>
    </div>
@endsection
