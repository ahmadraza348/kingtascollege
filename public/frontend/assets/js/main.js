/* ==========================================================================
   Global site behaviour: sticky navbar, scroll progress, back-to-top,
   active nav state, footer year, language scaffolding.
   ========================================================================== */
(function () {
  const $ = (sel, ctx = document) => ctx.querySelector(sel);
  const $$ = (sel, ctx = document) => Array.from(ctx.querySelectorAll(sel));

  /* ---------- Sticky navbar + scroll progress ---------------------------- */
  function initScrollUI() {
    const navbar = $("#siteNavbar");
    const progress = $("#scrollProgress");
    const toTop = $("#backToTop");
    const offset = navbar ? navbar.offsetTop : 0;

    function onScroll() {
      const y = window.scrollY || document.documentElement.scrollTop;
      if (navbar) {
        const stuck = y > offset + 4;
        navbar.classList.toggle("is-stuck", stuck);
        document.body.classList.toggle("nav-stuck", stuck);
      }
      if (progress) {
        const h = document.documentElement.scrollHeight - window.innerHeight;
        progress.style.width = (h > 0 ? (y / h) * 100 : 0) + "%";
      }
      if (toTop) toTop.classList.toggle("show", y > 500);
    }
    window.addEventListener("scroll", onScroll, { passive: true });
    onScroll();

    if (toTop) {
      toTop.addEventListener("click", () =>
        window.scrollTo({ top: 0, behavior: "smooth" })
      );
    }
  }

  /* ---------- Active navigation state ----------------------------------- */
  function initActiveNav() {
    // Works with clean Laravel URLs (e.g. /about) as well as static .html files.
    const norm = (p) => (p.replace(/\/+$/, "") || "/").toLowerCase();
    const here = norm(location.pathname);
    $$(".site-navbar .nav-link, .site-navbar .dropdown-item").forEach((link) => {
      const raw = link.getAttribute("href") || "";
      if (!raw || raw.startsWith("#") || /^(https?:|mailto:|tel:)/i.test(raw)) return;
      let url;
      try { url = new URL(link.href, location.href); } catch (e) { return; }
      if (url.origin !== location.origin || url.hash) return;
      if (norm(url.pathname) !== here) return;
      if (url.search && url.search !== location.search) return;
      link.classList.add("active");
      const parent = link.closest(".dropdown");
      if (parent) parent.querySelector(".nav-link")?.classList.add("active");
    });
  }

  /* ---------- Close mobile menu after a link tap ------------------------- */
  function initMobileMenu() {
    const collapse = $("#mainNav");
    if (!collapse) return;
    $$("a.nav-link:not(.dropdown-toggle), .dropdown-item", collapse).forEach((link) => {
      link.addEventListener("click", () => {
        if (window.innerWidth < 1200 && collapse.classList.contains("show")) {
          window.bootstrap?.Collapse.getOrCreateInstance(collapse).hide();
        }
      });
    });
  }

  /* ---------- Footer year ------------------------------------------------ */
  function initYear() {
    $$("[data-year]").forEach((el) => (el.textContent = new Date().getFullYear()));
  }

  /* ---------- Language scaffolding (English / Urdu ready) ---------------- */
  function initLanguage() {
    const buttons = $$("[data-lang]");
    if (!buttons.length) {
      // No language switch on the page: always English / LTR and drop any stale "ur" setting.
      try { localStorage.removeItem("kt-lang"); } catch (e) {}
      document.documentElement.setAttribute("lang", "en");
      document.documentElement.setAttribute("dir", "ltr");
      return;
    }
    const stored = localStorage.getItem("kt-lang") || "en";
    apply(stored);

    function apply(lang) {
      document.documentElement.setAttribute("lang", lang === "ur" ? "ur" : "en");
      document.documentElement.setAttribute("dir", lang === "ur" ? "rtl" : "ltr");
      buttons.forEach((b) => b.classList.toggle("active", b.dataset.lang === lang));
      // Urdu translations can be attached later via data-ur attributes:
      $$("[data-ur]").forEach((el) => {
        if (lang === "ur") {
          if (!el.dataset.en) el.dataset.en = el.textContent;
          el.textContent = el.dataset.ur;
        } else if (el.dataset.en) {
          el.textContent = el.dataset.en;
        }
      });
    }

    buttons.forEach((b) =>
      b.addEventListener("click", () => {
        localStorage.setItem("kt-lang", b.dataset.lang);
        apply(b.dataset.lang);
      })
    );
  }

  document.addEventListener("DOMContentLoaded", function () {
    initScrollUI();
    initActiveNav();
    initMobileMenu();
    initYear();
    initLanguage();
    document.body.classList.add("page-fade");
  });
})();
