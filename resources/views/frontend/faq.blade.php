@extends('frontend.layouts.layout')
@section('title', 'FAQs | King TAS College of Nursing & Allied Health Sciences')
@section('description', 'Frequently asked questions about admissions, programs, eligibility, fees, documents and clinical training at King TAS College, Gojra.')
@section('content')
<main id="main">
<header class="page-hero">
  <div class="container">
    <h1>Frequently asked questions</h1>
    <p>Answers about admissions, programs, eligibility, fees, clinical training and student life.</p>
    <nav aria-label="Breadcrumb">
      <ol class="breadcrumb breadcrumb-brand"><li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li><li class="breadcrumb-item active" aria-current="page">FAQ</li></ol>
    </nav>
  </div>
</header>
<section class="section">
  <div class="container">
    <div class="row g-4 mb-4">
      <div class="col-lg-5">
        <label class="visually-hidden" for="faqSearch">Search questions</label>
        <div class="search-field"><i class="bi bi-search" aria-hidden="true"></i>
          <input class="form-control" type="search" id="faqSearch" placeholder="Search questions..."></div>
      </div>
      <div class="col-lg-7">
        <div class="d-flex flex-wrap gap-2 justify-content-lg-end" id="faqFilters" role="group" aria-label="FAQ categories">
          <button class="filter-chip active" data-filter="all">All</button>
          <button class="filter-chip" data-filter="Admissions">Admissions</button>
          <button class="filter-chip" data-filter="Programs">Programs</button>
          <button class="filter-chip" data-filter="Eligibility">Eligibility</button>
          <button class="filter-chip" data-filter="Fees">Fees</button>
          <button class="filter-chip" data-filter="Clinical Training">Clinical Training</button>
          <button class="filter-chip" data-filter="Student Life">Student Life</button>
          <button class="filter-chip" data-filter="Documents">Documents</button>
          <button class="filter-chip" data-filter="Contact">Contact</button>
        </div>
      </div>
    </div>
    <div class="accordion accordion-brand" id="faqAccordion">
<div class="accordion-item" data-reveal data-item data-category="Admissions" data-search="how can i apply for admission? you can submit the online admission form on this website or visit the campus admissions office. the admissions team will guide you through document requirements and next steps.">
  <h3 class="accordion-header" id="faqH0">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
      data-bs-target="#faqC0" aria-expanded="false" aria-controls="faqC0">
      How can I apply for admission?
    </button>
  </h3>
  <div id="faqC0" class="accordion-collapse collapse" aria-labelledby="faqH0" data-bs-parent="#faqAccordion">
    <div class="accordion-body">You can submit the online admission form on this website or visit the campus admissions office. The admissions team will guide you through document requirements and next steps.</div>
  </div>
</div>
<div class="accordion-item" data-reveal data-item data-category="Admissions" data-search="are admissions currently open? admissions are open for session 2026–27 for selected nursing and allied health programs. please contact the admissions office to confirm availability for a specific program.">
  <h3 class="accordion-header" id="faqH1">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
      data-bs-target="#faqC1" aria-expanded="false" aria-controls="faqC1">
      Are admissions currently open?
    </button>
  </h3>
  <div id="faqC1" class="accordion-collapse collapse" aria-labelledby="faqH1" data-bs-parent="#faqAccordion">
    <div class="accordion-body">Admissions are open for session 2026–27 for selected nursing and allied health programs. Please contact the admissions office to confirm availability for a specific program.</div>
  </div>
</div>
<div class="accordion-item" data-reveal data-item data-category="Admissions" data-search="is there an admission deadline? deadline information will be announced by the college administration. please confirm current dates with the admissions office.">
  <h3 class="accordion-header" id="faqH2">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
      data-bs-target="#faqC2" aria-expanded="false" aria-controls="faqC2">
      Is there an admission deadline?
    </button>
  </h3>
  <div id="faqC2" class="accordion-collapse collapse" aria-labelledby="faqH2" data-bs-parent="#faqAccordion">
    <div class="accordion-body">Deadline information will be announced by the college administration. Please confirm current dates with the admissions office.</div>
  </div>
</div>
<div class="accordion-item" data-reveal data-item data-category="Programs" data-search="which programs does the college offer? the college offers nursing programs including bsn generic, post rn, lhv, cmw and cna, along with allied health programs such as anesthesia technician, radiography technology, medical lab technology, dental technician, operation theater technology, dispenser and b-category pharmacy technician.">
  <h3 class="accordion-header" id="faqH3">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
      data-bs-target="#faqC3" aria-expanded="false" aria-controls="faqC3">
      Which programs does the college offer?
    </button>
  </h3>
  <div id="faqC3" class="accordion-collapse collapse" aria-labelledby="faqH3" data-bs-parent="#faqAccordion">
    <div class="accordion-body">The college offers nursing programs including BSN Generic, Post RN, LHV, CMW and CNA, along with allied health programs such as Anesthesia Technician, Radiography Technology, Medical Lab Technology, Dental Technician, Operation Theater Technology, Dispenser and B-Category Pharmacy Technician.</div>
  </div>
</div>
<div class="accordion-item" data-reveal data-item data-category="Programs" data-search="can i change my program after applying? program change requests are handled by the admissions office and depend on eligibility and seat availability.">
  <h3 class="accordion-header" id="faqH4">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
      data-bs-target="#faqC4" aria-expanded="false" aria-controls="faqC4">
      Can I change my program after applying?
    </button>
  </h3>
  <div id="faqC4" class="accordion-collapse collapse" aria-labelledby="faqH4" data-bs-parent="#faqAccordion">
    <div class="accordion-body">Program change requests are handled by the admissions office and depend on eligibility and seat availability.</div>
  </div>
</div>
<div class="accordion-item" data-reveal data-item data-category="Eligibility" data-search="what are the eligibility requirements? eligibility criteria differ per program and are confirmed by the admissions office. please refer to the eligibility page and contact the college for final requirements.">
  <h3 class="accordion-header" id="faqH5">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
      data-bs-target="#faqC5" aria-expanded="false" aria-controls="faqC5">
      What are the eligibility requirements?
    </button>
  </h3>
  <div id="faqC5" class="accordion-collapse collapse" aria-labelledby="faqH5" data-bs-parent="#faqAccordion">
    <div class="accordion-body">Eligibility criteria differ per program and are confirmed by the admissions office. Please refer to the eligibility page and contact the college for final requirements.</div>
  </div>
</div>
<div class="accordion-item" data-reveal data-item data-category="Eligibility" data-search="is there an age requirement? age requirements, where applicable, will be confirmed by the admissions office.">
  <h3 class="accordion-header" id="faqH6">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
      data-bs-target="#faqC6" aria-expanded="false" aria-controls="faqC6">
      Is there an age requirement?
    </button>
  </h3>
  <div id="faqC6" class="accordion-collapse collapse" aria-labelledby="faqH6" data-bs-parent="#faqAccordion">
    <div class="accordion-body">Age requirements, where applicable, will be confirmed by the admissions office.</div>
  </div>
</div>
<div class="accordion-item" data-reveal data-item data-category="Fees" data-search="what is the fee structure? fee information will be provided by the college administration. please contact the admissions office for the current fee schedule and payment options.">
  <h3 class="accordion-header" id="faqH7">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
      data-bs-target="#faqC7" aria-expanded="false" aria-controls="faqC7">
      What is the fee structure?
    </button>
  </h3>
  <div id="faqC7" class="accordion-collapse collapse" aria-labelledby="faqH7" data-bs-parent="#faqAccordion">
    <div class="accordion-body">Fee information will be provided by the college administration. Please contact the admissions office for the current fee schedule and payment options.</div>
  </div>
</div>
<div class="accordion-item" data-reveal data-item data-category="Clinical Training" data-search="is clinical training part of the programs? practical and clinical skill development is a core part of healthcare education at the college. specific clinical arrangements are confirmed by the administration.">
  <h3 class="accordion-header" id="faqH8">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
      data-bs-target="#faqC8" aria-expanded="false" aria-controls="faqC8">
      Is clinical training part of the programs?
    </button>
  </h3>
  <div id="faqC8" class="accordion-collapse collapse" aria-labelledby="faqH8" data-bs-parent="#faqAccordion">
    <div class="accordion-body">Practical and clinical skill development is a core part of healthcare education at the college. Specific clinical arrangements are confirmed by the administration.</div>
  </div>
</div>
<div class="accordion-item" data-reveal data-item data-category="Student Life" data-search="what activities are available for students? students take part in seminars, workshops, health awareness activities and academic sessions organised through the college.">
  <h3 class="accordion-header" id="faqH9">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
      data-bs-target="#faqC9" aria-expanded="false" aria-controls="faqC9">
      What activities are available for students?
    </button>
  </h3>
  <div id="faqC9" class="accordion-collapse collapse" aria-labelledby="faqH9" data-bs-parent="#faqAccordion">
    <div class="accordion-body">Students take part in seminars, workshops, health awareness activities and academic sessions organised through the college.</div>
  </div>
</div>
<div class="accordion-item" data-reveal data-item data-category="Documents" data-search="which documents do i need to submit? typically educational certificates, cnic or b-form, photographs and other supporting documents. please confirm the final checklist with the admissions office.">
  <h3 class="accordion-header" id="faqH10">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
      data-bs-target="#faqC10" aria-expanded="false" aria-controls="faqC10">
      Which documents do I need to submit?
    </button>
  </h3>
  <div id="faqC10" class="accordion-collapse collapse" aria-labelledby="faqH10" data-bs-parent="#faqAccordion">
    <div class="accordion-body">Typically educational certificates, CNIC or B-Form, photographs and other supporting documents. Please confirm the final checklist with the admissions office.</div>
  </div>
</div>
<div class="accordion-item" data-reveal data-item data-category="Contact" data-search="how do i contact the admissions office? call 0302-8098542 or 0326-0298542, message the college on whatsapp, or visit the campus at main painsara road, college road, near model city phase 3, gojra.">
  <h3 class="accordion-header" id="faqH11">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
      data-bs-target="#faqC11" aria-expanded="false" aria-controls="faqC11">
      How do I contact the admissions office?
    </button>
  </h3>
  <div id="faqC11" class="accordion-collapse collapse" aria-labelledby="faqH11" data-bs-parent="#faqAccordion">
    <div class="accordion-body">Call 0302-8098542 or 0326-0298542, message the college on WhatsApp, or visit the campus at Main Painsara Road, College Road, Near Model City Phase 3, Gojra.</div>
  </div>
</div>
<div class="empty-state d-none" data-empty><i class="bi bi-question-circle d-block mb-2"></i>No questions match your search.</div>
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
</section></main>
@endsection
