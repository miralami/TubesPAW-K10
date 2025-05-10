<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Menyimpan review baru
    public function store(Request $request, Product $product)
    {
        // Validasi input dari pengguna
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);


        // Membuat review baru
        $review = new Review([
            'user_id' => Auth::id(),  // Mengambil ID pengguna yang sedang login
            'product_id' => $product->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        // Simpan review ke database
        $review->save();

        // Redirect ke halaman produk dengan pesan sukses
        return redirect()->route('products.show', $product->id)->with('success', 'Review telah berhasil ditambahkan.');
    }
}