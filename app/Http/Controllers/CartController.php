<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    // Menampilkan semua item di cart
    public function index()
    {
        $cart = Session::get('cart', []);  // Mengambil cart dari session (default empty array)
        return view('customer.cart.index', compact('cart'));
    }

    // Menambahkan item ke cart
    public function add(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Mengambil cart dari session
        $cart = Session::get('cart', []);

        // Cek apakah produk sudah ada di cart
        if (isset($cart[$validated['product_id']])) {
            // Jika sudah ada, tambahkan kuantitas
            $cart[$validated['product_id']]['quantity'] += $validated['quantity'];
        } else {
            // Jika belum ada, tambahkan produk baru ke cart
            $cart[$validated['product_id']] = [
                'quantity' => $validated['quantity'],
            ];
        }

        // Menyimpan cart yang telah diperbarui ke session
        Session::put('cart', $cart);

        return redirect()->route('customer.cart')->with('success', 'Item added to cart');
    }

    // Menghapus item dari cart
    public function remove(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);

        // Mengambil cart dari session
        $cart = Session::get('cart', []);

        // Cek apakah produk ada di cart
        if (isset($cart[$validated['product_id']])) {
            // Menghapus produk dari cart
            unset($cart[$validated['product_id']]);
        }

        // Menyimpan cart yang telah diperbarui ke session
        Session::put('cart', $cart);

        return redirect()->route('customer.cart')->with('success', 'Item removed from cart');
    }
}
