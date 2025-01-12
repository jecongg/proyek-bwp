<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\HTrans;
use App\Models\DTrans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Cart::with('details.product')->where('user_id', auth()->id())->firstOrFail();
        if (!$cart->details || $cart->details->count() == 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }
        return view('customer.checkout.index', compact('cart'));
    }

    public function process(Request $request)
    {
        try {
            DB::beginTransaction();

            $cart = Cart::with('details.product')
                       ->where('user_id', auth()->id())
                       ->firstOrFail();

            // Create HTrans
            $htrans = HTrans::create([
                'user_id' => auth()->id(),
                'total_price' => $cart->total,
                'status' => 'pending'
            ]);

            // Create DTrans
            foreach ($cart->details as $detail) {
                DTrans::create([
                    'htrans_id' => $htrans->id,
                    'product_id' => $detail->product_id,
                    'quantity' => $detail->quantity,
                    'price' => $detail->product->price,
                    'subtotal' => $detail->product->price * $detail->quantity
                ]);

                // Update stock
                $detail->product->decrement('stock', $detail->quantity);
            }

            // Clear cart
            $cart->details()->delete();

            DB::commit();

            return redirect()->route('customer.orders.show', ['order' => $htrans->id])
                           ->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                           ->with('error', 'Something went wrong! Please try again.');
        }
    }
}
