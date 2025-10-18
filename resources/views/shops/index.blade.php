
@extends('layouts.main')

@section('content')

<div class="container py-4">
    <h2 class="mb-4 text-center" style="color: #6c584c;">Our Lovely Shops</h2>
    
    <div class="row g-4">
        @foreach($sellers as $seller)
        <div class="col-md-4">
            <div class="card h-100 shop-card" style="border-radius: 15px; overflow: hidden; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                <div class="position-relative">
                    <!-- Shop Banner Color -->
                    <div style="height: 100px; background: linear-gradient(45deg, #f6e8dc, #deb9a0);"></div>
                    
                    <!-- Shop Avatar -->
                    <div class="text-center" style="margin-top: -50px;">
                        <div class="rounded-circle bg-white p-2 d-inline-block">
                            <img src="{{ asset('images/default-avatar.png') }}" 
                                 class="rounded-circle"
                                 style="width: 80px; height: 80px; object-fit: cover;"
                                 alt="{{ $seller->name }}'s shop">
                        </div>
                    </div>
                </div>

                <div class="card-body text-center">
                    <h5 class="card-title" style="color: #6c584c;">{{ $seller->name }}'s Shop</h5>
                    <p class="text-muted">{{ $seller->products_count }} Products</p>
                    
                    <div class="mt-3">
                        <a href="{{ route('shops.show', $seller) }}" 
                           class="btn btn-outline-primary"
                           style="border-radius: 20px; border-color: #a98467; color: #6c584c;">
                            Visit Shop
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<style>
.shop-card {
    transition: transform 0.2s;
    background: #fff;
}

.shop-card:hover {
    transform: translateY(-5px);
}

.btn-outline-primary:hover {
    background-color: #a98467;
    border-color: #a98467;
    color: white;
}
</style>
@endsection