// resources/views/reviews/edit.blade.php

@extends('layouts.app')

@section('content')
    <h2>Edit Review untuk Produk: {{ $review->product->name }}</h2>

    <form action="{{ route('reviews.update', $review->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="rating">Rating:</label>
        <input type="number" name="rating" min="1" max="5" value="{{ $review->rating }}" required class="form-control">
    </div>

    <div class="mb-3">
        <label for="comment">Komentar:</label>
        <textarea name="comment" class="form-control">{{ $review->comment }}</textarea>
    </div>

    <div class="mb-3">
        <label for="image">Upload Gambar Baru (opsional):</label>
        <input type="file" name="image" class="form-control">
    </div>

    <button type="submit" class="btn btn-success">Perbarui Review</button>
</form>
@endsection