<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Cottagecore Diary')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/cottagecore.css') }}" rel="stylesheet">
</head>
<body>
    {{-- 🌸 Header --}}
    <header class="cottage-header">
        <div class="header-inner container d-flex align-items-center justify-content-between">
            <div class="brand">
                <img src="{{ asset('images/branch.png') }}" alt="logo" class="logo">
                <a href="/" class="brand-text">Home</a>
            </div>

             <button class="hamburger d-md-none" type="button" id="menu-toggle" aria-label="Toggle menu">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </button>
            <nav id="navbar-menu" class="nav-links d-flex flex-direction-row align-items-center">
                 <!-- Categories Dropdown -->
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" id="categoriesDropdown"
                    data-bs-toggle="dropdown" aria-expanded="false">
                        Categories
                    </a>

                    <ul class="dropdown-menu" aria-labelledby="categoriesDropdown">
                        @foreach($productCategories as $category)
                            <li>
                                <a class="dropdown-item" href="{{ route('products.index', ['category' => $category->id]) }}">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    
                </div>
                <!-- Simple Search Bar -->
                <form method="GET" class="d-flex align-items-center ms-2">
                    <input type="text" name="query" class="form-control form-control-sm me-2" placeholder="Search...">
                    <button class="btn btn-sm btn-outline-primary" type="submit">🔍</button>
                </form>

                <!-- Authenticated Users -->
                @auth
                    @php $role = auth()->user()->role; @endphp

                    @if($role === 'guest')
                        <a href="{{ route('diary.index') }}" class="nav-link">Diary</a>
                        <a href="/" class="nav-link">🔔</a>
                        <a href="{{ route('cart.index') }}" class="nav-link">🛒</a>
                        <a href="{{ route('logout') }}" class="nav-link"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign Out</a>

                    @elseif($role === 'student')
                        <a href="{{ route('products.seller.index') }}" class="nav-link">My Products</a>
                        <a href="{{ route('diary.index') }}" class="nav-link">Diary</a>
                        <a href="/" class="nav-link">🔔</a>
                        <a href="{{ route('cart.index') }}" class="nav-link">🛒</a>
                        <a href="{{ route('logout') }}" class="nav-link"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign Out</a>

                    @elseif($role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="nav-link">Admin Dashboard</a>
                        <a href="{{ route('diary.index') }}" class="nav-link">Diary</a>
                        <a href="/" class="nav-link">🔔</a>
                        <a href="{{ route('logout') }}" class="nav-link"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign Out</a>
                    @endif

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @else
                    <a href="{{ route('diary.index') }}" class="nav-link">Diary</a>
                    <a href="/shop" class="nav-link">View Shops</a>
                    <a href="{{ route('login') }}" class="nav-link">Sign In</a>
                    <a href="{{ route('register') }}" class="nav-link">Register</a>
                @endauth
            </nav>
        </div>
    </header>

    {{-- 🍯 Page Content --}}
    <main class="cottage-content container-fluid">
        @yield('content')
    </main>

    {{-- 🕯 Footer --}}
    <footer class="cottage-footer text-center">
        <p>🪶 Made with love by <strong>Ayesha Mehereen</strong> • {{ date('Y') }}</p>
        <p class="tiny">A soft place to share cozy recipes, crafts, and dreams.</p>
    </footer>


    <script>
        document.getElementById('menu-toggle').addEventListener('click', function() {
        document.querySelector('navbar-menu').classList.toggle('active');
        this.classList.toggle('open');
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    
</body>
</html>
