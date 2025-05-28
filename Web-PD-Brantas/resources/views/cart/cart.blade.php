@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="text-center mb-5">Your Cart ({{ count(session('cart', [])) }} items)</h2>

    @if(session('cart'))
    <form action="{{ route('cart.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row gy-4">
       
        <div class="col-lg-8">
                <div class="table-responsive shadow-sm">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Item</th>
                                <th class="text-end">Price</th>
                                <th class="text-end">Qty On Cart</th>
                                <th class="text-center" style="width:120px">Change Qty</th>
                                <th class="text-end">Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        @php $total = 0; @endphp
                        @foreach(session('cart') as $id => $item)
                            @php
                                $subtotal = $item['price'] * $item['quantity'];
                                $total   += $subtotal;
                                $maxQty = $products[$id]->stock ?? 1;
                            @endphp
                            <tr>
       
                            <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ asset('storage/'.$item['image']) }}" alt="{{ $item['name'] }}" width="60" class="rounded">
                                        <span>{{ $item['name'] }}</span>
                                    </div>
                                </td>
                                <td class="text-end">Rp{{ number_format($item['price'], 0, ',', '.') }}</td>
                                <td class="text-end">{{ $item['quantity'] }} pcs</td>
                                <td class="text-center">
                                    <input type="number" name="quantities[{{ $id }}]" value="{{ $item['quantity'] }}" min="1" max="{{ $maxQty }}" class="form-control text-center">
                                </td>
                                <td class="text-end fw-semibold">Rp{{ number_format($subtotal, 0, ',', '.') }}</td>
                                <td class="text-end">
                                    <button type="submit" form="remove-form-{{ $id }}" class="btn btn-sm btn-link text-danger" onclick="return confirm('Yakin ingin menghapus item ini?')">&times;</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <button class="btn btn-outline-primary mt-3">Update Quantity</button>
            </div>

       
            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Order Summary</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span class="fw-semibold">Rp{{ number_format($total, 0, ',', '.') }}</span>
                        </div>
       
                        <hr>
                        <div class="d-flex justify-content-between mb-3 fs-5">
                            <strong>Total:</strong>
                            <strong class="text-primary">Rp{{ number_format($total, 0, ',', '.') }}</strong>
                        </div>
                        <a href="{{ route('checkout') }}" class="btn btn-success w-100">Proceed to Checkout</a>
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
