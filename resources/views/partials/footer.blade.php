<footer class="bg-dark text-light pt-5 pb-3 mt-5">
    <div class="container">
        <div class="row">
            <!-- About Section -->
            <div class="col-md-4 mb-4">
                <h5 class="text-success mb-3">
                    <i class="bi bi-flower2 me-2"></i>AgriConnect
                </h5>
                <p class="text-muted">
                    Connecting local farmers directly with consumers for fresh, organic, and sustainable produce.
                </p>
                <div class="social-links mt-3">
                    <a href="#" class="text-light me-3"><i class="bi bi-facebook fs-5"></i></a>
                    <a href="#" class="text-light me-3"><i class="bi bi-twitter fs-5"></i></a>
                    <a href="#" class="text-light me-3"><i class="bi bi-instagram fs-5"></i></a>
                    <a href="#" class="text-light"><i class="bi bi-linkedin fs-5"></i></a>
                </div>
            </div>
            
            <!-- Quick Links -->
            <div class="col-md-4 mb-4">
                <h5 class="text-success mb-3">Quick Links</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="{{ route('home') }}" class="text-muted text-decoration-none">
                            <i class="bi bi-chevron-right"></i> Home
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('products.index') }}" class="text-muted text-decoration-none">
                            <i class="bi bi-chevron-right"></i> Products
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('farmers.index') }}" class="text-muted text-decoration-none">
                            <i class="bi bi-chevron-right"></i> Community
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('about') }}" class="text-muted text-decoration-none">
                            <i class="bi bi-chevron-right"></i> About Us
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('contact.index') }}" class="text-muted text-decoration-none">
                            <i class="bi bi-chevron-right"></i> Contact
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Contact Info -->
            <div class="col-md-4 mb-4">
                <h5 class="text-success mb-3">Contact Info</h5>
                <ul class="list-unstyled text-muted">
                    <li class="mb-2">
                        <i class="bi bi-geo-alt text-success me-2"></i>
                        123 Farm Road, Karachi, Pakistan
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-telephone text-success me-2"></i>
                        +92 300 1234567
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-envelope text-success me-2"></i>
                        info@agriconnect.pk
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-clock text-success me-2"></i>
                        Mon - Sat: 8AM - 6PM
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Copyright -->
        <hr class="border-secondary">
        <div class="row">
            <div class="col-md-12 text-center">
                <p class="text-muted mb-0">
                    &copy; {{ date('Y') }} AgriConnect. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</footer>