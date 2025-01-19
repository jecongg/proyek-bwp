<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\HTrans;
use App\Models\DTrans;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }

    public function orders()
    {
        // Logika untuk menampilkan pesanan
        $htrans = HTrans::where('status', 'pending')->get();
        return view('admin.orders', compact('htrans')); // Buat file view di resources/views/admin/orders.blade.php
    }

    // Reports
    public function reports()
    {
        $htrans = HTrans::whereIn('status', ['paid', 'cancelled'])
                    ->orderBy('created_at', 'desc')
                    ->get();
                    
        return view('admin.reports', compact('htrans'));
    }

    public function generateReports(Request $request)
    {
        $startDate = Carbon::parse($request->start_date)->startOfDay();
        $endDate = Carbon::parse($request->end_date)->endOfDay();

        // Mengambil semua transaksi dalam rentang waktu
        $transactions = HTrans::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'paid')
            ->get();

        $reports = [];

        foreach ($transactions as $trans) {
            $date = $trans->created_at->format('Y-m-d');
            
            if (!isset($reports[$date])) {
                $reports[$date] = [
                    'total_transactions' => 0,
                    'total_sales' => 0,
                    'total_products' => 0,
                    'products' => []
                ];
            }

            $reports[$date]['total_transactions']++;
            $reports[$date]['total_sales'] += $trans->total_price;

            foreach ($trans->details as $detail) {
                $reports[$date]['total_products'] += $detail->quantity;
                
                $productId = $detail->product->id;
                if (!isset($reports[$date]['products'][$productId])) {
                    $reports[$date]['products'][$productId] = [
                        'name' => $detail->product->name,
                        'quantity' => 0,
                        'total' => 0
                    ];
                }
                
                $reports[$date]['products'][$productId]['quantity'] += $detail->quantity;
                $reports[$date]['products'][$productId]['total'] += $detail->subtotal;
            }
        }

        // Sort by date
        ksort($reports);

        $htrans = HTrans::whereIn('status', ['paid', 'cancelled'])
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('admin.reports', compact('reports', 'startDate', 'endDate', 'htrans'));
    }

    // Manage Users
    public function users()
    {
        $customers = User::where('role', 'Customer')->get();
        return view('admin.users', compact('customers'));
    }

    public function toggleStatus($id)
    {
        $user = User::find($id);
        $user->status = $user->status === 'active' ? 'not active' : 'active';
        $user->save();

        return redirect()->back()->with('status', 'User status updated successfully!');
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:user,email,' . auth()->id(),
            'phone' => 'required|string|max:15',
            'password' => 'nullable|string|min:6|confirmed', // Password bersifat opsional
        ]);

        $user = auth()->user();

        // Update nama, email, dan telepon
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];

        // Jika password diubah, kita akan mengenkripsi password dan menyimpannya
        if ($request->filled('password')) {
            $user->password = bcrypt($validated['password']);
        }

        $user->save();

        return redirect()->route('customer.profile')->with('success', 'Profile updated successfully.');
    }

    public function orderDetails($id)
    {
        $dtrans = DTrans::where('htrans_id', $id)->get();
        $htrans = HTrans::findOrFail($id);
        return view('admin.orders.order-details', compact('htrans', 'dtrans'));
    }

    public function orderEdit($id)
    {
        $htrans = HTrans::findOrFail($id);
        $dtrans = DTrans::where('htrans_id', $id)->get();
        return view('admin.orders.order-edit', compact('htrans', 'dtrans'));
    }

    public function updateOrder(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            
            $htrans = HTrans::findOrFail($id);
            $htrans->status = $request->status;
            $htrans->save();

            // Update quantities
            if($request->has('quantities')) {
                foreach($request->quantities as $dtransId => $quantity) {
                    $dtrans = DTrans::findOrFail($dtransId);
                    $dtrans->quantity = $quantity;
                    $dtrans->subtotal = $dtrans->price * $quantity;
                    $dtrans->save();
                }

                // Recalculate total price
                $newTotal = DTrans::where('htrans_id', $id)->sum('subtotal');
                $htrans->total_price = $newTotal;
                $htrans->save();
            }

            DB::commit();
            return redirect()->back()->with('success', 'Order berhasil diupdate!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function historyDetails($id){
        $dtrans = DTrans::where('htrans_id', $id)->get();
        $htrans = HTrans::findOrFail($id);
        return view('admin.reports.history-details', compact('htrans', 'dtrans'));
    }
}
