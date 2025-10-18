@extends('layouts.main')

@section('content')
<div class="container">
    <h2>Delivery Dashboard</h2>

    @if(session('success'))
        <div style="color: green">{{ session('success') }}</div>
    @endif

    <table border="1" cellpadding="6">
        <tr>
            <th>Order ID</th>
            <th>Customer</th>
            <th>Total</th>
            <th>Status</th>
            <th>Update</th>
        </tr>

        @foreach($deliveries as $delivery)
        <tr>
            <td>{{ $delivery->order->id }}</td>
            <td>{{ $delivery->order->user->name }}</td>
            <td>{{ $delivery->order->total_amount }}</td>
            <td>{{ ucfirst($delivery->status) }}</td>
            <td>
                <form action="{{ route('delivery.update', $delivery->id) }}" method="POST">
                    @csrf
                    <select name="status">
                        <option value="pending" {{ $delivery->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="picked" {{ $delivery->status == 'picked' ? 'selected' : '' }}>Picked</option>
                        <option value="shipped" {{ $delivery->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ $delivery->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    </select>
                    <button type="submit">Update</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
