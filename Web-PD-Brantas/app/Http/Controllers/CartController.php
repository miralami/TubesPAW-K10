<?php
namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
class CartController extends Controller
{
    public function addToCart($productId, Request $request)
    {
        $product = Product::findOrFail($productId);
        $cart = session()->get('cart', []);
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->image,
            ];
        }
        session()->put('cart', $cart);
        return redirect()->route('products.show', $productId)->with('success', 'Product added to cart!');
    }
    public function viewCart()
{
    $cart = session()->get('cart', []);
    return view('cart.cart', compact('cart'));
}
public function updateQuantity(Request $request, $id)
{
    $cart = session()->get('cart', []);
    if (isset($cart[$id])) {
        $cart[$id]['quantity'] = $request->quantity;
    }
    session()->put('cart', $cart);
    return redirect()->route('cart.view')->with('success', 'Cart updated!');
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
}
