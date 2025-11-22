@extends('layouts.app')

@section('title', 'Checkout - AgriConnect')

@section('styles')
<style>
    .checkout-form label { font-weight: 500; }
    .checkout-summary { background: #f8f9fa; border-radius: 8px; padding: 1.5rem; }
    /* debug area removed in production */
</style>
@endsection

@section('content')
<div class="container my-4">
    <div class="row">
        <div class="col-md-7">
            <h3>Shipping Details</h3>
            <form id="checkoutForm" class="checkout-form">
                @csrf
                <div class="mb-3">
                    <label for="name">Full name</label>
                    <input id="name" class="form-control" required />
                </div>
                <div class="mb-3">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" required />
                </div>
                <div class="mb-3">
                    <label for="phone">Phone</label>
                    <input id="phone" class="form-control" required />
                </div>
                <div class="mb-3">
                    <label for="address">Address</label>
                    <textarea id="address" class="form-control" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label>Payment Method</label>
                    <div>
                        <div class="form-check">
                            <input id="cod" name="paymentMethod" class="form-check-input" type="radio" value="cod" checked />
                            <label class="form-check-label" for="cod">Cash on Delivery</label>
                        </div>
                        <div class="form-check">
                            <input id="card" name="paymentMethod" class="form-check-input" type="radio" value="card" />
                            <label class="form-check-label" for="card">Credit / Debit Card</label>
                        </div>
                    </div>
                </div>

                <div id="cardDetails" class="d-none mb-3">
                    <div class="mb-2"><input id="cardNumber" class="form-control" placeholder="Card number" inputmode="numeric" maxlength="19" autocomplete="cc-number" /></div>
                    <div class="row">
                        <div class="col-6">
                            <input id="cardExpiry" class="form-control" placeholder="MM/YY" maxlength="5" inputmode="numeric" pattern="(0[1-9]|1[0-2])\/\d{2}" autocomplete="cc-exp" title="Format: MM/YY" />
                        </div>
                        <div class="col-6"><input id="cardCVC" class="form-control" placeholder="CVC" maxlength="4" inputmode="numeric" /></div>
                    </div>
                </div> <!-- /#cardDetails -->

                <div class="mb-3">
                    <button type="submit" class="btn btn-success">Place Order</button>
                </div>
            </form>
        </div> <!-- /.col-md-7 -->

        <div class="col-md-5">
            <div class="checkout-summary">
                <h5 class="mb-3">Order Summary</h5>
                <div id="checkoutCartList"></div>
                <div class="d-flex justify-content-between"><div>Subtotal</div><div id="checkoutSub">Rs 0.00</div></div>
                <div class="d-flex justify-content-between"><div>Tax (5%)</div><div id="checkoutTax">Rs 0.00</div></div>
                <hr />
                <div class="d-flex justify-content-between fw-semibold"><div>Total</div><div id="checkoutTotal">Rs 0.00</div></div>
            </div>
        </div>
    </div> <!-- /.row -->
</div> <!-- /.container -->

@endsection

@section('scripts')
    <script src="{{ asset('assets/js/checkout.js') }}"></script>
@endsection

<!-- Thank You Modal -->
<div class="modal fade" id="checkoutThankYouModal" tabindex="-1" aria-labelledby="checkoutThankYouLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="checkoutThankYouLabel">Thank you for your order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-2">We received your order. A confirmation has been sent to:</p>
                <p class="small text-muted mb-2">Order #: <span id="checkoutThankYouOrderNumber">&nbsp;</span></p>
                <p class="fw-semibold mb-1" id="checkoutThankYouName">&nbsp;</p>
                <p class="small text-muted mb-3" id="checkoutThankYouEmail">&nbsp;</p>

                <div class="mb-3">
                    <div class="d-flex justify-content-between small text-muted"><div>Subtotal</div><div id="checkoutThankYouSubtotal">Rs 0.00</div></div>
                    <div class="d-flex justify-content-between small text-muted"><div>Tax (5%)</div><div id="checkoutThankYouTax">Rs 0.00</div></div>
                    <hr />
                    <div class="d-flex justify-content-between fw-semibold"><div id="checkoutThankYouAmountLabel">Total amount:</div><div id="checkoutThankYouTotal">Rs 0.00</div></div>
                </div>

                <div class="small text-muted">
                    <div><strong>Phone:</strong> <span id="checkoutThankYouPhone">&nbsp;</span></div>
                    <div><strong>Address:</strong> <span id="checkoutThankYouAddress">&nbsp;</span></div>
                    <div><strong>Payment:</strong> <span id="checkoutThankYouPayment">&nbsp;</span></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="/" class="btn btn-primary">Go to Home</a>
            </div>
        </div>
    </div>
</div>
