@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2 class="section-title mb-4">User Management</h2>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $customer)
                            <tr>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->status }}</td>
                                <td>
                                    <form action="{{ route('admin.users.toggleStatus', $customer->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-{{ $customer->status === 'active' ? 'danger' : 'success' }}">
                                            {{ $customer->status === 'active' ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .section-title {
        font-size: 3rem; /* Perbesar ukuran font judul */
    }
    .table th, .table td {
        font-size: 1.5rem; /* Perbesar ukuran font tabel */
    }
    .btn {
        font-size: 1.25rem; /* Perbesar ukuran font tombol */
    }
</style>
@endsection
