@extends('layouts.app')

@section('content')
    <div class="container py-5">
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('catalog.index') }}">Catalog</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $product->name }}
                </li>
            </ol>
        </nav>

        <div class="row g-5 align-items-start">
            <!-- Gambar Produk -->
            <div class="col-lg-5 text-center fade-in">
                <div class="border rounded shadow-sm p-2 bg-white">
                    <img src="{{ asset('storage/' . $product->image) }}"
                         alt="{{ $product->name }}"
                         class="img-fluid img-product">
                </div>
            </div>

            <!-- Detail Produk -->
            <div class="col-lg-7 fade-in">
                {{-- Kategori --}}
                <span class="badge bg-secondary mb-2">{{ $product->category }}</span>

                {{-- Nama --}}
                <h2 class="fw-semibold text-dark-custom">
                    {{ $product->name }}
                </h2>

                {{-- Deskripsi --}}
                <p class="text-muted text-dark-custom">
                    {{ $product->description }}
                </p>

                {{-- Harga --}}
                <h4 class="fw-bold mb-3 text-dark-custom">
                    Harga: Rp{{ number_format($product->price, 0, ',', '.') }}
                </h4>

                {{-- Stok & Terjual --}}
                <p class="text-dark-custom mb-4">
                    <span class="me-3">
                        Stok: <strong>{{ $product->stock }}</strong>
                    </span>
                    <span class="text-muted">
                        Terjual: {{ $product->sold }}
                    </span>
                </p>

                {{-- Form Tambah ke Cart --}}
                <form action="{{ route('cart.add', $product->id) }}" method="POST"
                      class="mt-4 fade-in">
                    @csrf
                    <div class="input-group input-qty">
                        <input type="number"
                               name="qty"
                               value="1"
                               min="1"
                               max="{{ $product->stock }}"
                               class="form-control text-center"
                               aria-label="Quantity">
                        <button type="submit" class="btn btn-custom-login">
                            <i class="bi bi-cart-plus me-1"></i> Add to Cart
                        </button>
                    </div>
                </form>

                {{-- Back to Catalog --}}
                <a href="{{ route('catalog.index') }}"
                   class="btn btn-outline-secondary mt-4 fade-in">
                    ← Back to Catalog
                </a>

                {{-- Review Section --}}
                <div class="reviews mt-5">
                    <h3 class="fade-in">Reviews</h3>

                    {{-- Tombol Add Review --}}
                    @auth
                        <button class="btn btn-custom-login mb-3 fade-in"
                                data-bs-toggle="modal"
                                data-bs-target="#reviewModal">
                            Add Review
                        </button>
                    @else
                        <p class="text-muted fade-in">
                            Please <a href="{{ route('login') }}">login</a> to leave a review.
                        </p>
                    @endauth

                    {{-- Filter Rating --}}
                    <div class="rating-filter mb-4">
                        <span class="me-2 text-dark-custom">Filter by rating:</span>
                        @for($i = 5; $i >= 1; $i--)
                            <a href="{{ route('products.show', ['id' => $product->id, 'rating' => $i]) }}"
                               class="btn btn-sm {{ request('rating') == $i ? 'btn-warning' : 'btn-outline-secondary' }}">
                                {{ str_repeat('★', $i) }}
                            </a>
                        @endfor

                        @if(request('rating'))
                            <a href="{{ route('products.show', $product->id) }}"
                               class="btn btn-sm btn-outline-secondary ms-2">
                                Clear filter
                            </a>
                        @endif
                    </div>

                    {{-- Daftar Review --}}
                    @if($reviews->isEmpty())
                        <p class="text-dark-custom fade-in">No reviews yet.</p>
                    @else
                        @foreach($reviews as $review)
                            @if(!request('rating') || $review->rating == request('rating'))
                                <div class="review mb-3 p-3 border rounded fade-in">
                                    <div class="d-flex justify-content-between">
                                        <strong>{{ $review->user->name }}</strong>
                                        <small class="text-muted">
                                            {{ $review->created_at->format('M d, Y') }}
                                        </small>
                                    </div>

                                    {{-- Rating --}}
                                    <div class="rating mb-2">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $review->rating)
                                                <span class="text-warning">★</span>
                                            @else
                                                <span class="text-muted">★</span>
                                            @endif
                                        @endfor
                                    </div>

                                    {{-- Komentar --}}
                                    <p class="text-dark-custom">{{ $review->comment }}</p>

                                    {{-- Gambar Review (jika ada) --}}
                                    @if($review->image)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $review->image) }}"
                                                 alt="Review Image"
                                                 class="img-fluid rounded"
                                                 style="max-height: 150px; object-fit:cover;">
                                        </div>
                                    @endif

                                    {{-- Tombol Edit / Delete untuk yang punya review --}}
                                    @if(Auth::id() == $review->user_id)
                                        <div class="mt-2">
                                            <button class="btn btn-sm btn-warning me-2"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editReviewModal{{ $review->id }}">
                                                Edit
                                            </button>

                                            <form action="{{ route('reviews.destroy', $review->id) }}"
                                                  method="POST"
                                                  class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-sm btn-danger">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>

                                {{-- Modal Edit Review --}}
                                <div class="modal fade"
                                     id="editReviewModal{{ $review->id }}"
                                     tabindex="-1"
                                     aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Review</h5>
                                                <button type="button"
                                                        class="btn-close"
                                                        data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('reviews.update', $review->id) }}"
                                                  method="POST"
                                                  enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="rating">Rating:</label>
                                                        <select name="rating" class="form-select" required>
                                                            @for($i = 1; $i <= 5; $i++)
                                                                <option value="{{ $i }}"
                                                                    {{ $i == $review->rating ? 'selected' : '' }}>
                                                                    {{ $i }} star
                                                                </option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="comment">Comment:</label>
                                                        <textarea name="comment"
                                                                  class="form-control"
                                                                  rows="3">{{ $review->comment }}</textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="image">Change Image (optional):</label>
                                                        <input type="file" name="image" class="form-control">
                                                        @if($review->image)
                                                            <div class="mt-2">
                                                                <img src="{{ asset('storage/' . $review->image) }}"
                                                                     alt="Current Image"
                                                                     class="img-fluid rounded"
                                                                     style="max-height: 100px; object-fit:cover;">
                                                                <label class="mt-2 d-block">
                                                                    <input type="checkbox" name="remove_image">
                                                                    Remove current image
                                                                </label>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button"
                                                            class="btn btn-secondary"
                                                            data-bs-dismiss="modal">
                                                        Cancel
                                                    </button>
                                                    <button type="submit"
                                                            class="btn btn-custom-login">
                                                        Update Review
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div> {{-- /.reviews --}}
            </div> {{-- /.col-lg-7 --}}
        </div> {{-- /.row --}}
    </div> {{-- /.container --}}

    {{-- Modal Tambah Review --}}
    @auth
        <div class="modal fade" id="reviewModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Review</h5>
                        <button type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close">
                        </button>
                    </div>
                    <form action="{{ route('reviews.store', $product->id) }}"
                          method="POST"
                          enctype="multipart/form-data">
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
                            <button type="button"
                                    class="btn btn-secondary"
                                    data-bs-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="btn btn-custom-login">
                                Submit Review
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endauth
@endsection
