@extends('layouts.main')

@section('title', $diary->title ?? 'Homepage')

@section('content')
<!DOCTYPE html>
<html>
<head>
    <title>Cottage Marketplace</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f8f9fa; }
        .navbar { background-color: #007bff; color: white; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; }
        .navbar a { color: white; text-decoration: none; margin: 0 15px; }
        .navbar a:hover { text-decoration: underline; }
        .user-info { display: flex; align-items: center; gap: 15px; }
        .logout-btn { background: #dc3545; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer; }
        .logout-btn:hover { background: #c82333; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .hero { text-align: center; padding: 60px 0; }
        .hero h1 { font-size: 3em; color: #333; margin-bottom: 20px; }
        .hero p { font-size: 1.2em; color: #666; margin-bottom: 30px; }
        .btn { display: inline-block; background-color: #007bff; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 10px; }
        .btn:hover { background-color: #0056b3; }
        .btn-success { background-color: #28a745; }
        .btn-success:hover { background-color: #218838; }
        .demo-info { background-color: #e7f3ff; border: 1px solid #b3d9ff; border-radius: 5px; padding: 20px; margin: 20px 0; }
        .demo-info h3 { margin-top: 0; color: #0066cc; }
    </style>
</head>
<body>
    <nav class="navbar">
        <div>
            <a href="/">Home</a>
            <a href="/shop">Categories</a>
            @auth
                @if(auth()->user()->role === 'student')
                    <a href="{{ route('products.index') }}">My Products</a>
                @endif
                @if(auth()->user()->role === 'guest')
                    <a href="{{ route('apply.seller.form') }}">Apply to Sell</a>
                @endif
                @if(auth()->user()->role === 'admin')
                    <a href="/admin-demo">Admin Panel</a>
                @endif
            @endauth
        </div>
        
        <div class="user-info">
            @auth
                <span>Welcome, {{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})</span>
                <a href="/cart">Cart</a>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
            @endauth
        </div>
    </nav>

    <div class="container">
        <div class="hero">
            <h1>Welcome to Cottage Marketplace</h1>
            <p>A platform for local artisans and crafters to sell their handmade products</p>
            
            @guest
                <a href="{{ route('register') }}" class="btn btn-success">Get Started</a>
                <a href="{{ route('login') }}" class="btn">Login</a>
            @endguest
            
            <a href="/shop" class="btn">Browse Products</a>
        </div>

        @guest
            <div class="demo-info">
                <h3>Demo Accounts Available:</h3>
                <ul>
                    <li><strong>Admin:</strong> admin@demo.com (password: password) - Manage seller applications and products</li>
                    <li><strong>Seller:</strong> seller@demo.com (password: password) - Create and manage products (pre-approved)</li>
                    <li><strong>Buyer:</strong> buyer@demo.com (password: password) - Browse and purchase items</li>
                </ul>
                <p><strong>Note:</strong> New users register as guests and must apply to become sellers!</p>
            </div>
        @endguest

        <div style="margin-top: 40px;">
            <h2>Quick Links</h2>
            <a href="/shop" class="btn">Browse Shop</a>
            <a href="/apply-seller" class="btn">Apply as Seller</a>
            <a href="/cart" class="btn">View Cart</a>
            @auth
                @if(auth()->user()->role === 'admin')
                    <a href="/admin-demo" class="btn">Admin Dashboard</a>
                @endif
            @endauth
        </div>
    </div>
</body>
</html>
@endsection