<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('items.product')->latest()->get();
        return view('admin.transactions.index', compact('transactions'));
    }

    public function create()
    {
        $products = Product::all();
        return view('admin.transactions.create', compact('products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'status' => 'required|string',
        ]);

        DB::transaction(function () use ($data) {
            $total = 0;

            $transaction = Transaction::create([
                'user_id' => Auth::id(),
                'status' => $data['status'],
                'total' => 0,
            ]);

            foreach ($data['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);

                if ($item['quantity'] > $product->stock) {
                    throw new \Exception("Stok tidak cukup untuk {$product->name}");
                }

                $transaction->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                ]);

                $product->decrement('stock', $item['quantity']);
                $product->increment('sold', $item['quantity']);
                $total += $product->price * $item['quantity'];
            }

            $transaction->update(['total' => $total]);
        });

        return redirect()->route('admin.transactions.index')
            ->with('success', 'Transaksi berhasil dibuat.');
    }

    public function edit(Transaction $transaction)
    {
        $products = Product::all();
        $transaction->load('items.product');
        return view('admin.transactions.edit', compact('transaction', 'products'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $data = $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'status' => 'required|string',
        ]);

        DB::transaction(function () use ($data, $transaction) {
            foreach ($transaction->items as $oldItem) {
                $product = $oldItem->product;
                $product->increment('stock', $oldItem->quantity);
                $product->decrement('sold', $oldItem->quantity);
            }

            $transaction->items()->delete();

            $total = 0;

            foreach ($data['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);

                if ($item['quantity'] > $product->stock) {
                    throw new \Exception("Stok tidak cukup untuk {$product->name}");
                }

                $transaction->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                ]);

                $product->decrement('stock', $item['quantity']);
                $product->increment('sold', $item['quantity']);
                $total += $product->price * $item['quantity'];
            }

            $transaction->update([
                'status' => $data['status'],
                'total' => $total,
            ]);
        });

        return redirect()->route('admin.transactions.index')
            ->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Transaction $transaction)
    {
        DB::transaction(function () use ($transaction) {
            foreach ($transaction->items as $item) {
                $product = $item->product;
                $product->increment('stock', $item->quantity);
                $product->decrement('sold', $item->quantity);
            }

            $transaction->items()->delete();
            $transaction->delete();
        });

        return redirect()->route('admin.transactions.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }

    public function show(Transaction $transaction)
    {
        $transaction->load('items.product');
        return view('admin.transactions.show', compact('transaction'));
    }
}
