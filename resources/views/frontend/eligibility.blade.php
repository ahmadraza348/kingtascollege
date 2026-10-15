@extends('frontend.layouts.layout')
@section('title', 'Eligibility Criteria | King TAS College of Nursing & Allied Health Sciences')
@section('description', 'Program-by-program eligibility guidance for nursing and allied health admissions at King TAS College, Gojra. Final criteria confirmed by the admissions office.')
@section('content')
<main id="main">
<header class="page-hero">
  <div class="container">
    <h1>Eligibility</h1>
    <p>Program-specific entry requirements. Final criteria are confirmed by the admissions office before an application is accepted.</p>
    <nav aria-label="Breadcrumb">
      <ol class="breadcrumb breadcrumb-brand"><li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li><li class="breadcrumb-item"><a href="{{ route('frontend.admission') }}">Admissions</a></li><li class="breadcrumb-item active" aria-current="page">Eligibility</li></ol>
    </nav>
  </div>
</header>
<section class="section">
  <div class="container">
    <div class="accordion accordion-brand" id="eligibilityAccordion">
<div class="accordion-item" data-reveal>
  <h3 class="accordion-header" id="elH0">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
      data-bs-target="#elC0" aria-expanded="false" aria-controls="elC0">
      BSN Generic <span class="badge badge-soft ms-2">Nursing</span>
    </button>
  </h3>
  <div id="elC0" class="accordion-collapse collapse" aria-labelledby="elH0" data-bs-parent="#eligibilityAccordion">
    <div class="accordion-body">
      <div class="row g-3">
        <div class="col-md-6"><strong class="d-block small text-dark">Minimum qualification</strong>
          <span class="small">Details to be confirmed by Admissions Office</span></div>
        <div class="col-md-6"><strong class="d-block small text-dark">Duration</strong>
          <span class="small">Details to be confirmed by Admissions Office</span></div>
        <div class="col-md-6"><strong class="d-block small text-dark">Required subjects</strong>
          <span class="small">To be confirmed by the Admissions Office</span></div>
        <div class="col-md-6"><strong class="d-block small text-dark">Age requirement</strong>
          <span class="small">To be confirmed by the Admissions Office</span></div>
        <div class="col-12"><strong class="d-block small text-dark">Required documents</strong>
          <span class="small">Educational certificates, CNIC/B-Form, photographs and any additional documents advised by the admissions office.</span></div>
        <div class="col-12"><strong class="d-block small text-dark">Admission notes</strong>
          <span class="small">Please confirm final requirements with the Admissions Office before applying.</span></div>
      </div>
      <a class="btn btn-brand btn-sm mt-3" href="{{ route('frontend.admission') }}#apply">Apply for BSN Generic</a>
    </div>
  </div>
</div>
<div class="accordion-item" data-reveal>
  <h3 class="accordion-header" id="elH1">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
      data-bs-target="#elC1" aria-expanded="false" aria-controls="elC1">
      Post RN <span class="badge badge-soft ms-2">Nursing</span>
    </button>
  </h3>
  <div id="elC1" class="accordion-collapse collapse" aria-labelledby="elH1" data-bs-parent="#eligibilityAccordion">
    <div class="accordion-body">
      <div class="row g-3">
        <div class="col-md-6"><strong class="d-block small text-dark">Minimum qualification</strong>
          <span class="small">Details to be confirmed by Admissions Office</span></div>
        <div class="col-md-6"><strong class="d-block small text-dark">Duration</strong>
          <span class="small">Details to be confirmed by Admissions Office</span></div>
        <div class="col-md-6"><strong class="d-block small text-dark">Required subjects</strong>
          <span class="small">To be confirmed by the Admissions Office</span></div>
        <div class="col-md-6"><strong class="d-block small text-dark">Age requirement</strong>
          <span class="small">To be confirmed by the Admissions Office</span></div>
        <div class="col-12"><strong class="d-block small text-dark">Required documents</strong>
          <span class="small">Educational certificates, CNIC/B-Form, photographs and any additional documents advised by the admissions office.</span></div>
        <div class="col-12"><strong class="d-block small text-dark">Admission notes</strong>
          <span class="small">Please confirm final requirements with the Admissions Office before applying.</span></div>
      </div>
      <a class="btn btn-brand btn-sm mt-3" href="{{ route('frontend.admission') }}#apply">Apply for Post RN</a>
    </div>
  </div>
</div>
<div class="accordion-item" data-reveal>
  <h3 class="accordion-header" id="elH2">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
      data-bs-target="#elC2" aria-expanded="false" aria-controls="elC2">
      LHV (Lady Health Visitor) <span class="badge badge-soft ms-2">Nursing</span>
    </button>
  </h3>
  <div id="elC2" class="accordion-collapse collapse" aria-labelledby="elH2" data-bs-parent="#eligibilityAccordion">
    <div class="accordion-body">
      <div class="row g-3">
        <div class="col-md-6"><strong class="d-block small text-dark">Minimum qualification</strong>
          <span class="small">Details to be confirmed by Admissions Office</span></div>
        <div class="col-md-6"><strong class="d-block small text-dark">Duration</strong>
          <span class="small">Details to be confirmed by Admissions Office</span></div>
        <div class="col-md-6"><strong class="d-block small text-dark">Required subjects</strong>
          <span class="small">To be confirmed by the Admissions Office</span></div>
        <div class="col-md-6"><strong class="d-block small text-dark">Age requirement</strong>
          <span class="small">To be confirmed by the Admissions Office</span></div>
        <div class="col-12"><strong class="d-block small text-dark">Required documents</strong>
          <span class="small">Educational certificates, CNIC/B-Form, photographs and any additional documents advised by the admissions office.</span></div>
        <div class="col-12"><strong class="d-block small text-dark">Admission notes</strong>
          <span class="small">Please confirm final requirements with the Admissions Office before applying.</span></div>
      </div>
      <a class="btn btn-brand btn-sm mt-3" href="{{ route('frontend.admission') }}#apply">Apply for LHV (Lady Health Visitor)</a>
    </div>
  </div>
</div>
<div class="accordion-item" data-reveal>
  <h3 class="accordion-header" id="elH3">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
      data-bs-target="#elC3" aria-expanded="false" aria-controls="elC3">
      CMW (Community Midwife) <span class="badge badge-soft ms-2">Nursing</span>
    </button>
  </h3>
  <div id="elC3" class="accordion-collapse collapse" aria-labelledby="elH3" data-bs-parent="#eligibilityAccordion">
    <div class="accordion-body">
      <div class="row g-3">
        <div class="col-md-6"><strong class="d-block small text-dark">Minimum qualification</strong>
          <span class="small">Details to be confirmed by Admissions Office</span></div>
        <div class="col-md-6"><strong class="d-block small text-dark">Duration</strong>
          <span class="small">Details to be confirmed by Admissions Office</span></div>
        <div class="col-md-6"><strong class="d-block small text-dark">Required subjects</strong>
          <span class="small">To be confirmed by the Admissions Office</span></div>
        <div class="col-md-6"><strong class="d-block small text-dark">Age requirement</strong>
          <span class="small">To be confirmed by the Admissions Office</span></div>
        <div class="col-12"><strong class="d-block small text-dark">Required documents</strong>
          <span class="small">Educational certificates, CNIC/B-Form, photographs and any additional documents advised by the admissions office.</span></div>
        <div class="col-12"><strong class="d-block small text-dark">Admission notes</strong>
          <span class="small">Please confirm final requirements with the Admissions Office before applying.</span></div>
      </div>
      <a class="btn btn-brand btn-sm mt-3" href="{{ route('frontend.admission') }}#apply">Apply for CMW (Community Midwife)</a>
    </div>
  </div>
</div>
<div class="accordion-item" data-reveal>
  <h3 class="accordion-header" id="elH4">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
      data-bs-target="#elC4" aria-expanded="false" aria-controls="elC4">
      CNA (Certified Nursing Assistant) <span class="badge badge-soft ms-2">Nursing</span>
    </button>
  </h3>
  <div id="elC4" class="accordion-collapse collapse" aria-labelledby="elH4" data-bs-parent="#eligibilityAccordion">
    <div class="accordion-body">
      <div class="row g-3">
        <div class="col-md-6"><strong class="d-block small text-dark">Minimum qualification</strong>
          <span class="small">Details to be confirmed by Admissions Office</span></div>
        <div class="col-md-6"><strong class="d-block small text-dark">Duration</strong>
          <span class="small">Details to be confirmed by Admissions Office</span></div>
        <div class="col-md-6"><strong class="d-block small text-dark">Required subjects</strong>
          <span class="small">To be confirmed by the Admissions Office</span></div>
        <div class="col-md-6"><strong class="d-block small text-dark">Age requirement</strong>
          <span class="small">To be confirmed by the Admissions Office</span></div>
        <div class="col-12"><strong class="d-block small text-dark">Required documents</strong>
          <span class="small">Educational certificates, CNIC/B-Form, photographs and any additional documents advised by the admissions office.</span></div>
        <div class="col-12"><strong class="d-block small text-dark">Admission notes</strong>
          <span class="small">Please confirm final requirements with the Admissions Office before applying.</span></div>
      </div>
      <a class="btn btn-brand btn-sm mt-3" href="{{ route('frontend.admission') }}#apply">Apply for CNA (Certified Nursing Assistant)</a>
    </div>
  </div>
</div>
<div class="accordion-item" data-reveal>
  <h3 class="accordion-header" id="elH5">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
      data-bs-target="#elC5" aria-expanded="false" aria-controls="elC5">
      Anesthesia Technician <span class="badge badge-soft ms-2">Allied Health</span>
    </button>
  </h3>
  <div id="elC5" class="accordion-collapse collapse" aria-labelledby="elH5" data-bs-parent="#eligibilityAccordion">
    <div class="accordion-body">
      <div class="row g-3">
        <div class="col-md-6"><strong class="d-block small text-dark">Minimum qualification</strong>
          <span class="small">Details to be confirmed by Admissions Office</span></div>
        <div class="col-md-6"><strong class="d-block small text-dark">Duration</strong>
          <span class="small">Details to be confirmed by Admissions Office</span></div>
        <div class="col-md-6"><strong class="d-block small text-dark">Required subjects</strong>
          <span class="small">To be confirmed by the Admissions Office</span></div>
        <div class="col-md-6"><strong class="d-block small text-dark">Age requirement</strong>
          <span class="small">To be confirmed by the Admissions Office</span></div>
        <div class="col-12"><strong class="d-block small text-dark">Required documents</strong>
          <span class="small">Educational certificates, CNIC/B-Form, photographs and any additional documents advised by the admissions office.</span></div>
        <div class="col-12"><strong class="d-block small text-dark">Admission notes</strong>
          <span class="small">Please confirm final requirements with the Admissions Office before applying.</span></div>
      </div>
      <a class="btn btn-brand btn-sm mt-3" href="{{ route('frontend.admission') }}#apply">Apply for Anesthesia Technician</a>
    </div>
  </div>
</div>
<div class="accordion-item" data-reveal>
  <h3 class="accordion-header" id="elH6">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
      data-bs-target="#elC6" aria-expanded="false" aria-controls="elC6">
      Radiography Technology + F.Sc <span class="badge badge-soft ms-2">Allied Health</span>
    </button>
  </h3>
  <div id="elC6" class="accordion-collapse collapse" aria-labelledby="elH6" data-bs-parent="#eligibilityAccordion">
    <div class="accordion-body">
      <div class="row g-3">
        <div class="col-md-6"><strong class="d-block small text-dark">Minimum qualification</strong>
          <span class="small">Details to be confirmed by Admissions Office</span></div>
        <div class="col-md-6"><strong class="d-block small text-dark">Duration</strong>
          <span class="small">Details to be confirmed by Admissions Office</span></div>
        <div class="col-md-6"><strong class="d-block small text-dark">Required subjects</strong>
          <span class="small">To be confirmed by the Admissions Office</span></div>
        <div class="col-md-6"><strong class="d-block small text-dark">Age requirement</strong>
          <span class="small">To be confirmed by the Admissions Office</span></div>
        <div class="col-12"><strong class="d-block small text-dark">Required documents</strong>
          <span class="small">Educational certificates, CNIC/B-Form, photographs and any additional documents advised by the admissions office.</span></div>
        <div class="col-12"><strong class="d-block small text-dark">Admission notes</strong>
          <span class="small">Please confirm final requirements with the Admissions Office before applying.</span></div>
      </div>
      <a class="btn btn-brand btn-sm mt-3" href="{{ route('frontend.admission') }}#apply">Apply for Radiography Technology + F.Sc</a>
    </div>
  </div>
</div>
<div class="accordion-item" data-reveal>
  <h3 class="accordion-header" id="elH7">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
      data-bs-target="#elC7" aria-expanded="false" aria-controls="elC7">
      Medical Lab Technology + F.Sc <span class="badge badge-soft ms-2">Allied Health</span>
    </button>
  </h3>
  <div id="elC7" class="accordion-collapse collapse" aria-labelledby="elH7" data-bs-parent="#eligibilityAccordion">
    <div class="accordion-body">
      <div class="row g-3">
        <div class="col-md-6"><strong class="d-block small text-dark">Minimum qualification</strong>
          <span class="small">Details to be confirmed by Admissions Office</span></div>
        <div class="col-md-6"><strong class="d-block small text-dark">Duration</strong>
          <span class="small">Details to be confirmed by Admissions Office</span></div>
        <div class="col-md-6"><strong class="d-block small text-dark">Required subjects</strong>
          <span class="small">To be confirmed by the Admissions Office</span></div>
        <div class="col-md-6"><strong class="d-block small text-dark">Age requirement</strong>
          <span class="small">To be confirmed by the Admissions Office</span></div>
        <div class="col-12"><strong class="d-block small text-dark">Required documents</strong>
          <span class="small">Educational certificates, CNIC/B-Form, photographs and any additional documents advised by the admissions office.</span></div>
        <div class="col-12"><strong class="d-block small text-dark">Admission notes</strong>
          <span class="small">Please confirm final requirements with the Admissions Office before applying.</span></div>
      </div>
      <a class="btn btn-brand btn-sm mt-3" href="{{ route('frontend.admission') }}#apply">Apply for Medical Lab Technology + F.Sc</a>
    </div>
  </div>
</div>
<div class="accordion-item" data-reveal>
  <h3 class="accordion-header" id="elH8">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
      data-bs-target="#elC8" aria-expanded="false" aria-controls="elC8">
      Dental Technician <span class="badge badge-soft ms-2">Allied Health</span>
    </button>
  </h3>
  <div id="elC8" class="accordion-collapse collapse" aria-labelledby="elH8" data-bs-parent="#eligibilityAccordion">
    <div class="accordion-body">
      <div class="row g-3">
        <div class="col-md-6"><strong class="d-block small text-dark">Minimum qualification</strong>
          <span class="small">Details to be confirmed by Admissions Office</span></div>
        <div class="col-md-6"><strong class="d-block small text-dark">Duration</strong>
          <span class="small">Details to be confirmed by Admissions Office</span></div>
        <div class="col-md-6"><strong class="d-block small text-dark">Required subjects</strong>
          <span class="small">To be confirmed by the Admissions Office</span></div>
        <div class="col-md-6"><strong class="d-block small text-dark">Age requirement</strong>
          <span class="small">To be confirmed by the Admissions Office</span></div>
        <div class="col-12"><strong class="d-block small text-dark">Required documents</strong>
          <span class="small">Educational certificates, CNIC/B-Form, photographs and any additional documents advised by the admissions office.</span></div>
        <div class="col-12"><strong class="d-block small text-dark">Admission notes</strong>
          <span class="small">Please confirm final requirements with the Admissions Office before applying.</span></div>
      </div>
      <a class="btn btn-brand btn-sm mt-3" href="{{ route('frontend.admission') }}#apply">Apply for Dental Technician</a>
    </div>
  </div>
</div>
<div class="accordion-item" data-reveal>
  <h3 class="accordion-header" id="elH9">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
      data-bs-target="#elC9" aria-expanded="false" aria-controls="elC9">
      Operation Theater Technology + F.Sc <span class="badge badge-soft ms-2">Allied Health</span>
    </button>
  </h3>
  <div id="elC9" class="accordion-collapse collapse" aria-labelledby="elH9" data-bs-parent="#eligibilityAccordion">
    <div class="accordion-body">
      <div class="row g-3">
        <div class="col-md-6"><strong class="d-block small text-dark">Minimum qualification</strong>
          <span class="small">Details to be confirmed by Admissions Office</span></div>
        <div class="col-md-6"><strong class="d-block small text-dark">Duration</strong>
          <span class="small">Details to be confirmed by Admissions Office</span></div>
        <div class="col-md-6"><strong class="d-block small text-dark">Required subjects</strong>
          <span class="small">To be confirmed by the Admissions Office</span></div>
        <div class="col-md-6"><strong class="d-block small text-dark">Age requirement</strong>
          <span class="small">To be confirmed by the Admissions Office</span></div>
        <div class="col-12"><strong class="d-block small text-dark">Required documents</strong>
          <span class="small">Educational certificates, CNIC/B-Form, photographs and any additional documents advised by the admissions office.</span></div>
        <div class="col-12"><strong class="d-block small text-dark">Admission notes</strong>
          <span class="small">Please confirm final requirements with the Admissions Office before applying.</span></div>
      </div>
      <a class="btn btn-brand btn-sm mt-3" href="{{ route('frontend.admission') }}#apply">Apply for Operation Theater Technology + F.Sc</a>
    </div>
  </div>
</div>
<div class="accordion-item" data-reveal>
  <h3 class="accordion-header" id="elH10">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
      data-bs-target="#elC10" aria-expanded="false" aria-controls="elC10">
      Dispenser + F.Sc <span class="badge badge-soft ms-2">Allied Health</span>
    </button>
  </h3>
  <div id="elC10" class="accordion-collapse collapse" aria-labelledby="elH10" data-bs-parent="#eligibilityAccordion">
    <div class="accordion-body">
      <div class="row g-3">
        <div class="col-md-6"><strong class="d-block small text-dark">Minimum qualification</strong>
          <span class="small">Details to be confirmed by Admissions Office</span></div>
        <div class="col-md-6"><strong class="d-block small text-dark">Duration</strong>
          <span class="small">Details to be confirmed by Admissions Office</span></div>
        <div class="col-md-6"><strong class="d-block small text-dark">Required subjects</strong>
          <span class="small">To be confirmed by the Admissions Office</span></div>
        <div class="col-md-6"><strong class="d-block small text-dark">Age requirement</strong>
          <span class="small">To be confirmed by the Admissions Office</span></div>
        <div class="col-12"><strong class="d-block small text-dark">Required documents</strong>
          <span class="small">Educational certificates, CNIC/B-Form, photographs and any additional documents advised by the admissions office.</span></div>
        <div class="col-12"><strong class="d-block small text-dark">Admission notes</strong>
          <span class="small">Please confirm final requirements with the Admissions Office before applying.</span></div>
      </div>
      <a class="btn btn-brand btn-sm mt-3" href="{{ route('frontend.admission') }}#apply">Apply for Dispenser + F.Sc</a>
    </div>
  </div>
</div>
<div class="accordion-item" data-reveal>
  <h3 class="accordion-header" id="elH11">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
      data-bs-target="#elC11" aria-expanded="false" aria-controls="elC11">
      B-Category Pharmacy Technician <span class="badge badge-soft ms-2">Allied Health</span>
    </button>
  </h3>
  <div id="elC11" class="accordion-collapse collapse" aria-labelledby="elH11" data-bs-parent="#eligibilityAccordion">
    <div class="accordion-body">
      <div class="row g-3">
        <div class="col-md-6"><strong class="d-block small text-dark">Minimum qualification</strong>
          <span class="small">Details to be confirmed by Admissions Office</span></div>
        <div class="col-md-6"><strong class="d-block small text-dark">Duration</strong>
          <span class="small">Details to be confirmed by Admissions Office</span></div>
        <div class="col-md-6"><strong class="d-block small text-dark">Required subjects</strong>
          <span class="small">To be confirmed by the Admissions Office</span></div>
        <div class="col-md-6"><strong class="d-block small text-dark">Age requirement</strong>
          <span class="small">To be confirmed by the Admissions Office</span></div>
        <div class="col-12"><strong class="d-block small text-dark">Required documents</strong>
          <span class="small">Educational certificates, CNIC/B-Form, photographs and any additional documents advised by the admissions office.</span></div>
        <div class="col-12"><strong class="d-block small text-dark">Admission notes</strong>
          <span class="small">Please confirm final requirements with the Admissions Office before applying.</span></div>
      </div>
      <a class="btn btn-brand btn-sm mt-3" href="{{ route('frontend.admission') }}#apply">Apply for B-Category Pharmacy Technician</a>
    </div>
  </div>
</div>
</div>
  </div>
</section>
</main>
@endsection
