@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Customers</h1>
    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <table class="table">
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
@endsection
