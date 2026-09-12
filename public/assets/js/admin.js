(() => {
  'use strict';

  const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';
  const confirmBackdrop = document.getElementById('adminConfirmDialog');
  const confirmMessage = document.getElementById('adminConfirmMessage');
  const confirmAccept = document.querySelector('[data-confirm-accept]');
  const confirmCancel = document.querySelector('[data-confirm-cancel]');
  const adminToast = document.getElementById('adminToast');
  let pendingForm = null;
  let toastTimer = null;

  function showToast(message) {
    if (!adminToast) return;
    adminToast.textContent = message;
    adminToast.classList.add('is-show');
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => adminToast.classList.remove('is-show'), 2400);
  }

  function openConfirm(form) {
    if (!confirmBackdrop || !confirmMessage) return;
    pendingForm = form;
    confirmMessage.textContent = form.dataset.confirm || 'Lanjutkan aksi ini?';
    confirmBackdrop.hidden = false;
    requestAnimationFrame(() => confirmBackdrop.classList.add('is-open'));
    confirmAccept?.focus();
  }

  function closeConfirm() {
    if (!confirmBackdrop) return;
    confirmBackdrop.classList.remove('is-open');
    setTimeout(() => { confirmBackdrop.hidden = true; }, 120);
    pendingForm = null;
  }

  document.querySelectorAll('form[data-confirm]').forEach(form => {
    form.addEventListener('submit', event => {
      if (form.dataset.confirmApproved === '1') {
        delete form.dataset.confirmApproved;
        return;
      }
      event.preventDefault();
      openConfirm(form);
    });
  });

  confirmAccept?.addEventListener('click', () => {
    if (!pendingForm) return closeConfirm();
    const form = pendingForm;
    form.dataset.confirmApproved = '1';
    closeConfirm();
    form.requestSubmit();
  });
  confirmCancel?.addEventListener('click', closeConfirm);
  confirmBackdrop?.addEventListener('click', event => {
    if (event.target === confirmBackdrop) closeConfirm();
  });
  document.addEventListener('keydown', event => {
    if (event.key === 'Escape' && confirmBackdrop && !confirmBackdrop.hidden) closeConfirm();
  });

  document.querySelectorAll('[data-image-input]').forEach(input => input.addEventListener('change', () => {
    const file = input.files?.[0];
    const targetSelector = input.dataset.previewTarget;
    const preview = targetSelector ? document.querySelector(targetSelector) : input.closest('form')?.querySelector('[data-image-preview]');
    if (!file || !preview) return;
    const reader = new FileReader();
    reader.onload = event => { preview.innerHTML = `<img src="${event.target.result}" alt="Preview gambar">`; };
    reader.readAsDataURL(file);
  }));

  document.querySelectorAll('[data-admin-search]').forEach(input => input.addEventListener('input', () => {
    const q = input.value.trim().toLowerCase();
    document.querySelectorAll(input.dataset.target).forEach(row => {
      row.hidden = Boolean(q && !(row.dataset.searchText || '').includes(q));
    });
  }));

  const quickSearch = document.querySelector('[data-quick-search]');
  const quickCategory = document.querySelector('[data-quick-category]');
  function filterQuick() {
    const q = (quickSearch?.value || '').trim().toLowerCase();
    const cat = quickCategory?.value || 'all';
    document.querySelectorAll('[data-quick-product]').forEach(card => {
      const text = card.dataset.searchText || '';
      const cats = (card.dataset.categoryText || '').split(' ');
      card.hidden = Boolean((q && !text.includes(q)) || (cat !== 'all' && !cats.includes(cat)));
    });
  }
  quickSearch?.addEventListener('input', filterQuick);
  quickCategory?.addEventListener('change', filterQuick);
  document.querySelectorAll('[data-collapse-toggle]').forEach(btn => btn.addEventListener('click', () => {
    btn.closest('[data-quick-product]')?.classList.toggle('is-collapsed');
  }));

  document.querySelectorAll('[data-dirty-form]').forEach(form => {
    const note = form.querySelector('[data-dirty-note]');
    const save = form.querySelector('[data-dirty-save]');
    const relevant = [...form.querySelectorAll('input, select, textarea')].filter(el => !['hidden','submit','button'].includes(el.type));
    const snapshot = () => relevant.map(el => el.type === 'checkbox' || el.type === 'radio' ? `${el.name}:${el.checked}:${el.value}` : `${el.name}:${el.value}`).join('|');
    const initial = snapshot();
    const refresh = () => {
      const dirty = snapshot() !== initial;
      if (save) save.disabled = !dirty;
      if (note) note.textContent = dirty ? 'Ada perubahan yang belum disimpan.' : 'Belum ada perubahan.';
      form.classList.toggle('is-dirty', dirty);
    };
    relevant.forEach(el => {
      el.addEventListener('input', refresh);
      el.addEventListener('change', refresh);
    });
    refresh();
  });

  document.querySelectorAll('[data-sortable]').forEach(list => {
    let active = null;
    let moved = false;
    list.querySelectorAll('.drag-handle').forEach(handle => {
      handle.addEventListener('pointerdown', event => {
        active = handle.closest('[data-sort-id]');
        if (!active) return;
        moved = false;
        active.classList.add('is-dragging');
        handle.setPointerCapture?.(event.pointerId);
        event.preventDefault();
      });
      handle.addEventListener('pointermove', event => {
        if (!active) return;
        const target = document.elementFromPoint(event.clientX, event.clientY)?.closest('[data-sort-id]');
        if (!target || target === active || target.parentElement !== list) return;
        const rect = target.getBoundingClientRect();
        list.insertBefore(active, event.clientY < rect.top + rect.height / 2 ? target : target.nextSibling);
        moved = true;
      });
      const finish = async () => {
        if (!active) return;
        active.classList.remove('is-dragging');
        active = null;
        if (!moved) return;
        const order = [...list.querySelectorAll('[data-sort-id]')].map(el => Number(el.dataset.sortId));
        try {
          const response = await fetch(list.dataset.reorderUrl, {
            method: 'POST',
            headers: {'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':csrf},
            body: JSON.stringify({order})
          });
          if (!response.ok) throw new Error('save failed');
          showToast('Urutan berhasil disimpan ♡');
        } catch (error) {
          console.error(error);
          showToast('Urutan belum tersimpan. Muat ulang lalu coba lagi.');
        }
      };
      handle.addEventListener('pointerup', finish);
      handle.addEventListener('pointercancel', finish);
    });
  });
})();
