<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register - AgriConnect</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            min-height: 100vh;
        }
        .auth-card {
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            border-radius: 1rem;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card auth-card">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <a href="{{ route('home') }}" class="text-decoration-none">
                            <i class="bi bi-flower2 text-success display-4"></i>
                            <h3 class="fw-bold text-success mt-2">AgriConnect</h3>
                        </a>
                        <p class="text-muted mt-2">Create Account & Join Community</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-person text-muted"></i>
                                </span>
                                <input type="text" class="form-control border-start-0 @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="John Doe">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Email Address -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-envelope text-muted"></i>
                                </span>
                                <input type="email" class="form-control border-start-0 @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="name@example.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-lock text-muted"></i>
                                </span>
                                <input type="password" class="form-control border-start-0 border-end-0 @error('password') is-invalid @enderror" 
                                       id="password" name="password" required autocomplete="new-password" placeholder="Create a password">
                                <button class="btn btn-outline-secondary border-start-0" type="button" id="togglePassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-lock-fill text-muted"></i>
                                </span>
                                <input type="password" class="form-control border-start-0 border-end-0" 
                                       id="password_confirmation" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password">
                                <button class="btn btn-outline-secondary border-start-0" type="button" id="toggleConfirmPassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-success btn-lg">Register</button>
                        </div>

                        <!-- Login Link -->
                        <div class="text-center mb-3">
                            <span class="text-muted">Already have an account?</span>
                            <a href="{{ route('login') }}" class="text-decoration-none fw-bold text-success">Log In</a>
                        </div>

                        <!-- Back to Home -->
                        <div class="text-center">
                            <a href="{{ route('home') }}" class="text-decoration-none text-muted small">
                                <i class="bi bi-arrow-left me-1"></i> Back to Home
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle Password
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                const icon = this.querySelector('i');
                icon.classList.toggle('bi-eye');
                icon.classList.toggle('bi-eye-slash');
            });
        }

        // Toggle Confirm Password
        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const confirmPasswordInput = document.getElementById('password_confirmation');
        if (toggleConfirmPassword && confirmPasswordInput) {
            toggleConfirmPassword.addEventListener('click', function() {
                const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                confirmPasswordInput.setAttribute('type', type);
                const icon = this.querySelector('i');
                icon.classList.toggle('bi-eye');
                icon.classList.toggle('bi-eye-slash');
            });
        }
    });
</script>
</body>
</html>

