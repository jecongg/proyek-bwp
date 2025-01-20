@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2 class="section-title mb-4">Transaction Reports</h2>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User ID</th>
                            <th>User Email</th>
                            <th>Username</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Date Time</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($htrans as $h)
                            <tr>
                                <td>{{ $h->id }}</td>
                                <td>{{ $h->user->id }}</td>
                                <td>{{ $h->user->email }}</td>
                                <td>{{ $h->user->name }}</td>
                                <td>Rp {{ number_format($h->total_price, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge {{ $h->status == 'completed' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $h->status }}
                                    </span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($h->created_at)->format('d M Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('admin.reports.history-details', $h->id) }}" class="btn btn-info btn-lg">Details</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="container my-5">
        <h1 class="text-center mb-4">Generate Reports</h1>

        <form action="{{ route('admin.reports.handle') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Tanggal Mulai</label>
                <input type="date" name="start_date" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Tanggal Selesai</label>
                <input type="date" name="end_date" class="form-control" required>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" name="action" value="generate" class="btn btn-primary btn-lg">Generate Reports Here</button>
                <button type="submit" name="action" value="export" class="btn btn-secondary btn-lg ms-2">Export to Excel File</button>
            </div>
        </form>
    </div>
</div>

<style>
    .section-title {
        font-size: 2.5rem;
    }
    .table th, .table td {
        font-size: 1.25rem;
    }
    .badge {
        font-size: 1.25rem;
    }
    .form-label {
        font-size: 1.5rem;
    }
    .form-control {
        font-size: 1.25rem;
    }
    .btn-lg {
        font-size: 1.25rem;
    }
</style>

@endsection
