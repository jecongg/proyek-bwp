@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">History Orders</h2>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Email</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($htrans as $h)
                    <tr>
                        <td>{{ $h->id }}</td>
                        <td>{{ $h->user->email }}</td>
                        <td>Rp {{ number_format($h->total_price, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ $h->status == 'paid' ? 'bg-success' : 'bg-danger' }}">
                                {{ $h->status }}
                            </span>
                        </td>
                        <td>{{ $h->created_at->format('d M Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.reports.history-details', $h->id) }}" class="btn btn-info btn-sm">Details</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="container my-5">
        <h1 class="text-center mb-4">Generate Reports</h1>

        <form action="{{ route('admin.reports.handle') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Tanggal Mulai</label>
                <input type="date" name="start_date" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Tanggal Akhir</label>
                <input type="date" name="end_date" class="form-control" required>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" name="action" value="generate" class="btn btn-primary me-2">Generate Laporan</button>
                <button type="submit" name="action" value="export" class="btn btn-secondary">Export to Excel</button>
            </div>
        </form>

        @if(isset($transactions) && count($transactions) > 0)
        <div class="card mt-5">
            <div class="card-body">
                <h4>Laporan Penjualan: {{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }}</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Transaction ID</th>
                            <th>User Name</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                            @foreach($transaction->dtrans as $dtrans)
                                <tr>
                                    <td>{{ $transaction->id }}</td>
                                    <td>{{ $transaction->user->name }}</td>
                                    <td>{{ $transaction->total_price }}</td>
                                    <td>{{ $transaction->status }}</td>
                                    <td>{{ $transaction->created_at }}</td>
                                    <td>{{ $dtrans->product->name }}</td>
                                    <td>{{ $dtrans->quantity }}</td>
                                    <td>{{ $dtrans->price }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
@endsection
