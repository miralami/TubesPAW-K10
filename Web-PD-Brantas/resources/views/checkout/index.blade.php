@extends('layouts.app') 
@section('content')
<style>
.checkout-container {
    background: #f8f9fa;
    min-height: 80vh;
    padding: 2rem 0;
}

.checkout-title {
    text-align: center;
    color: #2c3e50;
    margin-bottom: 2rem;
    font-weight: 600;
}

.checkout-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    padding: 2rem;
    margin-bottom: 1rem;
}

.cart-section h3 {
    color: #2c3e50;
    margin-bottom: 1.5rem;
    border-bottom: 2px solid #4fd1c7;
    padding-bottom: 0.5rem;
}

.cart-item {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1rem;
    border-left: 4px solid #4fd1c7;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.product-image {
    width: 60px;
    height: 60px;
    border-radius: 8px;
    object-fit: cover;
    border: 2px solid #e9ecef;
}

.product-info {
    flex: 1;
}

.form-section h3 {
    color: #2c3e50;
    margin-bottom: 1.5rem;
    border-bottom: 2px solid #4fd1c7;
    padding-bottom: 0.5rem;
}

.btn-order {
    background: linear-gradient(45deg, #4fd1c7, #36b3a8);
    border: none;
    padding: 12px 30px;
    border-radius: 25px;
    color: white;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.btn-order:hover {
    background: linear-gradient(45deg, #36b3a8, #2a9d8f);
    transform: translateY(-2px);
    color: white;
}

.total-section {
    background: #e8f6f3;
    padding: 1rem;
    border-radius: 8px;
    border-left: 4px solid #27ae60;
    margin-top: 1rem;
}
</style>

<div class="checkout-container">
    <div class="container">
        <h2 class="checkout-title">Checkout</h2>
        
        <div class="row">
            <!-- Your Cart -->
            <div class="col-md-6">
                <div class="checkout-card cart-section">
                    <h3>Your Cart</h3>
                    
                    @if(session('cart') && count(session('cart')) > 0)
                        @php $total = 0; @endphp
                        @foreach(session('cart', []) as $id => $item)
                            <div class="cart-item">
                                <img src="{{ $item['image'] ?? '/images/no-image.png' }}" 
                                     alt="{{ $item['name'] }}" 
                                     class="product-image">
                                <div class="product-info">
                                    <strong>{{ $item['name'] }}</strong><br>
                                    <span class="text-muted">
                                        Rp{{ number_format($item['price'], 0, ',', '.') }} x {{ $item['quantity'] }}
                                    </span>
                                </div>
                            </div>
                            @php $total += $item['price'] * $item['quantity']; @endphp
                        @endforeach
                        
                        <div class="total-section">
                            <strong>Total: Rp{{ number_format($total, 0, ',', '.') }}</strong>
                        </div>
                    @else
                        <p class="text-muted">Keranjang kosong</p>
                    @endif
                </div>
            </div>

            <!-- Checkout Form -->
            <div class="col-md-6">
                <div class="checkout-card form-section">
                    <h3>Checkout Form</h3>
                    
                    @if(session('cart') && count(session('cart')) > 0)
                        <form action="{{ route('transactions.orderMultiple') }}" method="POST">
                            @csrf
                            @foreach(session('cart', []) as $productId => $item)
                                <input type="hidden" name="products[{{ $productId }}][product_id]" value="{{ $productId }}">
                                <input type="hidden" name="products[{{ $productId }}][quantity]" value="{{ $item['quantity'] }}">
                            @endforeach
                            <input type="hidden" name="status" value="pending">
                            
                            <div class="text-center">
                                <button type="submit" class="btn btn-order">
                                    Pesan Sekarang
                                </button>
                            </div>
                        </form>
                    @else
                        <p class="text-muted">Tidak ada item untuk dipesan</p>
                        <a href="{{ route('products.catalog') }}" class="btn btn-primary">
                            Mulai Belanja
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection