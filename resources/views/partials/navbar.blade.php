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
            <!-- Search Bar -->
            <form class="d-flex mx-lg-4 my-2 my-lg-0 position-relative flex-grow-1" style="max-width: 400px;" onsubmit="return false;">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input class="form-control border-start-0 ps-0 bg-light" type="search" id="global-search" placeholder="Search products (name, category)..." aria-label="Search" autocomplete="off">
                </div>
                <div id="search-results" class="list-group position-absolute w-100 shadow mt-1" style="top: 100%; z-index: 1050; display: none; max-height: 400px; overflow-y: auto;">
                    <!-- Results will appear here -->
                </div>
            </form>

            <ul class="navbar-nav ms-auto align-items-center">
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
                <li class="nav-item ms-lg-3">
                    <a class="nav-link {{ request()->routeIs('cart') ? 'active' : '' }}" href="{{ route('cart') }}">
                        <i class="bi bi-cart me-1"></i> Cart <span id="cart-count" class="badge bg-success ms-1">0</span>
                    </a>
                </li>

                @auth
                    @if(Auth::user()->is_admin)
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->is('admin*') ? 'active' : '' }}" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-shield-lock me-1"></i> Admin
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.orders.index') }}">Manage Orders</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.users.index') }}">Manage Users</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('orders.index') }}">My Orders</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    @endif
                @else
                    <li class="nav-item ms-2">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Login
                        </a>
                    </li>
                    <li class="nav-item ms-2">
                        <a class="nav-link btn btn-success text-white px-3" href="{{ route('register') }}">
                            Register
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('global-search');
    const resultsContainer = document.getElementById('search-results');
    let timeout = null;

    if (searchInput && resultsContainer) {
        searchInput.addEventListener('keyup', function() {
            clearTimeout(timeout);
            const query = this.value;

            if (query.length < 2) {
                resultsContainer.style.display = 'none';
                resultsContainer.innerHTML = '';
                return;
            }

            timeout = setTimeout(() => {
                fetch(`{{ route('api.search') }}?query=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        resultsContainer.innerHTML = '';
                        if (data.length > 0) {
                            data.forEach(item => {
                                const el = document.createElement('a');
                                el.className = 'list-group-item list-group-item-action d-flex align-items-center p-2';
                                
                                if (item.type === 'farmer') {
                                    el.href = item.url;
                                    el.innerHTML = `
                                        <img src="${item.image_url}" class="rounded-circle me-2" width="40" height="40" style="object-fit: cover;">
                                        <div>
                                            <div class="fw-bold text-dark">${item.farm_name}</div>
                                            <div class="small text-muted"><i class="bi bi-person"></i> ${item.name} &bull; <i class="bi bi-geo-alt"></i> ${item.location}</div>
                                        </div>
                                    `;
                                } else {
                                    // Product
                                    el.href = `{{ route('products.index') }}?search=${encodeURIComponent(item.name)}`;
                                    el.innerHTML = `
                                        <img src="${item.image_url}" class="rounded me-2" width="40" height="40" style="object-fit: cover;">
                                        <div>
                                            <div class="fw-bold text-dark">${item.name}</div>
                                            <div class="small text-muted">${item.category} &bull; Rs. ${item.price}</div>
                                        </div>
                                    `;
                                }
                                resultsContainer.appendChild(el);
                            });
                            resultsContainer.style.display = 'block';
                        } else {
                            resultsContainer.innerHTML = '<div class="list-group-item text-muted p-2">No results found</div>';
                            resultsContainer.style.display = 'block';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching search results:', error);
                        resultsContainer.style.display = 'none';
                    });
            }, 300);
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !resultsContainer.contains(e.target)) {
                resultsContainer.style.display = 'none';
            }
        });
    }
});
</script>