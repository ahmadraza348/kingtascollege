/* ==========================================================================
   Global site behaviour: sticky navbar, scroll progress, back-to-top,
   active nav state, footer year, language scaffolding, shared renderers.
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
    const page = (location.pathname.split("/").pop() || "index.html").toLowerCase();
    $$(".site-navbar .nav-link, .site-navbar .dropdown-item").forEach((link) => {
      const href = (link.getAttribute("href") || "").toLowerCase();
      if (!href || href.startsWith("#") || href.startsWith("http")) return;
      if (href === page) {
        link.classList.add("active");
        const parent = link.closest(".dropdown");
        if (parent) parent.querySelector(".nav-link")?.classList.add("active");
      }
    });
  }

  /* ---------- Close mobile menu after a link tap ------------------------- */
  function initMobileMenu() {
    const collapse = $("#mainNav");
    if (!collapse) return;
    $$("a.nav-link:not(.dropdown-toggle), .dropdown-item", collapse).forEach((link) => {
      link.addEventListener("click", () => {
        if (window.innerWidth < 992 && collapse.classList.contains("show")) {
          window.bootstrap?.Collapse.getOrCreateInstance(collapse).hide();
        }
      });
    });
  }

  /* ---------- Footer year + contact placeholders ------------------------- */
  function initDynamicText() {
    const c = window.KT?.COLLEGE;
    $$("[data-year]").forEach((el) => (el.textContent = new Date().getFullYear()));
    if (!c) return;
    $$("[data-wa-link]").forEach((el) => {
      el.href = `https://wa.me/${c.whatsapp}?text=${encodeURIComponent(c.whatsappMessage)}`;
    });
    $$("[data-college-email]").forEach((el) => {
      el.textContent = c.email;
      if (el.tagName === "A") el.href = "mailto:" + c.email;
    });
  }

  /* ---------- Language scaffolding (English / Urdu ready) ---------------- */
  function initLanguage() {
    const buttons = $$("[data-lang]");
    if (!buttons.length) return;
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

  /* ---------- Shared formatters / renderers ------------------------------ */
  const helpers = {
    formatDate(iso) {
      const d = new Date(iso + "T00:00:00");
      return d.toLocaleDateString("en-GB", { day: "numeric", month: "short", year: "numeric" });
    },
    day: (iso) => new Date(iso + "T00:00:00").getDate(),
    month: (iso) =>
      new Date(iso + "T00:00:00").toLocaleDateString("en-GB", { month: "short" }),
    esc(str) {
      return String(str).replace(/[&<>"']/g, (ch) =>
        ({ "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#39;" }[ch])
      );
    },
    programCard(p, delayIndex = 0) {
      const KT = window.KT;
      const duration = p.duration || KT.TBC;
      const eligibility = p.eligibility || KT.TBC;
      return `
      <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="${(delayIndex % 3) + 1}">
        <article class="card-brand program-card d-flex flex-column">
          <div class="media-frame ratio-16x9">
            <span class="badge-brand ${p.category === "Nursing" ? "" : "badge-brand-red"} badge-float">${helpers.esc(p.category)}</span>
            <img src="${p.image}" alt="${helpers.esc(p.title)} program at King TAS College" loading="lazy" width="1200" height="675">
          </div>
          <div class="p-4 d-flex flex-column flex-grow-1">
            <div class="d-flex align-items-center gap-2 mb-2">
              <i class="bi ${p.icon} text-brand fs-5"></i>
              <h3 class="h6 mb-0">${helpers.esc(p.title)}</h3>
            </div>
            <p class="small text-soft flex-grow-1">${helpers.esc(p.description)}</p>
            <div class="meta-row mb-2">
              <span><i class="bi bi-clock me-1"></i>${helpers.esc(duration)}</span>
            </div>
            <div class="meta-row mb-3">
              <span><i class="bi bi-mortarboard me-1"></i>${helpers.esc(eligibility)}</span>
            </div>
            <div class="d-flex gap-2">
              <a class="btn btn-outline-brand btn-sm flex-fill" href="program-details.html?program=${encodeURIComponent(p.id)}">Learn More</a>
              <a class="btn btn-brand-red btn-sm flex-fill" href="admissions.html#apply">Apply Now</a>
            </div>
          </div>
        </article>
      </div>`;
    },
    newsCard(n, delayIndex = 0) {
      return `
      <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="${(delayIndex % 3) + 1}">
        <article class="card-brand news-card d-flex flex-column">
          <a class="media-frame ratio-16x9 d-block" href="news-details.html?article=${encodeURIComponent(n.id)}">
            <img src="${n.image}" alt="${helpers.esc(n.title)}" loading="lazy" width="1200" height="675">
          </a>
          <div class="p-4 d-flex flex-column flex-grow-1">
            <div class="news-meta mb-2">
              <span class="badge badge-soft">${helpers.esc(n.category)}</span>
              <span><i class="bi bi-calendar3 me-1"></i>${helpers.formatDate(n.date)}</span>
            </div>
            <h3><a class="text-reset" href="news-details.html?article=${encodeURIComponent(n.id)}">${helpers.esc(n.title)}</a></h3>
            <p class="small text-soft flex-grow-1">${helpers.esc(n.summary)}</p>
            <a class="fw-600 small" href="news-details.html?article=${encodeURIComponent(n.id)}">Read More <i class="bi bi-arrow-right ms-1"></i></a>
          </div>
        </article>
      </div>`;
    },
    eventCard(e, delayIndex = 0) {
      return `
      <div class="col-md-6" data-reveal data-reveal-delay="${(delayIndex % 3) + 1}">
        <article class="card-brand h-100">
          <div class="media-frame ratio-16x9">
            <img src="${e.image}" alt="${helpers.esc(e.title)}" loading="lazy" width="1200" height="675">
          </div>
          <div class="p-4 d-flex gap-3">
            <div class="event-date">
              <span class="day">${helpers.day(e.date)}</span>
              <span class="mon">${helpers.month(e.date)}</span>
            </div>
            <div>
              <h3 class="h6 mb-1">${helpers.esc(e.title)}</h3>
              <p class="small text-soft mb-2"><i class="bi bi-geo-alt me-1"></i>${helpers.esc(e.location)}</p>
              <p class="small text-soft mb-2">${helpers.esc(e.description)}</p>
              <span class="badge badge-soft">${helpers.esc(e.status)}</span>
            </div>
          </div>
        </article>
      </div>`;
    },
  };

  window.KTHelpers = helpers;

  document.addEventListener("DOMContentLoaded", function () {
    initScrollUI();
    initActiveNav();
    initMobileMenu();
    initDynamicText();
    initLanguage();
    document.body.classList.add("page-fade");
  });
})();
