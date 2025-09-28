<!DOCTYPE html>
<html>
<head><title>Admin Dashboard</title></head>
<body>
    <h1>Admin Dashboard</h1>

    <h2>Pending Seller Applications</h2>
    <ul>
        @forelse($applications as $a)
            <li>
                User ID: {{ $a->user_id }} — {{ $a->message }}
                <form method="POST" action="{{ route('admin.approveSeller', $a->id) }}">
                    @csrf
                    <button type="submit">Approve Seller</button>
                </form>
                <form method="POST" action="{{ route('admin.rejectSeller', $a->id) }}">
                    @csrf
                    <button type="submit">Reject Seller</button>
                </form>
            </li>
        @empty
            <p>No pending applications</p>
        @endforelse
    </ul>

    <h2>Pending Products</h2>
    <ul>
        @forelse($products as $p)
            <li>
                {{ $p->title }} - ${{ $p->price }}
                <form method="POST" action="{{ route('admin.approveProduct', $p->id) }}">
                    @csrf
                    <button type="submit">Approve Product</button>
                </form>
                <form method="POST" action="{{ route('admin.rejectProduct', $p->id) }}">
                    @csrf
                    <button type="submit">Reject Product</button>
                </form>
            </li>
        @empty
            <p>No pending products</p>
        @endforelse
    </ul>

    <a href="/">Back Home</a>
</body>
</html>
