(() => {
  'use strict';
  document.addEventListener('DOMContentLoaded', () => {
    const color = document.querySelector('#mgd-a11y-color');
    const preview = document.querySelector('.mgd-a11y-preview__page button');
    const label = document.querySelector('#mgd-a11y-button_label');
    const position = document.querySelector('#mgd-a11y-position');
    if (!preview) return;
    const text = preview.querySelector('.mgd-a11y-preview__button-label');
    const update = () => {
      if (color) preview.style.setProperty('--mgd-accent', color.value);
      if (text && label) text.textContent = label.value.trim() || 'Barrierefreiheit';
      if (position) preview.style.justifySelf = position.value === 'right' ? 'end' : 'start';
    };
    [color, label, position].forEach((field) => {
      if (field) field.addEventListener('input', update);
    });
    update();
  });
})();
