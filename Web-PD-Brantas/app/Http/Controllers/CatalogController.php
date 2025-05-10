<?php

// app/Http/Controllers/CatalogController.php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        /* ---------- ambil daftar produk dengan filter ---------- */
        $products = Product::query()
            ->when($request->filled('q'), function ($q) use ($request) {
                $q->where(function ($sub) use ($request) {
                    $sub->where('name',        'like', '%'.$request->q.'%')
                        ->orWhere('description','like', '%'.$request->q.'%');
                });
            })
            ->when($request->filled('category'), function ($q) use ($request) {
                $q->where('category', $request->category);
            })
            ->latest()            // urut terbaru
            ->get();              // atau ->paginate(12) jika mau paging

        /* ---------- daftar kategori unik untuk dropdown ---------- */
        $categories = Product::pluck('category')
                     ->unique()
                     ->sort()
                     ->values();

        return view('catalog', compact('products','categories'));
    }
}
