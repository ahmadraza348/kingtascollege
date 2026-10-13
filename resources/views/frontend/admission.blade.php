@extends('frontend.layouts.layout')

@section('title', 'Admissions 2026–27 | Apply to King TAS College, Gojra')
@section('description', 'Apply to King TAS College of Nursing & Allied Health Sciences. Review the admission process, required documents, financial support guidance and online application form.')

@section('content')
<main id="main">
    <header class="page-hero">
        <div class="container">
            <h1>Start your healthcare career with us</h1>
            <p>Admissions are open for session 2026–27 in selected nursing and allied health programs. Follow the steps below to apply.</p>
            <nav aria-label="Breadcrumb">
                <ol class="breadcrumb breadcrumb-brand">
                    <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Admissions</li>
                </ol>
            </nav>
        </div>
    </header>

    <section class="section">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-7">
                    <span class="eyebrow">Admission process</span>
                    <h2 class="mt-3 mb-4">Six steps from interest to enrollment</h2>
                    <ul class="timeline">
                        <li class="timeline-item"><span class="timeline-step">1</span>
                            <h3>Choose a program</h3><p>Review nursing and allied health programs and select the one that matches your interests and qualifications.</p>
                        </li>
                        <li class="timeline-item"><span class="timeline-step">2</span>
                            <h3>Check eligibility</h3><p>Confirm the entry requirements for your chosen program with the admissions office.</p>
                        </li>
                        <li class="timeline-item"><span class="timeline-step">3</span>
                            <h3>Prepare documents</h3><p>Prepare your CNIC/B-Form front and back, domicile, educational certificates/degree documents, a recent personal photograph and any additional documents advised.</p>
                        </li>
                        <li class="timeline-item"><span class="timeline-step">4</span>
                            <h3>Submit application</h3><p>Complete the online application form and carefully review your information and selected files before submitting.</p>
                        </li>
                        <li class="timeline-item"><span class="timeline-step">5</span>
                            <h3>Admissions review</h3><p>The admissions team reviews applications and contacts applicants regarding next steps.</p>
                        </li>
                        <li class="timeline-item"><span class="timeline-step">6</span>
                            <h3>Enrollment</h3><p>Complete enrollment formalities and join the session as advised by the college.</p>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-5">
                    <div class="card-brand p-4 sticky-side">
                        <h2 class="h6">Required documents</h2>
                        <ul class="list-check small">
                            <li><i class="bi bi-file-earmark-text"></i><span>Educational certificates and mark sheets / degree documents</span></li>
                            <li><i class="bi bi-person-vcard"></i><span>Applicant's CNIC or B-Form — front and back</span></li>
                            <li><i class="bi bi-geo"></i><span>Domicile certificate</span></li>
                            <li><i class="bi bi-camera"></i><span>Recent passport-size personal photograph</span></li>
                            <li><i class="bi bi-person-vcard"></i><span>Father's/guardian's CNIC copy, if requested</span></li>
                        </ul>
                        <div class="demo-note mt-3"><i class="bi bi-info-circle me-1"></i>Upload clear, readable scans. Confirm the final document requirements with the Admissions Office.</div>
                        <a class="btn btn-brand w-100 mt-3" href="#apply">Apply online</a>
                        <a class="btn btn-outline-brand w-100 mt-2" href="{{ route('frontend.eligibility') }}">Check eligibility</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section bg-light-soft" id="scholarships">
        <div class="container">
            <div class="section-header">
                <span class="eyebrow">Financial support</span>
                <h2>Scholarships &amp; fee guidance</h2>
                <p>Financial support options are confirmed by the college administration. The sections below are editable placeholders.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="1">
                    <div class="card-brand p-4 h-100">
                        <span class="icon-badge mb-3"><i class="bi bi-award"></i></span>
                        <h3 class="h6">Merit opportunities</h3>
                        <p class="small text-soft mb-0">Information about any merit-based support will be published by the college administration.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="2">
                    <div class="card-brand p-4 h-100">
                        <span class="icon-badge mb-3"><i class="bi bi-cash-coin"></i></span>
                        <h3 class="h6">Fee guidance</h3>
                        <p class="small text-soft mb-0">Fee structure and payment details are provided by the admissions office on request.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="3">
                    <div class="card-brand p-4 h-100">
                        <span class="icon-badge mb-3"><i class="bi bi-calendar2-check"></i></span>
                        <h3 class="h6">Installment options</h3>
                        <p class="small text-soft mb-0">Any installment arrangements are decided and confirmed by the college.</p>
                    </div>
                </div>
            </div>
            <p class="placeholder-note text-center mt-4 mb-0">No scholarship scheme is claimed here. Information will be updated by the college administration.</p>
        </div>
    </section>

    <section class="section" id="apply">
        <div class="container">
            <div class="section-header">
                <span class="eyebrow">Online application</span>
                <h2>Admission application form</h2>
                <p>Complete the six steps below. Fields marked with * are required. You can review your answers and uploaded files before the final submission.</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="stepper" id="admissionStepper" aria-label="Application steps">
                        <div class="step active" data-step="1">Personal</div>
                        <div class="step" data-step="2">Academic</div>
                        <div class="step" data-step="3">Program</div>
                        <div class="step" data-step="4">Address</div>
                        <div class="step" data-step="5">Documents</div>
                        <div class="step" data-step="6">Review</div>
                    </div>

                    <div class="progress mb-4" style="height:6px" role="progressbar" aria-label="Application progress" aria-valuemin="1" aria-valuemax="6" aria-valuenow="1" id="admissionProgressWrap">
                        <div class="progress-bar bg-primary" id="admissionProgress" style="width:16.6667%"></div>
                    </div>

                    <form id="admissionForm" class="card-brand p-4" method="post" action="{{ route('frontend.admission.store') }}" enctype="multipart/form-data" novalidate>
                        @csrf

                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                <strong>Please fix the following:</strong>
                                <ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                            </div>
                        @endif

                        <fieldset class="form-step active">
                            <legend class="h6 mb-3">Step 1 — Personal information</legend>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="fullName">Full name *</label>
                                    <input class="form-control" id="fullName" name="fullName" value="{{ old('fullName') }}" required minlength="3" autocomplete="name">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="fatherName">Father's name *</label>
                                    <input class="form-control" id="fatherName" name="fatherName" value="{{ old('fatherName') }}" required minlength="3">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="dob">Date of birth *</label>
                                    <input class="form-control" type="date" id="dob" name="dob" value="{{ old('dob') }}" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="gender">Gender *</label>
                                    <select class="form-select" id="gender" name="gender" required>
                                        <option value="">Select</option>
                                        <option value="Female" @selected(old('gender') === 'Female')>Female</option>
                                        <option value="Male" @selected(old('gender') === 'Male')>Male</option>
                                        <option value="Prefer not to say" @selected(old('gender') === 'Prefer not to say')>Prefer not to say</option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="cnic">CNIC / B-Form number *</label>
                                    <input class="form-control" id="cnic" name="cnic" value="{{ old('cnic') }}" placeholder="33302-1234567-1" data-validate="cnic" required autocomplete="off">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="phone">Phone *</label>
                                    <input class="form-control" id="phone" name="phone" value="{{ old('phone') }}" placeholder="0300-1234567" type="tel" data-validate="phone" required autocomplete="tel">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="whatsapp">WhatsApp number</label>
                                    <input class="form-control" id="whatsapp" name="whatsapp" value="{{ old('whatsapp') }}" placeholder="0300-1234567" type="tel" data-validate="phone">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="email">Email *</label>
                                    <input class="form-control" type="email" id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" autocomplete="email" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="form-step">
                            <legend class="h6 mb-3">Step 2 — Academic information</legend>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="qualification">Previous qualification *</label>
                                    <select class="form-select" id="qualification" name="qualification" required>
                                        <option value="">Select</option>
                                        <option value="Matric" @selected(old('qualification') === 'Matric')>Matric</option>
                                        <option value="F.Sc / Intermediate" @selected(old('qualification') === 'F.Sc / Intermediate')>F.Sc / Intermediate</option>
                                        <option value="Diploma" @selected(old('qualification') === 'Diploma')>Diploma</option>
                                        <option value="Bachelor" @selected(old('qualification') === 'Bachelor')>Bachelor</option>
                                        <option value="Other" @selected(old('qualification') === 'Other')>Other</option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="institution">Institution *</label>
                                    <input class="form-control" id="institution" name="institution" value="{{ old('institution') }}" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="obtained">Marks obtained</label>
                                    <input class="form-control" id="obtained" name="obtained" type="number" data-validate="number" min="0" step="any" value="{{ old('obtained') }}">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="total">Total marks</label>
                                    <input class="form-control" id="total" name="total" type="number" data-validate="number" min="0" step="any" value="{{ old('total') }}">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="percentage">Percentage</label>
                                    <input class="form-control" id="percentage" name="percentage" type="number" data-validate="number" min="0" max="100" step="any" value="{{ old('percentage') }}">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="form-step">
                            <legend class="h6 mb-3">Step 3 — Program selection</legend>
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <label class="form-label" for="program">Preferred program *</label>
                                    <select class="form-select" id="program" name="program" required>
                                        <option value="">Select a program</option>
                                        <optgroup label="Nursing Programs">
                                            <option value="BSN Generic" @selected(old('program') === 'BSN Generic')>BSN Generic</option>
                                            <option value="Post RN" @selected(old('program') === 'Post RN')>Post RN</option>
                                            <option value="LHV (Lady Health Visitor)" @selected(old('program') === 'LHV (Lady Health Visitor)')>LHV (Lady Health Visitor)</option>
                                            <option value="CMW (Community Midwife)" @selected(old('program') === 'CMW (Community Midwife)')>CMW (Community Midwife)</option>
                                            <option value="CNA (Certified Nursing Assistant)" @selected(old('program') === 'CNA (Certified Nursing Assistant)')>CNA (Certified Nursing Assistant)</option>
                                        </optgroup>
                                        <optgroup label="Allied Health Programs">
                                            <option value="Anesthesia Technician" @selected(old('program') === 'Anesthesia Technician')>Anesthesia Technician</option>
                                            <option value="Radiography Technology + F.Sc" @selected(old('program') === 'Radiography Technology + F.Sc')>Radiography Technology + F.Sc</option>
                                            <option value="Medical Lab Technology + F.Sc" @selected(old('program') === 'Medical Lab Technology + F.Sc')>Medical Lab Technology + F.Sc</option>
                                            <option value="Dental Technician" @selected(old('program') === 'Dental Technician')>Dental Technician</option>
                                            <option value="Operation Theater Technology + F.Sc" @selected(old('program') === 'Operation Theater Technology + F.Sc')>Operation Theater Technology + F.Sc</option>
                                            <option value="Dispenser + F.Sc" @selected(old('program') === 'Dispenser + F.Sc')>Dispenser + F.Sc</option>
                                            <option value="B-Category Pharmacy Technician" @selected(old('program') === 'B-Category Pharmacy Technician')>B-Category Pharmacy Technician</option>
                                        </optgroup>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="session">Session</label>
                                    <input class="form-control" id="session" name="session" value="2026–27" readonly>
                                </div>
                                <div class="col-12">
                                    <label class="form-label" for="notes">Notes for the admissions office</label>
                                    <textarea class="form-control" id="notes" name="notes" rows="3" maxlength="600">{{ old('notes') }}</textarea>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="form-step">
                            <legend class="h6 mb-3">Step 4 — Address</legend>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label" for="street">Postal address *</label>
                                    <input class="form-control" id="street" name="street" value="{{ old('street') }}" required autocomplete="street-address">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="city">City *</label>
                                    <input class="form-control" id="city" name="city" value="{{ old('city') }}" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="district">District</label>
                                    <input class="form-control" id="district" name="district" value="{{ old('district') }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="province">Province</label>
                                    <select class="form-select" id="province" name="province">
                                        <option value="Punjab" @selected(old('province', 'Punjab') === 'Punjab')>Punjab</option>
                                        <option value="Sindh" @selected(old('province') === 'Sindh')>Sindh</option>
                                        <option value="Khyber Pakhtunkhwa" @selected(old('province') === 'Khyber Pakhtunkhwa')>Khyber Pakhtunkhwa</option>
                                        <option value="Balochistan" @selected(old('province') === 'Balochistan')>Balochistan</option>
                                        <option value="Islamabad Capital Territory" @selected(old('province') === 'Islamabad Capital Territory')>Islamabad Capital Territory</option>
                                        <option value="Other" @selected(old('province') === 'Other')>Other</option>
                                    </select>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="form-step">
                            <legend class="h6 mb-2">Step 5 — Documents</legend>
                            <p class="small text-soft mb-4">Upload clear and readable scans. Accepted formats are PDF, JPG and PNG unless otherwise stated. Each document file must be 5 MB or smaller; the personal photograph must be 2 MB or smaller. Required fields are marked with *.</p>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="document-upload-card h-100 p-3 border rounded">
                                        <label class="form-label fw-semibold" for="cnic_front">CNIC / B-Form — Front *</label>
                                        <input class="form-control" type="file" id="cnic_front" name="cnic_front" accept=".pdf,.jpg,.jpeg,.png" required data-max-mb="5" data-review-label="CNIC / B-Form — Front">
                                        <div class="form-text">Upload the front side, fully visible and readable. PDF/JPG/PNG, max 5 MB.</div>
                                        <div class="invalid-feedback"></div>
                                        <div class="small mt-2 text-break" data-file-summary="cnic_front">No file selected.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="document-upload-card h-100 p-3 border rounded">
                                        <label class="form-label fw-semibold" for="cnic_back">CNIC / B-Form — Back *</label>
                                        <input class="form-control" type="file" id="cnic_back" name="cnic_back" accept=".pdf,.jpg,.jpeg,.png" required data-max-mb="5" data-review-label="CNIC / B-Form — Back">
                                        <div class="form-text">Upload the back side, fully visible and readable. PDF/JPG/PNG, max 5 MB.</div>
                                        <div class="invalid-feedback"></div>
                                        <div class="small mt-2 text-break" data-file-summary="cnic_back">No file selected.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="document-upload-card h-100 p-3 border rounded">
                                        <label class="form-label fw-semibold" for="domicile_document">Domicile certificate *</label>
                                        <input class="form-control" type="file" id="domicile_document" name="domicile_document" accept=".pdf,.jpg,.jpeg,.png" required data-max-mb="5" data-review-label="Domicile certificate">
                                        <div class="form-text">Upload a complete, readable domicile certificate. PDF/JPG/PNG, max 5 MB.</div>
                                        <div class="invalid-feedback"></div>
                                        <div class="small mt-2 text-break" data-file-summary="domicile_document">No file selected.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="document-upload-card h-100 p-3 border rounded">
                                        <label class="form-label fw-semibold" for="degree_documents">Educational certificates / degree documents *</label>
                                        <input class="form-control" type="file" id="degree_documents" name="degree_documents[]" accept=".pdf,.jpg,.jpeg,.png" multiple required data-max-mb="5" data-review-label="Educational certificates / degree documents">
                                        <div class="form-text">Select one or more mark sheets, certificates or degree documents. Each file max 5 MB.</div>
                                        <div class="invalid-feedback"></div>
                                        <div class="small mt-2 text-break" data-file-summary="degree_documents">No files selected.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="document-upload-card h-100 p-3 border rounded">
                                        <label class="form-label fw-semibold" for="personal_picture">Recent personal photograph *</label>
                                        <input class="form-control" type="file" id="personal_picture" name="personal_picture" accept=".jpg,.jpeg,.png" required data-max-mb="2" data-review-label="Personal photograph">
                                        <div class="form-text">Use a recent, clear passport-size photograph. JPG/PNG only, max 2 MB.</div>
                                        <div class="invalid-feedback"></div>
                                        <div class="small mt-2 text-break" data-file-summary="personal_picture">No file selected.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="document-upload-card h-100 p-3 border rounded">
                                        <label class="form-label fw-semibold" for="other_documents">Additional supporting documents</label>
                                        <input class="form-control" type="file" id="other_documents" name="other_documents[]" accept=".pdf,.jpg,.jpeg,.png" multiple data-max-mb="5" data-review-label="Additional supporting documents">
                                        <div class="form-text">Optional: guardian CNIC or other documents specifically requested by the college. Each file max 5 MB.</div>
                                        <div class="invalid-feedback"></div>
                                        <div class="small mt-2 text-break" data-file-summary="other_documents">No files selected.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="alert alert-info mt-4 mb-0 small" role="note">
                                Check that every scan belongs to you and is readable. The review step will show selected filenames and previews where the browser supports them. You can go back to replace any file before submitting.
                            </div>
                        </fieldset>

                        <fieldset class="form-step">
                            <legend class="h6 mb-3">Step 6 — Review &amp; submit</legend>
                            <p class="small text-soft">Check every detail below, including the uploaded files. Use Back to make corrections. The application is submitted only when you press Submit Application.</p>
                            <div class="table-responsive">
                                <table class="table review-table align-middle">
                                    <tbody id="reviewBody"></tbody>
                                </table>
                            </div>
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" id="agreeTerms" name="agreeTerms" value="1" required>
                                <label class="form-check-label small" for="agreeTerms">I confirm the information provided is accurate and I accept the <a href="{{ route('frontend.terms') }}" target="_blank" rel="noopener">terms &amp; conditions</a>. *</label>
                                <div class="invalid-feedback"></div>
                            </div>
                        </fieldset>

                        <div class="d-flex flex-wrap gap-2 mt-4">
                            <button class="btn btn-outline-brand" type="button" data-action="prev" disabled><i class="bi bi-arrow-left me-1"></i>Back</button>
                            <button class="btn btn-brand ms-auto" type="button" data-action="next">Continue <i class="bi bi-arrow-right ms-1"></i></button>
                            <button class="btn btn-brand-red ms-auto d-none" type="submit" data-action="submit">Submit Application</button>
                        </div>
                    </form>
                    <div class="alert alert-success d-none mt-4" id="admissionSuccess" role="status" aria-live="polite">
                        <h2 class="h6"><i class="bi bi-check-circle-fill me-2"></i>Thank you. Your application has been received.</h2>
                        <p class="small mb-0">Our admissions team will contact you using the details provided.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="cta-band cta-red text-center" data-reveal>
                <h2>Have questions about admissions?</h2>
                <p class="mb-4">Speak with the admissions team about programs, eligibility and application procedures.</p>
                <div class="d-flex flex-wrap justify-content-center gap-2">
                    <a class="btn btn-light btn-lg" href="tel:+923028098542"><i class="bi bi-telephone-fill me-2"></i>Call Now</a>
                    <a class="btn btn-outline-light-brand btn-lg" href="https://wa.me/923028098542?text=Hello%2C%20I%20would%20like%20information%20about%20admissions%20at%20King%20TAS%20College" target="_blank" rel="noopener"><i class="bi bi-whatsapp me-2"></i>WhatsApp Admissions</a>
                </div>
            </div>
        </div>
    </section>
</main>

<style>
    .form-step:not(.active) { display: none; }
    .document-upload-card { background: var(--bs-body-bg, #fff); }
    .document-upload-card .form-text { min-height: 2.6em; }
    .review-section-heading th { background: var(--bs-light, #f8f9fa); }
    .review-file { display: flex; align-items: flex-start; gap: .75rem; margin-bottom: .75rem; }
    .review-file:last-child { margin-bottom: 0; }
    .review-file-preview { width: 88px; height: 88px; object-fit: contain; border: 1px solid #dee2e6; border-radius: .375rem; background: #fff; padding: .2rem; }
    .review-file-meta { min-width: 0; }
    .review-file-name { overflow-wrap: anywhere; }

    /* Validation is shown by the field border only; hide Bootstrap's tick icons. */
    .form-control.is-valid,
    .form-control.is-invalid {
        background-image: none !important;
        padding-right: .75rem !important;
    }

    /* Keep the select dropdown arrow while removing validation tick icons. */
    .form-select.is-valid,
    .form-select.is-invalid {
        background-image: var(--bs-form-select-bg-img, url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e")) !important;
        background-position: right .75rem center !important;
        background-size: 16px 12px !important;
        padding-right: 2.25rem !important;
    }

    .form-control.is-valid,
    .form-select.is-valid {
        border-color: #198754 !important;
    }

    .form-control.is-invalid,
    .form-select.is-invalid {
        border-color: #dc3545 !important;
    }

    .form-control.is-valid:focus,
    .form-select.is-valid:focus {
        border-color: #198754 !important;
        box-shadow: 0 0 0 .25rem rgba(25, 135, 84, .15) !important;
    }

    .form-control.is-invalid:focus,
    .form-select.is-invalid:focus {
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 .25rem rgba(220, 53, 69, .15) !important;
    }

    .form-check-input.is-valid { border-color: #198754 !important; }
    .form-check-input.is-invalid { border-color: #dc3545 !important; }
</style>

<script src="{{ asset('js/forms.js') }}" defer></script>
@endsection
