@extends('frontend.layouts.layout')
@section('title', 'Admissions 2026–27 | Apply to King TAS College, Gojra')
@section('description', 'Apply to King TAS College of Nursing & Allied Health Sciences. Admission process, required documents, financial support guidance and the online application form.')
@section('content')
<main id="main">
<header class="page-hero">
  <div class="container">
    <h1>Start your healthcare career with us</h1>
    <p>Admissions are open for session 2026–27 in selected nursing and allied health programs. Follow the steps below to apply.</p>
    <nav aria-label="Breadcrumb">
      <ol class="breadcrumb breadcrumb-brand"><li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li><li class="breadcrumb-item active" aria-current="page">Admissions</li></ol>
    </nav>
  </div>
</header>
<section class="section">
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-7">
        <span class="eyebrow">Admission process</span>
        <h2 class="mt-3 mb-4">Six steps from interest to enrollment</h2>
        <ul class="timeline"><li class="timeline-item"><span class="timeline-step">1</span>
      <h3>Choose a program</h3><p>Review nursing and allied health programs and select the one that matches your interests and qualifications.</p></li><li class="timeline-item"><span class="timeline-step">2</span>
      <h3>Check eligibility</h3><p>Confirm the entry requirements for your chosen program with the admissions office.</p></li><li class="timeline-item"><span class="timeline-step">3</span>
      <h3>Prepare documents</h3><p>Collect educational certificates, CNIC/B-Form, photographs and any additional documents advised.</p></li><li class="timeline-item"><span class="timeline-step">4</span>
      <h3>Submit application</h3><p>Complete the online application form or submit your application at the campus admissions office.</p></li><li class="timeline-item"><span class="timeline-step">5</span>
      <h3>Admissions review</h3><p>The admissions team reviews applications and contacts applicants regarding next steps.</p></li><li class="timeline-item"><span class="timeline-step">6</span>
      <h3>Enrollment</h3><p>Complete enrollment formalities and join the session as advised by the college.</p></li></ul>
      </div>
      <div class="col-lg-5">
        <div class="card-brand p-4 sticky-side">
          <h2 class="h6">Required documents</h2>
          <ul class="list-check small">
            <li><i class="bi bi-file-earmark-text"></i><span>Educational certificates and mark sheets</span></li>
            <li><i class="bi bi-person-vcard"></i><span>CNIC or B-Form (applicant)</span></li>
            <li><i class="bi bi-person-vcard"></i><span>CNIC copy (father/guardian)</span></li>
            <li><i class="bi bi-camera"></i><span>Passport-size photographs</span></li>
            <li><i class="bi bi-geo"></i><span>Domicile, where applicable</span></li>
            <li><i class="bi bi-award"></i><span>Character certificate, where applicable</span></li>
            <li><i class="bi bi-folder"></i><span>Any other documents advised by the office</span></li>
          </ul>
          <div class="demo-note mt-3"><i class="bi bi-info-circle me-1"></i>Please confirm final requirements with the Admissions Office.</div>
          <a class="btn btn-brand w-100 mt-3" href="#apply">Apply online</a>
          <a class="btn btn-outline-brand w-100 mt-2" href="{{ route('frontend.eligibility') }}">Check eligibility</a>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section bg-light-soft" id="scholarships">
  <div class="container">
    <div class="section-header"><span class="eyebrow">Financial support</span><h2>Scholarships &amp; fee guidance</h2>
      <p>Financial support options are confirmed by the college administration. The sections below are editable placeholders.</p></div>
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
    <div class="section-header"><span class="eyebrow">Online application</span><h2>Admission application form</h2>
      <p>Complete the six steps below. Fields marked with * are required.</p></div>

    <div class="row justify-content-center">
      <div class="col-lg-9">
        <div class="stepper" id="admissionStepper">
          <div class="step active" data-step="1">Personal</div>
          <div class="step" data-step="2">Academic</div>
          <div class="step" data-step="3">Program</div>
          <div class="step" data-step="4">Address</div>
          <div class="step" data-step="5">Documents</div>
          <div class="step" data-step="6">Review</div>
        </div>

        <div class="progress mb-4" style="height:6px" role="progressbar" aria-label="Application progress" aria-valuemin="1" aria-valuemax="6" aria-valuenow="1">
          <div class="progress-bar bg-primary" id="admissionProgress" style="width:16.6%"></div>
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
              <div class="col-md-6"><label class="form-label" for="fullName">Full name *</label>
                <input class="form-control" id="fullName" name="fullName" required minlength="3"><div class="invalid-feedback"></div></div>
              <div class="col-md-6"><label class="form-label" for="fatherName">Father's name *</label>
                <input class="form-control" id="fatherName" name="fatherName" required minlength="3"><div class="invalid-feedback"></div></div>
              <div class="col-md-6"><label class="form-label" for="dob">Date of birth *</label>
                <input class="form-control" type="date" id="dob" name="dob" required><div class="invalid-feedback"></div></div>
              <div class="col-md-6"><label class="form-label" for="gender">Gender *</label>
                <select class="form-select" id="gender" name="gender" required>
                  <option value="">Select</option><option>Female</option><option>Male</option><option>Prefer not to say</option>
                </select><div class="invalid-feedback"></div></div>
              <div class="col-md-6"><label class="form-label" for="cnic">CNIC / B-Form *</label>
                <input class="form-control" id="cnic" name="cnic" data-validate="cnic" placeholder="33302-1234567-1" required><div class="invalid-feedback"></div></div>
              <div class="col-md-6"><label class="form-label" for="phone">Phone *</label>
                <input class="form-control" id="phone" name="phone" data-validate="phone" placeholder="0302-8098542" required><div class="invalid-feedback"></div></div>
              <div class="col-md-6"><label class="form-label" for="whatsapp">WhatsApp number</label>
                <input class="form-control" id="whatsapp" name="whatsapp" data-validate="phone" placeholder="0302-8098542"><div class="invalid-feedback"></div></div>
              <div class="col-md-6"><label class="form-label" for="email">Email</label>
                <input class="form-control" type="email" id="email" name="email" placeholder="you@example.com"><div class="invalid-feedback"></div></div>
            </div>
          </fieldset>

          <fieldset class="form-step">
            <legend class="h6 mb-3">Step 2 — Academic information</legend>
            <div class="row g-3">
              <div class="col-md-6"><label class="form-label" for="qualification">Previous qualification *</label>
                <select class="form-select" id="qualification" name="qualification" required>
                  <option value="">Select</option><option>Matric</option><option>F.Sc / Intermediate</option>
                  <option>Diploma</option><option>Bachelor</option><option>Other</option>
                </select><div class="invalid-feedback"></div></div>
              <div class="col-md-6"><label class="form-label" for="institution">Institution *</label>
                <input class="form-control" id="institution" name="institution" required><div class="invalid-feedback"></div></div>
              <div class="col-md-4"><label class="form-label" for="obtained">Marks obtained</label>
                <input class="form-control" id="obtained" name="obtained" data-validate="number"><div class="invalid-feedback"></div></div>
              <div class="col-md-4"><label class="form-label" for="total">Total marks</label>
                <input class="form-control" id="total" name="total" data-validate="number"><div class="invalid-feedback"></div></div>
              <div class="col-md-4"><label class="form-label" for="percentage">Percentage</label>
                <input class="form-control" id="percentage" name="percentage" data-validate="number"><div class="invalid-feedback"></div></div>
            </div>
          </fieldset>

          <fieldset class="form-step">
            <legend class="h6 mb-3">Step 3 — Program selection</legend>
            <div class="row g-3">
              <div class="col-md-8"><label class="form-label" for="program">Preferred program *</label>
                <select class="form-select" id="program" name="program" data-program-select required>
                  <option value="">Select a program</option>
  <optgroup label="Nursing Programs">
    <option value="BSN Generic" data-program-id="bsn-generic">BSN Generic</option>
    <option value="Post RN" data-program-id="post-rn">Post RN</option>
    <option value="LHV (Lady Health Visitor)" data-program-id="lhv">LHV (Lady Health Visitor)</option>
    <option value="CMW (Community Midwife)" data-program-id="cmw">CMW (Community Midwife)</option>
    <option value="CNA (Certified Nursing Assistant)" data-program-id="cna">CNA (Certified Nursing Assistant)</option>
  </optgroup>
  <optgroup label="Allied Health Programs">
    <option value="Anesthesia Technician" data-program-id="anesthesia-technician">Anesthesia Technician</option>
    <option value="Radiography Technology + F.Sc" data-program-id="radiography-technology">Radiography Technology + F.Sc</option>
    <option value="Medical Lab Technology + F.Sc" data-program-id="medical-lab-technology">Medical Lab Technology + F.Sc</option>
    <option value="Dental Technician" data-program-id="dental-technician">Dental Technician</option>
    <option value="Operation Theater Technology + F.Sc" data-program-id="operation-theater-technology">Operation Theater Technology + F.Sc</option>
    <option value="Dispenser + F.Sc" data-program-id="dispenser">Dispenser + F.Sc</option>
    <option value="B-Category Pharmacy Technician" data-program-id="b-category-pharmacy-technician">B-Category Pharmacy Technician</option>
  </optgroup>
                </select><div class="invalid-feedback"></div></div>
              <div class="col-md-4"><label class="form-label" for="session">Session</label>
                <input class="form-control" id="session" name="session" value="2026–27" readonly></div>
              <div class="col-12"><label class="form-label" for="notes">Notes for the admissions office</label>
                <textarea class="form-control" id="notes" name="notes" rows="3" maxlength="600"></textarea></div>
            </div>
          </fieldset>

          <fieldset class="form-step">
            <legend class="h6 mb-3">Step 4 — Address</legend>
            <div class="row g-3">
              <div class="col-12"><label class="form-label" for="street">Postal address *</label>
                <input class="form-control" id="street" name="street" required><div class="invalid-feedback"></div></div>
              <div class="col-md-4"><label class="form-label" for="city">City *</label>
                <input class="form-control" id="city" name="city" required><div class="invalid-feedback"></div></div>
              <div class="col-md-4"><label class="form-label" for="district">District</label>
                <input class="form-control" id="district" name="district"></div>
              <div class="col-md-4"><label class="form-label" for="province">Province</label>
                <select class="form-select" id="province" name="province">
                  <option>Punjab</option><option>Sindh</option><option>Khyber Pakhtunkhwa</option>
                  <option>Balochistan</option><option>Islamabad Capital Territory</option><option>Other</option>
                </select></div>
            </div>
          </fieldset>

          <fieldset class="form-step">
            <legend class="h6 mb-3">Step 5 — Documents</legend>
            <div class="upload-drop" id="documentDrop" tabindex="0" role="button" aria-label="Choose document files">
              <i class="bi bi-cloud-arrow-up fs-2 text-brand d-block mb-2" aria-hidden="true"></i>
              <p class="mb-1 fw-600">Click or drop files to attach</p>
              <p class="small text-soft mb-0">Certificates, CNIC/B-Form, photographs (PDF, JPG, PNG)</p>
              <input class="d-none" type="file" id="documentInput" name="documents[]" multiple accept=".pdf,.jpg,.jpeg,.png">
            </div>
            <ul class="upload-list list-unstyled mt-3" id="documentList"></ul>
            <p class="small text-soft mt-2 mb-0">Accepted formats: PDF, JPG, PNG.</p>
          </fieldset>

          <fieldset class="form-step">
            <legend class="h6 mb-3">Step 6 — Review &amp; submit</legend>
            <div class="table-responsive">
              <table class="table review-table"><tbody id="reviewBody"></tbody></table>
            </div>
            <div class="form-check mt-3">
              <input class="form-check-input" type="checkbox" id="agreeTerms" name="agreeTerms" value="1" required>
              <label class="form-check-label small" for="agreeTerms">
                I confirm the information provided is accurate and I accept the <a href="{{ route('frontend.terms') }}">terms &amp; conditions</a>.
              </label>
              <div class="invalid-feedback"></div>
            </div>
          </fieldset>

          <div class="d-flex flex-wrap gap-2 mt-4">
            <button class="btn btn-outline-brand" type="button" data-action="prev"><i class="bi bi-arrow-left me-1"></i>Back</button>
            <button class="btn btn-brand ms-auto" type="button" data-action="next">Continue<i class="bi bi-arrow-right ms-1"></i></button>
            <button class="btn btn-brand-red ms-auto d-none" type="submit" data-action="submit">Submit Application</button>
          </div>
        </form>

        <div class="alert alert-success d-none mt-4" id="admissionSuccess" role="status">
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
        <a class="btn btn-outline-light-brand btn-lg" href="https://wa.me/923028098542?text=Hello%2C%20I%20would%20like%20information%20about%20admissions%20at%20King%20TAS%20College." target="_blank" rel="noopener"><i class="bi bi-whatsapp me-2"></i>WhatsApp Admissions</a>
      </div>
    </div>
  </div>
</section>
</main>
@endsection
