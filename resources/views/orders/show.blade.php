@extends('layouts.main')

@section('content')
<div class="container my-4">
    <h2>Order #{{ $order->id }}</h2>
    <p>Status: <strong>{{ $order->status }}</strong></p>
    <p>Payment Status: <strong>{{ $order->payment_status }}</strong></p>

    <div class="card mb-3">
        <div class="card-header bg-light">
            Buyer Information
        </div>
        <div class="card-body">
            <p><strong>Name:</strong> {{ $order->user->name }}</p>
            <p><strong>Email:</strong> {{ $order->user->email }}</p>
            <p><strong>Address:</strong> {{ $order->address ?? 'N/A' }}</p>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header bg-light">
            Products in this Order
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Seller</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>
                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="img" width="60" height="60">
                            {{ $item->product->title }}
                        </td>
                        <td>{{ $item->product->seller->user->name ?? 'N/A' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ number_format($item->price, 2) }}</td>
                        <td>${{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <h5 class="text-end">Total: ${{ number_format($order->total_amount, 2) }}</h5>
        </div>
    </div>

    @if($order->delivery)
    <div class="card mb-3">
        <div class="card-header bg-light">
            Delivery Information
        </div>
        <div class="card-body">
            <p><strong>Status:</strong> {{ $order->delivery->status }}</p>
            <p><strong>Assigned At:</strong> {{ $order->delivery->created_at->format('d M Y H:i') }}</p>
        </div>
    </div>
    @endif

    <div class="text-end">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">← Back</a>
    </div>
</div>
@endsection
