/* ==========================================================================
   Client-side directories: program finder, faculty filter, news filter,
   notice board, FAQ search. All rendering is driven by assets/js/data.js.
   ========================================================================== */
(function () {
  const H = () => window.KTHelpers;
  const KT = () => window.KT;

  function refresh(container) {
    window.KTAnimate?.initReveal();
    // A tiny delay guarantees the transition runs on freshly injected nodes.
    requestAnimationFrame(() =>
      container.querySelectorAll("[data-reveal]").forEach((el) => el.classList.add("is-visible"))
    );
  }

  function showSkeletons(container, count = 3) {
    container.innerHTML = Array.from({ length: count })
      .map(
        () => `<div class="col-md-6 col-lg-4"><div class="skeleton-card">
          <div class="skeleton skeleton-img"></div>
          <div class="skeleton skeleton-line" style="width:60%"></div>
          <div class="skeleton skeleton-line" style="width:85%"></div>
          <div class="skeleton skeleton-line" style="width:45%;margin-bottom:1rem"></div>
        </div></div>`
      )
      .join("");
  }

  function emptyState(message) {
    return `<div class="col-12"><div class="empty-state">
      <i class="bi bi-search d-block mb-2"></i>
      <p class="mb-0">${message}</p>
    </div></div>`;
  }

  /* ---------- Program finder -------------------------------------------- */
  function initPrograms() {
    const grid = document.getElementById("programGrid");
    if (!grid) return;
    const chips = Array.from(document.querySelectorAll("#programFilters .filter-chip"));
    const search = document.getElementById("programSearch");
    const countEl = document.getElementById("programCount");
    const limit = parseInt(grid.dataset.limit || "0", 10);
    let filter = grid.dataset.initialFilter || "all";

    function matches(p) {
      if (filter !== "all") {
        const isCategory = filter === "Nursing" || filter === "Allied Health";
        if (isCategory ? p.category !== filter : !p.tags.includes(filter)) return false;
      }
      const term = (search?.value || "").trim().toLowerCase();
      if (!term) return true;
      return (
        p.title.toLowerCase().includes(term) ||
        p.category.toLowerCase().includes(term) ||
        p.description.toLowerCase().includes(term) ||
        p.tags.join(" ").toLowerCase().includes(term)
      );
    }

    function render() {
      let list = KT().PROGRAMS.filter(matches);
      if (limit) list = list.slice(0, limit);
      grid.innerHTML = list.length
        ? list.map((p, i) => H().programCard(p, i)).join("")
        : emptyState("No programs match your search. Try a different keyword or filter.");
      if (countEl) countEl.textContent = list.length;
      refresh(grid);
    }

    chips.forEach((chip) =>
      chip.addEventListener("click", () => {
        chips.forEach((c) => c.classList.toggle("active", c === chip));
        filter = chip.dataset.filter;
        showSkeletons(grid, 3);
        setTimeout(render, 160); // brief loading state keeps filtering legible
      })
    );

    let t;
    search?.addEventListener("input", () => {
      clearTimeout(t);
      t = setTimeout(render, 180);
    });

    render();
  }

  /* ---------- Program dropdown (used by forms) --------------------------- */
  function initProgramSelects() {
    document.querySelectorAll("[data-program-select]").forEach((select) => {
      const groups = { Nursing: [], "Allied Health": [] };
      KT().PROGRAMS.forEach((p) => groups[p.category]?.push(p));
      select.insertAdjacentHTML(
        "beforeend",
        Object.entries(groups)
          .map(
            ([label, items]) =>
              `<optgroup label="${label} Programs">${items
                .map((p) => `<option value="${p.title}">${p.title}</option>`)
                .join("")}</optgroup>`
          )
          .join("")
      );
      const preset = new URLSearchParams(location.search).get("program");
      if (preset) {
        const found = KT().PROGRAMS.find((p) => p.id === preset);
        if (found) select.value = found.title;
      }
    });
  }

  /* ---------- Faculty --------------------------------------------------- */
  function initFaculty() {
    const grid = document.getElementById("facultyGrid");
    if (!grid) return;
    const chips = Array.from(document.querySelectorAll("#facultyFilters .filter-chip"));
    let filter = "all";

    function card(f, i) {
      return `
      <div class="col-sm-6 col-lg-3" data-reveal data-reveal-delay="${(i % 4) + 1}">
        <article class="card-brand faculty-card text-center h-100">
          <div class="media-frame"><i class="bi bi-person-badge faculty-avatar" aria-hidden="true"></i></div>
          <div class="p-3">
            <h3 class="h6 mb-1">${H().esc(f.name)}</h3>
            <p class="small text-brand fw-600 mb-1">${H().esc(f.designation)}</p>
            <p class="small text-soft mb-1">${H().esc(f.qualification)}</p>
            <span class="badge badge-soft mb-2">${H().esc(f.department)}</span>
            <p class="small text-soft mb-1">${H().esc(f.bio)}</p>
            <p class="small mb-0"><i class="bi bi-stars text-brand me-1"></i>${H().esc(f.expertise)}</p>
          </div>
        </article>
      </div>`;
    }

    function render() {
      const list = KT().FACULTY.filter((f) => filter === "all" || f.department === filter);
      grid.innerHTML = list.length ? list.map(card).join("") : emptyState("No faculty records in this category yet.");
      refresh(grid);
    }

    chips.forEach((chip) =>
      chip.addEventListener("click", () => {
        chips.forEach((c) => c.classList.toggle("active", c === chip));
        filter = chip.dataset.filter;
        render();
      })
    );
    render();
  }

  /* ---------- News ------------------------------------------------------ */
  function initNews() {
    const grid = document.getElementById("newsGrid");
    if (!grid) return;
    const chips = Array.from(document.querySelectorAll("#newsFilters .filter-chip"));
    const limit = parseInt(grid.dataset.limit || "0", 10);
    let filter = "all";

    function render() {
      let list = KT().NEWS.filter((n) => filter === "all" || n.category === filter);
      if (limit) list = list.slice(0, limit);
      grid.innerHTML = list.length
        ? list.map((n, i) => H().newsCard(n, i)).join("")
        : emptyState("No articles in this category yet.");
      refresh(grid);
    }

    chips.forEach((chip) =>
      chip.addEventListener("click", () => {
        chips.forEach((c) => c.classList.toggle("active", c === chip));
        filter = chip.dataset.filter;
        render();
      })
    );
    render();
  }

  /* ---------- News details --------------------------------------------- */
  function initNewsDetails() {
    const host = document.getElementById("articleBody");
    if (!host) return;
    const id = new URLSearchParams(location.search).get("article");
    const article = KT().NEWS.find((n) => n.id === id) || KT().NEWS[0];

    document.getElementById("articleTitle").textContent = article.title;
    document.getElementById("articleCrumb").textContent = article.title;
    document.getElementById("articleMeta").innerHTML =
      `<span class="badge badge-soft">${H().esc(article.category)}</span>
       <span><i class="bi bi-calendar3 me-1"></i>${H().formatDate(article.date)}</span>
       <span><i class="bi bi-person me-1"></i>College Administration</span>`;
    document.getElementById("articleImage").src = article.image;
    document.getElementById("articleImage").alt = article.title;
    host.innerHTML = `
      <p class="lead-text">${H().esc(article.summary)}</p>
      <p>The college shares academic and admission updates through this news section so students and families can follow
      developments related to programs, schedules and campus activities.</p>
      <p>For details specific to this announcement, students are encouraged to contact the admissions office directly. Final
      details are confirmed by the college administration.</p>
      <div class="demo-note mt-4"><i class="bi bi-info-circle me-1"></i>Sample article body — replace with the official
      announcement text supplied by the college.</div>`;

    const related = document.getElementById("relatedNews");
    if (related) {
      related.innerHTML = KT().NEWS.filter((n) => n.id !== article.id)
        .slice(0, 3)
        .map((n, i) => H().newsCard(n, i))
        .join("");
      refresh(related);
    }
  }

  /* ---------- Events ---------------------------------------------------- */
  function initEvents() {
    const grid = document.getElementById("eventsGrid");
    if (!grid) return;
    const limit = parseInt(grid.dataset.limit || "0", 10);
    const list = limit ? KT().EVENTS.slice(0, limit) : KT().EVENTS;
    grid.innerHTML = list.map((e, i) => H().eventCard(e, i)).join("");
    refresh(grid);

    const cal = document.getElementById("eventsList");
    if (cal) {
      cal.innerHTML = KT()
        .EVENTS.map(
          (e) => `<li class="notice-row mb-2">
            <div class="event-date"><span class="day">${H().day(e.date)}</span><span class="mon">${H().month(e.date)}</span></div>
            <div class="flex-grow-1">
              <p class="fw-600 mb-0">${H().esc(e.title)}</p>
              <p class="small text-soft mb-0"><i class="bi bi-geo-alt me-1"></i>${H().esc(e.location)}</p>
            </div>
            <span class="badge badge-soft">${H().esc(e.status)}</span>
          </li>`
        )
        .join("");
    }
  }

  /* ---------- Notices --------------------------------------------------- */
  function initNotices() {
    const host = document.getElementById("noticeList");
    if (!host) return;
    const chips = Array.from(document.querySelectorAll("#noticeFilters .filter-chip"));
    let filter = "all";

    function render() {
      const list = KT().NOTICES.filter((n) => filter === "all" || n.category === filter);
      host.innerHTML = list.length
        ? list
            .map(
              (n) => `<li class="notice-row mb-2" data-reveal>
          <i class="bi bi-file-earmark-pdf file-icon" aria-hidden="true"></i>
          <div class="flex-grow-1">
            <p class="fw-600 mb-0">${H().esc(n.title)}</p>
            <p class="small text-soft mb-0">
              <span class="badge badge-soft me-2">${H().esc(n.category)}</span>
              <i class="bi bi-calendar3 me-1"></i>${H().formatDate(n.date)}
            </p>
          </div>
          <a class="btn btn-outline-brand btn-sm" href="#" onclick="return false;" aria-label="View notice: ${H().esc(n.title)}">
            <i class="bi bi-eye me-1"></i>View
          </a>
        </li>`
            )
            .join("")
        : `<li class="empty-state"><i class="bi bi-inbox d-block mb-2"></i>No notices in this category yet.</li>`;
      refresh(host);
    }

    chips.forEach((chip) =>
      chip.addEventListener("click", () => {
        chips.forEach((c) => c.classList.toggle("active", c === chip));
        filter = chip.dataset.filter;
        render();
      })
    );
    render();
  }

  /* ---------- FAQ ------------------------------------------------------- */
  function initFaq() {
    const host = document.getElementById("faqAccordion");
    if (!host) return;
    const chips = Array.from(document.querySelectorAll("#faqFilters .filter-chip"));
    const search = document.getElementById("faqSearch");
    const limit = parseInt(host.dataset.limit || "0", 10);
    let filter = "all";

    function render() {
      const term = (search?.value || "").trim().toLowerCase();
      let list = KT().FAQS.filter(
        (f) =>
          (filter === "all" || f.category === filter) &&
          (!term || f.q.toLowerCase().includes(term) || f.a.toLowerCase().includes(term))
      );
      if (limit) list = list.slice(0, limit);
      host.innerHTML = list.length
        ? list
            .map(
              (f, i) => `<div class="accordion-item" data-reveal>
          <h3 class="accordion-header" id="faqH${i}">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
              data-bs-target="#faqC${i}" aria-expanded="false" aria-controls="faqC${i}">
              ${H().esc(f.q)}
            </button>
          </h3>
          <div id="faqC${i}" class="accordion-collapse collapse" aria-labelledby="faqH${i}" data-bs-parent="#faqAccordion">
            <div class="accordion-body">${H().esc(f.a)}</div>
          </div>
        </div>`
            )
            .join("")
        : `<div class="empty-state"><i class="bi bi-question-circle d-block mb-2"></i>No questions match your search.</div>`;
      refresh(host);
    }

    chips.forEach((chip) =>
      chip.addEventListener("click", () => {
        chips.forEach((c) => c.classList.toggle("active", c === chip));
        filter = chip.dataset.filter;
        render();
      })
    );
    let t;
    search?.addEventListener("input", () => {
      clearTimeout(t);
      t = setTimeout(render, 160);
    });
    render();
  }

  /* ---------- Eligibility accordion ------------------------------------- */
  function initEligibility() {
    const host = document.getElementById("eligibilityAccordion");
    if (!host) return;
    host.innerHTML = KT()
      .PROGRAMS.map(
        (p, i) => `<div class="accordion-item" data-reveal>
        <h3 class="accordion-header" id="elH${i}">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#elC${i}" aria-expanded="false" aria-controls="elC${i}">
            ${H().esc(p.title)} <span class="badge badge-soft ms-2">${H().esc(p.category)}</span>
          </button>
        </h3>
        <div id="elC${i}" class="accordion-collapse collapse" aria-labelledby="elH${i}" data-bs-parent="#eligibilityAccordion">
          <div class="accordion-body">
            <div class="row g-3">
              <div class="col-md-6"><strong class="d-block small text-dark">Minimum qualification</strong>
                <span class="small">${H().esc(p.eligibility || KT().TBC)}</span></div>
              <div class="col-md-6"><strong class="d-block small text-dark">Duration</strong>
                <span class="small">${H().esc(p.duration || KT().TBC)}</span></div>
              <div class="col-md-6"><strong class="d-block small text-dark">Required subjects</strong>
                <span class="small">To be confirmed by the Admissions Office</span></div>
              <div class="col-md-6"><strong class="d-block small text-dark">Age requirement</strong>
                <span class="small">To be confirmed by the Admissions Office</span></div>
              <div class="col-12"><strong class="d-block small text-dark">Required documents</strong>
                <span class="small">Educational certificates, CNIC/B-Form, photographs and any additional documents advised by the admissions office.</span></div>
              <div class="col-12"><strong class="d-block small text-dark">Admission notes</strong>
                <span class="small">Please confirm final requirements with the Admissions Office before applying.</span></div>
            </div>
            <a class="btn btn-brand btn-sm mt-3" href="admissions.html#apply">Apply for ${H().esc(p.title)}</a>
          </div>
        </div>
      </div>`
      )
      .join("");
    refresh(host);
  }

  /* ---------- Program details page -------------------------------------- */
  function initProgramDetails() {
    const host = document.getElementById("programDetail");
    if (!host) return;
    const id = new URLSearchParams(location.search).get("program");
    const p = KT().PROGRAMS.find((x) => x.id === id) || KT().PROGRAMS[0];
    const tbc = KT().TBC;

    document.getElementById("programTitle").textContent = p.title;
    document.getElementById("programCrumb").textContent = p.title;
    document.getElementById("programLede").textContent = p.description;
    document.getElementById("programHeroImg").src = p.image;
    document.getElementById("programHeroImg").alt = p.title + " training at King TAS College";
    document.getElementById("programCategory").textContent = p.category + " Program";

    document.getElementById("programSidebar").innerHTML = `
      <h3 class="h6 mb-3">Program Information</h3>
      <ul class="list-unstyled small mb-4">
        <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Program</span><strong>${H().esc(p.title)}</strong></li>
        <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Category</span><strong>${H().esc(p.category)}</strong></li>
        <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Duration</span><strong>${H().esc(p.duration || tbc)}</strong></li>
        <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Eligibility</span><strong>${H().esc(p.eligibility || tbc)}</strong></li>
        <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Admission status</span><strong class="text-brand-red">${H().esc(p.status)}</strong></li>
        <li class="d-flex justify-content-between py-2"><span class="text-soft">How to apply</span><strong>Online form or campus visit</strong></li>
      </ul>
      <a class="btn btn-brand-red w-100 mb-2" href="admissions.html#apply">Apply Now</a>
      <a class="btn btn-outline-brand w-100" href="contact.html">Talk to Admissions</a>`;

    host.innerHTML = `
      <h2 class="h4">Overview</h2>
      <p>${H().esc(p.description)}</p>
      <p>Teaching combines classroom study with practical skill development so students build the professional habits expected
      in healthcare environments — accuracy, patient safety awareness, hygiene discipline and clear communication.</p>

      <h2 class="h4 mt-5">Who should apply</h2>
      <p>Students who want a healthcare career and are prepared for practical, discipline-focused study in a professional
      learning environment.</p>

      <div class="row g-3 mt-4">
        <div class="col-md-6"><div class="card-brand p-3 h-100"><h3 class="h6"><i class="bi bi-mortarboard text-brand me-2"></i>Eligibility</h3><p class="small mb-0">${H().esc(p.eligibility || tbc)}</p></div></div>
        <div class="col-md-6"><div class="card-brand p-3 h-100"><h3 class="h6"><i class="bi bi-clock text-brand me-2"></i>Duration</h3><p class="small mb-0">${H().esc(p.duration || tbc)}</p></div></div>
      </div>

      <h2 class="h4 mt-5">Study structure</h2>
      <ul class="list-check">
        <li><i class="bi bi-check-circle-fill"></i><span>Theory sessions covering core subject knowledge</span></li>
        <li><i class="bi bi-check-circle-fill"></i><span>Practical sessions in skills and laboratory settings</span></li>
        <li><i class="bi bi-check-circle-fill"></i><span>Supervised clinical or technical skill practice</span></li>
        <li><i class="bi bi-check-circle-fill"></i><span>Internal assessments and instructor feedback</span></li>
      </ul>

      <h2 class="h4 mt-5">Practical training and clinical exposure</h2>
      <p>Students practise procedures under supervision before applying them in real care settings, with emphasis on infection
      control, professional conduct and patient dignity. Specific clinical arrangements are confirmed by the college administration.</p>

      <h2 class="h4 mt-5">Career pathways</h2>
      <div class="d-flex flex-wrap gap-2 mb-4">
        ${p.careers.map((c) => `<span class="badge badge-soft">${H().esc(c)}</span>`).join("")}
      </div>

      <h2 class="h4 mt-5">Skills students develop</h2>
      <div class="row g-3">
        ${[
          ["bi-heart-pulse", "Patient-centred care"],
          ["bi-shield-check", "Safety and infection control"],
          ["bi-chat-dots", "Professional communication"],
          ["bi-clipboard-check", "Accurate documentation"],
          ["bi-people", "Teamwork in clinical settings"],
          ["bi-graph-up", "Continuous professional learning"],
        ]
          .map(
            ([icon, label]) =>
              `<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi ${icon} text-brand"></i><span class="small">${label}</span></div></div>`
          )
          .join("")}
      </div>

      <h2 class="h4 mt-5">Frequently asked questions</h2>
      <div class="accordion accordion-brand" id="programFaq">
        ${KT()
          .FAQS.slice(0, 4)
          .map(
            (f, i) => `<div class="accordion-item">
              <h3 class="accordion-header" id="pfH${i}">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pfC${i}" aria-expanded="false" aria-controls="pfC${i}">${H().esc(f.q)}</button>
              </h3>
              <div id="pfC${i}" class="accordion-collapse collapse" aria-labelledby="pfH${i}" data-bs-parent="#programFaq">
                <div class="accordion-body">${H().esc(f.a)}</div>
              </div>
            </div>`
          )
          .join("")}
      </div>

      <div class="demo-note mt-4"><i class="bi bi-info-circle me-1"></i>Program duration, eligibility and affiliation details
      are pending confirmation by the college administration and should be verified before publishing.</div>`;

    const other = document.getElementById("otherPrograms");
    if (other) {
      other.innerHTML = KT()
        .PROGRAMS.filter((x) => x.id !== p.id && x.category === p.category)
        .slice(0, 3)
        .map((x, i) => H().programCard(x, i))
        .join("");
      refresh(other);
    }
  }

  /* ---------- Testimonials --------------------------------------------- */
  function initTestimonials() {
    const host = document.getElementById("testimonialGrid");
    if (!host) return;
    host.innerHTML = KT()
      .TESTIMONIALS.map(
        (t, i) => `<div class="col-md-4" data-reveal data-reveal-delay="${i + 1}">
        <div class="card-brand testimonial-card h-100">
          <i class="bi bi-quote quote-mark" aria-hidden="true"></i>
          <p class="small">${H().esc(t.quote)}</p>
          <div class="d-flex align-items-center gap-2 mt-3">
            <i class="bi bi-person-circle fs-3 text-brand" aria-hidden="true"></i>
            <div>
              <p class="fw-600 mb-0 small">${H().esc(t.name)}</p>
              <p class="small text-soft mb-0">${H().esc(t.program)} · ${H().esc(t.session)}</p>
            </div>
          </div>
        </div>
      </div>`
      )
      .join("");
    refresh(host);
  }

  document.addEventListener("DOMContentLoaded", function () {
    initPrograms();
    initProgramSelects();
    initProgramDetails();
    initFaculty();
    initNews();
    initNewsDetails();
    initEvents();
    initNotices();
    initFaq();
    initEligibility();
    initTestimonials();
  });
})();
