<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $products = auth()->user()->wishlists()->with('category')->get();
        return view('customer.wishlist.index', compact('products'));
    }

    public function add(Request $request)
    {
        try {
            $validated = $request->validate([
                'product_id' => 'required|exists:product,id',
            ]);

            auth()->user()->wishlists()->attach($validated['product_id']);

            return redirect()->back()->with('success', 'Product added to wishlist successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to add product to wishlist. Please try again.');
        }
    }

    public function remove(Request $request)
    {
        try {
            $validated = $request->validate([
                'product_id' => 'required|exists:product,id',
            ]);

            auth()->user()->wishlists()->detach($validated['product_id']);

            return redirect()->back()->with('success', 'Product removed from wishlist!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to remove product from wishlist. Please try again.');
        }
    }
}
