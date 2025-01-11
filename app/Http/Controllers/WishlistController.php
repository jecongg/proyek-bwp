<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class WishlistController extends Controller
{
    // Menampilkan semua item di wishlist
    public function index()
    {
        // Mengambil wishlist dari session
        $wishlist = Session::get('wishlist', []);  // Defaultnya kosong jika belum ada
        return view('customer.wishlist.index', compact('wishlist'));
    }

    // Menambahkan item ke wishlist
    public function add(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);

        // Mengambil wishlist dari session
        $wishlist = Session::get('wishlist', []);

        // Cek apakah produk sudah ada di wishlist
        if (!isset($wishlist[$validated['product_id']])) {
            // Jika belum ada, tambahkan produk ke wishlist
            $wishlist[$validated['product_id']] = [
                'product_id' => $validated['product_id'],
            ];

            // Menyimpan wishlist yang telah diperbarui ke session
            Session::put('wishlist', $wishlist);

            return redirect()->route('customer.wishlist')->with('success', 'Item added to wishlist');
        }

        return redirect()->route('customer.wishlist')->with('info', 'Item is already in your wishlist');
    }

    // Menghapus item dari wishlist
    public function remove(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);

        // Mengambil wishlist dari session
        $wishlist = Session::get('wishlist', []);

        // Cek apakah produk ada di wishlist
        if (isset($wishlist[$validated['product_id']])) {
            // Menghapus produk dari wishlist
            unset($wishlist[$validated['product_id']]);
        }

        // Menyimpan wishlist yang telah diperbarui ke session
        Session::put('wishlist', $wishlist);

        return redirect()->route('customer.wishlist')->with('success', 'Item removed from wishlist');
    }
}
