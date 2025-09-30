<h2>Payment for Order #{{ $order->id }}</h2>
<p>Total Amount: {{ $order->total_amount }} BDT</p>
<p>Status: {{ $order->payment_status }}</p>

@if($order->payment_status !== 'paid')
    <form method="POST" action="{{ route('payment.pay', $order->id) }}">
        @csrf
        <button type="submit">Pay with bKash</button>
    </form>
@endif

@if(session('success'))
    <p style="color:green;">{{ session('success') }}</p>
@endif
@if(session('error'))
    <p style="color:red;">{{ session('error') }}</p>
@endif
