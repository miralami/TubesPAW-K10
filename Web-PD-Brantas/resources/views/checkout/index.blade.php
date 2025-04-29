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
                <form action="#" method="POST">
                    <button type="submit" class="btn btn-success">Complete Purchase</button>
                </form>
            </div>
        </div>
    </div>
@endsection
