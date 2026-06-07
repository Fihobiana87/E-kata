(() => {
  const inView = (el) => {
    const r = el.getBoundingClientRect();
    return r.top < window.innerHeight * 0.9 && r.bottom > 0;
  };

  const revealAll = () => {
    document.querySelectorAll('.reveal:not(.is-in)').forEach((el) => {
      if (inView(el)) el.classList.add('is-in');
    });
  };

  const onScroll = () => requestAnimationFrame(revealAll);
  window.addEventListener('scroll', onScroll, { passive: true });
  window.addEventListener('resize', onScroll);

  const init = () => revealAll();
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();

(() => {
  const prefersReduced = () =>
    window.matchMedia &&
    window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  const parseWords = (el) => {
    const raw = (el.getAttribute('data-words') || '').trim();
    if (!raw) return [];
    return raw
      .split('|')
      .map((s) => s.trim())
      .filter(Boolean);
  };

  const sleep = (ms) => new Promise((r) => setTimeout(r, ms));

  const run = async (el) => {
    const words = parseWords(el);
    if (!words.length) return;

    const motion = (el.getAttribute('data-motion') || 'auto').toLowerCase();
    const shouldReduce = motion !== 'force' && prefersReduced();

    if (shouldReduce) {
      el.textContent = words[0];
      return;
    }

    let i = 0;
    let txt = '';
    let isDeleting = false;

    // tuned for a "welcome/hero" vibe
    const typeSpeed = 42;
    const deleteSpeed = 26;
    const pauseAfterType = 1100;
    const pauseAfterDelete = 250;

    while (el.isConnected) {
      const word = words[i % words.length];

      if (!isDeleting) {
        txt = word.slice(0, txt.length + 1);
        el.textContent = txt;
        if (txt === word) {
          await sleep(pauseAfterType);
          isDeleting = true;
        } else {
          await sleep(typeSpeed);
        }
      } else {
        txt = word.slice(0, Math.max(0, txt.length - 1));
        el.textContent = txt;
        if (!txt) {
          isDeleting = false;
          i += 1;
          await sleep(pauseAfterDelete);
        } else {
          await sleep(deleteSpeed);
        }
      }
    }
  };

  const init = () => {
    document.querySelectorAll('.typewriter').forEach((el) => {
      if (el.dataset.tw === '1') return;
      el.dataset.tw = '1';
      run(el);
    });
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();

