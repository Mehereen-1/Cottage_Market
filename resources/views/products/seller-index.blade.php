<!DOCTYPE html>
<html>
<head>
    <title>My Products</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .product { border: 1px solid #ddd; padding: 15px; margin: 10px 0; border-radius: 5px; }
        .status { padding: 3px 8px; border-radius: 3px; font-size: 12px; font-weight: bold; }
        .status.pending { background-color: #fff3cd; color: #856404; }
        .status.approved { background-color: #d4edda; color: #155724; }
        .status.rejected { background-color: #f8d7da; color: #721c24; }
        .actions { margin-top: 10px; }
        .actions a, .actions button { margin-right: 10px; padding: 5px 10px; text-decoration: none; border: 1px solid #ccc; background: #f8f9fa; }
        .actions button { cursor: pointer; }
        .actions form { display: inline; }
    </style>
</head>
<body>
    <h1>My Products</h1>
    
    <p><a href="{{ route('products.create') }}">Add New Product</a> | <a href="/shop">View Shop</a></p>

    @if($products->count())
        @foreach($products as $product)
            <div class="product">
                <h3>{{ $product->title }}</h3>
                <p><strong>Price:</strong> ${{ $product->price }}</p>
                <p><strong>Description:</strong> {{ $product->description }}</p>
                <p><strong>Status:</strong> <span class="status {{ $product->status }}">{{ ucfirst($product->status) }}</span></p>
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" style="max-width: 150px; max-height: 150px;">
                @endif
                
                <div class="actions">
                    <a href="{{ route('products.show', $product) }}">View</a>
                    <a href="{{ route('products.edit', $product) }}">Edit</a>
                    <form method="POST" action="{{ route('products.destroy', $product) }}" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach
    @else
        <p>You haven't created any products yet. <a href="{{ route('products.create') }}">Create your first product</a>!</p>
    @endif
</body>
</html>
