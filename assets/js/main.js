/**
 * ClassiPress Pro - Main JavaScript
 * @package ClassiPressPro
 */

(function ($) {
  'use strict';

  const CP = window.ClassiPressData || {};

  /* ── MOBILE MENU ─────────────────────────────────────── */
  const mobileToggle = document.getElementById('cp-mobile-toggle');
  const mobileMenu   = document.getElementById('cp-mobile-menu');

  if (mobileToggle && mobileMenu) {
    mobileToggle.addEventListener('click', () => {
      const expanded = mobileToggle.getAttribute('aria-expanded') === 'true';
      mobileToggle.setAttribute('aria-expanded', String(!expanded));
      mobileMenu.hidden = expanded;
      mobileToggle.classList.toggle('is-active', !expanded);
    });

    // Close on outside click
    document.addEventListener('click', (e) => {
      if (!mobileMenu.contains(e.target) && !mobileToggle.contains(e.target)) {
        mobileMenu.hidden = true;
        mobileToggle.setAttribute('aria-expanded', 'false');
        mobileToggle.classList.remove('is-active');
      }
    });
  }

  /* ── USER DROPDOWN ───────────────────────────────────── */
  const userToggle = document.querySelector('.cp-user-menu-toggle');
  const userDropdown = document.querySelector('.cp-user-dropdown');

  if (userToggle && userDropdown) {
    userToggle.addEventListener('click', () => {
      const expanded = userToggle.getAttribute('aria-expanded') === 'true';
      userToggle.setAttribute('aria-expanded', String(!expanded));
      userDropdown.style.display = expanded ? 'none' : 'flex';
      userDropdown.style.flexDirection = 'column';
    });

    document.addEventListener('click', (e) => {
      if (!userToggle.contains(e.target)) {
        userToggle.setAttribute('aria-expanded', 'false');
        userDropdown.style.display = 'none';
      }
    });
  }

  /* ── VIEW TOGGLE (GRID / LIST) ───────────────────────── */
  const viewBtns  = document.querySelectorAll('.cp-view-btn');
  const listingsGrid = document.getElementById('cp-listings-grid');

  viewBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      const view = btn.dataset.view;

      viewBtns.forEach(b => {
        b.classList.remove('active');
        b.setAttribute('aria-pressed', 'false');
      });
      btn.classList.add('active');
      btn.setAttribute('aria-pressed', 'true');

      if (listingsGrid) {
        listingsGrid.classList.toggle('cp-list-view', view === 'list');
      }

      // Persist in cookie
      document.cookie = `cp_view=${view};path=/;max-age=2592000`;
    });
  });

  /* ── LIVE SEARCH ─────────────────────────────────────── */
  let searchTimeout;
  const searchInput   = document.querySelector('.cp-header-search input[type="search"]');
  const searchResults = document.getElementById('cp-live-search-results');

  if (searchInput && searchResults) {
    searchInput.addEventListener('input', () => {
      clearTimeout(searchTimeout);
      const term = searchInput.value.trim();

      if (term.length < 2) {
        searchResults.hidden = true;
        return;
      }

      searchTimeout = setTimeout(() => {
        $.ajax({
          url: CP.ajax_url,
          type: 'POST',
          data: { action: 'cp_live_search', nonce: CP.nonce, term },
          success(res) {
            if (!res.success || !res.data.length) {
              searchResults.hidden = true;
              return;
            }
            renderLiveResults(res.data);
            searchResults.hidden = false;
          },
        });
      }, 300);
    });

    document.addEventListener('click', (e) => {
      if (!searchInput.contains(e.target)) {
        searchResults.hidden = true;
      }
    });
  }

  function renderLiveResults(items) {
    searchResults.innerHTML = items.map(item => `
      <a href="${escHtml(item.url)}" class="cp-live-result-item" role="option">
        ${item.thumb ? `<img src="${escHtml(item.thumb)}" alt="" loading="lazy">` : ''}
        <div>
          <strong>${escHtml(item.title)}</strong>
          ${item.city ? `<small>📍 ${escHtml(item.city)}</small>` : ''}
        </div>
        ${item.price ? `<span class="price">$${escHtml(item.price)}</span>` : ''}
      </a>
    `).join('');
  }

  /* ── WISHLIST ─────────────────────────────────────────── */
  document.addEventListener('click', (e) => {
    const btn = e.target.closest('.cp-listing-wishlist');
    if (!btn) return;

    const postId = btn.dataset.id;
    if (!postId) return;

    btn.disabled = true;

    $.ajax({
      url: CP.ajax_url,
      type: 'POST',
      data: { action: 'cp_toggle_wishlist', nonce: CP.nonce, post_id: postId },
      success(res) {
        if (res.success) {
          btn.classList.toggle('active', res.data.action === 'added');
          btn.innerHTML = res.data.action === 'added' ? '♥' : '♡';
          showToast(res.data.action === 'added' ? CP.i18n.added_wishlist : CP.i18n.removed_wishlist);
        }
      },
      complete() { btn.disabled = false; },
    });
  });

  /* ── CONTACT FORM ────────────────────────────────────── */
  const showContactBtn  = document.getElementById('cp-show-contact-form');
  const contactForm     = document.getElementById('cp-contact-form');
  const contactFormEl   = document.getElementById('cp-contact-seller-form');

  if (showContactBtn && contactForm) {
    showContactBtn.addEventListener('click', () => {
      const isOpen = contactForm.style.display !== 'none';
      contactForm.style.display = isOpen ? 'none' : 'block';
      showContactBtn.setAttribute('aria-expanded', String(!isOpen));
    });
  }

  if (contactFormEl) {
    contactFormEl.addEventListener('submit', (e) => {
      e.preventDefault();
      const btn      = contactFormEl.querySelector('[type="submit"]');
      const response = document.getElementById('cp-contact-response');
      const data     = new FormData(contactFormEl);

      btn.disabled    = true;
      btn.textContent = CP.i18n.loading;

      $.ajax({
        url: CP.ajax_url,
        type: 'POST',
        data: {
          action:   'cp_contact_seller',
          nonce:     CP.nonce,
          post_id:   data.get('post_id'),
          name:      data.get('name'),
          email:     data.get('email'),
          phone:     data.get('phone'),
          message:   data.get('message'),
        },
        success(res) {
          response.innerHTML = `<div class="cp-alert ${res.success ? 'cp-alert-success' : 'cp-alert-error'}" style="margin-top:.75rem;">${escHtml(res.data.message)}</div>`;
          if (res.success) contactFormEl.reset();
        },
        error() {
          response.innerHTML = `<div class="cp-alert cp-alert-error" style="margin-top:.75rem;">${escHtml(CP.i18n.error)}</div>`;
        },
        complete() {
          btn.disabled    = false;
          btn.textContent = 'Send Message';
        },
      });
    });
  }

  /* ── GALLERY THUMBS ──────────────────────────────────── */
  const galleryThumbs = document.querySelectorAll('.cp-gallery-thumb');
  const galleryMain   = document.getElementById('cp-gallery-main');

  galleryThumbs.forEach(thumb => {
    thumb.addEventListener('click', () => {
      galleryThumbs.forEach(t => t.classList.remove('active'));
      thumb.classList.add('active');

      if (galleryMain) {
        const img = galleryMain.querySelector('img');
        if (img) img.src = thumb.dataset.full;
      }
    });
  });

  /* ── MOBILE FILTER TOGGLE ────────────────────────────── */
  const filterToggle  = document.querySelector('.cp-filter-toggle-mobile');
  const filterSidebar = document.getElementById('cp-filters-sidebar');

  if (filterToggle && filterSidebar) {
    filterToggle.addEventListener('click', () => {
      const expanded = filterToggle.getAttribute('aria-expanded') === 'true';
      filterToggle.setAttribute('aria-expanded', String(!expanded));
      filterSidebar.classList.toggle('is-open', !expanded);
    });
  }

  /* ── GOOGLE MAPS ─────────────────────────────────────── */
  function initListingMap() {
    const mapEl = document.getElementById('cp-listing-map');
    if (!mapEl || !window.google) return;

    const lat = parseFloat(mapEl.dataset.lat);
    const lng = parseFloat(mapEl.dataset.lng);
    if (isNaN(lat) || isNaN(lng)) return;

    const map = new google.maps.Map(mapEl, {
      center: { lat, lng },
      zoom: 14,
      mapTypeControl: false,
      streetViewControl: false,
    });

    new google.maps.Marker({
      position: { lat, lng },
      map,
      title: document.title,
    });
  }

  if (window.google && window.google.maps) {
    initListingMap();
  } else {
    window.initListingMap = initListingMap;
  }

  /* ── TOAST NOTIFICATIONS ─────────────────────────────── */
  function showToast(message, type = 'success') {
    let container = document.getElementById('cp-toast-container');
    if (!container) {
      container = document.createElement('div');
      container.id = 'cp-toast-container';
      container.style.cssText = 'position:fixed;bottom:1.5rem;right:1.5rem;z-index:9999;display:flex;flex-direction:column;gap:.5rem;';
      document.body.appendChild(container);
    }

    const toast = document.createElement('div');
    toast.style.cssText = `background:var(--cp-${type === 'success' ? 'success' : 'danger'});color:#fff;padding:.75rem 1.25rem;border-radius:.5rem;font-size:.875rem;font-weight:600;box-shadow:0 4px 12px rgba(0,0,0,.15);animation:cpToastIn .25s ease;max-width:300px;`;
    toast.textContent = message;
    container.appendChild(toast);

    setTimeout(() => { toast.style.opacity = '0'; toast.style.transition = 'opacity .3s'; }, 2700);
    setTimeout(() => toast.remove(), 3000);
  }

  /* ── UTIL ────────────────────────────────────────────── */
  function escHtml(str) {
    const div = document.createElement('div');
    div.appendChild(document.createTextNode(String(str)));
    return div.innerHTML;
  }

  /* ── ADD CSS FOR TOAST ANIMATION ─────────────────────── */
  const style = document.createElement('style');
  style.textContent = `
    @keyframes cpToastIn { from { transform:translateY(1rem);opacity:0; } to { transform:translateY(0);opacity:1; } }
    .cp-live-search-results { position:absolute;top:calc(100% + .5rem);left:0;right:0;background:#fff;border-radius:.5rem;box-shadow:0 10px 30px rgba(0,0,0,.12);max-height:380px;overflow-y:auto;z-index:200;border:1px solid var(--cp-gray-100); }
    .cp-live-result-item { display:flex;align-items:center;gap:.75rem;padding:.75rem 1rem;text-decoration:none;color:var(--cp-gray-700);transition:background .15s; }
    .cp-live-result-item:hover { background:var(--cp-gray-50); }
    .cp-live-result-item img { width:48px;height:36px;object-fit:cover;border-radius:.25rem;flex-shrink:0; }
    .cp-live-result-item strong { display:block;font-size:.875rem;color:var(--cp-dark);font-weight:600; }
    .cp-live-result-item small { font-size:.75rem;color:var(--cp-gray-500); }
    .cp-live-result-item .price { margin-left:auto;font-weight:700;color:var(--cp-primary);font-size:.875rem;white-space:nowrap; }
    .cp-header-icon-btn { position:relative;width:36px;height:36px;display:flex;align-items:center;justify-content:center;border-radius:.5rem;color:var(--cp-gray-600);transition:all .2s; }
    .cp-header-icon-btn:hover { background:var(--cp-gray-100);color:var(--cp-primary); }
    .cp-badge-count { position:absolute;top:-4px;right:-4px;background:var(--cp-danger);color:#fff;font-size:10px;font-weight:700;width:18px;height:18px;border-radius:50%;display:flex;align-items:center;justify-content:center; }
    .cp-mobile-menu-toggle { display:none;flex-direction:column;gap:5px;padding:.5rem;background:none;border:none;cursor:pointer; }
    .hamburger-line { display:block;width:22px;height:2px;background:var(--cp-gray-700);border-radius:2px;transition:all .25s; }
    .cp-mobile-menu-toggle.is-active .hamburger-line:nth-child(1) { transform:translateY(7px) rotate(45deg); }
    .cp-mobile-menu-toggle.is-active .hamburger-line:nth-child(2) { opacity:0; }
    .cp-mobile-menu-toggle.is-active .hamburger-line:nth-child(3) { transform:translateY(-7px) rotate(-45deg); }
    .cp-mobile-nav { background:var(--cp-white);border-top:1px solid var(--cp-gray-100);padding:1rem 0; }
    .cp-mobile-search { display:flex;gap:.5rem;margin-bottom:1rem; }
    .cp-mobile-search input { flex:1;padding:.5rem .75rem;border:1.5px solid var(--cp-gray-300);border-radius:.5rem;outline:none;font-size:.875rem; }
    .cp-mobile-search button { padding:.5rem 1rem;background:var(--cp-primary);color:#fff;border:none;border-radius:.5rem;font-weight:600;cursor:pointer; }
    .cp-user-dropdown { display:none;position:absolute;top:calc(100% + .5rem);right:0;background:#fff;border-radius:.5rem;box-shadow:0 10px 25px rgba(0,0,0,.12);min-width:180px;padding:.5rem;border:1px solid var(--cp-gray-100);z-index:200; }
    .cp-user-dropdown a { display:block;padding:.5rem .75rem;border-radius:.375rem;font-size:.875rem;color:var(--cp-gray-700);transition:background .15s; }
    .cp-user-dropdown a:hover { background:var(--cp-gray-50);color:var(--cp-primary); }
    .cp-user-menu-wrap { position:relative; }
    .cp-user-menu-toggle { display:flex;align-items:center;gap:.5rem;background:none;border:1.5px solid var(--cp-gray-200);border-radius:.5rem;padding:.375rem .75rem;cursor:pointer;transition:all .2s; }
    .cp-user-menu-toggle:hover { border-color:var(--cp-primary); }
    .cp-header-avatar { border-radius:50%;width:28px;height:28px;object-fit:cover; }
    .cp-user-name { font-size:.8125rem;font-weight:600;color:var(--cp-gray-700); }
    .cp-filters-sidebar.is-open { display:block!important; }
    @media(max-width:768px) {
      .cp-mobile-menu-toggle { display:flex; }
      .cp-layout-sidebar { grid-template-columns:1fr!important; }
      .cp-filters-sidebar { display:none; }
      .cp-single-layout { grid-template-columns:1fr!important; }
    }
  `;
  document.head.appendChild(style);

})(jQuery);
