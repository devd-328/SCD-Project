<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <i class="bi bi-flower2 text-success fs-3 me-2"></i>
            <span class="fw-bold text-success">AgriConnect</span>
        </a>
        
        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <!-- Navigation Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        <i class="bi bi-house-door me-1"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                        <i class="bi bi-basket me-1"></i> Products
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('farmers.*') ? 'active' : '' }}" href="{{ route('farmers.index') }}">
                        <i class="bi bi-people me-1"></i> Community
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">
                        <i class="bi bi-info-circle me-1"></i> About
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact.*') ? 'active' : '' }}" href="{{ route('contact.index') }}">
                        <i class="bi bi-envelope me-1"></i> Contact
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('cart') ? 'active' : '' }}" href="{{ route('cart') }}">
                        <i class="bi bi-cart me-1"></i> Cart <span id="cart-count" class="badge bg-success ms-1">0</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin*') ? 'active' : '' }}" href="{{ url('/admin') }}">
                        <i class="bi bi-shield-lock me-1"></i> Admin
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>