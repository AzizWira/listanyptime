(() => {
  'use strict';
  const products = Array.isArray(window.PINKY_DATA) ? window.PINKY_DATA : [];
  const settings = window.PINKY_SETTINGS || {};
  const money = value => `Rp${new Intl.NumberFormat('id-ID').format(Number(value || 0))}`;
  const byId = id => products.find(p => Number(p.id) === Number(id));
  const searchInput = document.getElementById('productSearch');
  const clearSearch = document.getElementById('clearSearch');
  const productGrid = document.getElementById('productGrid');
  const searchEmpty = document.getElementById('searchEmpty');
  const resultCount = document.getElementById('resultCount');
  const productOverlay = document.getElementById('productOverlay');
  const cartOverlay = document.getElementById('cartOverlay');
  const productDetail = document.getElementById('productDetail');
  const cartContent = document.getElementById('cartContent');
  const toast = document.getElementById('toast');
  let activeCategory = 'all';
  let activeProduct = null;
  let selected = {};
  let quantity = 1;
  let toastTimer;

  const escapeHtml = str => String(str ?? '').replace(/[&<>'"]/g, ch => ({'&':'&amp;','<':'&lt;','>':'&gt;',"'":'&#039;','"':'&quot;'}[ch]));

  function showToast(message){
    toast.textContent = message;
    toast.classList.add('is-show');
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => toast.classList.remove('is-show'), 2100);
  }

  function filterCatalog(){
    const query = (searchInput?.value || '').trim().toLowerCase();
    let visible = 0;
    document.querySelectorAll('.product-card').forEach(card => {
      const categoryMatch = activeCategory === 'all' || (card.dataset.categories || '').split(' ').includes(activeCategory);
      const searchMatch = !query || (card.dataset.search || '').includes(query);
      const show = categoryMatch && searchMatch;
      card.hidden = !show;
      if(show) visible++;
    });
    if(resultCount) resultCount.textContent = visible;
    if(searchEmpty) searchEmpty.hidden = visible !== 0;
    if(productGrid) productGrid.hidden = visible === 0;
    if(clearSearch) clearSearch.hidden = !query;
  }

  document.getElementById('categoryFilters')?.addEventListener('click', event => {
    const btn = event.target.closest('[data-category]');
    if(!btn) return;
    activeCategory = btn.dataset.category;
    document.querySelectorAll('[data-category]').forEach(el => el.classList.toggle('is-active', el === btn));
    filterCatalog();
  });
  searchInput?.addEventListener('input', filterCatalog);
  clearSearch?.addEventListener('click', () => { searchInput.value = ''; searchInput.focus(); filterCatalog(); });

  function openOverlay(el){ el.hidden = false; requestAnimationFrame(() => document.body.classList.add('modal-open')); }
  function closeOverlay(el){ el.hidden = true; document.body.classList.remove('modal-open'); }

  function firstPreferredVariant(product){
    return product.variants.find(v => v.status === 'ready') || product.variants[0] || null;
  }
  function hydrateSelectionFromVariant(variant){
    selected = {};
    if(!activeProduct || !variant) return;
    activeProduct.options.forEach(option => {
      const value = option.values.find(v => variant.valueIds.map(Number).includes(Number(v.id)));
      if(value) selected[option.id] = value.id;
    });
  }
  function exactVariant(){
    if(!activeProduct) return null;
    if(activeProduct.options.length === 0) return activeProduct.variants[0] || null;
    const ids = Object.values(selected).map(Number).sort((a,b)=>a-b);
    return activeProduct.variants.find(v => {
      const candidate = v.valueIds.map(Number).sort((a,b)=>a-b);
      return candidate.length === ids.length && candidate.every((id,i)=>id===ids[i]);
    }) || null;
  }
  function valueAvailable(optionId, valueId){
    if(!activeProduct) return false;
    return activeProduct.variants.some(variant => {
      if(!variant.valueIds.map(Number).includes(Number(valueId))) return false;
      return activeProduct.options.every(option => {
        if(Number(option.id) === Number(optionId)) return true;
        const selectedId = selected[option.id];
        return !selectedId || variant.valueIds.map(Number).includes(Number(selectedId));
      });
    });
  }
  function chooseValue(optionId, valueId){
    selected[optionId] = valueId;
    if(exactVariant()) return renderDetailBody();
    const fallback = activeProduct.variants.find(v => v.valueIds.map(Number).includes(Number(valueId)));
    if(fallback) hydrateSelectionFromVariant(fallback);
    renderDetailBody();
  }

  function renderDetailBody(){
    if(!activeProduct) return;
    const variant = exactVariant();
    const effective = variant ? (variant.promoPrice || variant.regularPrice) : 0;
    const sold = !variant || variant.status !== 'ready';
    const image = activeProduct.image
      ? `<img src="${escapeHtml(activeProduct.image)}" alt="${escapeHtml(activeProduct.name)}">`
      : `<div class="product-placeholder">${escapeHtml(activeProduct.name.charAt(0).toUpperCase())}</div>`;
    const category = activeProduct.categories?.[0]?.name || 'Premium App';
    const optionsHtml = activeProduct.options.map(option => `
      <div class="option-group">
        <div class="option-label"><span>${escapeHtml(option.name)}</span><small>Pilih satu</small></div>
        <div class="option-list">
          ${option.values.map(value => {
            const isSelected = Number(selected[option.id]) === Number(value.id);
            const enabled = valueAvailable(option.id, value.id) || isSelected;
            return `<button type="button" class="option-btn ${isSelected?'is-selected':''}" data-option-id="${option.id}" data-value-id="${value.id}" ${enabled?'':'disabled'}>${escapeHtml(value.label)}</button>`;
          }).join('')}
        </div>
      </div>`).join('');
    const priceHtml = variant ? `
      <div class="current-price"><small>Harga pilihan</small><div><strong>${money(effective)}</strong>${variant.promoPrice ? `<span class="regular-strike">${money(variant.regularPrice)}</span>`:''}</div></div>
      <span class="stock-pill ${variant.status}">${variant.status==='ready'?'Ready':'Sold Out'}</span>` : `
      <div class="current-price"><small>Harga pilihan</small><strong>Belum tersedia</strong></div><span class="stock-pill sold_out">Tidak tersedia</span>`;
    const qtyHtml = activeProduct.quantityMode === 'multiple' ? `
      <div class="quantity-row"><span>Jumlah</span><div class="stepper"><button type="button" data-qty-minus aria-label="Kurangi">−</button><b>${quantity}</b><button type="button" data-qty-plus aria-label="Tambah">+</button></div></div>` : `<div class="quantity-row"><span>Jumlah</span><b>1 item</b></div>`;
    productDetail.innerHTML = `
      <div class="detail-cover">${image}</div>
      <div class="detail-body">
        <div class="detail-meta"><span class="mini-pill">${escapeHtml(category)}</span>${activeProduct.badge?`<span class="mini-pill">${escapeHtml(activeProduct.badge)}</span>`:''}</div>
        <h2 id="detailTitle">${escapeHtml(activeProduct.name)}</h2>
        <p class="detail-desc">${escapeHtml(activeProduct.description || 'Pilih paket yang paling cocok untuk kamu.')}</p>
        ${optionsHtml}
        <div class="purchase-panel"><div class="price-row">${priceHtml}</div>${qtyHtml}</div>
        <div class="buy-actions">
          <button class="btn btn-secondary" type="button" data-add-cart ${sold?'disabled':''}>+ Keranjang</button>
          <button class="btn btn-primary" type="button" data-buy-now ${sold?'disabled':''}>Beli Sekarang</button>
        </div>
      </div>`;
  }

  function openProduct(id){
    activeProduct = byId(id);
    if(!activeProduct) return;
    quantity = 1;
    hydrateSelectionFromVariant(firstPreferredVariant(activeProduct));
    renderDetailBody();
    openOverlay(productOverlay);
  }

  document.addEventListener('click', event => {
    const opener = event.target.closest('[data-open-product]');
    if(opener) openProduct(opener.dataset.openProduct);
    if(event.target.closest('[data-close-product]')) closeOverlay(productOverlay);
    if(event.target.closest('[data-close-cart]')) closeOverlay(cartOverlay);
    const valueBtn = event.target.closest('[data-option-id][data-value-id]');
    if(valueBtn) chooseValue(valueBtn.dataset.optionId, valueBtn.dataset.valueId);
    if(event.target.closest('[data-qty-minus]')) { quantity = Math.max(1, quantity-1); renderDetailBody(); }
    if(event.target.closest('[data-qty-plus]')) { quantity = Math.min(99, quantity+1); renderDetailBody(); }
    if(event.target.closest('[data-add-cart]')) addActiveToCart(false);
    if(event.target.closest('[data-buy-now]')) buyActiveNow();
  });
  productOverlay?.addEventListener('click', event => { if(event.target === productOverlay) closeOverlay(productOverlay); });
  cartOverlay?.addEventListener('click', event => { if(event.target === cartOverlay) closeOverlay(cartOverlay); });

  const CART_KEY = 'pinky_cart_v1';
  const readCart = () => { try { return JSON.parse(localStorage.getItem(CART_KEY) || '[]'); } catch { return []; } };
  const writeCart = cart => { localStorage.setItem(CART_KEY, JSON.stringify(cart)); updateCartCount(); };

  function reconcileCart(){
    const current = readCart();
    const refreshed = current.map(row => {
      const product = byId(row.productId);
      if(!product) return null;
      const variant = product.variants.find(v => Number(v.id) === Number(row.variantId));
      if(!variant) return null;
      const labels = Object.entries(variant.labels || {}).map(([key,value]) => `${key}: ${value}`);
      return {
        ...row,
        name: product.name,
        image: product.image,
        labels,
        quantityMode: product.quantityMode,
        quantity: product.quantityMode === 'single' ? 1 : Math.max(1, Math.min(99, Number(row.quantity || 1))),
        unitPrice: Number(variant.promoPrice || variant.regularPrice),
        status: variant.status,
        selected: variant.status === 'ready' ? row.selected !== false : false,
      };
    }).filter(Boolean);
    writeCart(refreshed);
    return refreshed;
  }
  function cartItemFromActive(){
    const variant = exactVariant();
    if(!activeProduct || !variant || variant.status !== 'ready') return null;
    const labels = Object.entries(variant.labels || {}).map(([key,value]) => `${key}: ${value}`);
    return { key:`${activeProduct.id}-${variant.id}`, productId:activeProduct.id, variantId:variant.id, name:activeProduct.name, image:activeProduct.image, labels, quantity:activeProduct.quantityMode==='single'?1:quantity, quantityMode:activeProduct.quantityMode, unitPrice:Number(variant.promoPrice || variant.regularPrice), status:'ready', selected:true };
  }
  function addActiveToCart(openCartAfter){
    const item = cartItemFromActive(); if(!item) return;
    const cart = readCart(); const existing = cart.find(row => row.key === item.key);
    if(existing){
      existing.quantity = item.quantityMode === 'single' ? 1 : Math.min(99, Number(existing.quantity)+Number(item.quantity));
      existing.selected = true;
    } else cart.push(item);
    writeCart(cart); closeOverlay(productOverlay); showToast(`${activeProduct.name} ditambahkan ke keranjang ♡`);
    if(openCartAfter) setTimeout(openCart, 100);
  }
  function updateCartCount(){ const count = readCart().reduce((sum,row)=>sum+Number(row.quantity||1),0); document.querySelectorAll('[data-cart-count]').forEach(el=>el.textContent=count); }
  function setCartQty(key, delta){
    const cart = readCart(); const item = cart.find(row=>row.key===key); if(!item) return;
    if(item.quantityMode === 'single') item.quantity = 1; else item.quantity = Math.max(1,Math.min(99,Number(item.quantity)+delta));
    writeCart(cart); renderCart();
  }
  function setCartSelection(key, isSelected){
    const cart = readCart(); const item = cart.find(row=>row.key===key); if(!item || item.status==='sold_out') return;
    item.selected = Boolean(isSelected);
    writeCart(cart); renderCart();
  }
  function setAllCartSelection(isSelected){
    const cart = readCart().map(row => ({...row, selected: row.status === 'sold_out' ? false : Boolean(isSelected)}));
    writeCart(cart); renderCart();
  }
  function removeCartItem(key){ const cart = readCart().filter(row=>row.key!==key); writeCart(cart); renderCart(); }
  function renderCart(){
    const cart = reconcileCart();
    if(cart.length===0){ cartContent.innerHTML=`<div class="empty-state"><span>🛍️</span><h3>Keranjang masih kosong</h3><p>Tambah aplikasi yang kamu mau dulu ya.</p></div>`; return; }
    const selectedCart = cart.filter(row=>row.selected && row.status==='ready');
    const total = selectedCart.reduce((sum,row)=>sum+Number(row.unitPrice)*Number(row.quantity),0);
    const selectedQty = selectedCart.reduce((sum,row)=>sum+Number(row.quantity),0);
    const selectable = cart.filter(row=>row.status==='ready');
    const allSelected = selectable.length > 0 && selectable.every(row=>row.selected);
    cartContent.innerHTML=`<div class="cart-selection-head"><label class="cart-select-all"><input type="checkbox" data-cart-select-all ${allSelected?'checked':''}><span class="cart-check-ui" aria-hidden="true"></span><b>Pilih semua</b></label><span>${selectedCart.length} dari ${cart.length} produk dipilih</span></div>
      <div class="cart-items">${cart.map(row=>`
      <div class="cart-item ${row.selected?'is-selected':''} ${row.status==='sold_out'?'is-unavailable':''}">
        <label class="cart-selector" aria-label="${row.selected?'Batalkan pilihan':'Pilih'} ${escapeHtml(row.name)}"><input type="checkbox" data-cart-select="${escapeHtml(row.key)}" ${row.selected?'checked':''} ${row.status==='sold_out'?'disabled':''}><span class="cart-check-ui" aria-hidden="true"></span></label>
        <div class="cart-thumb">${row.image?`<img src="${escapeHtml(row.image)}" alt="">`:`<div class="product-placeholder">${escapeHtml(row.name.charAt(0).toUpperCase())}</div>`}</div>
        <div class="cart-copy"><h3>${escapeHtml(row.name)}</h3><p>${escapeHtml((row.labels||[]).join(' · ') || 'Paket utama')}</p><strong>${money(row.unitPrice * row.quantity)}</strong>${row.status==='sold_out'?'<span class="cart-unavailable">Sold Out</span>':''}</div>
        <div class="cart-controls">${row.quantityMode==='multiple'?`<div class="mini-stepper"><button type="button" data-cart-minus="${escapeHtml(row.key)}">−</button><b>${row.quantity}</b><button type="button" data-cart-plus="${escapeHtml(row.key)}">+</button></div>`:`<span class="mini-pill">Qty 1</span>`}<button type="button" class="remove-link" data-cart-remove="${escapeHtml(row.key)}">Hapus</button></div>
      </div>`).join('')}</div>
      <div class="cart-summary"><div class="cart-total"><span>Total ${selectedQty} item dipilih</span><strong>${money(total)}</strong></div><button class="whatsapp-btn" type="button" data-checkout-cart ${selectedCart.length===0?'disabled':''}>${selectedCart.length===0?'Pilih item yang mau dipesan':(allSelected?'Pesan Semua via WhatsApp':`Pesan ${selectedCart.length} Pilihan via WhatsApp`)}</button></div>`;
  }
  function openCart(){ renderCart(); openOverlay(cartOverlay); }
  document.querySelectorAll('[data-open-cart]').forEach(btn=>btn.addEventListener('click',openCart));
  cartContent?.addEventListener('click', event => {
    const minus=event.target.closest('[data-cart-minus]'); if(minus) setCartQty(minus.dataset.cartMinus,-1);
    const plus=event.target.closest('[data-cart-plus]'); if(plus) setCartQty(plus.dataset.cartPlus,1);
    const remove=event.target.closest('[data-cart-remove]'); if(remove) removeCartItem(remove.dataset.cartRemove);
    if(event.target.closest('[data-checkout-cart]')) checkoutCart();
  });
  cartContent?.addEventListener('change', event => {
    const select=event.target.closest('[data-cart-select]'); if(select) setCartSelection(select.dataset.cartSelect,select.checked);
    const selectAll=event.target.closest('[data-cart-select-all]'); if(selectAll) setAllCartSelection(selectAll.checked);
  });

  function applyTemplate(template, values){ return Object.entries(values).reduce((result,[key,val])=>result.replaceAll(`{${key}}`,String(val ?? '')), template); }
  function sanitizeWhatsAppText(text){
    return Array.from(String(text ?? '').normalize('NFC')).filter(char => char !== '\uFFFD').join('');
  }
  function openWhatsApp(text){
    const number = String(settings.whatsapp || '').replace(/\D/g,'');
    const cleanText = sanitizeWhatsAppText(text);
    window.open(`https://wa.me/${number}?text=${encodeURIComponent(cleanText)}`,'_blank','noopener');
  }
  function buyActiveNow(){
    const item = cartItemFromActive(); if(!item) return;
    const variantLines = (item.labels||[]).map(label=>`- ${label}`).join('\n');
    const priceLine = item.quantity>1 ? `${money(item.unitPrice)} x ${item.quantity}` : money(item.unitPrice);
    const template = settings.singleTemplate || `{opening}\n\n{product}\n{variant_lines}\nQty: {quantity}\nHarga: {price_line}\nSubtotal: {subtotal}\n\n{closing}`;
    const text = applyTemplate(template,{opening:settings.opening||'',closing:settings.closing||'',product:item.name,variant_lines:variantLines,quantity:item.quantity,price_line:priceLine,subtotal:money(item.unitPrice*item.quantity)});
    openWhatsApp(text);
  }
  function checkoutCart(){
    const cart=reconcileCart();
    const selectedCart=cart.filter(row=>row.selected && row.status==='ready');
    if(!selectedCart.length) return;
    const items=selectedCart.map((row,index)=>`${index+1}. ${row.name}\n${(row.labels||[]).map(v=>`- ${v}`).join('\n')}${row.labels?.length?'\n':''}- Qty: ${row.quantity}\n- ${money(row.unitPrice)}${row.quantity>1?` x ${row.quantity}`:''} = ${money(row.unitPrice*row.quantity)}`).join('\n\n');
    const total=selectedCart.reduce((sum,row)=>sum+row.unitPrice*row.quantity,0);
    const template=settings.cartTemplate || `{opening}\n\n{items}\n\nTotal: {total}\n\n{closing}`;
    const text=applyTemplate(template,{opening:settings.opening||'',closing:settings.closing||'',items,total:money(total)});
    openWhatsApp(text);
    const selectedKeys=new Set(selectedCart.map(row=>row.key));
    writeCart(cart.filter(row=>!selectedKeys.has(row.key)));
    renderCart();
    showToast('Item yang dipesan sudah dikeluarkan dari keranjang.');
  }

  document.addEventListener('keydown', event => { if(event.key==='Escape'){ if(!productOverlay.hidden) closeOverlay(productOverlay); if(!cartOverlay.hidden) closeOverlay(cartOverlay); } });
  reconcileCart();
})();
