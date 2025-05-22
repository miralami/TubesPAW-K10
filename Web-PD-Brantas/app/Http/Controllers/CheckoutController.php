<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('checkout.index');
    }

    public function pesan(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $products = $request->input('products', []);

        if (empty($products)) {
            return redirect()->back()->with('error', 'Keranjang kosong.');
        }

        foreach ($products as $item) {
            $productId = $item['product_id'];
            $quantity = $item['quantity'];

            $product = Product::findOrFail($productId);

            Transaction::create([
                'user_id'     => Auth::id(),
                'product_id'  => $product->id,
                'quantity'    => $quantity,
                'total_price' => $product->price * $quantity,
                'status'      => 'pending',
            ]);
        }

        // Kosongkan cart setelah checkout
        session()->forget('cart');

        // Redirect ke halaman transaksi atau landing
        return redirect()->route('landing.index')->with('success', 'Pesanan berhasil dibuat.');
    }
}
