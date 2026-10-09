/* Scroll reveal + counters — lightweight IntersectionObserver implementation
   (no external animation library needed). Respects prefers-reduced-motion. */
(function () {
  const reduced = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  function revealAll() {
    document.querySelectorAll("[data-reveal], .timeline-item").forEach((el) => el.classList.add("is-visible"));
  }

  function initReveal() {
    if (reduced || !("IntersectionObserver" in window)) return revealAll();
    const io = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add("is-visible");
            io.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.12, rootMargin: "0px 0px -40px 0px" }
    );
    document.querySelectorAll("[data-reveal], .timeline-item").forEach((el) => io.observe(el));
  }

  function animateCounter(el) {
    const target = parseFloat(el.dataset.count || "0");
    const suffix = el.dataset.suffix || "";
    if (reduced) { el.textContent = target + suffix; return; }
    const duration = 1400;
    const start = performance.now();
    function tick(now) {
      const p = Math.min((now - start) / duration, 1);
      const eased = 1 - Math.pow(1 - p, 3);
      el.textContent = Math.round(target * eased) + suffix;
      if (p < 1) requestAnimationFrame(tick);
    }
    requestAnimationFrame(tick);
  }

  function initCounters() {
    const counters = document.querySelectorAll("[data-count]");
    if (!counters.length) return;
    if (!("IntersectionObserver" in window)) return counters.forEach(animateCounter);
    const io = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) { animateCounter(entry.target); io.unobserve(entry.target); }
        });
      },
      { threshold: 0.4 }
    );
    counters.forEach((el) => io.observe(el));
  }

  // Public helper so dynamically rendered cards can be observed too.
  window.KTAnimate = { initReveal, initCounters };

  document.addEventListener("DOMContentLoaded", function () {
    initReveal();
    initCounters();
  });
})();
