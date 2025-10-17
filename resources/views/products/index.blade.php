@extends('layouts.main')

@section('title', $diary->title ?? 'Homepage')

@section('content')
<!DOCTYPE html>
<html>
<head><title>Shop</title></head>
<body>
    <h1>Approved Products</h1>

    @if($products->count())
        <ul>
        @foreach($products as $p)
            <li style="border: 1px solid #ddd; padding: 15px; margin: 10px 0; border-radius: 5px;">
                <h3><a href="{{ route('products.show', $p->id) }}">{{ $p->title }}</a></h3>
                <p><strong>Price:</strong> ${{ number_format($p->price, 2) }}</p>
                <p>{{ $p->description }}</p>
                <p><strong>Seller:</strong> {{ $p->user->name }}</p>
                @if($p->image)
                    <img src="{{ asset('storage/' . $p->image) }}" alt="{{ $p->title }}" style="max-width: 150px; max-height: 150px; margin: 10px 0;">
                @endif
                <br>
                <form method="POST" action="{{ route('cart.add', $p->id) }}" style="display: inline;">
                    @csrf
                    <button type="submit">Add to cart</button>
                </form>
            </li>
        @endforeach
        </ul>
    @else
        <p>No approved products yet.</p>
    @endif

    <a href="/">Back Home</a> | 
    <a href="{{ route('products.index') }}">Manage My Products</a>
</body>
</html>
@endsection
