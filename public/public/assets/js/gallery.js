/* ==========================================================================
   Gallery: category filters, masonry grid, lightweight custom lightbox.
   ========================================================================== */
(function () {
  function init() {
    const grid = document.getElementById("galleryGrid");
    if (!grid) return;
    const KT = window.KT;
    const H = window.KTHelpers;
    const chips = Array.from(document.querySelectorAll("#galleryFilters .filter-chip"));
    const limit = parseInt(grid.dataset.limit || "0", 10);
    let filter = "all";
    let visible = [];

    function render() {
      visible = KT.GALLERY.filter((g) => filter === "all" || g.category === filter);
      if (limit) visible = visible.slice(0, limit);
      grid.innerHTML = visible.length
        ? visible
            .map(
              (g, i) => `<a class="gallery-item" href="${g.src}" data-index="${i}"
                aria-label="Open image: ${H.esc(g.caption)}">
                <img src="${g.src}" alt="${H.esc(g.caption)}" loading="lazy">
                <span class="caption">${H.esc(g.caption)} <em class="d-block text-white-50">${H.esc(g.category)}</em></span>
              </a>`
            )
            .join("")
        : `<div class="empty-state"><i class="bi bi-images d-block mb-2"></i>No images in this category yet.</div>`;
    }

    /* ---- Lightbox (no third-party dependency, keyboard accessible) ---- */
    const lb = document.createElement("div");
    lb.className = "modal fade";
    lb.tabIndex = -1;
    lb.setAttribute("aria-label", "Image viewer");
    lb.innerHTML = `<div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content border-0 bg-transparent">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <p class="text-white small mb-0" id="lbCaption"></p>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <img id="lbImage" class="rounded-brand w-100" alt="">
        <div class="d-flex justify-content-between mt-3">
          <button class="btn btn-outline-light-brand btn-sm" id="lbPrev"><i class="bi bi-arrow-left me-1"></i>Previous</button>
          <button class="btn btn-outline-light-brand btn-sm" id="lbNext">Next<i class="bi bi-arrow-right ms-1"></i></button>
        </div>
      </div></div>`;
    document.body.appendChild(lb);
    const modal = new window.bootstrap.Modal(lb);
    let current = 0;

    function show(i) {
      current = (i + visible.length) % visible.length;
      const item = visible[current];
      lb.querySelector("#lbImage").src = item.src;
      lb.querySelector("#lbImage").alt = item.caption;
      lb.querySelector("#lbCaption").textContent = `${item.caption} — ${item.category}`;
    }

    grid.addEventListener("click", (e) => {
      const link = e.target.closest(".gallery-item");
      if (!link) return;
      e.preventDefault();
      show(parseInt(link.dataset.index, 10));
      modal.show();
    });

    lb.querySelector("#lbPrev").addEventListener("click", () => show(current - 1));
    lb.querySelector("#lbNext").addEventListener("click", () => show(current + 1));
    document.addEventListener("keydown", (e) => {
      if (!lb.classList.contains("show")) return;
      if (e.key === "ArrowLeft") show(current - 1);
      if (e.key === "ArrowRight") show(current + 1);
    });

    chips.forEach((chip) =>
      chip.addEventListener("click", () => {
        chips.forEach((c) => c.classList.toggle("active", c === chip));
        filter = chip.dataset.filter;
        grid.style.opacity = "0.35";
        setTimeout(() => {
          render();
          grid.style.opacity = "1";
        }, 150);
      })
    );

    grid.style.transition = "opacity .25s ease";
    render();
  }

  document.addEventListener("DOMContentLoaded", init);
})();
