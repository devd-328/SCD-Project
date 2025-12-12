<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'AgriConnect - Farm to Consumer Marketplace')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- Google Fonts - Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    
    <script>
        window.isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
        window.loginUrl = "{{ route('login') }}";
    </script>

    @yield('styles')
</head>
<body>
    <!-- Navigation -->
    @include('partials.navbar')
    
    <!-- Main Content -->
    <main>
        @yield('content')
    </main>
    
    <!-- Footer -->
    @include('partials.footer')
    
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript -->
    <!-- Cart manager (frontend-only) -->
    <script src="{{ asset('assets/js/cart.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>

    {{-- Allow pages to push scripts into the stack (preferred) and also support yield for single-script pages --}}
    @stack('scripts')
    @yield('scripts')
</body>
</html>
