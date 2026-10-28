(() => {
  'use strict';
  const root = document.querySelector('.mgd-a11y');
  if (!root) return;
  const trigger = root.querySelector('.mgd-a11y__trigger');
  const panel = root.querySelector('.mgd-a11y__panel');
  const backdrop = root.querySelector('.mgd-a11y__backdrop');
  const close = root.querySelector('.mgd-a11y__close');
  if (!trigger || !panel || !backdrop || !close) return;

  const key = 'mgd-barrierefrei-preferences-v1';
  const html = document.documentElement;
  const toggles = ['contrast', 'grayscale', 'focus', 'readable', 'links', 'motion'];
  let opener = null;
  let state = {};
  try {
    const saved = JSON.parse(localStorage.getItem(key) || '{}');
    if (saved && typeof saved === 'object' && !Array.isArray(saved)) state = saved;
  } catch (_) { /* Storage may be blocked. */ }

  const persist = () => {
    try { localStorage.setItem(key, JSON.stringify(state)); } catch (_) {}
  };
  const apply = () => {
    const raw = Number(state.fontSize);
    const step = Number.isFinite(raw) ? Math.max(-2, Math.min(3, raw)) : 0;
    html.style.setProperty('--mgd-a11y-font-scale', String(1 + step * 0.1));
    html.classList.toggle('mgd-a11y-font-adjusted', step !== 0);
    toggles.forEach((action) => {
      const enabled = state[action] === true;
      html.classList.toggle('mgd-a11y-' + action, enabled);
      const control = root.querySelector('[data-mgd-a11y="' + action + '"]');
      if (control) control.setAttribute('aria-pressed', String(enabled));
    });
    const increase = root.querySelector('[data-mgd-a11y="font-increase"]');
    const decrease = root.querySelector('[data-mgd-a11y="font-decrease"]');
    if (increase) increase.disabled = step >= 3;
    if (decrease) decrease.disabled = step <= -2;
  };

  const isOpen = () => !panel.hidden;
  const focusable = () => [...panel.querySelectorAll('button:not([disabled]), a[href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])')]
    .filter((el) => el.getClientRects().length > 0 && el.getAttribute('aria-hidden') !== 'true');

  const open = () => {
    if (isOpen()) return;
    opener = document.activeElement;
    panel.hidden = false;
    backdrop.hidden = false;
    trigger.setAttribute('aria-expanded', 'true');
    close.focus();
  };
  const shut = () => {
    if (!isOpen()) return;
    panel.hidden = true;
    backdrop.hidden = true;
    trigger.setAttribute('aria-expanded', 'false');
    const target = opener instanceof HTMLElement && opener.isConnected ? opener : trigger;
    target.focus();
  };

  trigger.addEventListener('click', () => isOpen() ? shut() : open());
  close.addEventListener('click', shut);
  backdrop.addEventListener('click', shut);
  root.addEventListener('click', (event) => {
    const control = event.target instanceof Element ? event.target.closest('[data-mgd-a11y]') : null;
    if (!control || !root.contains(control)) return;
    const action = control.dataset.mgdA11y;
    if (action === 'reset') {
      state = {};
      try { localStorage.removeItem(key); } catch (_) {}
      apply();
      return;
    }
    if (action === 'font-increase' || action === 'font-decrease') {
      const raw = Number(state.fontSize);
      const current = Number.isFinite(raw) ? raw : 0;
      state.fontSize = Math.max(-2, Math.min(3, current + (action === 'font-increase' ? 1 : -1)));
    } else if (toggles.includes(action)) {
      state[action] = state[action] !== true;
    } else {
      return;
    }
    persist();
    apply();
  });

  document.addEventListener('keydown', (event) => {
    if (!isOpen()) return;
    if (event.key === 'Escape') {
      event.preventDefault();
      shut();
      return;
    }
    if (event.key !== 'Tab') return;
    const items = focusable();
    if (!items.length) { event.preventDefault(); panel.focus(); return; }
    const first = items[0], last = items[items.length - 1];
    if (event.shiftKey && (document.activeElement === first || !panel.contains(document.activeElement))) {
      event.preventDefault(); last.focus();
    } else if (!event.shiftKey && (document.activeElement === last || !panel.contains(document.activeElement))) {
      event.preventDefault(); first.focus();
    }
  });
  document.addEventListener('focusin', (event) => {
    if (isOpen() && !panel.contains(event.target)) close.focus();
  });
  apply();
})();
