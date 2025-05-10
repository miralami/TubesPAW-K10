<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Review; // Import the Review model
use Illuminate\Support\Facades\Auth; // Import Auth for user authentication

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string',
            'price'       => 'required|numeric',
            'stock'       => 'required|integer',
            'category'    => 'required|string|max:50',
            'image'       => 'nullable|image|max:2048', // max 2MB
        ]);

        // simpan file jika ada
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string',
            'price'       => 'required|numeric',
            'stock'       => 'required|integer',
            'category'    => 'required|string|max:50',
            'image'       => 'nullable|image|max:2048',
        ]);

        // ganti gambar jika ada
        if ($request->hasFile('image')) {
            // hapus gambar lama jika ada
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        // hapus file gambar jika ada
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }

    public function show($id)
{
    $product = Product::findOrFail($id);
    $reviews = $product->reviews; // Mengambil review terkait produk

    return view('products.show', compact('product', 'reviews'));
}

    // Menyimpan review baru untuk produk
    public function storeReview(Request $request, Product $product)
{
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
