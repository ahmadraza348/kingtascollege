/* ==========================================================================
   Forms: multi-step admission application + contact form.

   This file only handles the browser side (step navigation, validation,
   review table, file list). Once a form passes validation it is submitted
   natively (method/action on the <form>), so the server receives a normal
   POST and decides what to do with it.
   ========================================================================== */

(function () {
  const esc = (str) =>
    String(str).replace(/[&<>"']/g, (ch) => ({ "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#39;" }[ch]));
  const flag = (name) => new URLSearchParams(location.search).get(name) === "1";

  /* ---------- Validation helpers --------------------------------------- */
  const patterns = {
    email: /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/,
    phone: /^(0\d{3}-?\d{7}|\+92\d{10})$/,
    cnic: /^\d{5}-?\d{7}-?\d$/,
  };

  function setError(field, message) {
    field.classList.add("is-invalid");
    const holder = field.parentElement.querySelector(".invalid-feedback");
    if (holder) holder.textContent = message;
  }

  function clearError(field) {
    field.classList.remove("is-invalid");
  }

  function validateField(field) {
    const value = (field.value || "").trim();
    if (field.hasAttribute("required") && !value) {
      setError(field, "This field is required.");
      return false;
    }
    if (!value) { clearError(field); return true; }
    if (field.type === "email" && !patterns.email.test(value)) {
      setError(field, "Enter a valid email address.");
      return false;
    }
    if (field.dataset.validate === "phone" && !patterns.phone.test(value)) {
      setError(field, "Enter a valid phone number, e.g. 0302-8098542.");
      return false;
    }
    if (field.dataset.validate === "cnic" && !patterns.cnic.test(value)) {
      setError(field, "Enter a valid CNIC/B-Form number, e.g. 33302-1234567-1.");
      return false;
    }
    if (field.dataset.validate === "number") {
      const num = Number(value);
      if (Number.isNaN(num) || num < 0) { setError(field, "Enter a valid number."); return false; }
    }
    if (field.minLength > 0 && value.length < field.minLength) {
      setError(field, `Please enter at least ${field.minLength} characters.`);
      return false;
    }
    clearError(field);
    return true;
  }

  function attachLiveValidation(form) {
    form.querySelectorAll("input, select, textarea").forEach((field) => {
      field.addEventListener("blur", () => validateField(field));
      field.addEventListener("input", () => {
        if (field.classList.contains("is-invalid")) validateField(field);
      });
    });
  }

  function validateScope(scope) {
    let ok = true;
    scope.querySelectorAll("input, select, textarea").forEach((field) => {
      if (field.type === "file" || field.disabled) return;
      if (!validateField(field)) ok = false;
    });
    return ok;
  }

  /* ---------- Multi-step admission form -------------------------------- */
  function initAdmissionForm() {
    const form = document.getElementById("admissionForm");
    if (!form) return;

    const steps = Array.from(form.querySelectorAll(".form-step"));
    const indicators = Array.from(document.querySelectorAll("#admissionStepper .step"));
    const progress = document.getElementById("admissionProgress");
    const successBox = document.getElementById("admissionSuccess");
    const submitBtn = form.querySelector('[data-action="submit"]');
    let index = 0;

    attachLiveValidation(form);

    function paint() {
      steps.forEach((s, i) => s.classList.toggle("active", i === index));
      indicators.forEach((ind, i) => {
        ind.classList.toggle("active", i === index);
        ind.classList.toggle("done", i < index);
      });
      if (progress) {
        progress.style.width = ((index + 1) / steps.length) * 100 + "%";
        progress.parentElement.setAttribute("aria-valuenow", index + 1);
      }
      form.querySelector('[data-action="prev"]').disabled = index === 0;
      form.querySelector('[data-action="next"]').classList.toggle("d-none", index === steps.length - 1);
      submitBtn.classList.toggle("d-none", index !== steps.length - 1);
      if (index === steps.length - 1) buildReview();
      steps[index].scrollIntoView({ behavior: "smooth", block: "center" });
    }

    function buildReview() {
      const rows = [];
      form.querySelectorAll("input:not([type=file]):not([type=checkbox]), select, textarea").forEach((field) => {
        const label = form.querySelector(`label[for="${field.id}"]`);
        if (!label || !field.value) return;
        rows.push(
          `<tr><th scope="row">${label.textContent.replace("*", "").trim()}</th><td>${esc(field.value)}</td></tr>`
        );
      });
      const files = Array.from(document.querySelectorAll("#documentList li")).map((li) => li.dataset.name);
      if (files.length) {
        rows.push(`<tr><th scope="row">Documents selected</th><td>${files.map((f) => esc(f)).join(", ")}</td></tr>`);
      }
      document.getElementById("reviewBody").innerHTML =
        rows.join("") || `<tr><td colspan="2" class="text-soft">No information entered yet.</td></tr>`;
    }

    form.querySelector('[data-action="next"]').addEventListener("click", () => {
      if (!validateScope(steps[index])) return;
      index = Math.min(index + 1, steps.length - 1);
      paint();
    });
    form.querySelector('[data-action="prev"]').addEventListener("click", () => {
      index = Math.max(index - 1, 0);
      paint();
    });

    form.addEventListener("submit", (e) => {
      let valid = true;
      steps.forEach((s) => { if (!validateScope(s)) valid = false; });
      if (!document.getElementById("agreeTerms").checked) {
        setError(document.getElementById("agreeTerms"), "Please confirm before submitting.");
        valid = false;
      }
      if (!valid) { e.preventDefault(); return; }

      // Valid: let the browser submit the form to its action.
      submitBtn.disabled = true;
      submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Submitting…`;
    });

    // The server redirects back with ?submitted=1 to show the confirmation.
    if (flag("submitted")) {
      form.classList.add("d-none");
      document.getElementById("admissionStepper").classList.add("d-none");
      successBox.classList.remove("d-none");
      return;
    }

    /* ---- Document upload UI ------------------------------------------ */
    const drop = document.getElementById("documentDrop");
    const input = document.getElementById("documentInput");
    const list = document.getElementById("documentList");
    if (drop && input) {
      drop.addEventListener("click", () => input.click());
      drop.addEventListener("keydown", (e) => {
        if (e.key === "Enter" || e.key === " ") { e.preventDefault(); input.click(); }
      });
      ["dragenter", "dragover"].forEach((ev) =>
        drop.addEventListener(ev, (e) => { e.preventDefault(); drop.classList.add("dragover"); })
      );
      ["dragleave", "drop"].forEach((ev) =>
        drop.addEventListener(ev, () => drop.classList.remove("dragover"))
      );
      drop.addEventListener("drop", (e) => {
        e.preventDefault();
        input.files = e.dataTransfer.files; // so dropped files are part of the real submission
        listFiles();
      });
      input.addEventListener("change", listFiles);

      function listFiles() {
        list.innerHTML = Array.from(input.files)
          .map(
            (file) => `<li data-name="${esc(file.name)}"><span><i class="bi bi-file-earmark-text me-2 text-brand"></i>${esc(file.name)}</span>
            <span class="text-soft">${(file.size / 1024).toFixed(0)} KB</span></li>`
          )
          .join("");
      }
    }

    paint();
  }

  /* ---------- Contact / inquiry form ----------------------------------- */
  function initContactForm() {
    const form = document.getElementById("contactForm");
    if (!form) return;
    const status = document.getElementById("contactStatus");
    const btn = form.querySelector('button[type="submit"]');
    attachLiveValidation(form);

    // The server redirects back with ?sent=1 to show the confirmation.
    if (flag("sent")) {
      status.className = "alert alert-success mt-3";
      status.textContent = "Thank you. Your inquiry has been received. Our admissions team will contact you.";
    }

    form.addEventListener("submit", (e) => {
      if (!validateScope(form)) {
        e.preventDefault();
        status.className = "alert alert-danger mt-3";
        status.textContent = "Please correct the highlighted fields and try again.";
        return;
      }
      btn.disabled = true;
      btn.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Sending…`;
    });
  }

  document.addEventListener("DOMContentLoaded", function () {
    initAdmissionForm();
    initContactForm();
  });
})();
