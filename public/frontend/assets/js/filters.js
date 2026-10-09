/* ==========================================================================
   Client-side directories. All content is rendered in the HTML itself; this
   file only filters / searches the existing items and picks which detail
   block to show. Items opt in with data attributes:
     data-item  data-category="..."  data-tags="a|b"  data-search="lowercase text"
   ========================================================================== */
(function () {
  const params = new URLSearchParams(location.search);

  function reveal(container) {
    window.KTAnimate?.initReveal();
    requestAnimationFrame(() =>
      container.querySelectorAll("[data-reveal]").forEach((el) => el.classList.add("is-visible"))
    );
  }

  /* ---------- Generic filter + search ----------------------------------- */
  function initFilter({ container, chips, search, count }) {
    const host = document.getElementById(container);
    if (!host) return;
    const chipEls = Array.from(document.querySelectorAll(`#${chips} .filter-chip`));
    const searchEl = search ? document.getElementById(search) : null;
    const countEl = count ? document.getElementById(count) : null;
    if (!chipEls.length && !searchEl) return;

    const items = Array.from(host.querySelectorAll("[data-item]"));
    const empty = host.querySelector("[data-empty]");
    let filter = "all";

    function matches(item) {
      if (filter !== "all") {
        const tags = (item.dataset.tags || "").split("|");
        if (item.dataset.category !== filter && !tags.includes(filter)) return false;
      }
      const term = (searchEl?.value || "").trim().toLowerCase();
      return !term || (item.dataset.search || "").includes(term);
    }

    function apply() {
      let shown = 0;
      items.forEach((item) => {
        const ok = matches(item);
        item.classList.toggle("d-none", !ok);
        if (ok) shown++;
      });
      if (empty) empty.classList.toggle("d-none", shown > 0);
      if (countEl) countEl.textContent = shown;
      reveal(host);
    }

    chipEls.forEach((chip) =>
      chip.addEventListener("click", () => {
        chipEls.forEach((c) => c.classList.toggle("active", c === chip));
        filter = chip.dataset.filter;
        apply();
      })
    );

    let t;
    searchEl?.addEventListener("input", () => {
      clearTimeout(t);
      t = setTimeout(apply, 160);
    });
  }

  /* ---------- Detail pages: show the block matching the query string ----- */
  function initDetailPages(selector, attr, param) {
    const pages = Array.from(document.querySelectorAll(selector));
    if (!pages.length) return;
    const wanted = params.get(param);
    const target = pages.find((p) => p.dataset[attr] === wanted) || pages[0];
    pages.forEach((p) => (p.hidden = p !== target));
    if (target.dataset.title) document.title = target.dataset.title;
    reveal(target);
  }

  /* ---------- Preselect a program in forms (?program=<id>) --------------- */
  function initProgramPreset() {
    const preset = params.get("program");
    if (!preset) return;
    document.querySelectorAll("[data-program-select]").forEach((select) => {
      const option = select.querySelector(`option[data-program-id="${CSS.escape(preset)}"]`);
      if (option) select.value = option.value;
    });
  }

  document.addEventListener("DOMContentLoaded", function () {
    initFilter({ container: "programGrid", chips: "programFilters", search: "programSearch", count: "programCount" });
    initFilter({ container: "facultyGrid", chips: "facultyFilters" });
    initFilter({ container: "newsGrid", chips: "newsFilters" });
    initFilter({ container: "noticeList", chips: "noticeFilters" });
    initFilter({ container: "faqAccordion", chips: "faqFilters", search: "faqSearch" });
    initFilter({ container: "galleryGrid", chips: "galleryFilters" });
    initDetailPages("[data-program-page]", "programPage", "program");
    initDetailPages("[data-article-page]", "articlePage", "article");
    initProgramPreset();
  });
})();
