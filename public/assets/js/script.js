document.addEventListener("DOMContentLoaded", function () {
    // Initialize all components
    initNavbar();
    initScrollAnimations();
    initFormValidation();
    initImageErrorHandlers();
    initFilterForm();
    initAlertAutoClose();

    console.log("AgriConnect initialized successfully!");
});

/**
 * Navbar functionality
 */
function initNavbar() {
    const navbar = document.querySelector(".navbar");

    if (!navbar) return;

    window.addEventListener("scroll", function () {
        if (window.scrollY > 50) {
            navbar.classList.add("shadow");
        } else {
            navbar.classList.remove("shadow");
        }
    });

    const navLinks = document.querySelectorAll(".nav-link");
    const navbarCollapse = document.querySelector(".navbar-collapse");

    navLinks.forEach((link) => {
        link.addEventListener("click", function () {
            if (window.innerWidth < 992 && navbarCollapse) {
                if (window.bootstrap && window.bootstrap.Collapse) {
                    try {
                        const bsCollapse = new bootstrap.Collapse(
                            navbarCollapse,
                            { toggle: false }
                        );
                        bsCollapse.hide();
                    } catch (_) {
                        navbarCollapse.classList.remove("show");
                    }
                } else {
                    navbarCollapse.classList.remove("show");
                }
            }
        });
    });
}

function initScrollAnimations() {
    const observerOptions = { threshold: 0.1, rootMargin: "0px 0px -50px 0px" };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add("animate-fade-in");
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    const animatedElements = document.querySelectorAll(
        ".card, .feature-card, .product-card, .farmer-card"
    );
    animatedElements.forEach((el) => observer.observe(el));
}

function initFormValidation() {
    const forms = document.querySelectorAll(".needs-validation, #contactForm");

    forms.forEach((form) => {
        form.addEventListener(
            "submit",
            function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add("was-validated");
            },
            false
        );
    });

    const contactForm = document.getElementById("contactForm");
    if (contactForm) {
        const inputs = contactForm.querySelectorAll("input, textarea");
        inputs.forEach((input) => {
            input.addEventListener("blur", function () {
                validateField(this);
            });
            input.addEventListener("input", function () {
                if (
                    this.classList.contains("is-invalid") ||
                    this.classList.contains("is-valid")
                )
                    validateField(this);
            });
        });
    }
}

function validateField(field) {
    if (field.checkValidity()) {
        field.classList.remove("is-invalid");
        field.classList.add("is-valid");
    } else {
        field.classList.remove("is-valid");
        field.classList.add("is-invalid");
    }
}

function initFilterForm() {
    const filterForm = document.getElementById("filterForm");
    if (!filterForm) return;

    const searchInput = filterForm.querySelector('input[name="search"]');
    if (searchInput) {
        searchInput.addEventListener("keydown", function (e) {
            if (e.key === "Enter") {
                e.preventDefault();
                if (typeof filterForm.requestSubmit === "function")
                    filterForm.requestSubmit();
                else filterForm.submit();
            }
        });
    }
}

// Robust price parser: accepts strings like "₹ 1,200.00", "1.200,00" (basic), and returns Number or null
function parsePrice(raw) {
    if (raw === null || raw === undefined) return null;
    let s = String(raw).trim();
    if (!s) return null;
    // Normalize non-breaking spaces and similar
    s = s.replace(/\u00A0/g, " ").replace(/\s+/g, " ");
    // Extract number-like characters (digits, comma, dot, minus)
    let cleaned = s.replace(/[^0-9.,-]/g, "");
    if (!cleaned) return null;
    // If there are multiple dots/commas try a safe cleanup: remove commas
    cleaned = cleaned.replace(/,/g, "");
    const n = parseFloat(cleaned);
    return isNaN(n) ? null : n;
}

function initAlertAutoClose() {
    const alerts = document.querySelectorAll(".alert");
    alerts.forEach((alert) => {
        setTimeout(function () {
            if (window.bootstrap && window.bootstrap.Alert) {
                try {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                } catch (_) {
                    alert.classList.add("d-none");
                }
            } else {
                alert.classList.add("d-none");
            }
        }, 5000);
    });
}

function initScrollToTop() {
    const scrollBtn = document.createElement("button");
    scrollBtn.innerHTML = '<i class="bi bi-arrow-up"></i>';
    scrollBtn.className =
        "btn btn-success position-fixed bottom-0 end-0 m-4 rounded-circle";
    scrollBtn.style.cssText =
        "width: 50px; height: 50px; display: none; z-index: 1000;";
    scrollBtn.id = "scrollToTop";
    document.body.appendChild(scrollBtn);
    window.addEventListener("scroll", function () {
        scrollBtn.style.display = window.scrollY > 300 ? "block" : "none";
    });
    scrollBtn.addEventListener("click", function () {
        window.scrollTo({ top: 0, behavior: "smooth" });
    });
}

document.addEventListener("click", function (e) {
    const btn = e.target.closest && e.target.closest(".btn");
    if (!btn || !(btn.textContent && btn.textContent.includes("Add to Cart")))
        return;

    e.preventDefault();

    // Check if user is logged in
    if (!window.isLoggedIn) {
        if (window.showToast) {
            window.showToast("Please login to add items to cart.", { type: "warning" });
        } else {
            alert("Please login to add items to cart.");
        }
        
        setTimeout(() => {
            window.location.href = window.loginUrl || "/login";
        }, 1000);
        return;
    }

    const button = btn;
    const originalText = button.innerHTML;

    // Button loading animation
    button.disabled = true;
    button.innerHTML = '<span class="loading"></span> Adding...';

    // Collect product data: prefer data-* attributes, fallback to DOM
    const item = {};
    item.id =
        button.getAttribute("data-id") ||
        button.getAttribute("data-product-id") ||
        null;
    item.name =
        button.getAttribute("data-name") ||
        button.getAttribute("data-product-name") ||
        null;
    // parse price from data attribute if provided
    item.price = parsePrice(
        button.getAttribute("data-price") ||
            button.getAttribute("data-product-price") ||
            null
    );
    item.image =
        button.getAttribute("data-image") ||
        button.getAttribute("data-product-image") ||
        null;
    item.qty = parseInt(button.getAttribute("data-qty") || "1", 10) || 1;

    // Fallback: try to find product card context
    if (!item.name) {
        const card = button.closest(".product-card, .card, .product-item");
        if (card) {
            const title = card.querySelector(
                ".product-title, .card-title, h5, h4"
            );
            if (title) item.name = title.textContent.trim();
            const priceEl = card.querySelector(
                ".price, .product-price, .card-price"
            );
            if (priceEl && item.price === null) {
                // try data attribute on the price element first, then text
                const fromAttr =
                    priceEl.getAttribute("data-price") ||
                    priceEl.getAttribute("data-product-price");
                item.price =
                    parsePrice(fromAttr) ??
                    parsePrice(priceEl.textContent) ??
                    item.price;
            }
            // further fallback: any element in card with data-price
            if (item.price === null) {
                const anyPrice = card.querySelector(
                    "[data-price], [data-product-price]"
                );
                if (anyPrice)
                    item.price =
                        parsePrice(
                            anyPrice.getAttribute("data-price") ||
                                anyPrice.getAttribute("data-product-price") ||
                                anyPrice.textContent
                        ) ?? item.price;
            }
            const img = card.querySelector("img");
            if (img && !item.image) item.image = img.getAttribute("src");
        }
    }

    // After short delay show added state and add to cart — DO NOT redirect so user can keep browsing
    setTimeout(function () {
        // Add to cart via frontend cart manager if available
        try {
            if (window.AgriCart && typeof window.AgriCart.add === "function") {
                // ensure id/name/price exist before adding
                if (!item.id) item.id = "p-" + Date.now();
                if (!item.name) item.name = "Product";
                if (item.price === null || isNaN(item.price)) item.price = 0;
                window.AgriCart.add(item);
                if (window.showToast) window.showToast(item.name + ' added to cart.');
            }
        } catch (err) {
            // ignore
        }

        // show added state
        button.innerHTML = '<i class="bi bi-check-circle me-1"></i> Added!';
        button.classList.remove("btn-success");
        button.classList.add("btn-outline-success");

        // update badge immediately if helper exists
        try {
            if (typeof updateCartCountBadge === "function")
                updateCartCountBadge();
        } catch (e) {}

        // revert button to original after short delay so user can add more
        setTimeout(function () {
            try {
                button.disabled = false;
                button.innerHTML = originalText;
                button.classList.remove("btn-outline-success");
                button.classList.add("btn-success");
            } catch (e) {
                // ignore
            }
        }, 1200);
    }, 700);
});

function initImageErrorHandlers() {
    document.querySelectorAll("img").forEach((img) => {
        img.addEventListener("error", function () {
            if (!this.hasAttribute("data-error-handled"))
                this.setAttribute("data-error-handled", "true");
        });
    });
}

function debounce(func, wait) {
    let timeout;
    return function (...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func(...args), wait);
    };
}

function makeTablesResponsive() {
    const tables = document.querySelectorAll("table");
    tables.forEach((table) => {
        if (!table.parentElement.classList.contains("table-responsive")) {
            const wrapper = document.createElement("div");
            wrapper.className = "table-responsive";
            table.parentNode.insertBefore(wrapper, table);
            wrapper.appendChild(table);
        }
    });
}

// Utility: update cart count badge (reads from localStorage)
function updateCartCountBadge() {
    try {
        const data = JSON.parse(localStorage.getItem("agri_cart") || "[]");
        const count = data.reduce(
            (s, it) => s + (parseInt(it.qty, 10) || 0),
            0
        );
        const badge = document.getElementById("cart-count");
        if (badge) badge.textContent = count;
    } catch (err) {
        // ignore
    }
}

// Update badge on load and when storage changes
document.addEventListener("DOMContentLoaded", updateCartCountBadge);
window.addEventListener("storage", function (e) {
    if (e.key === "agri_cart") updateCartCountBadge();
});
