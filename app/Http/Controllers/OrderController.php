<?php

namespace App\Http\Controllers;

use App\Models\HTrans;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = HTrans::with(['details.product' => function ($query) {
            $query->withTrashed();
        }])->where('user_id', auth()->id())
          ->orderBy('created_at', 'desc')
          ->get();

        return view('customer.orders.index', compact('orders'));
    }

    public function show(HTrans $order)
    {
        if ($order->user_id !== auth()->id()) {
            return redirect()->route('customer.orders.index')
                           ->with('error', 'You are not authorized to view this order.');
        }

        $order->load(['details.product' => function ($query) {
            $query->withTrashed();
        }]);

        return view('customer.orders.show', compact('order'));
    }

    public function cancel(HTrans $order)
    {
        if ($order->user_id !== auth()->id() || $order->status !== 'pending') {
            return redirect()->back()->with('error', 'Cannot cancel this order.');
        }

        $order->update(['status' => 'cancelled']);

        // Return stock to products
        foreach ($order->details as $detail) {
            $detail->product->increment('stock', $detail->quantity);
        }

        return redirect()->back()->with('success', 'Order cancelled successfully.');
    }
}
