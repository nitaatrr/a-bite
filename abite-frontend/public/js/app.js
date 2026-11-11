// ═══════════════════════════════════════
// A-BITE — Frontend JavaScript
// ═══════════════════════════════════════

// ── Toast Notification ──
function showToast(message, duration) {
    duration = duration || 2300;
    var toast = document.getElementById('toast') || document.getElementById('toast-notif');
    if (!toast) return;
    toast.textContent = message;
    toast.classList.add('show');
    clearTimeout(window._toastTimer);
    window._toastTimer = setTimeout(function() {
        toast.classList.remove('show');
    }, duration);
}

// ── Cart Quantity Helper ──
function getCart() {
    try {
        return JSON.parse(localStorage.getItem('abite_cart') || '{}');
    } catch(e) { return {}; }
}

function setCart(cart) {
    localStorage.setItem('abite_cart', JSON.stringify(cart));
}

function updateCartBadge() {
    var cart = getCart();
    var total = 0;
    for (var key in cart) {
        if (cart.hasOwnProperty(key)) {
            total += cart[key];
        }
    }
    var badge = document.getElementById('cart-badge');
    if (badge) {
        badge.textContent = total;
        badge.style.display = total > 0 ? 'inline' : 'none';
    }
}

// ── Tab Filtering ──
function filterTabs(containerId, filterParam) {
    var container = document.getElementById(containerId);
    if (!container) return;
    var tabs = container.querySelectorAll('.tab-item, .tab, .tab-pill');
    tabs.forEach(function(tab) {
        tab.classList.remove('active');
    });
    if (filterParam) {
        tabs.forEach(function(tab) {
            if (tab.textContent.trim() === filterParam) {
                tab.classList.add('active');
            }
        });
    }
}

// ── Password Toggle ──
function togglePassword() {
    var input = document.getElementById('passwordField');
    var btn = document.querySelector('.password-toggle');
    if (!input) return;
    if (input.type === 'password') {
        input.type = 'text';
        if (btn) btn.textContent = '🔒';
    } else {
        input.type = 'password';
        if (btn) btn.textContent = '👁';
    }
}

// ── Food Card Add to Cart (SPA fallback) ──
function addToCart(foodId) {
    var cart = getCart();
    cart[foodId] = (cart[foodId] || 0) + 1;
    setCart(cart);
    updateCartBadge();
    showToast('Menu ditambahkan ke keranjang');
}

function changeQty(foodId, change) {
    var cart = getCart();
    cart[foodId] = Math.max(0, (cart[foodId] || 0) + change);
    if (cart[foodId] === 0) delete cart[foodId];
    setCart(cart);
    updateCartBadge();
}

// ── Confirm Dialog ──
function confirmAction(message, callback) {
    var overlay = document.getElementById('confirmDialog');
    if (!overlay) {
        // Create modal dynamically
        var body = document.body;
        overlay = document.createElement('div');
        overlay.id = 'confirmDialog';
        overlay.className = 'modal-overlay';
        overlay.innerHTML = '<div class="modal-box"><h3>Konfirmasi</h3><p id="confirmMsg"></p><div class="modal-actions"><button class="btn btn-outline" id="confirmCancel">Batal</button><button class="btn btn-primary" id="confirmOk">Konfirmasi</button></div></div>';
        body.appendChild(overlay);
        document.getElementById('confirmCancel').onclick = function() { overlay.classList.remove('show'); };
        document.getElementById('confirmOk').onclick = function() { overlay.classList.remove('show'); callback(); };
    }
    document.getElementById('confirmMsg').textContent = message;
    overlay.classList.add('show');
}

// ── Star Rating ──
function setRating(orderId, rating) {
    var container = document.getElementById('stars-' + orderId);
    if (!container) return;
    var buttons = container.querySelectorAll('button');
    buttons.forEach(function(btn, index) {
        btn.style.background = index < rating ? 'var(--red)' : 'var(--pink2)';
        btn.style.color = index < rating ? '#fff' : 'var(--red)';
    });
    container.dataset.rating = rating;
}

function submitRating(orderId) {
    var container = document.getElementById('stars-' + orderId);
    var rating = container ? container.dataset.rating : null;
    if (!rating) {
        showToast('Pilih jumlah rating terlebih dahulu');
        return;
    }
    showToast('Terima kasih! Rating ' + rating + ' bintang dikirim.');
    if (container && container.parentElement) {
        var form = container.parentElement.querySelector('form');
        if (form) form.submit();
    }
}

// ── Voucher Apply ──
function applyVoucher(code) {
    if (!code) {
        showToast('Masukkan kode voucher terlebih dahulu');
        return;
    }
    showToast('Memvalidasi voucher ' + code + '...');
    // In real app, this would call an API
    setTimeout(function() {
        showToast('Voucher berhasil diterapkan!');
    }, 800);
}

// ── Driver Selection ──
function openDriverModal(orderId, orderNumber) {
    var modal = document.getElementById('driverModal');
    if (!modal) return;
    document.getElementById('modalOrderNumber').textContent = orderNumber;
    modal.classList.add('show');
}

function closeDriverModal() {
    var modal = document.getElementById('driverModal');
    if (!modal) return;
    modal.classList.remove('show');
}

function selectDriver(driverId, driverName) {
    var options = document.querySelectorAll('.driver-option');
    options.forEach(function(el) {
        el.classList.remove('selected');
    });
    event.currentTarget.classList.add('selected');
    document.getElementById('confirmDriverBtn').disabled = false;
}

function confirmDriverAssignment() {
    showToast('Driver berhasil ditugaskan!');
    closeDriverModal();
}

// ── Search ──
function initSearch(inputId, callback) {
    var input = document.getElementById(inputId);
    if (!input) return;
    input.addEventListener('input', function() {
        if (callback) callback(this.value);
    });
}

// ── Date Filter ──
function applyDateFilter() {
    var from = document.getElementById('fromDatePicker');
    var to = document.getElementById('toDatePicker');
    if (!from || !to) return;
    if (!from.value || !to.value) {
        showToast('Pilih tanggal mulai dan akhir');
        return;
    }
    showToast('Filter tanggal diterapkan');
    // In real app, submit the form or make an AJAX call
}

function resetDateFilter() {
    var from = document.getElementById('fromDatePicker');
    var to = document.getElementById('toDatePicker');
    if (from) from.value = '';
    if (to) to.value = '';
    showToast('Filter tanggal direset');
}

// ── Modal ──
function openModal(id) {
    var modal = document.getElementById(id);
    if (modal) modal.classList.add('show');
}

function closeModal(id) {
    var modal = document.getElementById(id);
    if (modal) modal.classList.remove('show');
}

// ── Close modal on overlay click ──
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('modal-overlay')) {
        e.target.classList.remove('show');
    }
});

// ── Initialize on DOM ready ──
document.addEventListener('DOMContentLoaded', function() {
    updateCartBadge();

    // Close modals on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal-overlay.show').forEach(function(modal) {
                modal.classList.remove('show');
            });
        }
    });

    // Auto-dismiss alerts after 5 seconds
    document.querySelectorAll('.alert-success, .alert-warning').forEach(function(alert) {
        setTimeout(function() {
            alert.style.opacity = '0';
            alert.style.transition = 'opacity 0.3s';
            setTimeout(function() { alert.style.display = 'none'; }, 300);
        }, 5000);
    });
});
