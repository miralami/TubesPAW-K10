// resources/views/reviews/create.blade.php

@extends('layouts.app')

@section('content')
    <h2>Tambah Review untuk Produk: {{ $product->name }}</h2>

    <form action="{{ route('reviews.store', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="rating">Rating:</label>
        <input type="number" name="rating" min="1" max="5" required class="form-control">
    </div>

    <div class="mb-3">
        <label for="comment">Komentar:</label>
        <textarea name="comment" class="form-control"></textarea>
    </div>

    <div class="mb-3">
        <label for="image">Upload Gambar:</label>
        <input type="file" name="image" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Kirim Review</button>
</form>

@endsection