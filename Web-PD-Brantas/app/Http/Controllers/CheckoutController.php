<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('checkout.index');
    }

    public function pesan(Request $request)
    {
        // Validasi input produk dan kuantitas
        $request->validate([
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity'   => 'required|integer|min:1',
        ]);

        $products = $request->input('products', []);

        if (empty($products)) {
            return redirect()->back()->with('error', 'Keranjang kosong.');
        }

        DB::beginTransaction();

        try {
            $total = 0;

            // Hitung total dan cek stok
            foreach ($products as $item) {
                $product = Product::findOrFail($item['product_id']);

                if ($item['quantity'] > $product->stock) {
                    throw new \Exception("Stok tidak mencukupi untuk {$product->name}. Sisa: {$product->stock}");
                }

                $total += $product->price * $item['quantity'];
            }

            // Buat transaksi utama
            $transaction = Transaction::create([
                'user_id'     => Auth::id(),
                'status'      => 'pending',
                'total' => $total,
            ]);

            // Simpan setiap item ke transaction_items
            foreach ($products as $item) {
                $product = Product::findOrFail($item['product_id']);

                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id'     => $product->id,
                    'quantity'       => $item['quantity'],
                    'price'          => $product->price,
                ]);

                // Kurangi stok
                $product->decrement('stock', $item['quantity']);
                $product->increment('sold', $item['quantity']);
            }

            DB::commit();
            session()->forget('cart');

            return redirect()->route('landing.index')->with('success', 'Pesanan berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal melakukan pemesanan: ' . $e->getMessage());
        }
    }
}
