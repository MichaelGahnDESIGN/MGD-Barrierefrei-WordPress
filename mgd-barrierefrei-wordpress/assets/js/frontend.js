(() => {
  'use strict';
  const root = document.querySelector('.mgd-a11y');
  if (!root) return;
  const trigger = root.querySelector('.mgd-a11y__trigger');
  const panel = root.querySelector('.mgd-a11y__panel');
  const backdrop = root.querySelector('.mgd-a11y__backdrop');
  const close = root.querySelector('.mgd-a11y__close');
  const storageKey = 'mgd-barrierefrei-preferences-v1';
  const html = document.documentElement;
  let opener = null;
  let state = {};

  try { state = JSON.parse(localStorage.getItem(storageKey) || '{}'); } catch (_) { state = {}; }
  const persist = () => { try { localStorage.setItem(storageKey, JSON.stringify(state)); } catch (_) {} };
  const apply = () => {
    const size = Math.max(-2, Math.min(3, Number(state.fontSize || 0)));
    html.style.setProperty('--mgd-a11y-font-scale', String(1 + size * 0.1));
    ['contrast', 'grayscale', 'focus', 'readable', 'links', 'motion'].forEach((key) => {
      html.classList.toggle(`mgd-a11y-${key}`, Boolean(state[key]));
      const control = root.querySelector(`[data-mgd-a11y="${key}"]`);
      if (control) control.setAttribute('aria-pressed', String(Boolean(state[key])));
    });
  };
  const open = () => { opener = document.activeElement; panel.hidden = false; backdrop.hidden = false; trigger.setAttribute('aria-expanded', 'true'); panel.querySelector('.mgd-a11y__close').focus(); };
  const shut = () => { panel.hidden = true; backdrop.hidden = true; trigger.setAttribute('aria-expanded', 'false'); if (opener instanceof HTMLElement) opener.focus(); };
  trigger.addEventListener('click', open);
  close.addEventListener('click', shut);
  backdrop.addEventListener('click', shut);
  root.addEventListener('click', (event) => {
    const control = event.target.closest('[data-mgd-a11y]');
    if (!control) return;
    const action = control.dataset.mgdA11y;
    if (action === 'reset') { state = {}; localStorage.removeItem(storageKey); apply(); return; }
    if (action === 'font-increase') state.fontSize = Math.min(3, Number(state.fontSize || 0) + 1);
    else if (action === 'font-decrease') state.fontSize = Math.max(-2, Number(state.fontSize || 0) - 1);
    else state[action] = !state[action];
    persist(); apply();
  });
  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && !panel.hidden) { event.preventDefault(); shut(); }
    if (event.key !== 'Tab' || panel.hidden) return;
    const focusable = [...panel.querySelectorAll('button, a[href]')].filter((element) => !element.disabled);
    if (!focusable.length) return;
    const first = focusable[0], last = focusable[focusable.length - 1];
    if (event.shiftKey && document.activeElement === first) { event.preventDefault(); last.focus(); }
    if (!event.shiftKey && document.activeElement === last) { event.preventDefault(); first.focus(); }
  });
  apply();
})();
