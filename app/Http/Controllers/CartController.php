<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\DCart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        try {
            $request->validate([
                'product_id' => 'required|exists:product,id',
                'quantity' => 'required|integer|min:1'
            ]);

            // Get product and check stock
            $product = Product::findOrFail($request->product_id);

            if ($product->stock < $request->quantity) {
                return redirect()->back()
                               ->with('error', "Cannot add {$request->quantity} item(s) to cart. Available stock for {$product->name}: {$product->stock}");
            }

            $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);
            $detail = $cart->details()->where('product_id', $request->product_id)->first();

            DB::beginTransaction();
            try {
                if ($detail) {
                    // Check if new total quantity exceeds stock
                    $newQuantity = $detail->quantity + $request->quantity;
                    if ($product->stock < $request->quantity) {
                        return redirect()->back()
                                       ->with('error', "Cannot add {$request->quantity} more item(s) to cart. Available stock for {$product->name}: {$product->stock}");
                    }

                    $detail->update([
                        'quantity' => $newQuantity
                    ]);

                    // Kurangi stock hanya untuk quantity baru
                    $product->decrement('stock', $request->quantity);
                } else {
                    $cart->details()->create([
                        'product_id' => $request->product_id,
                        'quantity' => $request->quantity
                    ]);

                    // Kurangi stock untuk item baru
                    $product->decrement('stock', $request->quantity);
                }

                DB::commit();
                return redirect()->back()->with('success', "{$product->name} added to cart successfully!");
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to add product to cart. Please try again.');
        }
    }

    public function updateQuantity(Request $request, DCart $detail)
    {
        \Log::info('Update quantity request received', [
            'request_all' => $request->all(),
            'detail_id' => $detail->id,
            'current_quantity' => $detail->quantity,
            'new_quantity' => $request->quantity
        ]);

        try {
            $validated = $request->validate([
                'quantity' => 'required|integer|min:1'
            ]);

            \Log::info('Validation passed', $validated);

            $product = Product::findOrFail($detail->product_id);

            DB::beginTransaction();

            $oldQuantity = $detail->quantity;
            $newQuantity = (int)$request->quantity;

            \Log::info('Quantities', [
                'old' => $oldQuantity,
                'new' => $newQuantity,
                'current_stock' => $product->stock
            ]);

            if ($newQuantity > $oldQuantity) {
                $additionalQuantity = $newQuantity - $oldQuantity;

                if ($product->stock < $additionalQuantity) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => "Not enough stock. Available: {$product->stock}",
                        'current_quantity' => $oldQuantity
                    ]);
                }

                $product->decrement('stock', $additionalQuantity);
                \Log::info('Stock decreased', ['amount' => $additionalQuantity]);
            } elseif ($newQuantity < $oldQuantity) {
                $returnQuantity = $oldQuantity - $newQuantity;
                $product->increment('stock', $returnQuantity);
                \Log::info('Stock increased', ['amount' => $returnQuantity]);
            }

            $detail->update(['quantity' => $newQuantity]);
            \Log::info('Cart detail updated', ['new_quantity' => $newQuantity]);

            // Recalculate totals
            $newSubtotal = $product->price * $newQuantity;
            $cart = Cart::find($detail->cart_id);
            $newTotal = $cart->details->sum(function($item) {
                return $item->product->price * $item->quantity;
            });

            // Hitung total items setelah update
            $totalItems = $cart->details->sum('quantity');

            DB::commit();

            \Log::info('Update successful', [
                'subtotal' => $newSubtotal,
                'total' => $newTotal
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Cart updated successfully!',
                'subtotal' => number_format($newSubtotal, 0, ',', '.'),
                'total' => number_format($newTotal, 0, ',', '.'),
                'total_items' => $totalItems
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error updating cart:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update cart: ' . $e->getMessage()
            ]);
        }
    }

    public function removeItem(DCart $detail)
    {
        try {
            DB::beginTransaction();

            // Kembalikan quantity ke stock product
            $product = Product::findOrFail($detail->product_id);
            $product->increment('stock', $detail->quantity);

            // Hapus item dari cart
            $detail->delete();

            // Hitung total baru
            $cart = Cart::find($detail->cart_id);
            $newTotal = $cart->details->sum(function($item) {
                return $item->product->price * $item->quantity;
            });
            $totalItems = $cart->details->sum('quantity');

            DB::commit();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Item removed from cart!',
                    'total' => number_format($newTotal, 0, ',', '.'),
                    'total_items' => $totalItems
                ]);
            }

            return redirect()->back()->with('success', 'Item removed from cart!');
        } catch (\Exception $e) {
            DB::rollBack();

            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to remove item from cart.'
                ]);
            }

            return redirect()->back()->with('error', 'Failed to remove item from cart.');
        }
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
