@extends('layouts.app')

@section('content')
<div class="container mt-4 mb-5">
    <h2 class="section-title mb-4">Orders</h2>
    
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>User Email</th>
                <th>Total Price</th>
                <th>Date Time</th>
                <th>Status</th>
             
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($htrans as $h)
                <tr>
                    <td>{{ $h->id }}</td>
                    <td>{{ $h->user->email }}</td>
                    <td>Rp {{ number_format($h->total_price, 0, ',', '.') }}</td>
                    <td>{{ $h->created_at }}</td>
                    <td><span class="{{ $h->status == 'pending' ? 'text-warning' : '' }}">
                        {{ $h->status }}
                    </span></td>
                    <td>
                        <a href="{{ route('admin.order.details', $h->id) }}" class="btn btn-info btn-sm">Details & Edit</a>
                    </td>
                    
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>
</div>
</div>
@endsection

