<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Cottagecore Diary')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/cottagecore.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            margin: 0;
        }

        .cottage-content {
            flex: 1 0 auto;
        }

        .cottage-footer {
            flex-shrink: 0;
            background-color: #f6e8dc;
            padding: 1rem 0;
            margin-top: 2rem;
            box-shadow: 0 -2px 4px rgba(0,0,0,0.05);
        }

        .cottage-footer p {
            margin: 0;
            color: #6c584c;
        }

        .cottage-footer .tiny {
            font-size: 0.8rem;
            color: #a98467;
        }

        .cottage-header {
            background-color: #f6e8dc;
            padding: 1rem 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .header-inner {
            padding: 0 1rem;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .logo {
            height: 40px;
            width: auto;
        }

        .brand-text {
            color: #6c584c;
            text-decoration: none;
            font-size: 1.25rem;
            font-weight: 600;
        }

        .nav-links {
            gap: 1.5rem;
        }

        .nav-link {
            color: #6c584c;
            text-decoration: none;
            font-size: 1rem;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: #a98467;
        }

        .search-form {
            max-width: 250px;
        }

        /* Hamburger menu styles */
        .hamburger {
            display: none;
            background: none;
            border: none;
            padding: 0.5rem;
            cursor: pointer;
        }

        .bar {
            display: block;
            width: 25px;
            height: 3px;
            margin: 5px auto;
            background-color: #6c584c;
            transition: all 0.3s ease-in-out;
        }

        @media (max-width: 991px) {
            .hamburger {
                display: block;
            }

            .nav-links {
                display: none !important;
                position: absolute;
                top: 80px;
                left: 0;
                right: 0;
                background: #f8f9fa;
                flex-direction: column !important;
                padding: 1rem;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }

            .nav-links.active {
                display: flex !important;
            }

            .search-form {
                width: 100%;
                max-width: none;
                margin: 1rem 0;
            }
        }
    </style>
</head>
<body>
    {{-- 🌸 Header --}}
    <header class="cottage-header">
        <div class="header-inner container">
            <div class="row align-items-center">
                <!-- Brand Logo -->
                <div class="col-auto">
                    <div class="brand">
                        <img src="{{ asset('images/branch.png') }}" alt="logo" class="logo">
                        <a href="/" class="brand-text">Home</a>
                    </div>
                </div>

                <!-- Hamburger Menu -->
                <div class="col-auto d-lg-none ms-auto">
                    <button class="hamburger" type="button" id="menu-toggle">
                        <span class="bar"></span>
                        <span class="bar"></span>
                        <span class="bar"></span>
                    </button>
                </div>

                <!-- Navigation Menu -->
                <div class="col">
                    <nav id="navbar-menu" class="nav-links">
                        <div class="d-lg-flex align-items-center justify-content-end w-100 gap-3">
                            <!-- Categories Dropdown -->
                            <div class="dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" id="categoriesDropdown" data-bs-toggle="dropdown">
                                    Categories
                                </a>
                                <ul class="dropdown-menu">
                                    @foreach($productCategories as $category)
                                        <li><a class="dropdown-item" href="{{ route('products.index', ['category' => $category->id]) }}">{{ $category->name }}</a></li>
                                    @endforeach
                                </ul>
                            </div>

                            <!-- Search Bar -->
                            <form method="GET" class="search-form d-flex">
                                <input type="text" name="query" class="form-control form-control-sm me-2" placeholder="Search...">
                                <button class="btn btn-sm btn-outline-primary" type="submit">🔍</button>
                            </form>

                            <!-- Auth Links -->
                            @auth
                                @php $role = auth()->user()->role; @endphp
                                
                                <!-- Common links for all authenticated users -->
                                <a href="{{ route('diary.index') }}" class="nav-link">Diary</a>
                                
                                <!-- Role-specific links -->
                                @if($role === 'guest')
                                    <a href="{{ route('orders.myOrders') }}" class="nav-link">My Orders</a>
                                @elseif($role === 'student')
                                    <a href="{{ route('products.seller.index') }}" class="nav-link">My Products</a>
                                @elseif($role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="nav-link">Admin</a>
                                @elseif($role === 'delivery')
                                    <a href="{{ route('delivery.index') }}" class="nav-link">Deliveries</a>
                                @endif

                                <!-- Notifications Dropdown -->
                                <div class="dropdown">
                                    <a class="nav-link dropdown-toggle position-relative" href="#" id="navbarDropdown" data-bs-toggle="dropdown">
                                        🔔
                                        <span id="notif-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                            {{ auth()->user()->unreadNotifications->count() }}
                                        </span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown" id="notif-dropdown">
                                        @forelse(auth()->user()->notifications as $notification)
                                            <li>
                                                <a class="dropdown-item notif-item {{ is_null($notification->read_at) ? 'fw-bold' : '' }}"
                                                href="#"
                                                data-id="{{ $notification->id }}">
                                                    {{ $notification->data['message'] }}
                                                    @if(is_null($notification->read_at))
                                                        <span class="badge bg-danger ms-2">●</span>
                                                    @endif
                                                </a>
                                            </li>
                                        @empty
                                            <li><a class="dropdown-item" href="#">No notifications</a></li>
                                        @endforelse
                                    </ul>
                                </div>

                                @if(in_array($role, ['guest', 'student']))
                                    <a href="{{ route('cart.index') }}" class="nav-link">🛒</a>
                                @endif

                                <a href="{{ route('logout') }}" class="nav-link"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign Out</a>

                            @else
                                <a href="{{route('shops.index')}}" class="nav-link">View Shops</a>
                                <a href="{{ route('login') }}" class="nav-link">Sign In</a>
                                <a href="{{ route('register') }}" class="nav-link">Register</a>
                            @endauth
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    {{-- 🍯 Page Content --}}
    <main class="cottage-content container-fluid">
        @yield('content')
    </main>

    {{-- 🕯 Footer --}}
    <footer class="cottage-footer text-center">
        <div class="container">
            <p>🪶 Made with love by <strong>Ayesha Mehereen</strong> • {{ date('Y') }}</p>
            <p class="tiny">A soft place to share cozy recipes, crafts, and dreams.</p>
        </div>
    </footer>


    <script>
        document.getElementById('menu-toggle').addEventListener('click', function() {
            document.getElementById('navbar-menu').classList.toggle('active');
            this.classList.toggle('open');
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('navbar-menu');
            const hamburger = document.getElementById('menu-toggle');
            if (!menu.contains(event.target) && !hamburger.contains(event.target)) {
                menu.classList.remove('active');
                hamburger.classList.remove('open');
            }
        });

        // Adjust menu on window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 991) {
                document.getElementById('navbar-menu').classList.remove('active');
                document.getElementById('menu-toggle').classList.remove('open');
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- notification -->
     <script>
        setInterval(() => {
            fetch('{{ route('notifications.fetch') }}')
                .then(res => res.json())
                .then data => {
                    const countEl = document.getElementById('notif-count');
                    countEl.textContent = data.count > 0 ? data.count : '';
                });
        }, 10000); // every 10 seconds
    </script>

    <script>
        document.getElementById('notif-dropdown').addEventListener('click', function(e) {
            const target = e.target.closest('.notif-item');
            if (!target) return;
            e.preventDefault();

            const notifId = target.dataset.id;

            fetch("{{ route('notifications.markRead') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ id: notifId })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Remove red dot and bold
                    target.classList.remove('fw-bold');
                    const badge = target.querySelector('.badge.bg-danger');
                    if (badge) badge.remove();

                    // Update badge count
                    document.getElementById('notif-count').textContent = data.unreadCount;
                }
            });
        });
        </script>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>

</body>
</html>
