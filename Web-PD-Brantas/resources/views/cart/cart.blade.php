@extends('layouts.app')
@section('content')
<div class="container py-5">
    <h2 class="text-center mb-5 txt-white">Your Cart</h2>
    @if(session('cart') && count(session('cart')) > 0)
        <div class="row">
            @foreach(session('cart') as $id => $item)
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <img src="{{ $item['image'] }}" class="card-img-top" alt="{{ $item['name'] }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item['name'] }}</h5>
                            <p class="card-text">Price: Rp{{ number_format($item['price'], 0, ',', '.') }}</p>
                            <p>Quantity: {{ $item['quantity'] }}</p>
                            <form action="{{ route('cart.update', $id) }}" method="POST">
                                @csrf
                                <input type="number" name="quantity" min="1" value="{{ $item['quantity'] }}" class="form-control mb-2" />
                                <button type="submit" class="btn btn-warning">Update Quantity</button>
                            </form>
                            <form action="{{ route('cart.remove', $id) }}" method="POST" class="mt-2">
                                @csrf
                                <button type="submit" class="btn btn-danger">Remove from Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('checkout') }}" class="btn btn-success">Proceed to Checkout</a>
        </div>
    @else
        <p class="text-center txt-white">Your cart is empty.</p>
    @endif
</div>
@endsection
