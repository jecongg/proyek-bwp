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

    <h2 class="mb-4 mt-5">Laporan Penjualan</h2>
    
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.reports.generate') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="date" name="start_date" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tanggal Akhir</label>
                    <input type="date" name="end_date" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary d-block">Generate Laporan</button>
                </div>
            </form>
        </div>
    </div>

    @if(isset($reports) && count($reports) > 0)
    <div class="card">
        <div class="card-body">
            <h4>Laporan Penjualan: {{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }}</h4>
            <div class="table-responsive mt-4">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Total Transaksi</th>
                            <th>Total Penjualan</th>
                            <th>Total Produk Terjual</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reports as $date => $report)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($date)->format('d M Y') }}</td>
                            <td>{{ $report['total_transactions'] }}</td>
                            <td>Rp {{ number_format($report['total_sales'], 0, ',', '.') }}</td>
                            <td>{{ $report['total_products'] }}</td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal{{ \Carbon\Carbon::parse($date)->format('Ymd') }}">
                                    Lihat Detail
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @foreach($reports as $date => $report)
    <div class="modal fade" id="detailModal{{ \Carbon\Carbon::parse($date)->format('Ymd') }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Penjualan - {{ \Carbon\Carbon::parse($date)->format('d M Y') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Jumlah Terjual</th>
                                <th>Total Penjualan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($report['products'] as $product)
                            <tr>
                                <td>{{ $product['name'] }}</td>
                                <td>{{ $product['quantity'] }}</td>
                                <td>Rp {{ number_format($product['total'], 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @endif
</div>
@endsection
