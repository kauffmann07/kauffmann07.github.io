/* ============================================================
   Projeção 2026 — interações
   ============================================================ */

(() => {
  'use strict';

  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const fmtInt = new Intl.NumberFormat('pt-BR');
  const fmtDec = new Intl.NumberFormat('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

  /* ---------- progress + nav ---------- */

  const progress = document.getElementById('progress');
  const nav = document.getElementById('nav');
  const navLinks = [...document.querySelectorAll('.nav__links a')];
  const sections = navLinks
    .map((link) => document.querySelector(link.getAttribute('href')))
    .filter(Boolean);

  let ticking = false;

  function onScroll() {
    const y = window.scrollY || 0;
    const doc = document.documentElement;
    const max = doc.scrollHeight - window.innerHeight;

    if (progress) progress.style.transform = `scaleX(${max > 0 ? Math.min(y / max, 1) : 0})`;
    if (nav) nav.classList.toggle('is-scrolled', y > 10);

    let current = null;
    for (const section of sections) {
      if (section.offsetTop - 140 <= y) current = section;
    }

    for (const link of navLinks) {
      link.classList.toggle('is-active', current !== null && link.getAttribute('href') === `#${current.id}`);
    }

    ticking = false;
  }

  window.addEventListener('scroll', () => {
    if (!ticking) {
      ticking = true;
      requestAnimationFrame(onScroll);
    }
  }, { passive: true });

  onScroll();

  /* ---------- reveal ---------- */

  const reveals = [...document.querySelectorAll('.reveal')];

  if (reduceMotion || !('IntersectionObserver' in window)) {
    reveals.forEach((el) => el.classList.add('is-in'));
  } else {
    const revealObserver = new IntersectionObserver((entries) => {
      for (const entry of entries) {
        if (!entry.isIntersecting) continue;
        const el = entry.target;
        const siblings = el.parentElement
          ? [...el.parentElement.children].filter((child) => child.classList.contains('reveal'))
          : [];
        const index = Math.max(siblings.indexOf(el), 0);
        el.style.transitionDelay = `${Math.min(index * 70, 350)}ms`;
        el.classList.add('is-in');
        revealObserver.unobserve(el);
      }
    }, { threshold: 0.12, rootMargin: '0px 0px -6% 0px' });

    reveals.forEach((el) => revealObserver.observe(el));
  }

  /* ---------- animated numbers ---------- */

  const numbers = [...document.querySelectorAll('.num[data-count]')];
  let printMode = false;

  if (!reduceMotion) {
    for (const el of numbers) {
      const decimals = Number(el.dataset.dec || 0);
      el.textContent = decimals ? fmtDec.format(0) : fmtInt.format(0);
    }

    const countObserver = new IntersectionObserver((entries) => {
      for (const entry of entries) {
        if (!entry.isIntersecting) continue;
        countObserver.unobserve(entry.target);
        countUp(entry.target);
      }
    }, { threshold: 0.4, rootMargin: '0px 0px -4% 0px' });

    numbers.forEach((el) => countObserver.observe(el));
  }

  function countUp(el) {
    const target = Number(el.dataset.count);
    const decimals = Number(el.dataset.dec || 0);
    const duration = 1450;
    const start = performance.now();

    function frame(now) {
      if (printMode) {
        el.textContent = decimals ? fmtDec.format(target) : fmtInt.format(target);
        return;
      }

      const p = Math.min((now - start) / duration, 1);
      const eased = 1 - Math.pow(1 - p, 4);
      const value = target * eased;
      el.textContent = decimals ? fmtDec.format(value) : fmtInt.format(Math.round(value));
      if (p < 1) requestAnimationFrame(frame);
      else el.textContent = decimals ? fmtDec.format(target) : fmtInt.format(target);
    }

    requestAnimationFrame(frame);
  }

  /* ---------- copy link ---------- */

  const copyButton = document.getElementById('copy-link');
  const toast = document.getElementById('toast');
  let toastTimer = null;

  function showToast(message) {
    if (!toast) return;
    toast.textContent = message;
    toast.classList.add('is-on');
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => toast.classList.remove('is-on'), 2200);
  }

  if (copyButton) {
    const copyLabel = copyButton.innerHTML;

    copyButton.addEventListener('click', async () => {
      const url = window.location.href;
      let copied = false;

      if (navigator.clipboard && window.isSecureContext) {
        try {
          await navigator.clipboard.writeText(url);
          copied = true;
        } catch {
          copied = false;
        }
      }

      if (!copied) {
        try {
          const helper = document.createElement('textarea');
          helper.value = url;
          helper.setAttribute('readonly', '');
          helper.style.position = 'fixed';
          helper.style.top = '0';
          helper.style.left = '0';
          helper.style.opacity = '0';
          document.body.appendChild(helper);
          helper.focus();
          helper.select();
          helper.setSelectionRange(0, helper.value.length);
          copied = document.execCommand('copy');
          helper.remove();
        } catch {
          copied = false;
        }
      }

      if (!copied) {
        showToast('Não foi possível copiar — copie pela barra de endereço');
        return;
      }

      showToast('Link copiado para a área de transferência');
      copyButton.classList.add('is-done');
      copyButton.textContent = 'Link copiado';
      setTimeout(() => {
        copyButton.innerHTML = copyLabel;
        copyButton.classList.remove('is-done');
      }, 2200);
    });
  }

  /* ---------- print: open all details ---------- */

  const details = [...document.querySelectorAll('details')];

  window.addEventListener('beforeprint', () => {
    printMode = true;

    for (const item of details) {
      item.dataset.wasOpen = item.open ? '1' : '0';
      item.open = true;
    }

    for (const el of reveals) el.classList.add('is-in');

    for (const el of numbers) {
      const decimals = Number(el.dataset.dec || 0);
      el.textContent = decimals
        ? fmtDec.format(Number(el.dataset.count))
        : fmtInt.format(Number(el.dataset.count));
    }
  });

  window.addEventListener('afterprint', () => {
    for (const item of details) {
      if (item.dataset.wasOpen === '0') item.open = false;
    }
  });

  /* ---------- subtle aura parallax ---------- */

  const hero = document.querySelector('.hero');
  const auraA = document.querySelector('.hero__aura--a');
  const auraB = document.querySelector('.hero__aura--b');
  const finePointer = window.matchMedia('(pointer: fine)').matches;

  if (!reduceMotion && finePointer && hero && auraA && auraB) {
    let raf = 0;
    let px = 0;
    let py = 0;

    hero.addEventListener('pointermove', (event) => {
      const rect = hero.getBoundingClientRect();
      px = (event.clientX - rect.left) / rect.width - 0.5;
      py = (event.clientY - rect.top) / rect.height - 0.5;
      if (!raf) {
        raf = requestAnimationFrame(() => {
          auraA.style.transform = `translate3d(${px * 26}px, ${py * 18}px, 0)`;
          auraB.style.transform = `translate3d(${px * -22}px, ${py * -16}px, 0)`;
          raf = 0;
        });
      }
    });

    hero.addEventListener('pointerleave', () => {
      auraA.style.transform = '';
      auraB.style.transform = '';
    });
  }
})();
