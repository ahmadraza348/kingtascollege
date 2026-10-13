/* ========================================================================
 * King TAS College forms
 *
 * Handles the six-step admission application and the contact/inquiry form.
 * The admission form uses individual file inputs for each required document.
 * Files are submitted normally to Laravel; frontend validation is only a
 * convenience and MUST be repeated by the server.
 * ====================================================================== */
(function () {
    'use strict';

    // Prevent duplicate initialisation if this file is included by both the
    // base layout and the admissions view.
    if (window.__kingTasFormsInitialized) return;
    window.__kingTasFormsInitialized = true;

    const patterns = {
        email: /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/,
        phone: /^(0\d{3}-?\d{7}|\+92\d{10})$/,
        cnic: /^\d{5}-?\d{7}-?\d$/
    };

    const flag = (name) => new URLSearchParams(window.location.search).get(name) === '1';

    function getFeedbackElement(field) {
        const parent = field.closest(
            '.document-upload-card, .form-check, .col-md-6, .col-md-8, .col-md-4, .col-12'
        ) || field.parentElement;
        return parent ? parent.querySelector('.invalid-feedback') : null;
    }

    function setFieldValidity(field, valid, message) {
        field.classList.toggle('is-invalid', !valid);

        // Once a field has been validated, show its state using the border only.
        // CSS removes Bootstrap's built-in validation tick icons from text inputs.
        field.classList.toggle('is-valid', valid);

        const feedback = getFeedbackElement(field);
        if (feedback) {
            feedback.textContent = valid ? '' : (message || 'Please check this field.');
            feedback.style.display = valid ? '' : 'block';
        }
    }

    function validateFileInput(input) {
        const files = Array.from(input.files || []);
        const maxMb = Number(input.dataset.maxMb || 5);
        const maxBytes = maxMb * 1024 * 1024;
        const acceptedExtensions = (input.getAttribute('accept') || '')
            .split(',')
            .map((item) => item.trim().toLowerCase())
            .filter(Boolean);

        if (input.required && files.length === 0) {
            return { valid: false, message: 'Please select the required file(s).' };
        }

        for (const file of files) {
            if (file.size > maxBytes) {
                return { valid: false, message: `${file.name} exceeds the ${maxMb} MB limit.` };
            }

            if (acceptedExtensions.length) {
                const lowerName = file.name.toLowerCase();
                const extensionAllowed = acceptedExtensions.some((rule) =>
                    rule.startsWith('.') && lowerName.endsWith(rule)
                );
                const mimeAllowed = acceptedExtensions.some((rule) =>
                    rule.endsWith('/*') && file.type.startsWith(rule.slice(0, -1))
                );
                if (!extensionAllowed && !mimeAllowed) {
                    return {
                        valid: false,
                        message: `Choose an accepted file type: ${acceptedExtensions.join(', ')}.`
                    };
                }
            }
        }

        return { valid: true, message: '' };
    }

    function validateField(field) {
        if (field.disabled) return { valid: true, message: '' };
        if (field.type === 'file') return validateFileInput(field);

        if (field.type === 'checkbox' && field.required && !field.checked) {
            return { valid: false, message: 'Please confirm before submitting.' };
        }

        const value = String(field.value || '').trim();
        if (field.required && !value) {
            return { valid: false, message: 'This field is required.' };
        }
        if (!value) return { valid: true, message: '' };

        if (field.type === 'email' && !patterns.email.test(value)) {
            return { valid: false, message: 'Enter a valid email address.' };
        }
        if (field.dataset.validate === 'phone' && !patterns.phone.test(value)) {
            return { valid: false, message: 'Enter a valid Pakistani phone number, e.g. 0300-1234567.' };
        }
        if (field.dataset.validate === 'cnic' && !patterns.cnic.test(value)) {
            return { valid: false, message: 'Enter a valid CNIC/B-Form number, e.g. 33302-1234567-1.' };
        }
        if (field.dataset.validate === 'number') {
            const number = Number(value);
            if (!Number.isFinite(number) || number < 0) {
                return { valid: false, message: 'Enter a valid non-negative number.' };
            }
        }
        if (field.minLength > 0 && value.length < field.minLength) {
            return { valid: false, message: `Please enter at least ${field.minLength} characters.` };
        }
        if (!field.checkValidity()) {
            return { valid: false, message: field.validationMessage || 'Please enter a valid value.' };
        }

        return { valid: true, message: '' };
    }

    function attachLiveValidation(form) {
        form.querySelectorAll('input, select, textarea').forEach((field) => {
            field.addEventListener('blur', () => {
                const result = validateField(field);
                setFieldValidity(field, result.valid, result.message);
            });

            field.addEventListener('input', () => {
                if (field.classList.contains('is-invalid')) {
                    const result = validateField(field);
                    setFieldValidity(field, result.valid, result.message);
                }
            });
        });
    }

    /* ------------------------------------------------------------------
     * Multi-step admission application
     * ---------------------------------------------------------------- */
    function initAdmissionForm() {
        const form = document.getElementById('admissionForm');
        if (!form) return;

        const fieldsets = Array.from(form.querySelectorAll('.form-step'));
        const stepper = document.getElementById('admissionStepper');
        const stepIndicators = Array.from(document.querySelectorAll('#admissionStepper .step'));
        const progress = document.getElementById('admissionProgress');
        const progressWrap = document.getElementById('admissionProgressWrap');
        const prevButton = form.querySelector('[data-action="prev"]');
        const nextButton = form.querySelector('[data-action="next"]');
        const submitButton = form.querySelector('[data-action="submit"]');
        const reviewBody = document.getElementById('reviewBody');
        const successBox = document.getElementById('admissionSuccess');

        if (!fieldsets.length || !prevButton || !nextButton || !submitButton || !reviewBody) return;

        let currentStep = 0;
        let reviewObjectUrls = [];

        attachLiveValidation(form);

        function validateStep(stepIndex) {
            let allValid = true;
            const fields = Array.from(fieldsets[stepIndex].querySelectorAll('input, select, textarea'))
                .filter((field) => !['button', 'submit', 'reset', 'hidden'].includes(field.type) && !field.disabled);

            fields.forEach((field) => {
                const result = validateField(field);
                setFieldValidity(field, result.valid, result.message);
                if (!result.valid) allValid = false;
            });
            return allValid;
        }

        function releaseReviewUrls() {
            reviewObjectUrls.forEach((url) => URL.revokeObjectURL(url));
            reviewObjectUrls = [];
        }

        function appendSectionHeading(label) {
            const row = document.createElement('tr');
            row.className = 'review-section-heading';
            const heading = document.createElement('th');
            heading.colSpan = 2;
            heading.scope = 'colgroup';
            heading.textContent = label;
            row.appendChild(heading);
            reviewBody.appendChild(row);
        }

        function appendReviewRow(label, value) {
            const row = document.createElement('tr');
            const heading = document.createElement('th');
            const cell = document.createElement('td');
            heading.scope = 'row';
            heading.textContent = label;
            cell.textContent = value || 'Not provided';
            row.append(heading, cell);
            reviewBody.appendChild(row);
        }

        function displayFieldValue(field) {
            if (field.tagName === 'SELECT') {
                return field.value ? field.options[field.selectedIndex].text : '';
            }
            return String(field.value || '').trim();
        }

        function appendDocumentReviewRow(input) {
            const row = document.createElement('tr');
            const heading = document.createElement('th');
            const cell = document.createElement('td');
            heading.scope = 'row';
            heading.textContent = input.dataset.reviewLabel || input.labels?.[0]?.textContent?.trim() || 'Document';

            const files = Array.from(input.files || []);
            if (!files.length) {
                cell.textContent = input.multiple ? 'No files selected.' : 'No file selected.';
            } else {
                files.forEach((file) => {
                    const item = document.createElement('div');
                    item.className = 'review-file';

                    let objectUrl = null;
                    try {
                        objectUrl = URL.createObjectURL(file);
                        reviewObjectUrls.push(objectUrl);
                    } catch (error) {
                        // If a browser cannot create a local preview, the filename is still shown.
                    }

                    const lowerName = file.name.toLowerCase();
                    const isImage = file.type.startsWith('image/') || /\.(jpe?g|png|gif|webp)$/i.test(lowerName);
                    const isPdf = file.type === 'application/pdf' || lowerName.endsWith('.pdf');

                    if (isImage && objectUrl) {
                        const image = document.createElement('img');
                        image.src = objectUrl;
                        image.alt = `Preview of ${file.name}`;
                        image.className = 'review-file-preview';
                        item.appendChild(image);
                    } else {
                        const iconBox = document.createElement('span');
                        iconBox.className = 'review-file-preview d-flex align-items-center justify-content-center';
                        iconBox.setAttribute('aria-hidden', 'true');
                        iconBox.innerHTML = isPdf
                            ? '<i class="bi bi-file-earmark-pdf fs-2"></i>'
                            : '<i class="bi bi-file-earmark-text fs-2"></i>';
                        item.appendChild(iconBox);
                    }

                    const fileDetails = document.createElement('div');
                    fileDetails.className = 'review-file-meta';

                    const fileName = document.createElement('div');
                    fileName.className = 'review-file-name fw-semibold';
                    fileName.textContent = file.name;

                    const fileSize = document.createElement('div');
                    fileSize.className = 'small text-muted';
                    fileSize.textContent = `${(file.size / (1024 * 1024)).toFixed(2)} MB`;

                    fileDetails.append(fileName, fileSize);
                    if (objectUrl) {
                        const openLink = document.createElement('a');
                        openLink.href = objectUrl;
                        openLink.target = '_blank';
                        openLink.rel = 'noopener noreferrer';
                        openLink.className = 'small';
                        openLink.textContent = isPdf ? 'Open PDF to verify' : 'Open file to verify';
                        fileDetails.appendChild(openLink);
                    }

                    item.appendChild(fileDetails);
                    cell.appendChild(item);
                });
            }

            row.append(heading, cell);
            reviewBody.appendChild(row);
        }

        function renderReview() {
            releaseReviewUrls();
            reviewBody.replaceChildren();

            fieldsets.slice(0, 4).forEach((fieldset) => {
                const legend = fieldset.querySelector('legend');
                const sectionName = legend
                    ? legend.textContent.replace(/^Step\s*\d+\s*[—-]\s*/, '').trim()
                    : 'Application details';
                appendSectionHeading(sectionName);

                fieldset.querySelectorAll('input, select, textarea').forEach((field) => {
                    if (['file', 'hidden', 'button', 'submit', 'reset', 'checkbox', 'radio'].includes(field.type)) return;
                    const label = field.labels && field.labels.length ? field.labels[0] : null;
                    const labelText = label ? label.textContent.replace('*', '').trim() : (field.name || 'Field');
                    appendReviewRow(labelText, displayFieldValue(field));
                });
            });

            appendSectionHeading('Uploaded documents');
            form.querySelectorAll('input[type="file"][data-review-label]').forEach(appendDocumentReviewRow);

            appendSectionHeading('Declaration');
            const terms = document.getElementById('agreeTerms');
            appendReviewRow(
                'Terms & conditions',
                terms && terms.checked ? 'Accepted' : 'Not yet accepted — tick the checkbox below before submitting.'
            );
        }

        function showStep(requestedIndex, shouldScroll) {
            currentStep = Math.max(0, Math.min(requestedIndex, fieldsets.length - 1));

            fieldsets.forEach((fieldset, index) => {
                fieldset.classList.toggle('active', index === currentStep);
            });
            stepIndicators.forEach((indicator, index) => {
                indicator.classList.toggle('active', index === currentStep);
                indicator.classList.toggle('done', index < currentStep);
                indicator.classList.toggle('completed', index < currentStep);
                if (index === currentStep) indicator.setAttribute('aria-current', 'step');
                else indicator.removeAttribute('aria-current');
            });

            prevButton.disabled = currentStep === 0;
            nextButton.classList.toggle('d-none', currentStep === fieldsets.length - 1);
            submitButton.classList.toggle('d-none', currentStep !== fieldsets.length - 1);

            if (progress) {
                const percent = ((currentStep + 1) / fieldsets.length) * 100;
                progress.style.width = `${percent}%`;
            }
            if (progressWrap) progressWrap.setAttribute('aria-valuenow', String(currentStep + 1));

            if (currentStep === fieldsets.length - 1) renderReview();
            if (shouldScroll) {
                const applySection = document.getElementById('apply');
                if (applySection) applySection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }

        // Display the confirmation only when the server redirects with submitted=1.
        if (flag('submitted')) {
            form.classList.add('d-none');
            if (stepper) stepper.classList.add('d-none');
            if (progressWrap) progressWrap.classList.add('d-none');
            if (successBox) successBox.classList.remove('d-none');
            return;
        }

        form.querySelectorAll('input[type="file"][data-review-label]').forEach((input) => {
            input.addEventListener('change', () => {
                const summary = form.querySelector(`[data-file-summary="${window.CSS && CSS.escape ? CSS.escape(input.id) : input.id}"]`);
                const files = Array.from(input.files || []);
                if (summary) {
                    summary.textContent = files.length
                        ? files.map((file) => `${file.name} (${(file.size / (1024 * 1024)).toFixed(2)} MB)`).join(', ')
                        : (input.multiple ? 'No files selected.' : 'No file selected.');
                }
                const result = validateFileInput(input);
                setFieldValidity(input, result.valid, result.message);
                if (currentStep === fieldsets.length - 1) renderReview();
            });
        });

        form.querySelectorAll('input, select, textarea').forEach((field) => {
            field.addEventListener('input', () => {
                if (currentStep === fieldsets.length - 1 && field.type !== 'file') renderReview();
            });
            field.addEventListener('change', () => {
                if (currentStep === fieldsets.length - 1 && field.type !== 'file') renderReview();
            });
        });

        prevButton.addEventListener('click', () => showStep(currentStep - 1, true));
        nextButton.addEventListener('click', () => {
            if (!validateStep(currentStep)) {
                const invalidField = fieldsets[currentStep].querySelector('.is-invalid');
                if (invalidField) invalidField.focus();
                return;
            }
            showStep(currentStep + 1, true);
        });

        form.addEventListener('submit', (event) => {
            // Validate every step again; the backend must validate independently.
            for (let index = 0; index < fieldsets.length; index++) {
                if (!validateStep(index)) {
                    event.preventDefault();
                    showStep(index, true);
                    const invalidField = fieldsets[index].querySelector('.is-invalid');
                    if (invalidField) invalidField.focus();
                    return;
                }
            }

            submitButton.disabled = true;
            submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Submitting…';
        });

        showStep(0, false);
    }

    /* ------------------------------------------------------------------
     * Contact / inquiry form
     * ---------------------------------------------------------------- */
    function initContactForm() {
        const form = document.getElementById('contactForm');
        if (!form) return;

        const status = document.getElementById('contactStatus');
        const submitButton = form.querySelector('button[type="submit"]');
        attachLiveValidation(form);

        if (flag('sent') && status) {
            status.className = 'alert alert-success mt-3';
            status.textContent = 'Thank you. Your inquiry has been received. Our admissions team will contact you.';
        }

        form.addEventListener('submit', (event) => {
            let allValid = true;
            form.querySelectorAll('input, select, textarea').forEach((field) => {
                const result = validateField(field);
                setFieldValidity(field, result.valid, result.message);
                if (!result.valid) allValid = false;
            });

            if (!allValid) {
                event.preventDefault();
                if (status) {
                    status.className = 'alert alert-danger mt-3';
                    status.textContent = 'Please correct the highlighted fields and try again.';
                }
                return;
            }

            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Sending…';
            }
        });
    }

    initAdmissionForm();
    initContactForm();
})();
