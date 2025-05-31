@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-5 fw-bold">Your Cart ({{ count(session('cart', [])) }} items)</h2>

    @if(session('cart'))
    <form action="{{ route('cart.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row gy-5">
            <!-- Cart Items -->
            <div class="col-lg-8">
                @foreach(session('cart') as $id => $item)
                    @php
                        $subtotal = $item['price'] * $item['quantity'];
                        $maxQty = $products[$id]->stock ?? 1;
                    @endphp
                    <div class="d-flex mb-4 p-3 bg-white rounded shadow-sm align-items-center justify-content-between">
                        <div class="d-flex gap-3 align-items-center">
                            <img src="{{ asset('storage/'.$item['image']) }}" width="80" class="rounded border" alt="{{ $item['name'] }}">
                            <div>
                                <h5 class="mb-1">{{ $item['name'] }}</h5>
                                <div class="text-muted small">Harga: Rp{{ number_format($item['price'], 0, ',', '.') }}</div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-3">
                            <input type="number" name="quantities[{{ $id }}]" value="{{ $item['quantity'] }}" min="1" max="{{ $maxQty }}" class="form-control text-center" style="width: 80px;">
                            <div class="fw-semibold text-end">Rp{{ number_format($subtotal, 0, ',', '.') }}</div>
                            <button type="submit" form="remove-form-{{ $id }}" class="btn btn-outline-danger btn-sm" onclick="return confirm('Yakin ingin menghapus item ini?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                @endforeach

                <button class="btn btn-outline-primary mt-3">Update Quantity</button>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="mb-3">Order Summary</h5>
                        @php $total = collect(session('cart'))->sum(fn($i) => $i['price'] * $i['quantity']); @endphp

                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span>Rp{{ number_format($total, 0, ',', '.') }}</span>
                        </div>

                        <hr>
                        <div class="d-flex justify-content-between mb-3 fs-5">
                            <strong>Total:</strong>
                            <strong class="text-primary">Rp{{ number_format($total, 0, ',', '.') }}</strong>
                        </div>

                        <a href="{{ route('checkout') }}" class="btn btn-dark w-100">Checkout</a>

                        <div class="mt-3 text-center">
                            <a href="{{ route('catalog.index') }}" class="text-decoration-underline text-muted small">Continue Shopping</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    @foreach(session('cart') as $id => $item)
        <form id="remove-form-{{ $id }}" action="{{ route('cart.remove', $id) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    @endforeach

    @else
        <p class="text-center text-muted">Your cart is empty.</p>
        <div class="text-center mt-3">
            <a href="{{ route('catalog.index') }}" class="btn btn-primary">Back to Catalog</a>
        </div>
    @endif
</div>
@endsection
