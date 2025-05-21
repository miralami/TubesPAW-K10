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

            <!-- Review Section -->
            <div class="reviews mt-5">
                <h3>Reviews</h3>
                @if($reviews->isEmpty())
                    <p>No reviews yet.</p>
                @else
                    @foreach($reviews as $review)
                        <div class="review mb-3 p-3 border rounded">
                            <strong>{{ $review->user->name }}</strong>
                            <div class="rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $review->rating)
                                        <span class="text-warning">★</span> <!-- Filled star -->
                                    @else
                                        <span class="text-muted">★</span> <!-- Empty star -->
                                    @endif
                                @endfor
                            </div>
                            <p>{{ $review->comment }}</p>

                            {{-- Display review image if available --}}
                            @if($review->image)
                                <div>
                                    <img src="{{ asset('storage/' . $review->image) }}" alt="Review Image" class="img-fluid" style="max-height: 150px; object-fit:contain;">
                                </div>
                            @endif

                            {{-- Edit and delete buttons for the review owner --}}
                            @if(Auth::id() == $review->user_id)
                                <div class="mt-2">
                                    <a href="{{ route('reviews.update', $review->id) }}" class="btn btn-warning btn-sm">Update</a>

                                    <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @endforeach
                @endif

                <!-- Review Form -->
                @auth
                    <form action="{{ route('reviews.store', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="rating" class="form-label">Rating</label>
                            <select name="rating" id="rating" class="form-select" required>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="comment" class="form-label">Comment</label>
                            <textarea name="comment" id="comment" class="form-control" rows="4" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Upload Image (Optional)</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Review</button>
                    </form>
                @else
                    <p>Please <a href="{{ route('login') }}">log in</a> to leave a review.</p>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection
