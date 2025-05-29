@extends('layouts.app')

@section('content')
@if(session('success'))
    <div class="alert alert-success text-center mb-0">{{ session('success') }}</div>
@endif

<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('catalog.index') }}">Catalog</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-5 align-items-start">
        <!-- Gambar Produk -->
        <div class="col-lg-5 text-center fade-in" style="transition: opacity 1s ease;">
            <div class="border rounded shadow-sm p-2 bg-white">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                     class="img-fluid" style="max-height:420px;object-fit:contain">
            </div>
        </div>

        <!-- Detail Produk -->
        <div class="col-lg-7 fade-in" style="transition: opacity 1s ease;">
            <span class="badge bg-secondary mb-2">{{ $product->category }}</span>
            <h2 class="fw-semibold" style="color: #000;">{{ $product->name }}</h2>
            <p class="text-muted" style="color: #000;">{{ $product->description }}</p>
            <h4 class="text-primary fw-bold mb-3" style="color: #000;">
                Rp{{ number_format($product->price, 0, ',', '.') }}
            </h4>
            <p>
                <span class="me-3" style="color: #000;">Stok: <strong>{{ $product->stock }}</strong></span>
                <span class="text-muted" style="color: #000;">Terjual: {{ $product->sold }}</span>
            </p>

            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-4 fade-in" style="transition: opacity 1s ease;">
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

            <a href="{{ route('catalog.index') }}" class="btn btn-outline-secondary mt-4 fade-in" style="transition: opacity 1s ease;">
                ← Back to Catalog
            </a>

            <!-- Review Section -->
            <div class="reviews mt-5">
                <h3 class="fade-in" style="transition: opacity 1s ease;">Reviews</h3>

                <!-- Add Review Button -->
                @auth
                    <button class="btn btn-primary mb-3 fade-in" data-bs-toggle="modal" data-bs-target="#reviewModal" style="transition: opacity 1s ease;">
                        Add Review
                    </button>
                @else
                    <p class="text-muted" style="color: #000;" class="fade-in">Please <a href="{{ route('login') }}">login</a> to leave a review.</p>
                @endauth
                
                <!-- Rating Filter -->
                <div class="rating-filter mb-4">
                    <span class="me-2" style="color: #000;">Filter by rating:</span>
                    @for($i = 5; $i >= 1; $i--)
                        <a href="{{ route('products.show', ['id' => $product->id, 'rating' => $i]) }}" 
                           class="btn btn-sm {{ request('rating') == $i ? 'btn-warning' : 'btn-outline-secondary' }}">
                            {{ str_repeat('★', $i) }}
                        </a>
                    @endfor
                    @if(request('rating'))
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-outline-secondary ms-2">
                            Clear filter
                        </a>
                    @endif
                </div>

                @if($reviews->isEmpty())
                    <p style="color: #000;" class="fade-in">No reviews yet.</p>
                @else
                    @foreach($reviews as $review)
                        <!-- Filter reviews by rating -->
                        @if(!request('rating') || $review->rating == request('rating'))
                            <div class="review mb-3 p-3 border rounded fade-in" style="transition: opacity 1s ease;">
                                <div class="d-flex justify-content-between">
                                    <strong>{{ $review->user->name }}</strong>
                                    <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                                </div>
                                <div class="rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $review->rating)
                                            <span class="text-warning">★</span>
                                        @else
                                            <span class="text-muted">★</span>
                                        @endif
                                    @endfor
                                </div>
                                <p>{{ $review->comment }}</p>

                                @if($review->image)
                                    <div>
                                        <img src="{{ asset('storage/' . $review->image) }}" alt="Review Image" class="img-fluid" style="max-height: 150px; object-fit:contain;">
                                    </div>
                                @endif

                                @if(Auth::id() == $review->user_id)
                                    <div class="mt-2">
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editReviewModal{{ $review->id }}">
                                            Edit
                                        </button>

                                        <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </div>
                                @endif
                            </div>

                            <!-- Edit Review Modal -->
                            <div class="modal fade" id="editReviewModal{{ $review->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Review</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('reviews.update', $review->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="rating">Rating:</label>
                                                    <select name="rating" class="form-select" required>
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <option value="{{ $i }}" {{ $i == $review->rating ? 'selected' : '' }}>{{ $i }} star</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="comment">Comment:</label>
                                                    <textarea name="comment" class="form-control" rows="3">{{ $review->comment }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="image">Change Image (optional):</label>
                                                    <input type="file" name="image" class="form-control">
                                                    @if($review->image)
                                                        <div class="mt-2">
                                                            <img src="{{ asset('storage/' . $review->image) }}" alt="Current Image" style="max-height: 100px;">
                                                            <label class="mt-2">
                                                                <input type="checkbox" name="remove_image"> Remove current image
                                                            </label>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Update Review</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Add Review Modal -->
@auth
<div class="modal fade" id="reviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('reviews.store', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="rating">Rating:</label>
                        <select name="rating" class="form-select" required>
                            @for($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}">{{ $i }} star</option>
                            @endfor
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="comment">Comment:</label>
                        <textarea name="comment" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image">Upload Image (optional):</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit Review</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endauth

@endsection
