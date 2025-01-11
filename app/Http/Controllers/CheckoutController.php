<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    // Menampilkan halaman checkout dengan daftar produk yang ada di keranjang belanja
    public function index()
    {
        // Mendapatkan data keranjang belanja dari session
        $cart = Session::get('cart', []);
        $total = 0;

        // Menghitung total harga dari semua produk dalam keranjang
        foreach ($cart as $product) {
            $total += $product['price'] * $product['quantity'];
        }

        return view('customer.checkout.index', compact('cart', 'total'));
    }

    // Menyimpan data checkout (order) dan mengosongkan keranjang setelah checkout
    public function store(Request $request)
    {
        // Validasi input dari form checkout
        $validated = $request->validate([
            'address' => 'required|string|max:255',
            'payment_method' => 'required|string',
        ]);

        // Mengambil data keranjang belanja dari session
        $cart = Session::get('cart', []);

        // Jika keranjang kosong, kembalikan dengan pesan error
        if (empty($cart)) {
            return redirect()->route('customer.cart')->with('error', 'Your cart is empty. Please add items to your cart.');
        }

        try {
            // Menyimpan data order ke tabel orders
            $order = Order::create([
                'user_id' => auth()->user()->id,
                'address' => $validated['address'],
                'payment_method' => $validated['payment_method'],
                'status' => 'pending', // status awal adalah pending
                'total_price' => 0, // Total harga akan dihitung nanti
            ]);

            // Menambahkan detail order (produk yang dipesan)
            $total = 0;
            foreach ($cart as $product) {
                // Mengurangi stok produk di database
                $productModel = Product::find($product['product_id']);
                $productModel->stock -= $product['quantity'];
                $productModel->save();

                // Menambahkan item ke tabel order_details
                $order->details()->create([
                    'product_id' => $product['product_id'],
                    'quantity' => $product['quantity'],
                    'price' => $product['price'],
                ]);

                // Menghitung total harga
                $total += $product['price'] * $product['quantity'];
            }

            // Update total price di tabel orders
            $order->total_price = $total;
            $order->save();

            // Mengosongkan keranjang setelah checkout
            Session::forget('cart');

            return redirect()->route('customer.orders')->with('success', 'Your order has been placed successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'An error occurred while placing the order. Please try again.');
        }
    }
}
