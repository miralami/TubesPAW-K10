<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    // 1. List semua transaksi
    public function index()
    {
        $transactions = Transaction::with('product')->get();
        return view('admin.transactions.index', compact('transactions'));
    }

    // 2. Form buat transaksi manual
    public function create()
    {
        $products = Product::all();
        return view('admin.transactions.create', compact('products'));
    }

    // 3. Simpan transaksi baru (manual)
    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
            'status'     => 'required|string',
        ]);

        // ambil produk
        $product = Product::findOrFail($data['product_id']);

        // cek stok
        if ($data['quantity'] > $product->stock) {
            return back()
                ->withErrors(['quantity' => 'Stok tidak mencukupi. Tersisa: ' . $product->stock])
                ->withInput();
        }

        // siapkan data transaksi
        $data['user_id']     = Auth::id();
        $data['total_price'] = $product->price * $data['quantity'];

        // lakukan create + decrement stok dalam satu transaksi DB
        DB::transaction(function() use ($data, $product) {
            Transaction::create($data);
            $product->decrement('stock', $data['quantity']);
            $product->increment('sold', $data['quantity']);
        });

        return redirect()
            ->route('admin.transactions.index')
            ->with('success', 'Transaksi berhasil dibuat dan stok diperbarui.');
    }

    // 4. Detail transaksi
    public function show(Transaction $transaction)
    {
        return view('admin.transactions.show', compact('transaction'));
    }

    // 5. Form edit transaksi
    public function edit(Transaction $transaction)
    {
        $products = Product::all();
        return view('admin.transactions.edit', compact('transaction','products'));
    }

    // 6. Update transaksi yang sudah ada
    public function update(Request $request, Transaction $transaction)
    {
        $data = $request->validate([
            'product_id'  => 'required|exists:products,id',
            'quantity'    => 'required|integer|min:1',
            'status'      => 'required|string',
        ]);

        $product = Product::findOrFail($data['product_id']);
        $data['total_price'] = $product->price * $data['quantity'];

        $transaction->update($data);

        return redirect()->route('admin.transactions.index')
                         ->with('success', 'Transaksi berhasil diperbarui.');
    }

    // 7. Hapus transaksi
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->route('admin.transactions.index')
                         ->with('success', 'Transaksi berhasil dihapus.');
    }

    // 8. Proses create otomatis dari keranjang (order multiple)
    public function orderMultiple(Request $request)
    {
        $products = $request->input('products', []);
        $status   = $request->input('status', 'pending');

        if (empty($products)) {
            return redirect()->back()->with('error', 'Keranjang kosong.');
        }

        foreach ($products as $item) {
            $product = Product::findOrFail($item['product_id']);

            Transaction::create([
                'user_id'     => Auth::id() ?: null,
                'product_id'  => $product->id,
                'quantity'    => $item['quantity'],
                'total_price' => $product->price * $item['quantity'],
                'status'      => $status,
            ]);
        }

        // Kosongkan cart setelah order
        session()->forget('cart');

        return redirect()->route('admin.transactions.index')
                         ->with('success', 'Semua transaksi berhasil diproses.');
    }
}
