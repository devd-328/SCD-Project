<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>@yield('title', 'Admin - AgriConnect')</title>

	<!-- Bootstrap 5 CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Bootstrap Icons -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
	<!-- Custom CSS -->
	<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

	@yield('styles')
</head>
<body>
	@include('partials.navbar')

	<div class="container-fluid py-4">
		<div class="row">
			<div class="col-12">
				@yield('content')
			</div>
		</div>
	</div>

	@include('partials.footer')

    <!-- Global Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-danger" id="deleteConfirmationModalLabel">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>Confirm Deletion
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0">Are you sure you want to delete this item? This action cannot be undone.</p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteConfirmationForm" method="POST" action="" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

	<!-- Bootstrap JS -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
	<script src="{{ asset('assets/js/cart.js') }}"></script>
	<script src="{{ asset('assets/js/script.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var deleteModal = document.getElementById('deleteConfirmationModal');
            if (deleteModal) {
                deleteModal.addEventListener('show.bs.modal', function (event) {
                    var button = event.relatedTarget;
                    var actionUrl = button.getAttribute('data-action');
                    var form = document.getElementById('deleteConfirmationForm');
                    form.action = actionUrl;
                });
            }
        });
    </script>

	@stack('scripts')
	@yield('scripts')
</body>
</html>
