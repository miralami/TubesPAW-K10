@extends('layouts.app') 
@section('content')
    <div class="container py-5">
        <h2 class="text-center mb-5">Checkout</h2>
        <div class="row">
            <div class="col-md-6">
                <h3>Your Cart</h3>
                <ul>
                    @foreach(session('cart', []) as $id => $item)
                        <li>{{ $item['name'] }} - Rp{{ number_format($item['price'], 0, ',', '.') }} x {{ $item['quantity'] }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-6">
                <h3>Checkout Form</h3>

                {{-- Form untuk submit semua transaksi --}}
                <form action="{{ route('transactions.orderMultiple') }}" method="POST">
                    @csrf
                    @foreach(session('cart', []) as $productId => $item)
                        <input type="hidden" name="products[{{ $productId }}][product_id]" value="{{ $productId }}">
                        <input type="hidden" name="products[{{ $productId }}][quantity]" value="{{ $item['quantity'] }}">
                    @endforeach
                    <input type="hidden" name="status" value="pending">
                    <button type="submit" class="btn btn-success">Pesan Sekarang</button>
                </form>

            </div>
        </div>
    </div>
@endsection
