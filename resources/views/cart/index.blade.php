<DOCTYPE html>
<html>
<head><title>Your Cart</title></head>
<body>
<div class="container">
    <h2>Your Cart</h2>

    @if($cartItems->isEmpty())
        <p>Your cart is empty.</p>
    @else
        <table border="1" cellpadding="10">
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Subtotal</th>
                <th>Action</th> 
            </tr>
            @foreach($cartItems as $item)
                <tr>
                    <td>{{ $item->product->title }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->product->price }}</td>
                    <td>{{ $item->product->price * $item->quantity }}</td>
                    <td>
                        <form method="POST" action="{{ url('/cart/remove/'.$item->id) }}">
                            @csrf
                            <button type="submit">Remove</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>

        <h3>Total: {{ $total }}</h3>

        <form method="POST" action="{{ route('checkout') }}">
            @csrf
            <button type="submit">Confirm Order</button>
        </form>
    @endif
</div>
</body>
</html>
