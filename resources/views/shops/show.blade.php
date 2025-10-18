
@extends('layouts.main')

@section('content')
<div class="container py-4">
    <!-- Shop Header -->
    <div class="text-center mb-5">
        <div class="rounded-circle bg-white p-2 d-inline-block mb-3">
            <img src="{{ asset('images/default-avatar.png') }}" 
                 class="rounded-circle"
                 style="width: 120px; height: 120px; object-fit: cover;"
                 alt="{{ $user->name }}'s shop">
        </div>
        <h2 style="color: #6c584c;">{{ $user->name }}'s Shop</h2>
    </div>

    <!-- Products Grid -->
    <div class="row g-4">
        @foreach($products as $product)
        <div class="col-md-4">
            <div class="card h-100 product-card">
                <img src="{{ $product->image_url }}" 
                     class="card-img-top" 
                     style="height: 200px; object-fit: cover;"
                     alt="{{ $product->name }}">
                     
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text text-muted">{{ Str::limit($product->description, 100) }}</p>
                    <p class="card-text"><strong>${{ $product->price }}</strong></p>
                    
                    <a href="{{ route('products.show', $product) }}" 
                       class="btn btn-outline-primary w-100">
                        View Details
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<style>
.product-card {
    transition: transform 0.2s;
    border: none;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    border-radius: 15px;
    overflow: hidden;
}

.product-card:hover {
    transform: translateY(-5px);
}
</style>
@endsection