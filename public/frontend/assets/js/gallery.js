/* ==========================================================================
   Gallery lightbox. Images come from the .gallery-item links already in the
   HTML; the lightbox steps through whichever ones are currently visible.
   ========================================================================== */
(function () {
  function init() {
    const grid = document.getElementById("galleryGrid");
    if (!grid) return;

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

    let visible = [];
    let current = 0;

    function show(i) {
      current = (i + visible.length) % visible.length;
      const link = visible[current];
      const img = link.querySelector("img");
      const category = link.dataset.category || "";
      lb.querySelector("#lbImage").src = link.getAttribute("href");
      lb.querySelector("#lbImage").alt = link.dataset.caption || img.alt;
      lb.querySelector("#lbCaption").textContent = `${link.dataset.caption || img.alt} — ${category}`;
    }

    grid.addEventListener("click", (e) => {
      const link = e.target.closest(".gallery-item");
      if (!link) return;
      e.preventDefault();
      visible = Array.from(grid.querySelectorAll(".gallery-item:not(.d-none)"));
      show(visible.indexOf(link));
      modal.show();
    });

    lb.querySelector("#lbPrev").addEventListener("click", () => show(current - 1));
    lb.querySelector("#lbNext").addEventListener("click", () => show(current + 1));
    document.addEventListener("keydown", (e) => {
      if (!lb.classList.contains("show")) return;
      if (e.key === "ArrowLeft") show(current - 1);
      if (e.key === "ArrowRight") show(current + 1);
    });
  }

  document.addEventListener("DOMContentLoaded", init);
})();
