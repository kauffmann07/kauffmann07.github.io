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
  const toTop = document.getElementById('to-top');
  const navLinks = [...document.querySelectorAll('[data-nav-link]')];
  const sections = [...new Set(
    navLinks
      .map((link) => document.querySelector(link.getAttribute('href')))
      .filter(Boolean)
  )];

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
      const isActive = current !== null && link.getAttribute('href') === `#${current.id}`;
      link.classList.toggle('is-active', isActive);
      if (isActive) link.setAttribute('aria-current', 'location');
      else link.removeAttribute('aria-current');
    }

    if (toTop) {
      const nearFooter = doc.scrollHeight - (y + window.innerHeight) < 260;
      toTop.hidden = y < 700 || nearFooter;
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

  if (toTop) {
    toTop.addEventListener('click', () => {
      const top = document.getElementById('top');
      window.scrollTo({ top: 0, behavior: reduceMotion ? 'auto' : 'smooth' });
      if (top) top.focus({ preventScroll: true });
    });
  }

  const skipLink = document.querySelector('.skip-link');
  if (skipLink) {
    skipLink.addEventListener('click', () => {
      const target = document.getElementById('placar');
      if (!target) return;
      target.setAttribute('tabindex', '-1');
      requestAnimationFrame(() => target.focus({ preventScroll: true }));
    });
  }

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
    if ('IntersectionObserver' in window) {
      // Só zera o que já está na primeira dobra. O restante mantém o valor
      // final no HTML para leitores de tela, buscadores e links profundos.
      for (const el of numbers.filter((item) => item.closest('.hero'))) {
        const decimals = Number(el.dataset.dec || 0);
        el.textContent = decimals ? fmtDec.format(0) : fmtInt.format(0);
      }

      const countObserver = new IntersectionObserver((entries) => {
        for (const entry of entries) {
          if (!entry.isIntersecting) continue;
          countObserver.unobserve(entry.target);
          const decimals = Number(entry.target.dataset.dec || 0);
          entry.target.textContent = decimals ? fmtDec.format(0) : fmtInt.format(0);
          countUp(entry.target);
        }
      }, { threshold: 0.4, rootMargin: '0px 0px -4% 0px' });

      numbers.forEach((el) => countObserver.observe(el));
    } else {
      for (const el of numbers) {
        const decimals = Number(el.dataset.dec || 0);
        el.textContent = decimals
          ? fmtDec.format(Number(el.dataset.count))
          : fmtInt.format(Number(el.dataset.count));
      }
    }
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

  const printButton = document.getElementById('print-page');
  if (printButton) printButton.addEventListener('click', () => window.print());

  /* ---------- mobile menu ---------- */

  const menuToggle = document.getElementById('menu-toggle');
  const mobileMenu = document.getElementById('mobile-menu');
  let menuOpen = false;

  function setMenu(open, returnFocus = true) {
    if (!menuToggle || !mobileMenu) return;
    menuOpen = open;
    menuToggle.setAttribute('aria-expanded', String(open));
    menuToggle.setAttribute('aria-label', open ? 'Fechar menu' : 'Abrir menu');
    mobileMenu.hidden = !open;
    nav?.classList.toggle('is-menu-open', open);
    if (!open && returnFocus) menuToggle.focus();
  }

  if (menuToggle && mobileMenu) {
    menuToggle.addEventListener('click', () => setMenu(!menuOpen));

    for (const link of mobileMenu.querySelectorAll('a[href^="#"]')) {
      link.addEventListener('click', () => {
        const target = document.querySelector(link.getAttribute('href'));
        setMenu(false, false);
        if (!target) return;
        const heading = target.querySelector('h1, h2');
        if (heading) {
          heading.setAttribute('tabindex', '-1');
          requestAnimationFrame(() => heading.focus({ preventScroll: true }));
        }
      });
    }

    document.addEventListener('click', (event) => {
      if (!menuOpen) return;
      if (mobileMenu.contains(event.target) || menuToggle.contains(event.target)) return;
      setMenu(false, false);
    });

    const menuMedia = window.matchMedia('(max-width: 880px)');
    const closeOnDesktop = (event) => {
      if (!event.matches && menuOpen) setMenu(false, false);
    };
    if (typeof menuMedia.addEventListener === 'function') menuMedia.addEventListener('change', closeOnDesktop);
    else menuMedia.addListener(closeOnDesktop);
  }

  /* ---------- help dialog ---------- */

  const help = document.getElementById('help-dialog');
  const helpOpeners = [...document.querySelectorAll('[data-help-open]')];
  let helpOpener = null;
  let helpFallback = false;
  let helpReturnFocus = true;

  function focusHelpTarget(selector) {
    const target = document.querySelector(selector);
    if (!target) return;
    const heading = target.querySelector('h1, h2');
    if (heading) {
      heading.setAttribute('tabindex', '-1');
      requestAnimationFrame(() => heading.focus({ preventScroll: true }));
    }
  }

  function afterHelpClose() {
    document.body.classList.remove('is-dialog-open');
    const opener = helpOpener;
    helpOpener = null;
    const shouldFocus = helpReturnFocus;
    helpReturnFocus = true;
    if (!shouldFocus) return;
    if (opener && opener.isConnected && opener.getClientRects().length) {
      opener.focus();
    } else if (menuToggle && getComputedStyle(menuToggle).display !== 'none') {
      menuToggle.focus();
    }
  }

  function openHelp(opener) {
    if (!help || help.open) return;
    if (menuOpen) setMenu(false, false);
    helpOpener = opener || document.activeElement;
    helpReturnFocus = true;
    document.body.classList.add('is-dialog-open');
    try {
      if (typeof help.showModal === 'function') {
        helpFallback = false;
        help.showModal();
      } else {
        helpFallback = true;
        help.setAttribute('open', '');
      }
    } catch {
      helpFallback = true;
      help.setAttribute('open', '');
    }
    const closeButton = help.querySelector('button[data-help-close]');
    if (closeButton) closeButton.focus();
  }

  function closeHelp(returnFocus = true) {
    if (!help) return;
    helpReturnFocus = returnFocus;
    if (!helpFallback && typeof help.close === 'function' && help.open) {
      help.close();
    } else {
      help.removeAttribute('open');
      helpFallback = false;
      afterHelpClose();
    }
  }

  if (help) {
    help.addEventListener('close', afterHelpClose);

    for (const opener of helpOpeners) {
      opener.addEventListener('click', () => openHelp(opener));
    }

    for (const closeButton of help.querySelectorAll('button[data-help-close]')) {
      closeButton.addEventListener('click', () => closeHelp());
    }

    for (const link of help.querySelectorAll('a[href^="#"]')) {
      link.addEventListener('click', (event) => {
        event.preventDefault();
        const selector = link.getAttribute('href');
        closeHelp(false);
        focusHelpTarget(selector);
        const target = document.querySelector(selector);
        if (target) target.scrollIntoView({ behavior: reduceMotion ? 'auto' : 'smooth', block: 'start' });
      });
    }

    help.addEventListener('click', (event) => {
      if (event.target !== help) return;
      const rect = help.getBoundingClientRect();
      const outside = event.clientX < rect.left || event.clientX > rect.right
        || event.clientY < rect.top || event.clientY > rect.bottom;
      if (outside) closeHelp();
    });
  }

  function isTypingTarget(target) {
    return target instanceof HTMLElement
      && (target.isContentEditable || /^(INPUT|TEXTAREA|SELECT)$/.test(target.tagName));
  }

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && menuOpen) {
      event.preventDefault();
      setMenu(false);
      return;
    }

    if (event.key === '?' && !event.altKey && !event.ctrlKey && !event.metaKey
      && !isTypingTarget(event.target) && !(help && help.open)) {
      event.preventDefault();
      openHelp(document.activeElement);
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
