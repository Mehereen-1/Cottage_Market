@extends('layouts.main')

@section('title', 'Your Cozy Cart')

@section('content')
<div class="cart-page">
    <div class="container py-5">
        <h1 class="cart-title text-center mb-4">Your Lovely Basket</h1>
        
        @if(isset($cartItems) && $cartItems->count() > 0)
            <div class="row g-4">
                <!-- Cart Items List -->
                <div class="col-lg-8">
                    @php
                        $subtotal = 0;
                        $shipping = 5.00;
                    @endphp

                    @foreach($cartItems as $item)
                        @php
                            $subtotal += $item->product->price * $item->quantity;
                        @endphp
                        <div class="cart-item">
                            <div class="cart-item-content">
                                <img src="{{asset('storage/' . $item->product->image) }}" 
                                     alt="{{ $item->product->title }}" 
                                     class="cart-item-image">
                                
                                <div class="cart-item-details">
                                    <h3>{{ $item->product->name }}</h3>
                                    <p class="seller-name">by {{ $item->product->user->name }}</p>
                                    <p class="price">${{ number_format($item->product->price, 2) }}</p>
                                    
                                    <div class="quantity-controls">
                                        <form action="{{ route('cart.update', $item->id) }}" 
                                              method="POST" 
                                              class="d-inline-flex align-items-center">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" name="action" value="decrease" class="qty-btn">−</button>
                                            <span class="qty-display">{{ $item->quantity }}</span>
                                            <button type="submit" name="action" value="increase" class="qty-btn">+</button>
                                        </form>
                                        
                                         <form action="{{ route('cart.remove', $item->id) }}" 
                                              method="POST" 
                                              class="d-inline-block ms-3">
                                            @csrf
                                            <button type="submit" class="remove-btn">Remove</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Order Summary -->
                <div class="col-lg-4">
                    <div class="order-summary">
                        <h2>Order Summary</h2>
                        <div class="summary-row">
                            <span>Items ({{ $cartItems->sum('quantity') }})</span>
                            <span>${{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="summary-row">
                            <span>Shipping</span>
                            <span>${{ number_format($shipping, 2) }}</span>
                        </div>
                        <div class="summary-total">
                            <span>Total</span>
                            <span>${{ number_format($subtotal + $shipping, 2) }}</span>
                        </div>
                        <a href="{{ route('checkout') }}" class="checkout-btn">
                            Proceed to Checkout
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="empty-cart">
                <div class="empty-icon">🌿</div>
                <h2>Your basket is empty</h2>
                <p>Find something special in our lovely shop!</p>
                <a href="{{ route('products.index') }}" class="browse-btn">
                    Browse Shop
                </a>
            </div>
        @endif
    </div>
</div>

<style>
    .cart-page {
        background-color: #faf6f1;
        min-height: 80vh;
        padding: 2rem 0;
    }

    .cart-title {
        font-family: 'Cormorant Garamond', serif;
        color: #6c584c;
        font-size: 2.2rem;
    }

    .cart-item {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }

    .cart-item-content {
        display: grid;
        grid-template-columns: 100px 1fr;
        gap: 1.5rem;
        align-items: center;
    }

    .cart-item-image {
        width: 100%;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
    }

    .cart-item-details h3 {
        font-family: 'Cormorant Garamond', serif;
        color: #6c584c;
        font-size: 1.2rem;
        margin-bottom: 0.3rem;
    }

    .seller-name {
        color: #a98467;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .price {
        color: #6c584c;
        font-weight: 500;
        margin-bottom: 1rem;
    }

    .quantity-controls {
        display: flex;
        align-items: center;
    }

    .qty-btn {
        width: 28px;
        height: 28px;
        border: none;
        background: #f6e8dc;
        color: #6c584c;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .qty-btn:hover {
        background: #e6d5c7;
    }

    .qty-display {
        padding: 0 1rem;
        color: #6c584c;
    }

    .remove-btn {
        border: none;
        background: none;
        color: #cc9b8d;
        text-decoration: underline;
        cursor: pointer;
    }

    .order-summary {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }

    .order-summary h2 {
        font-family: 'Cormorant Garamond', serif;
        color: #6c584c;
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
        color: #6c584c;
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 2px solid #f6e8dc;
        font-weight: 500;
        color: #6c584c;
    }

    .checkout-btn {
        display: block;
        width: 100%;
        padding: 0.8rem;
        margin-top: 1.5rem;
        background: #a98467;
        color: white;
        text-align: center;
        text-decoration: none;
        border-radius: 25px;
        transition: all 0.2s ease;
    }

    .checkout-btn:hover {
        background: #8b6b4f;
        transform: translateY(-2px);
    }

    .empty-cart {
        text-align: center;
        padding: 3rem 0;
    }

    .empty-icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }

    .empty-cart h2 {
        font-family: 'Cormorant Garamond', serif;
        color: #6c584c;
        margin-bottom: 0.5rem;
    }

    .empty-cart p {
        color: #a98467;
        margin-bottom: 1.5rem;
    }

    .browse-btn {
        display: inline-block;
        padding: 0.8rem 2rem;
        background: #a98467;
        color: white;
        text-decoration: none;
        border-radius: 25px;
        transition: all 0.2s ease;
    }

    .browse-btn:hover {
        background: #8b6b4f;
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .cart-item-content {
            grid-template-columns: 1fr;
            text-align: center;
            gap: 1rem;
        }

        .cart-item-image {
            width: 120px;
            margin: 0 auto;
        }

        .quantity-controls {
            justify-content: center;
        }

        .order-summary {
            margin-top: 2rem;
        }
    }
</style>
@endsection
