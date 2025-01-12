<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\DCart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::with('details.product')->firstOrCreate(['user_id' => auth()->id()]);
        if (!$cart->details) {
            $cart->setRelation('details', collect([]));
        }
        return view('customer.cart.index', compact('cart'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:product,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);

        $detail = $cart->details()->where('product_id', $request->product_id)->first();

        if ($detail) {
            $detail->update([
                'quantity' => $detail->quantity + $request->quantity
            ]);
        } else {
            $cart->details()->create([
                'product_id' => $request->product_id,
                'quantity' => $request->quantity
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function updateQuantity(Request $request, DCart $detail)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $detail->update(['quantity' => $request->quantity]);
        return redirect()->back()->with('success', 'Cart updated successfully!');
    }

    public function removeItem(DCart $detail)
    {
        $detail->delete();
        return redirect()->back()->with('success', 'Item removed from cart!');
    }

    public function clear()
    {
        $cart = Cart::where('user_id', auth()->id())->first();
        if ($cart) {
            $cart->details()->delete();
        }
        return redirect()->back()->with('success', 'Cart cleared successfully!');
    }
}
