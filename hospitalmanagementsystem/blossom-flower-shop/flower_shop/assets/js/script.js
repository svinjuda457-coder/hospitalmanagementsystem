/* =========================================================
   Blossom Flower Shop — Main JS
   Handles: AJAX cart/wishlist actions, quantity selectors,
   toast notifications, mobile sidebar toggle, star rating.
   ========================================================= */

const BASE_URL = document.querySelector('meta[name="base-url"]')?.content || '/flower_shop/';

/* ---------------- Toast helper ---------------- */
function showToast(message, type = 'success') {
  let container = document.getElementById('bfs-toast-container');
  if (!container) {
    container = document.createElement('div');
    container.id = 'bfs-toast-container';
    container.className = 'toast-container position-fixed bottom-0 end-0 p-3';
    container.style.zIndex = 1080;
    document.body.appendChild(container);
  }
  const bg = type === 'success' ? 'bg-success' : (type === 'error' ? 'bg-danger' : 'bg-secondary');
  const toastEl = document.createElement('div');
  toastEl.className = `toast align-items-center text-white ${bg} border-0`;
  toastEl.setAttribute('role', 'alert');
  toastEl.innerHTML = `
    <div class="d-flex">
      <div class="toast-body">${message}</div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>`;
  container.appendChild(toastEl);
  const toast = new bootstrap.Toast(toastEl, { delay: 2500 });
  toast.show();
  toastEl.addEventListener('hidden.bs.toast', () => toastEl.remove());
}

/* ---------------- Quantity selectors ---------------- */
document.addEventListener('click', function (e) {
  if (e.target.closest('.qty-plus')) {
    const wrap = e.target.closest('.qty-selector');
    const input = wrap.querySelector('input[type="number"]');
    const max = parseInt(input.max || 999, 10);
    input.value = Math.min(parseInt(input.value || 1, 10) + 1, max);
    input.dispatchEvent(new Event('change'));
  }
  if (e.target.closest('.qty-minus')) {
    const wrap = e.target.closest('.qty-selector');
    const input = wrap.querySelector('input[type="number"]');
    input.value = Math.max(parseInt(input.value || 1, 10) - 1, 1);
    input.dispatchEvent(new Event('change'));
  }
});

/* ---------------- Add to cart (AJAX) ---------------- */
document.addEventListener('click', function (e) {
  const btn = e.target.closest('.js-add-to-cart');
  if (!btn) return;
  e.preventDefault();
  const productId = btn.dataset.productId;
  const qtyInput = document.querySelector(`#qty-${productId}`);
  const qty = qtyInput ? qtyInput.value : 1;

  fetch(BASE_URL + 'user/cart-action.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `action=add&product_id=${productId}&quantity=${qty}`
  })
    .then(r => r.json())
    .then(data => {
      if (data.status === 'login_required') {
        window.location.href = BASE_URL + 'login.php';
        return;
      }
      showToast(data.message, data.status === 'success' ? 'success' : 'error');
      if (data.cart_count !== undefined) {
        const badge = document.getElementById('cart-count-badge');
        if (badge) badge.textContent = data.cart_count;
      }
    })
    .catch(() => showToast('Something went wrong. Please try again.', 'error'));
});

/* ---------------- Wishlist toggle (AJAX) ---------------- */
document.addEventListener('click', function (e) {
  const btn = e.target.closest('.js-toggle-wishlist');
  if (!btn) return;
  e.preventDefault();
  const productId = btn.dataset.productId;

  fetch(BASE_URL + 'user/wishlist-action.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `action=toggle&product_id=${productId}`
  })
    .then(r => r.json())
    .then(data => {
      if (data.status === 'login_required') {
        window.location.href = BASE_URL + 'login.php';
        return;
      }
      showToast(data.message, 'success');
      btn.classList.toggle('active', data.in_wishlist);
      const icon = btn.querySelector('i');
      if (icon) icon.className = data.in_wishlist ? 'fa-solid fa-heart' : 'fa-regular fa-heart';
      const badge = document.getElementById('wishlist-count-badge');
      if (badge && data.wishlist_count !== undefined) badge.textContent = data.wishlist_count;
    })
    .catch(() => showToast('Something went wrong. Please try again.', 'error'));
});

/* ---------------- Sidebar toggle (admin/delivery mobile) ---------------- */
document.addEventListener('click', function (e) {
  if (e.target.closest('#sidebarToggle')) {
    document.querySelector('.bfs-sidebar')?.classList.toggle('show');
  }
});

/* ---------------- Cart quantity update on cart.php ---------------- */
document.addEventListener('change', function (e) {
  if (e.target.matches('.js-cart-qty')) {
    const cartId = e.target.dataset.cartId;
    const qty = e.target.value;
    fetch(BASE_URL + 'user/cart-action.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `action=update&cart_id=${cartId}&quantity=${qty}`
    })
      .then(r => r.json())
      .then(data => {
        if (data.status === 'success') {
          document.getElementById('line-total-' + cartId).textContent = data.line_total;
          document.getElementById('cart-subtotal').textContent = data.subtotal;
          const badge = document.getElementById('cart-count-badge');
          if (badge) badge.textContent = data.cart_count;
        }
      });
  }
});

/* ---------------- Remove cart item ---------------- */
document.addEventListener('click', function (e) {
  const btn = e.target.closest('.js-remove-cart-item');
  if (!btn) return;
  e.preventDefault();
  if (!confirm('Remove this item from your cart?')) return;
  const cartId = btn.dataset.cartId;
  fetch(BASE_URL + 'user/cart-action.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `action=remove&cart_id=${cartId}`
  })
    .then(r => r.json())
    .then(data => {
      if (data.status === 'success') {
        document.getElementById('cart-row-' + cartId)?.remove();
        showToast('Item removed from cart');
        location.reload();
      }
    });
});

/* ---------------- Payment method toggle on checkout ---------------- */
document.addEventListener('change', function (e) {
  if (e.target.name === 'payment_method') {
    document.querySelectorAll('.payment-fields').forEach(el => el.classList.add('d-none'));
    const target = document.getElementById('fields-' + e.target.value);
    if (target) target.classList.remove('d-none');
  }
});
