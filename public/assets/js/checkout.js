document.addEventListener('DOMContentLoaded', function() {
    console.log('checkout script loaded');

    function escapeHtml(str) {
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');
    }

    // Luhn algorithm for card number validation
    function luhnCheck(ccNum) {
        const s = ccNum.replace(/\D/g, '');
        let sum = 0;
        let shouldDouble = false;
        for (let i = s.length - 1; i >= 0; i--) {
            let digit = parseInt(s.charAt(i), 10);
            if (shouldDouble) {
                digit *= 2;
                if (digit > 9) digit -= 9;
            }
            sum += digit;
            shouldDouble = !shouldDouble;
        }
        return (sum % 10) === 0;
    }

    // Basic card brand detection for CVC length rules
    function detectCardBrand(number) {
        const n = number.replace(/\D/g, '');
        if (/^3[47]/.test(n)) return 'amex';
        if (/^4/.test(n)) return 'visa';
        if (/^5[1-5]/.test(n) || /^2(2[2-9]|[3-6][0-9]|7[01]|720)/.test(n)) return 'mastercard';
        return 'unknown';
    }

    const cardDetails = document.getElementById('cardDetails');
    document.querySelectorAll('input[name="paymentMethod"]').forEach(r => r.addEventListener('change', function() {
        if (this.value === 'card') cardDetails.classList.remove('d-none'); else cardDetails.classList.add('d-none');
    }));

    // expiry input handling: always show slash after month and format MM/YY
    const expiryEl = document.getElementById('cardExpiry');
    if (expiryEl) {
        expiryEl.addEventListener('input', function(e) {
            const raw = this.value.replace(/\D/g, '').slice(0,4);
            if (raw.length === 0) { this.value = ''; return; }
            if (raw.length === 1) {
                // prefix single-digit months with 0 and add slash to help typing
                const month = ('0' + raw).slice(-2);
                this.value = month + '/';
                return;
            }
            const monthNum = parseInt(raw.slice(0,2), 10);
            let month = isNaN(monthNum) ? 1 : monthNum;
            if (month < 1) month = 1;
            if (month > 12) month = 12;
            const monthStr = String(month).padStart(2, '0');
            const yearPart = raw.slice(2);
            if (yearPart.length) this.value = monthStr + '/' + yearPart;
            else this.value = monthStr + '/';
        });

        expiryEl.addEventListener('paste', function(e) {
            e.preventDefault();
            const text = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '').slice(0,4);
            if (text.length === 0) { this.value = ''; return; }
            if (text.length === 1) {
                const month = ('0' + text).slice(-2);
                this.value = month + '/';
                return;
            }
            const monthNum = parseInt(text.slice(0,2), 10);
            let month = isNaN(monthNum) ? 1 : monthNum;
            if (month < 1) month = 1;
            if (month > 12) month = 12;
            const monthStr = String(month).padStart(2, '0');
            const yearPart = text.slice(2);
            this.value = yearPart.length ? monthStr + '/' + yearPart : monthStr + '/';
        });
    }

    function renderCheckoutCart() {
        const listEl = document.getElementById('checkoutCartList');
        const subEl = document.getElementById('checkoutSub');
        const taxEl = document.getElementById('checkoutTax');
        const totalEl = document.getElementById('checkoutTotal');
        const cart = JSON.parse(localStorage.getItem('agri_cart') || '[]');
        console.log('renderCheckoutCart', cart);

        let html = '';
        let subtotal = 0;

        if (!cart || cart.length === 0) {
            html = '<p>Your cart is empty.</p>';
            if (listEl) listEl.innerHTML = html;
            if (subEl) subEl.textContent = 'Rs 0.00';
            if (taxEl) taxEl.textContent = 'Rs 0.00';
            if (totalEl) totalEl.textContent = 'Rs 0.00';
            return 0;
        }

        html = '<ul class="list-group mb-3">';
        cart.forEach(item => {
            const price = parseFloat(item.price) || 0;
            const qty = parseInt(item.qty, 10) || 1;
            const line = +(price * qty).toFixed(2);
            subtotal += line;
            html += `<li class="list-group-item d-flex justify-content-between align-items-center">` +
                    `<div><div class="fw-semibold">${escapeHtml(item.name)} <span class="text-muted">x${qty}</span></div>` +
                    `<div class="small text-muted">Rs ${price.toFixed(2)} each</div></div>` +
                    `<div class="text-end">Rs ${line.toFixed(2)}</div></li>`;
        });
        html += '</ul>';

        const tax = +(subtotal * 0.05).toFixed(2);
        const total = +(subtotal + tax).toFixed(2);

        if (listEl) listEl.innerHTML = html;
        if (subEl) subEl.textContent = 'Rs ' + subtotal.toFixed(2);
        if (taxEl) taxEl.textContent = 'Rs ' + tax.toFixed(2);
        if (totalEl) totalEl.textContent = 'Rs ' + total.toFixed(2);

        console.log({ subtotal, tax, total });
        return total;
    }

    renderCheckoutCart();

    const form = document.getElementById('checkoutForm');
    if (form) form.addEventListener('submit', function(e) {
        e.preventDefault();
        const name = document.getElementById('name') ? document.getElementById('name').value.trim() : '';
        const email = document.getElementById('email') ? document.getElementById('email').value.trim() : '';
        const phone = document.getElementById('phone') ? document.getElementById('phone').value.trim() : '';
        const address = document.getElementById('address') ? document.getElementById('address').value.trim() : '';
        const pm = document.querySelector('input[name="paymentMethod"]:checked');
        const paymentMethod = pm ? pm.value : 'cod';

        if (!name || !email || !phone || !address) { alert('Please fill in all required fields.'); return; }

        if (paymentMethod === 'card') {
            const cardNumberEl = document.getElementById('cardNumber');
            const cardNumber = cardNumberEl ? cardNumberEl.value.trim() : '';
            const cardExpiry = document.getElementById('cardExpiry') ? document.getElementById('cardExpiry').value.trim() : '';
            const cardCVC = document.getElementById('cardCVC') ? document.getElementById('cardCVC').value.trim() : '';
            if (!cardNumber || !cardExpiry || !cardCVC) { alert('Please fill in all card details.'); return; }
            const expiryRegex = /^(0[1-9]|1[0-2])\/\d{2}$/;
            if (!expiryRegex.test(cardExpiry)) { alert('Please enter card expiry in MM/YY format.'); return; }
            // Luhn check
            if (!luhnCheck(cardNumber)) { alert('Please enter a valid card number.'); return; }
            // CVC length enforcement based on brand
            const brand = detectCardBrand(cardNumber);
            if (brand === 'amex' && cardCVC.length !== 4) { alert('American Express cards require a 4-digit CVC.'); return; }
            if ((brand === 'visa' || brand === 'mastercard' || brand === 'unknown') && cardCVC.length !== 3) { alert('Card CVC must be 3 digits.'); return; }
        }

        const total = renderCheckoutCart();
        const thankTotal = document.getElementById('checkoutThankYouTotal');
        const thankSub = document.getElementById('checkoutThankYouSubtotal');
        const thankTax = document.getElementById('checkoutThankYouTax');
        const thankName = document.getElementById('checkoutThankYouName');
        const thankEmail = document.getElementById('checkoutThankYouEmail');
        const thankPhone = document.getElementById('checkoutThankYouPhone');
        const thankAddress = document.getElementById('checkoutThankYouAddress');
        const thankPayment = document.getElementById('checkoutThankYouPayment');

        if (thankTotal) thankTotal.textContent = 'Rs ' + total.toFixed(2);
        if (thankSub) thankSub.textContent = document.getElementById('checkoutSub') ? document.getElementById('checkoutSub').textContent : 'Rs 0.00';
        if (thankTax) thankTax.textContent = document.getElementById('checkoutTax') ? document.getElementById('checkoutTax').textContent : 'Rs 0.00';
        // adjust amount label depending on payment method
        const amountLabel = document.getElementById('checkoutThankYouAmountLabel');
        if (amountLabel) {
            if (paymentMethod === 'card') {
                amountLabel.textContent = 'Amount paid:';
            } else {
                amountLabel.textContent = 'Total amount:';
            }
        }
        if (thankName) thankName.textContent = name;
        if (thankEmail) thankEmail.textContent = email;
        if (thankPhone) thankPhone.textContent = phone;
        if (thankAddress) thankAddress.textContent = address;
        if (thankPayment) thankPayment.textContent = paymentMethod === 'card' ? 'Credit/Debit Card' : 'Cash on Delivery';

        // Send order to server so we can decrement stock and persist order server-side
        const cart = JSON.parse(localStorage.getItem('agri_cart') || '[]');
        const tokenInput = document.querySelector('input[name="_token"]');
        const csrf = tokenInput ? tokenInput.value : null;

        if (!csrf) {
            alert('Missing CSRF token — cannot submit order.');
            return;
        }

        fetch('/checkout/complete', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf,
                'Accept': 'application/json'
            },
            credentials: 'same-origin',
            body: JSON.stringify({
                name: name,
                email: email,
                phone: phone,
                address: address,
                paymentMethod: paymentMethod,
                cart: cart
            })
        }).then(async res => {
            let data = {};
            try { data = await res.json(); } catch (e) { /* ignore parse errors */ }
            if (res.ok) {
                // clear cart and show modal
                localStorage.removeItem('agri_cart');
                // set order number if returned
                if (data && data.order_number) {
                    const orderEl = document.getElementById('checkoutThankYouOrderNumber');
                    if (orderEl) orderEl.textContent = data.order_number;
                }
                const modalEl = document.getElementById('checkoutThankYouModal');
                if (modalEl) {
                    const m = new bootstrap.Modal(modalEl);
                    // when user clicks any close button in the modal, go to home immediately
                    const closeBtns = modalEl.querySelectorAll('[data-bs-dismiss="modal"]');
                    closeBtns.forEach(btn => btn.addEventListener('click', function() { window.location.href = '/'; }));
                    // also redirect when the modal is hidden (covers backdrop/esc close)
                    modalEl.addEventListener('hidden.bs.modal', function() { window.location.href = '/'; });
                    m.show();
                } else {
                    window.location.href = '/';
                }
            } else {
                // read JSON error message if present
                let err = 'Failed to process order.';
                if (data && data.message) err = data.message;
                alert(err);
            }
        }).catch(err => {
            console.error('Order submit failed', err);
            alert('Failed to submit order. Please try again later.');
        });
    });

});
