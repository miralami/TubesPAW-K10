<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    // Menyimpan review baru
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validation for image
        ]);

        // Handle image upload
        $imagePath = $request->file('image') ? $request->file('image')->store('reviews_images', 'public') : null;

        // Membuat review baru
        $review = new Review([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'image' => $imagePath,
        ]);

        // Simpan review ke database
        $review->save();

        return redirect()->route('products.show', $product->id)->with('success', 'Review telah berhasil ditambahkan.');
    }

    // Mengupdate review
    public function update(Request $request, Review $review)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validation for image
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($review->image && Storage::exists('public/' . $review->image)) {
                Storage::delete('public/' . $review->image);
            }
            // Store new image
            $imagePath = $request->file('image')->store('reviews_images', 'public');
            $review->image = $imagePath;
        }

        // Update other fields
        $review->rating = $request->rating;
        $review->comment = $request->comment;

        // Save the updated review
        $review->save();

        return redirect()->route('products.show', $review->product_id)->with('success', 'Review telah berhasil diperbarui.');
    }

    // Menghapus review
    public function destroy(Review $review)
    {
        // Delete the image if exists
        if ($review->image && Storage::exists('public/' . $review->image)) {
            Storage::delete('public/' . $review->image);
        }

        // Delete the review from the database
        $review->delete();

        return redirect()->route('products.show', $review->product_id)->with('success', 'Review telah berhasil dihapus.');
    }
}
