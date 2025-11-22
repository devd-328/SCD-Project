@extends('layouts.app')

@section('title', 'Shopping Cart - AgriConnect')

@section('styles')
<style>
    .cart-table img{ width:80px; height:80px; object-fit:cover; }
    .cart-empty{ padding:4rem 0; text-align:center; }
    .cart-actions { display:flex; gap:0.5rem; align-items:center; }
    @media (max-width:575px){ .cart-table td:nth-child(1){display:none;} }
</style>
@endsection

@section('content')
<div class="container my-5">
    <h1 class="mb-4">Your Cart</h1>

    <div id="cart-root">
        <div class="card">
            <div class="card-body">
                <div id="cart-list-area"></div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Continue shopping</a>
        <button id="clearCartBtn" class="btn btn-danger ms-2">Clear cart</button>
    </div>
</div>

@endsection

@section('scripts')
    <script src="{{ asset('assets/js/cart.js') }}"></script>
<<<<<<< HEAD
=======
        <!-- Thank you modal (shown after simulated checkout) -->
        <div class="modal fade" id="thankYouModal" tabindex="-1" aria-labelledby="thankYouLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="thankYouLabel">Thank you!</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Your order has been placed.</p>
                        <p class="fw-semibold">Order total: <span id="thankYouTotal">₹0.00</span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
>>>>>>> b1ee59a59cecc1750eaa6a3df0b0c673f4bbfa4e
@endsection
