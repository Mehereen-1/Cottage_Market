<!DOCTYPE html>
<html>
<head><title>Shop</title></head>
<body>
    <h1>Approved Products</h1>

    @if($products->count())
        <ul>
        @foreach($products as $p)
            <li>
                <strong>{{ $p->title }}</strong> - ${{ $p->price }} <br>
                {{ $p->description }} 
                <p>Seller: {{ $p->user->name }} (ID: {{ $p->user->id }})</p>
                <form method="GET" action="{{ url('/cart/add/'.$p->id) }}">
                    <button type="submit">Add to cart</button>
                </form>
            </li>
        @endforeach
        </ul>
    @else
        <p>No approved products yet.</p>
    @endif

    <a href="/">Back Home</a>
</body>
</html>
