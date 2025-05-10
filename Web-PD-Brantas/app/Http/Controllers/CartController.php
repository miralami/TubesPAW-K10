<?php
namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart($productId, Request $request)
{
    $product = Product::findOrFail($productId);
    $cart = session()->get('cart', []);

    // Ambil jumlah dari form, default = 1
    $qty = max((int) $request->input('qty', 1), 1);

    if (isset($cart[$productId])) {
        $cart[$productId]['quantity'] += $qty;
    } else {
        $cart[$productId] = [
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => $qty,
            'image' => $product->image,
        ];
    }

    session()->put('cart', $cart);
    return redirect()->route('products.show', $productId)->with('success', 'Product added to cart!');
}

public function viewCart()
{
    if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
    }

    $cart = session()->get('cart', []);
    return view('cart.cart', compact('cart'));
}

public function updateQuantity(Request $request, $id)
{
    $cart = session('cart', []);
    if (isset($cart[$id])) {
        $qty = max((int)$request->input('quantity',1),1);
        $cart[$id]['quantity'] = $qty;
    }
    session()->put('cart', $cart);
    return back()->with('success','Cart updated!');
}

public function removeFromCart($id)
{
    $cart = session()->get('cart', []);
    if (isset($cart[$id])) {
        unset($cart[$id]);
    }
    session()->put('cart', $cart);
    return redirect()->route('cart.view')->with('success', 'Product removed from cart!');
}

public function bulkUpdate(Request $request)
{
    $cart = session('cart', []);

    foreach ($request->input('quantities', []) as $id => $qty) {
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = max((int)$qty, 1);
        }
    }

    session()->put('cart', $cart);
    return back()->with('success', 'Cart updated!');
}

}
