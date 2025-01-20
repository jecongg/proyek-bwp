<?php

namespace App\Http\Controllers;


use App\Exports\TransactionsExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\HTrans;
use App\Models\DTrans;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class AdminController extends Controller
{
    public function reports()
    {
        $htrans = HTrans::whereIn('status', ['completed', 'cancelled'])
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('admin.reports', compact('htrans'));
    }

    public function handleReports(Request $request)
    {
        $startDate = Carbon::parse($request->start_date)->startOfDay();
        $endDate = Carbon::parse($request->end_date)->endOfDay();

        if ($request->input('action') == 'generate') {
            return $this->generateReport($startDate, $endDate);
        } elseif ($request->input('action') == 'export') {
            return $this->exportTransactions($startDate, $endDate);
        }
    }

    private function generateReport($startDate, $endDate)
    {
        $htrans = HTrans::whereIn('status', ['completed', 'cancelled'])
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('admin.reports', compact('htrans', 'startDate', 'endDate'));
    }

    private function exportTransactions($startDate, $endDate)
    {
        $transactions = $this->getTransactions($startDate, $endDate);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'User ID');
        $sheet->setCellValue('C1', 'User Email');
        $sheet->setCellValue('D1', 'Username');
        $sheet->setCellValue('E1', 'Total Price');
        $sheet->setCellValue('F1', 'Status');
        $sheet->setCellValue('G1', 'Date Time');
        $sheet->setCellValue('H1', 'Product Name');
        $sheet->setCellValue('I1', 'Quantity');
        $sheet->setCellValue('J1', 'Price');

        $row = 2;
        foreach ($transactions as $transaction) {
            foreach ($transaction->dtrans as $dtrans) {
                $sheet->setCellValue('A' . $row, $transaction->id);
                $sheet->setCellValue('B' . $row, $transaction->user->id);
                $sheet->setCellValue('C' . $row, $transaction->user->email);
                $sheet->setCellValue('D' . $row, $transaction->user->name);
                $sheet->setCellValue('E' . $row, $transaction->total_price);
                $sheet->setCellValue('F' . $row, $transaction->status);
                $sheet->setCellValue('G' . $row, $transaction->created_at);
                $sheet->setCellValue('H' . $row, $dtrans->product ? $dtrans->product->name : 'Product Deleted');
                $sheet->setCellValue('I' . $row, $dtrans->quantity);
                $sheet->setCellValue('J' . $row, $dtrans->price);
                $row++;
            }
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'transactions_' . $startDate->format('Ymd') . '_to_' . $endDate->format('Ymd') . '.xlsx';
        $filePath = storage_path('app/public/' . $fileName);
        $writer->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    private function getTransactions($startDate, $endDate)
    {
        return HTrans::whereIn('status', ['completed', 'cancelled'])
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->orderBy('created_at', 'desc')
                    ->get();
    }

    public function index()
    {
        $totalSales = HTrans::sum('total_price');
        $totalProductsSold = DTrans::sum('quantity');
        $totalUsersActive = User::where('status', 'active')->count();

        $recentUsers = User::orderBy('id', 'desc')->take(5)->get();

        // Get top selling products
        $topSellingProducts = DTrans::select('product_id', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('product_id')
            ->orderBy('total_quantity', 'desc')
            ->take(5)
            ->with('product')
            ->get()
            ->filter(function ($dtrans) {
                return $dtrans->product !== null;
            });

        $salesData = HTrans::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_price) as total_sales')
            )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $salesChartLabels = $salesData->pluck('date')->map(function ($date) {
            return Carbon::parse($date)->format('Y-m-d');
        });

        $salesChartData = $salesData->pluck('total_sales');

        return view('admin.dashboard', compact(
            'totalSales', 'totalProductsSold', 'totalUsersActive', 'recentUsers', 'topSellingProducts', 'salesChartLabels', 'salesChartData'
        ));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }

    public function orders()
    {
        // Logika untuk menampilkan pesanan
        $htrans = HTrans::whereIn('status', ['pending', 'processed'])->get();
        return view('admin.orders', compact('htrans')); // Buat file view di resources/views/admin/orders.blade.php
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
        $htrans = HTrans::findOrFail($id);
        $dtrans = DTrans::where('htrans_id', $id)->get();

        $productDeleted = false;
        foreach ($dtrans as $d) {
            if ($d->product === null) {
                $productDeleted = true;
                break;
            }
        }

        if ($productDeleted && in_array($htrans->status, ['pending', 'processed'])) {
            $htrans->status = 'cancelled';
            $htrans->save();
        }

        return view('admin.orders.order-details', compact('htrans', 'dtrans'));
    }

    public function orderEdit($id)
    {
        $htrans = HTrans::findOrFail($id);
        $dtrans = DTrans::where('htrans_id', $id)->get();
        return view('admin.orders.order-edit', compact('htrans', 'dtrans'));
    }


    public function historyDetails($id){
        $dtrans = DTrans::where('htrans_id', $id)->get();
        $htrans = HTrans::findOrFail($id);
        return view('admin.reports.history-details', compact('htrans', 'dtrans'));
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $htrans = HTrans::findOrFail($id);

            if ($request->input('action') == 'accept') {
                $htrans->status = 'processed';
            } elseif ($request->input('action') == 'complete') {
                $htrans->status = 'completed';
            } elseif ($request->input('action') == 'cancel') {
                $htrans->status = 'cancelled';
            }

            $htrans->save();

            DB::commit();
            return redirect()->back()->with('success', 'Order status berhasil diupdate!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


}
