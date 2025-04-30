<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Tambahkan ini

class CheckoutController extends Controller
{
    // Method pesan untuk create otomatis transaksi
    public function pesan(Request $request)
    {
        $cart = session()->get('cart', []);

        // Cek apakah keranjang kosong
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Keranjang kosong.');
        }

        // Looping untuk menyimpan transaksi untuk setiap produk dalam keranjang
        foreach ($cart as $item) {
            $product = Product::findOrFail($item['id']);

            // Membuat transaksi baru
            Transaction::create([
                'user_id'     => Auth::id() ?: null, // Mengambil ID pengguna yang login
                'product_id'  => $product->id,
                'quantity'    => $item['quantity'],
                'total_price' => $product->price * $item['quantity'],
                'status'      => 'pending', // Status transaksi
            ]);
        }

        // Kosongkan session keranjang
        session()->forget('cart');

        // Redirect ke halaman transaksi dengan pesan sukses
        return redirect()->route('transactions.index')->with('success', 'Pesanan berhasil dibuat.');
    }
}
