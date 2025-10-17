<!DOCTYPE html>
<html>
<head>
    <title>{{ $product->title }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; max-width: 800px; }
        .product-detail { border: 1px solid #ddd; padding: 20px; border-radius: 5px; }
        .product-image { max-width: 300px; max-height: 300px; margin: 15px 0; }
        .price { font-size: 24px; font-weight: bold; color: #007bff; margin: 15px 0; }
        .description { margin: 15px 0; line-height: 1.6; }
        .seller-info { background-color: #f8f9fa; padding: 10px; border-radius: 4px; margin: 15px 0; }
        button { background-color: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
        button:hover { background-color: #218838; }
    </style>
</head>
<body>
    <h1>{{ $product->title }}</h1>
    
    <p><a href="/shop">← Back to Shop</a></p>

    <div class="product-detail">
        @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" class="product-image">
        @else
            <div style="width: 300px; height: 200px; background-color: #f8f9fa; border: 2px dashed #ddd; display: flex; align-items: center; justify-content: center; color: #666;">
                No Image Available
            </div>
        @endif

        <div class="price">${{ number_format($product->price, 2) }}</div>

        <div class="description">
            <h3>Description</h3>
            <p>{{ $product->description ?: 'No description provided.' }}</p>
        </div>

        <div class="seller-info">
            <h4>Sold by:</h4>
            <p>{{ $product->user->name }}</p>
        </div>

        <form method="POST" action="{{ route('cart.add', $product->id) }}">
            @csrf
            <button type="submit">Add to Cart</button>
        </form>
    </div>
</body>
</html>
