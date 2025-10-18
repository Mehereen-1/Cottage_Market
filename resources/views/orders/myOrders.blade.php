@extends('layouts.main')

@section('content')
<h2>My Orders</h2>
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Total</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
        <tr>
            <td><a href="{{ route('orders.show', $order->id) }}">{{ $order->id }}</a></td>
            <td>{{ $order->total_amount }}</td>
            <td>{{ $order->status }}</td>
            <td><a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-info">View Details</a></td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
