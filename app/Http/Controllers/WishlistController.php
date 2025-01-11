<?php       
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::where('user_id', Auth::id())->get();
        return view('customer.wishlist.index', compact('wishlists'));
    }

    public function add(Request $request)
    {
        try {
            // Validasi input produk_id
            $validated = $request->validate([
                'product_id' => 'required|exists:products,id',
            ]);

            // Cek apakah produk sudah ada di wishlist
            $existingWishlist = Wishlist::where('user_id', Auth::id())
                ->where('product_id', $validated['product_id'])
                ->first();

            if ($existingWishlist) {
                // Jika produk sudah ada di wishlist, tampilkan pesan
                return redirect()->back()->with('error', 'Product is already in your wishlist!');
            }

            // Menambahkan produk ke wishlist
            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $validated['product_id'],
            ]);

            // Redirect dengan pesan sukses
            return redirect()->back()->with('success', 'Product added to wishlist successfully!');
        } catch (\Exception $e) {
            // Tangani error jika terjadi exception
            return back()->withInput()->with('error', 'Failed to add product to wishlist. Please try again.');
        }
    }

    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        Wishlist::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->delete();

        return redirect()->back()->with('status', 'Product removed from wishlist!');
    }
}
