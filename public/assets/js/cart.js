(function () {
    const STORAGE_KEY = "agri_cart";

    // Small set of featured products shown in the empty-cart state
    const FEATURED_PRODUCTS = [];

    // A small promo product shown on the empty-cart page so users can add at least one item directly
    const PROMO_PRODUCT = {
        id: "promo-tomato",
        name: "Fresh Tomatoes (1kg)",
        price: 300,
        qty: 1,
        image: "/assets/images/products/tomatoes.webp",
    };

    function getCart() {
        try {
            return JSON.parse(localStorage.getItem(STORAGE_KEY) || "[]");
        } catch (e) {
            return [];
        }
    }
    function saveCart(cart) {
        localStorage.setItem(STORAGE_KEY, JSON.stringify(cart));
        window.dispatchEvent(new Event("storage"));
    }

    function formatCurrency(v) {
        return "₹" + Number(v).toFixed(2);
    }

    // Small toast helper
    function showToast(message, opts) {
        opts = opts || {};
        const type = opts.type || "success"; // success | info | danger
        const delay = typeof opts.delay === "number" ? opts.delay : 3000;

        // ensure container
        let container = document.getElementById("agri-toast-container");
        if (!container) {
            container = document.createElement("div");
            container.id = "agri-toast-container";
            container.className = "position-fixed top-0 end-0 p-3";
            container.style.zIndex = 10800;
            document.body.appendChild(container);
        }

        const mapClass = {
            success: "text-bg-success",
            info: "text-bg-secondary",
            danger: "text-bg-danger",
            warning: "text-bg-warning",
        };
        const bgClass = mapClass[type] || mapClass.success;

        const toast = document.createElement("div");
        toast.className = `toast align-items-center ${bgClass} border-0 mb-2`;
        toast.setAttribute("role", "status");
        toast.setAttribute("aria-live", "polite");
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">${String(message)}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        `;

        container.appendChild(toast);

        if (window.bootstrap && window.bootstrap.Toast) {
            try {
                const bsToast = new bootstrap.Toast(toast, { delay: delay });
                toast.addEventListener("hidden.bs.toast", function () {
                    try {
                        toast.remove();
                    } catch (e) {}
                });
                bsToast.show();
            } catch (e) {
                // fallback: remove after delay
                setTimeout(function () {
                    try {
                        toast.remove();
                    } catch (e) {}
                }, delay);
            }
        } else {
            setTimeout(function () {
                try {
                    toast.remove();
                } catch (e) {}
            }, delay);
        }
    }

    function renderEmpty() {
        // Build a friendly empty state and optionally one promo card (string-concatenation to avoid complex template nesting)
        var cardsHtml = "";
        if (FEATURED_PRODUCTS && FEATURED_PRODUCTS.length > 0) {
            for (var i = 0; i < FEATURED_PRODUCTS.length; i++) {
                var p = FEATURED_PRODUCTS[i];
                var base = p.image ? p.image.replace(/\.[^.]+$/, "") : "";
                cardsHtml +=
                    '<div class="col-sm-6 col-md-4 mb-3">' +
                    '<div class="card product-card h-100 border-0 shadow-sm hover-lift">' +
                    '<div class="product-image-wrapper position-relative">' +
                    "<picture>" +
                    '<source srcset="' +
                    base +
                    '.webp" type="image/webp">' +
                    '<img src="' +
                    p.image +
                    '" class="card-img-top" alt="' +
                    escapeHtml(p.name) +
                    '" onerror="this.src=\'https://via.placeholder.com/400x300?text=' +
                    encodeURIComponent(p.name) +
                    "'\">" +
                    "</picture>" +
                    "</div>" +
                    '<div class="card-body">' +
                    '<h5 class="card-title fw-bold mb-1">' +
                    escapeHtml(p.name) +
                    "</h5>" +
                    '<p class="card-text text-muted small mb-2">Fresh from local farms</p>' +
                    '<div class="d-flex justify-content-between align-items-center mt-3">' +
                    '<span class="h6 text-success mb-0">' +
                    formatCurrency(p.price) +
                    "</span>" +
                    '<button class="btn btn-success btn-sm empty-add-btn add-to-cart-btn" data-id="' +
                    p.id +
                    '" data-name="' +
                    escapeHtml(p.name) +
                    '" data-price="' +
                    p.price +
                    '" data-image="' +
                    p.image +
                    '" data-qty="1">' +
                    '<i class="bi bi-cart-plus me-1"></i>Add to Cart' +
                    "</button>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>";
            }
        } else {
            var p = PROMO_PRODUCT;
            var base = p.image ? p.image.replace(/\.[^.]+$/, "") : "";
            cardsHtml =
                '<div class="col-sm-6 col-md-4 mb-3">' +
                '<div class="card product-card h-100 border-0 shadow-sm hover-lift">' +
                '<div class="product-image-wrapper position-relative">' +
                "<picture>" +
                '<source srcset="' +
                base +
                '.webp" type="image/webp">' +
                '<img src="' +
                p.image +
                '" class="card-img-top" alt="' +
                escapeHtml(p.name) +
                '" onerror="this.src=\'https://via.placeholder.com/400x300?text=' +
                encodeURIComponent(p.name) +
                "'\">" +
                "</picture>" +
                "</div>" +
                '<div class="card-body">' +
                '<h5 class="card-title fw-bold mb-1">' +
                escapeHtml(p.name) +
                "</h5>" +
                '<p class="card-text text-muted small mb-2">Fresh from local farms</p>' +
                '<div class="d-flex justify-content-between align-items-center mt-3">' +
                '<span class="h6 text-success mb-0">' +
                formatCurrency(p.price) +
                "</span>" +
                '<button class="btn btn-success btn-sm empty-add-btn add-to-cart-btn" data-id="' +
                p.id +
                '" data-name="' +
                escapeHtml(p.name) +
                '" data-price="' +
                p.price +
                '" data-image="' +
                p.image +
                '" data-qty="1">' +
                '<i class="bi bi-cart-plus me-1"></i>Add to Cart' +
                "</button>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>";
        }

        var html = "";
        html += '<div class="row align-items-center py-5">';
        html += '<div class="col-md-7">';
        html += '<h3 class="fw-bold">Your cart is empty</h3>';
        html +=
            '<p class="text-muted">Looks like you haven\'t added anything yet. Start browsing fresh produce from local farmers.</p>';
        html += "<p>";
        html +=
            '<a href="/products" class="btn btn-success btn-lg me-2" id="shopPopularBtn"><i class="bi bi-basket-fill me-2"></i>Shop popular items</a>';
        html +=
            '<a href="/products" class="btn btn-outline-success me-2">Browse products</a>';
        html +=
            '<a href="/community" class="btn btn-outline-secondary">Meet Farmers</a>';
        html += "</p>";
        html +=
            '<p class="text-muted small mt-3">Tip: click "Shop popular items" to see hand-picked produce — you can add items to your cart directly from the products page.</p>';
        html += "</div>";
        html += '<div class="col-md-5 text-center d-none d-md-block">';
        html +=
            '<img src="/assets/images/empty-basket.png" alt="Empty basket" style="max-width:320px;opacity:0.6;" onerror="this.style.display=\'none\'"/>';
        html += "</div>";
        html += "</div>";
        if (cardsHtml) {
            html += "<hr/>";
            html += '<div class="row g-3 mt-3">' + cardsHtml + "</div>";
        }
        return html;
    }

    // Attach listeners for the featured product add buttons rendered in the empty state
    function attachEmptyListeners() {
        const root = document.getElementById("cart-list-area");
        if (!root) return;
        root.querySelectorAll(".empty-add-btn").forEach((btn) => {
            if (btn.dataset.agriAttached) return;
            btn.addEventListener("click", function (e) {
                e.preventDefault();
                const item = {
                    id: btn.getAttribute("data-id") || "f-" + Date.now(),
                    name: btn.getAttribute("data-name") || "Product",
                    price: parseFloat(btn.getAttribute("data-price")) || 0,
                    qty: parseInt(btn.getAttribute("data-qty") || "1", 10) || 1,
                    image: btn.getAttribute("data-image") || null,
                };
                try {
                    if (
                        window.AgriCart &&
                        typeof window.AgriCart.add === "function"
                    ) {
                        window.AgriCart.add(item);
                        showToast(`${item.name} added to cart.`);
                        updateBadge();
                        announce(`${item.name} added to cart.`);
                    } else {
                        showToast("Added to cart.");
                    }
                } catch (err) {
                    showToast("Added to cart.");
                }
            });
            btn.dataset.agriAttached = "1";
        });
    }

    // Small ARIA announcer for screen readers
    function announce(msg) {
        let region = document.getElementById("agri-aria-live");
        if (!region) {
            region = document.createElement("div");
            region.id = "agri-aria-live";
            region.setAttribute("aria-live", "polite");
            region.setAttribute("aria-atomic", "true");
            region.style.position = "absolute";
            region.style.left = "-9999px";
            document.body.appendChild(region);
        }
        region.textContent = msg;
    }

    function renderCart() {
        const root = document.getElementById("cart-list-area");
        if (!root) return;
        const cart = getCart();
        if (!cart || cart.length === 0) {
            root.innerHTML = renderEmpty();
            // attach listeners for featured product buttons
            attachEmptyListeners();
            updateBadge();
            return;
        }

        let html =
            '<div class="table-responsive"><table class="table cart-table align-middle">';
        html +=
            "<thead><tr><th></th><th>Product</th><th>Price</th><th>Qty</th><th>Subtotal</th><th></th></tr></thead><tbody>";
        let subtotal = 0;
        cart.forEach((it, idx) => {
            const line = it.price * it.qty || 0;
            subtotal += line;
            html += `<tr data-idx="${idx}">
                <td><img src="${
                    it.image || "/assets/images/placeholder.png"
                }" alt=""/></td>
                <td>${escapeHtml(it.name)}</td>
                <td>${formatCurrency(it.price)}</td>
                <td><input class="form-control qty-input" type="number" min="1" value="${
                    it.qty
                }" style="width:90px"/></td>
                <td class="line-sub">${formatCurrency(line)}</td>
                <td><button class="btn btn-sm btn-outline-danger remove-item">Remove</button></td>
            </tr>`;
        });
        const tax = +(subtotal * 0.05).toFixed(2);
        const total = +(subtotal + tax).toFixed(2);
        html += `</tbody></table></div>`;
        html += `<div class="d-flex justify-content-end mt-3">
            <div style="max-width:360px;width:100%;">
                <div class="d-flex justify-content-between"><strong>Subtotal</strong><span id="cart-sub">${formatCurrency(
                    subtotal
                )}</span></div>
                <div class="d-flex justify-content-between"><small>Tax (5%)</small><span id="cart-tax">${formatCurrency(
                    tax
                )}</span></div>
                <hr/>
                <div class="d-flex justify-content-between"><strong>Total</strong><strong id="cart-total">${formatCurrency(
                    total
                )}</strong></div>
                <div class="mt-3 d-flex">
                    <button id="checkoutBtn" class="btn btn-success w-100 me-2">Checkout</button>
                    <button id="clearCartBtnLocal" class="btn btn-outline-secondary">Clear</button>
                </div>
            </div>
        </div>`;

        root.innerHTML = html;
        attachRowListeners();
        attachTotalsListeners();
        updateBadge();
    }

    function attachRowListeners() {
        const root = document.getElementById("cart-list-area");
        if (!root) return;
        root.querySelectorAll(".qty-input").forEach((el, idx) => {
            el.addEventListener("change", function (e) {
                const tr = el.closest("tr");
                const rowIdx = parseInt(tr.getAttribute("data-idx"), 10);
                const cart = getCart();
                const qty = Math.max(1, parseInt(el.value, 10) || 1);
                cart[rowIdx].qty = qty;
                saveCart(cart);
                renderCart();
            });
        });
        root.querySelectorAll(".remove-item").forEach((btn) => {
            btn.addEventListener("click", function () {
                const tr = btn.closest("tr");
                const rowIdx = parseInt(tr.getAttribute("data-idx"), 10);
                const cart = getCart();
                cart.splice(rowIdx, 1);
                saveCart(cart);
                renderCart();
            });
        });
    }

    function attachTotalsListeners() {
        // attach checkout (only once)
        const checkout = document.getElementById("checkoutBtn");
        const checkoutHandler = function () {
            try {
                const cart = getCart();
                if (!cart || cart.length === 0) {
                    showToast("Your cart is empty.", { type: "info" });
                    return;
                }
                const subtotal = cart.reduce(
                    (s, it) =>
                        s +
                        (parseFloat(it.price) || 0) *
                            (parseInt(it.qty, 10) || 1),
                    0
                );
                const tax = +(subtotal * 0.05).toFixed(2);
                const total = +(subtotal + tax).toFixed(2);

                // populate modal total
                const totalEl = document.getElementById("thankYouTotal");
                if (totalEl) totalEl.textContent = formatCurrency(total);

                const modalEl = document.getElementById("thankYouModal");
                if (modalEl && window.bootstrap && window.bootstrap.Modal) {
                    const bsModal = new bootstrap.Modal(modalEl);
                    // clear cart when modal hidden
                    modalEl.addEventListener(
                        "hidden.bs.modal",
                        function onHide() {
                            try {
                                localStorage.removeItem(STORAGE_KEY);
                            } catch (e) {}
                            renderCart();
                            modalEl.removeEventListener(
                                "hidden.bs.modal",
                                onHide
                            );
                        }
                    );
                    bsModal.show();
                } else {
                    showToast(
                        "Thank you for your order!\nTotal: " +
                            formatCurrency(total)
                    );
                    try {
                        localStorage.removeItem(STORAGE_KEY);
                    } catch (e) {}
                    renderCart();
                }
            } catch (err) {
                try {
                    localStorage.removeItem(STORAGE_KEY);
                } catch (e) {}
                renderCart();
            }
        };
        if (checkout && !checkout.dataset.agriAttached) {
            checkout.addEventListener("click", checkoutHandler);
            checkout.dataset.agriAttached = "1";
        }

        // clear button inside cart (dynamic element)
        const clearBtn = document.getElementById("clearCartBtnLocal");
        const clearHandler = function () {
            try {
                const cart = getCart();
                if (!cart || cart.length === 0) {
                    showToast(
                        "Nothing to clear — your cart is already empty.",
                        { type: "info" }
                    );
                    return;
                }
                localStorage.removeItem(STORAGE_KEY);
                renderCart();
                showToast("Cart has been cleared.");
            } catch (e) {
                // fallback
                localStorage.removeItem(STORAGE_KEY);
                renderCart();
            }
        };
        if (clearBtn && !clearBtn.dataset.agriAttached) {
            clearBtn.addEventListener("click", clearHandler);
            clearBtn.dataset.agriAttached = "1";
        }

        // global clear button (static in blade) - attach once
        const clearGlobal = document.getElementById("clearCartBtn");
        if (clearGlobal && !clearGlobal.dataset.agriAttached) {
            clearGlobal.addEventListener("click", clearHandler);
            clearGlobal.dataset.agriAttached = "1";
        }
    }
    function updateBadge() {
        const badge = document.getElementById("cart-count");
        if (!badge) return;
        const cart = getCart();
        const count = cart.reduce(
            (s, it) => s + (parseInt(it.qty, 10) || 0),
            0
        );
        badge.textContent = count;
    }

    // small helper to escape
    function escapeHtml(str) {
        return String(str)
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;");
    }

    // public API: addToCart
    function addToCart(item) {
        const cart = getCart();
        const existing = cart.find((c) => c.id === item.id);
        if (existing) {
            existing.qty =
                (parseInt(existing.qty, 10) || 0) +
                (parseInt(item.qty, 10) || 1);
        } else cart.push(Object.assign({ qty: 1 }, item));
        saveCart(cart);
        renderCart();
    }

    // Expose global
    window.AgriCart = {
        add: addToCart,
        get: getCart,
        clear: function () {
            localStorage.removeItem(STORAGE_KEY);
            renderCart();
        },
    };

    // render on load
    document.addEventListener("DOMContentLoaded", function () {
        renderCart();
    });
    window.addEventListener("storage", function (e) {
        if (e.key === STORAGE_KEY) renderCart();
    });
})();
