@extends('layouts.main')

@section('title', 'Welcome to Cottage Diary')

@section('content')
<div class="cottage-home">
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1 class="main-title">Welcome to Cottage Diary</h1>
            <p class="subtitle">A cozy corner for handmade treasures and heartfelt recipes</p>
            
            @guest
                <div class="cta-buttons">
                    <a href="{{ route('register') }}" class="btn-cottage">Join Our Community</a>
                    <a href="{{ route('login') }}" class="btn-cottage btn-cottage-outline">Sign In</a>
                </div>
            @endguest
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <div class="feature-grid">
                <div class="feature-card">
                    <div class="feature-icon">🌿</div>
                    <h3>Handmade Crafts</h3>
                    <p>Discover unique treasures made with love</p>
                    <a href="/shop" class="feature-link">Browse Shop</a>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">📝</div>
                    <h3>Share Recipes</h3>
                    <p>Document and share your favorite recipes</p>
                    <a href="/diaries" class="feature-link">View Diaries</a>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">🎨</div>
                    <h3>Start Selling</h3>
                    <p>Share your creations with the world</p>
                    <a href="{{ route('apply.seller.form') }}" class="feature-link">Become a Seller</a>
                </div>
            </div>
        </div>
    </section>

    @guest
        <section class="demo-section">
            <div class="container">
                <div class="demo-card">
                    <h3>🔑 Try Demo Accounts</h3>
                    <div class="demo-grid">
                        <div class="demo-item">
                            <strong>Admin</strong>
                            <span>admin@demo.com</span>
                        </div>
                        <div class="demo-item">
                            <strong>Seller</strong>
                            <span>seller@demo.com</span>
                        </div>
                        <div class="demo-item">
                            <strong>Buyer</strong>
                            <span>buyer@demo.com</span>
                        </div>
                    </div>
                    <p class="demo-note">Password for all accounts: "password"</p>
                </div>
            </div>
        </section>
    @endguest
</div>

<style>
    .cottage-home {
        background-color: #faf6f1;
    }

    .hero-section {
        padding: 6rem 0;
        text-align: center;
        background: linear-gradient(rgba(255,255,255,0.9), rgba(255,255,255,0.9)), 
                    url('/images/cottage-bg.jpg');
        background-size: cover;
        background-position: center;
    }

    .main-title {
        color: #6c584c;
        font-size: 3.5rem;
        margin-bottom: 1rem;
        font-family: 'Playfair Display', serif;
    }

    .subtitle {
        color: #a98467;
        font-size: 1.2rem;
        margin-bottom: 2rem;
    }

    .btn-cottage {
        display: inline-block;
        padding: 0.8rem 2rem;
        margin: 0.5rem;
        border-radius: 30px;
        background-color: #a98467;
        color: white;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-cottage:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(169,132,103,0.2);
    }

    .btn-cottage-outline {
        background-color: transparent;
        border: 2px solid #a98467;
        color: #a98467;
    }

    .features-section {
        padding: 5rem 0;
    }

    .feature-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        padding: 2rem 0;
    }

    .feature-card {
        background: white;
        padding: 2rem;
        border-radius: 15px;
        text-align: center;
        transition: transform 0.3s ease;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }

    .feature-card:hover {
        transform: translateY(-5px);
    }

    .feature-icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }

    .feature-card h3 {
        color: #6c584c;
        margin-bottom: 0.5rem;
    }

    .feature-card p {
        color: #a98467;
        margin-bottom: 1rem;
    }

    .feature-link {
        color: #6c584c;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s ease;
    }

    .feature-link:hover {
        color: #a98467;
    }

    .demo-section {
        padding: 3rem 0;
        background-color: #fff;
    }

    .demo-card {
        background: #f6e8dc;
        border-radius: 15px;
        padding: 2rem;
        text-align: center;
    }

    .demo-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin: 1.5rem 0;
    }

    .demo-item {
        background: white;
        padding: 1rem;
        border-radius: 10px;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .demo-note {
        color: #6c584c;
        font-size: 0.9rem;
        margin-top: 1rem;
    }

    @media (max-width: 768px) {
        .main-title {
            font-size: 2.5rem;
        }

        .hero-section {
            padding: 4rem 0;
        }

        .feature-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection