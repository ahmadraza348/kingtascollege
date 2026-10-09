/* ==========================================================================
   Forms: multi-step admission application + contact form.

   FRONTEND ONLY — nothing is transmitted anywhere. To go live, connect the
   endpoints below to a backend that stores applications and uploaded files
   securely. Never place secret API keys in this file; call your own backend.
   ========================================================================== */

/* ---- Backend integration placeholders ---------------------------------- */
const API_BASE_URL = "YOUR_BACKEND_API_URL";
const ENDPOINTS = {
  admissionApplication: `${API_BASE_URL}/admissions/applications`, // POST application data
  fileUpload: `${API_BASE_URL}/admissions/documents`, // POST multipart uploads
  contactInquiry: `${API_BASE_URL}/contact/inquiries`, // POST contact messages
  emailService: "YOUR_EMAIL_SERVICE_ENDPOINT", // transactional email notifications
};
const DEMO_MODE = true; // set to false once the endpoints above are live

(function () {
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
      form.querySelectorAll("input:not([type=file]), select, textarea").forEach((field) => {
        const label = form.querySelector(`label[for="${field.id}"]`);
        if (!label || !field.value) return;
        rows.push(
          `<tr><th scope="row">${label.textContent.replace("*", "").trim()}</th><td>${window.KTHelpers.esc(field.value)}</td></tr>`
        );
      });
      const files = Array.from(document.querySelectorAll("#documentList li")).map((li) => li.dataset.name);
      if (files.length) {
        rows.push(`<tr><th scope="row">Documents selected</th><td>${files.map((f) => window.KTHelpers.esc(f)).join(", ")}</td></tr>`);
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

    form.addEventListener("submit", async (e) => {
      e.preventDefault();
      let valid = true;
      steps.forEach((s) => { if (!validateScope(s)) valid = false; });
      if (!document.getElementById("agreeTerms").checked) {
        setError(document.getElementById("agreeTerms"), "Please confirm before submitting.");
        valid = false;
      }
      if (!valid) return;

      submitBtn.disabled = true;
      submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Submitting…`;

      // ---- Backend integration point --------------------------------
      // const payload = Object.fromEntries(new FormData(form).entries());
      // await fetch(ENDPOINTS.admissionApplication, {
      //   method: "POST", headers: { "Content-Type": "application/json" },
      //   body: JSON.stringify(payload)
      // });
      // Documents must be uploaded separately to ENDPOINTS.fileUpload.
      await new Promise((r) => setTimeout(r, 1100)); // simulated request (DEMO_MODE)

      submitBtn.disabled = false;
      submitBtn.innerHTML = "Submit Application";
      if (DEMO_MODE) {
        form.classList.add("d-none");
        document.getElementById("admissionStepper").classList.add("d-none");
        successBox.classList.remove("d-none");
        successBox.scrollIntoView({ behavior: "smooth", block: "center" });
      }
    });

    /* ---- Document upload UI (client-side listing only) --------------- */
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
      drop.addEventListener("drop", (e) => { e.preventDefault(); addFiles(e.dataTransfer.files); });
      input.addEventListener("change", () => addFiles(input.files));

      function addFiles(files) {
        Array.from(files).forEach((file) => {
          const li = document.createElement("li");
          li.dataset.name = file.name;
          li.innerHTML = `<span><i class="bi bi-file-earmark-text me-2 text-brand"></i>${window.KTHelpers.esc(file.name)}</span>
            <span class="text-soft">${(file.size / 1024).toFixed(0)} KB</span>`;
          list.appendChild(li);
        });
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

    form.addEventListener("submit", async (e) => {
      e.preventDefault();
      if (!validateScope(form)) {
        status.className = "alert alert-danger mt-3";
        status.textContent = "Please correct the highlighted fields and try again.";
        status.classList.remove("d-none");
        return;
      }
      btn.disabled = true;
      const original = btn.innerHTML;
      btn.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Sending…`;

      // ---- Backend integration point --------------------------------
      // await fetch(ENDPOINTS.contactInquiry, { method: "POST", body: new FormData(form) });
      await new Promise((r) => setTimeout(r, 900)); // simulated request (DEMO_MODE)

      btn.disabled = false;
      btn.innerHTML = original;
      status.className = "alert alert-success mt-3";
      status.innerHTML =
        "Thank you. Your inquiry has been received. Our admissions team will contact you. <br><small>Demo mode: this submission is simulated and not stored.</small>";
      status.classList.remove("d-none");
      form.reset();
    });
  }

  document.addEventListener("DOMContentLoaded", function () {
    initAdmissionForm();
    initContactForm();
  });
})();
