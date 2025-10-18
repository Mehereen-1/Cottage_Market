@extends('layouts.main')

@section('content')
<div class="container">
    <h2 class="mb-4">All Orders</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Total</th>
                <th>Status</th>
                <th>Delivery</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>
                    <a href="{{ route('orders.show', $order->id) }}">{{ $order->id }}</a>
                </td>
                <td>{{ $order->user->name ?? 'N/A' }}</td>
                <td>{{ $order->total_amount ?? $order->total }}</td>
                <td>{{ $order->status }}</td>
                <td>{{ $order->delivery->status ?? 'Not assigned' }}</td>
                <td>
                    @if(!$order->delivery)
                        <form action="{{ route('orders.assign', $order->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-primary">Assign to Delivery</button>
                        </form>
                    @else
                        <span class="text-success">Assigned</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
