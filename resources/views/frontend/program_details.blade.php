@extends('frontend.layouts.layout')
@section('title', 'Program Details | King TAS College of Nursing & Allied Health Sciences')
@section('description', 'Program overview, eligibility, study structure, clinical exposure and career pathways for nursing and allied health programs at King TAS College, Gojra.')
@section('content')
<main id="main">
<div data-program-page="bsn-generic" data-title="BSN Generic | King TAS College of Nursing &amp; Allied Health Sciences">
<header class="page-hero">
  <div class="container">
    <span class="eyebrow eyebrow-light">Nursing Program</span>
    <h1 class="mt-3">BSN Generic</h1>
    <p>A professional nursing degree pathway focused on patient care, clinical competence and evidence-based nursing practice.</p>
    <nav aria-label="Breadcrumb">
      <ol class="breadcrumb breadcrumb-brand">
        <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('frontend.all_program') }}">Programs</a></li>
        <li class="breadcrumb-item active" aria-current="page">BSN Generic</li>
      </ol>
    </nav>
  </div>
</header>

<section class="section">
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-8">
        <div class="media-frame rounded-brand shadow-brand ratio-16x9 mb-4">
          <img src="{{ asset('frontend/assets/images/hero/hero-nursing.jpg') }}" alt="BSN Generic training at King TAS College" width="1200" height="675">
        </div>
        <article>
  <h2 class="h4">Overview</h2>
  <p>A professional nursing degree pathway focused on patient care, clinical competence and evidence-based nursing practice.</p>
  <p>Teaching combines classroom study with practical skill development so students build the professional habits expected
  in healthcare environments — accuracy, patient safety awareness, hygiene discipline and clear communication.</p>

  <h2 class="h4 mt-5">Who should apply</h2>
  <p>Students who want a healthcare career and are prepared for practical, discipline-focused study in a professional
  learning environment.</p>

  <div class="row g-3 mt-4">
    <div class="col-md-6"><div class="card-brand p-3 h-100"><h3 class="h6"><i class="bi bi-mortarboard text-brand me-2"></i>Eligibility</h3><p class="small mb-0">Details to be confirmed by Admissions Office</p></div></div>
    <div class="col-md-6"><div class="card-brand p-3 h-100"><h3 class="h6"><i class="bi bi-clock text-brand me-2"></i>Duration</h3><p class="small mb-0">Details to be confirmed by Admissions Office</p></div></div>
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
    <span class="badge badge-soft">Staff Nurse</span>
<span class="badge badge-soft">Clinical Nurse</span>
<span class="badge badge-soft">Community Health Nursing</span>
<span class="badge badge-soft">Further Nursing Studies</span>
  </div>

  <h2 class="h4 mt-5">Skills students develop</h2>
  <div class="row g-3">
    <div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-heart-pulse text-brand"></i><span class="small">Patient-centred care</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-shield-check text-brand"></i><span class="small">Safety and infection control</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-chat-dots text-brand"></i><span class="small">Professional communication</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-clipboard-check text-brand"></i><span class="small">Accurate documentation</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-people text-brand"></i><span class="small">Teamwork in clinical settings</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-graph-up text-brand"></i><span class="small">Continuous professional learning</span></div></div>
  </div>

  <h2 class="h4 mt-5">Frequently asked questions</h2>
  <div class="accordion accordion-brand" id="programFaq-bsn-generic">
    <div class="accordion-item">
  <h3 class="accordion-header" id="pfH-bsn-generic-0">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pfC-bsn-generic-0" aria-expanded="false" aria-controls="pfC-bsn-generic-0">How can I apply for admission?</button>
  </h3>
  <div id="pfC-bsn-generic-0" class="accordion-collapse collapse" aria-labelledby="pfH-bsn-generic-0" data-bs-parent="#programFaq-bsn-generic">
    <div class="accordion-body">You can submit the online admission form on this website or visit the campus admissions office. The admissions team will guide you through document requirements and next steps.</div>
  </div>
</div>
<div class="accordion-item">
  <h3 class="accordion-header" id="pfH-bsn-generic-1">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pfC-bsn-generic-1" aria-expanded="false" aria-controls="pfC-bsn-generic-1">Are admissions currently open?</button>
  </h3>
  <div id="pfC-bsn-generic-1" class="accordion-collapse collapse" aria-labelledby="pfH-bsn-generic-1" data-bs-parent="#programFaq-bsn-generic">
    <div class="accordion-body">Admissions are open for session 2026–27 for selected nursing and allied health programs. Please contact the admissions office to confirm availability for a specific program.</div>
  </div>
</div>
<div class="accordion-item">
  <h3 class="accordion-header" id="pfH-bsn-generic-2">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pfC-bsn-generic-2" aria-expanded="false" aria-controls="pfC-bsn-generic-2">Is there an admission deadline?</button>
  </h3>
  <div id="pfC-bsn-generic-2" class="accordion-collapse collapse" aria-labelledby="pfH-bsn-generic-2" data-bs-parent="#programFaq-bsn-generic">
    <div class="accordion-body">Deadline information will be announced by the college administration. Please confirm current dates with the admissions office.</div>
  </div>
</div>
<div class="accordion-item">
  <h3 class="accordion-header" id="pfH-bsn-generic-3">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pfC-bsn-generic-3" aria-expanded="false" aria-controls="pfC-bsn-generic-3">Which programs does the college offer?</button>
  </h3>
  <div id="pfC-bsn-generic-3" class="accordion-collapse collapse" aria-labelledby="pfH-bsn-generic-3" data-bs-parent="#programFaq-bsn-generic">
    <div class="accordion-body">The college offers nursing programs including BSN Generic, Post RN, LHV, CMW and CNA, along with allied health programs such as Anesthesia Technician, Radiography Technology, Medical Lab Technology, Dental Technician, Operation Theater Technology, Dispenser and B-Category Pharmacy Technician.</div>
  </div>
</div>
  </div>

  <div class="demo-note mt-4"><i class="bi bi-info-circle me-1"></i>Program duration, eligibility and affiliation details
  are pending confirmation by the college administration and should be verified before publishing.</div>
</article>
      </div>
      <aside class="col-lg-4">
        <div class="card-brand p-4 sticky-side">
<h3 class="h6 mb-3">Program Information</h3>
<ul class="list-unstyled small mb-4">
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Program</span><strong>BSN Generic</strong></li>
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Category</span><strong>Nursing</strong></li>
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Duration</span><strong>Details to be confirmed by Admissions Office</strong></li>
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Eligibility</span><strong>Details to be confirmed by Admissions Office</strong></li>
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Admission status</span><strong class="text-brand-red">Admissions Open</strong></li>
  <li class="d-flex justify-content-between py-2"><span class="text-soft">How to apply</span><strong>Online form or campus visit</strong></li>
</ul>
<a class="btn btn-brand-red w-100 mb-2" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
<a class="btn btn-outline-brand w-100" href="{{ route('frontend.contact') }}">Talk to Admissions</a>
</div>
      </aside>
    </div>
  </div>
</section>

<section class="section bg-light-soft">
  <div class="container">
    <div class="section-header"><span class="eyebrow">Related</span><h2>Other programs in this category</h2></div>
    <div class="row g-4">
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="1">
  <article class="card-brand program-card d-flex flex-column">
    <div class="media-frame ratio-16x9">
      <span class="badge-brand  badge-float">Nursing</span>
      <img src="{{ asset('frontend/assets/images/programs/clinical.jpg') }}" alt="Post RN program at King TAS College" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-clipboard2-pulse text-brand fs-5"></i>
        <h3 class="h6 mb-0">Post RN</h3>
      </div>
      <p class="small text-soft flex-grow-1">A progression pathway for registered nurses who want to advance academic qualifications and professional responsibility.</p>
      <div class="meta-row mb-2">
        <span><i class="bi bi-clock me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="meta-row mb-3">
        <span><i class="bi bi-mortarboard me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-brand btn-sm flex-fill" href="{{ route('frontend.program-details') }}?program=post-rn">Learn More</a>
        <a class="btn btn-brand-red btn-sm flex-fill" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
      </div>
    </div>
  </article>
</div>
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="2">
  <article class="card-brand program-card d-flex flex-column">
    <div class="media-frame ratio-16x9">
      <span class="badge-brand  badge-float">Nursing</span>
      <img src="{{ asset('frontend/assets/images/programs/maternal.jpg') }}" alt="LHV (Lady Health Visitor) program at King TAS College" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-people text-brand fs-5"></i>
        <h3 class="h6 mb-0">LHV (Lady Health Visitor)</h3>
      </div>
      <p class="small text-soft flex-grow-1">Community and maternal healthcare training focused on family health education, preventive care and primary healthcare support.</p>
      <div class="meta-row mb-2">
        <span><i class="bi bi-clock me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="meta-row mb-3">
        <span><i class="bi bi-mortarboard me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-brand btn-sm flex-fill" href="{{ route('frontend.program-details') }}?program=lhv">Learn More</a>
        <a class="btn btn-brand-red btn-sm flex-fill" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
      </div>
    </div>
  </article>
</div>
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="3">
  <article class="card-brand program-card d-flex flex-column">
    <div class="media-frame ratio-16x9">
      <span class="badge-brand  badge-float">Nursing</span>
      <img src="{{ asset('frontend/assets/images/programs/maternal.jpg') }}" alt="CMW (Community Midwife) program at King TAS College" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-emoji-smile text-brand fs-5"></i>
        <h3 class="h6 mb-0">CMW (Community Midwife)</h3>
      </div>
      <p class="small text-soft flex-grow-1">Maternal and newborn care training covering antenatal, delivery and postnatal support within community healthcare settings.</p>
      <div class="meta-row mb-2">
        <span><i class="bi bi-clock me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="meta-row mb-3">
        <span><i class="bi bi-mortarboard me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-brand btn-sm flex-fill" href="{{ route('frontend.program-details') }}?program=cmw">Learn More</a>
        <a class="btn btn-brand-red btn-sm flex-fill" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
      </div>
    </div>
  </article>
</div>
</div>
  </div>
</section>
</div>
<div data-program-page="post-rn" data-title="Post RN | King TAS College of Nursing &amp; Allied Health Sciences" hidden>
<header class="page-hero">
  <div class="container">
    <span class="eyebrow eyebrow-light">Nursing Program</span>
    <h1 class="mt-3">Post RN</h1>
    <p>A progression pathway for registered nurses who want to advance academic qualifications and professional responsibility.</p>
    <nav aria-label="Breadcrumb">
      <ol class="breadcrumb breadcrumb-brand">
        <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('frontend.all_program') }}">Programs</a></li>
        <li class="breadcrumb-item active" aria-current="page">Post RN</li>
      </ol>
    </nav>
  </div>
</header>

<section class="section">
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-8">
        <div class="media-frame rounded-brand shadow-brand ratio-16x9 mb-4">
          <img src="{{ asset('frontend/assets/images/programs/clinical.jpg') }}" alt="Post RN training at King TAS College" width="1200" height="675">
        </div>
        <article>
  <h2 class="h4">Overview</h2>
  <p>A progression pathway for registered nurses who want to advance academic qualifications and professional responsibility.</p>
  <p>Teaching combines classroom study with practical skill development so students build the professional habits expected
  in healthcare environments — accuracy, patient safety awareness, hygiene discipline and clear communication.</p>

  <h2 class="h4 mt-5">Who should apply</h2>
  <p>Students who want a healthcare career and are prepared for practical, discipline-focused study in a professional
  learning environment.</p>

  <div class="row g-3 mt-4">
    <div class="col-md-6"><div class="card-brand p-3 h-100"><h3 class="h6"><i class="bi bi-mortarboard text-brand me-2"></i>Eligibility</h3><p class="small mb-0">Details to be confirmed by Admissions Office</p></div></div>
    <div class="col-md-6"><div class="card-brand p-3 h-100"><h3 class="h6"><i class="bi bi-clock text-brand me-2"></i>Duration</h3><p class="small mb-0">Details to be confirmed by Admissions Office</p></div></div>
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
    <span class="badge badge-soft">Senior Staff Nurse</span>
<span class="badge badge-soft">Ward Supervisor</span>
<span class="badge badge-soft">Nursing Instructor</span>
<span class="badge badge-soft">Specialised Nursing Roles</span>
  </div>

  <h2 class="h4 mt-5">Skills students develop</h2>
  <div class="row g-3">
    <div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-heart-pulse text-brand"></i><span class="small">Patient-centred care</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-shield-check text-brand"></i><span class="small">Safety and infection control</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-chat-dots text-brand"></i><span class="small">Professional communication</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-clipboard-check text-brand"></i><span class="small">Accurate documentation</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-people text-brand"></i><span class="small">Teamwork in clinical settings</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-graph-up text-brand"></i><span class="small">Continuous professional learning</span></div></div>
  </div>

  <h2 class="h4 mt-5">Frequently asked questions</h2>
  <div class="accordion accordion-brand" id="programFaq-post-rn">
    <div class="accordion-item">
  <h3 class="accordion-header" id="pfH-post-rn-0">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pfC-post-rn-0" aria-expanded="false" aria-controls="pfC-post-rn-0">How can I apply for admission?</button>
  </h3>
  <div id="pfC-post-rn-0" class="accordion-collapse collapse" aria-labelledby="pfH-post-rn-0" data-bs-parent="#programFaq-post-rn">
    <div class="accordion-body">You can submit the online admission form on this website or visit the campus admissions office. The admissions team will guide you through document requirements and next steps.</div>
  </div>
</div>
<div class="accordion-item">
  <h3 class="accordion-header" id="pfH-post-rn-1">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pfC-post-rn-1" aria-expanded="false" aria-controls="pfC-post-rn-1">Are admissions currently open?</button>
  </h3>
  <div id="pfC-post-rn-1" class="accordion-collapse collapse" aria-labelledby="pfH-post-rn-1" data-bs-parent="#programFaq-post-rn">
    <div class="accordion-body">Admissions are open for session 2026–27 for selected nursing and allied health programs. Please contact the admissions office to confirm availability for a specific program.</div>
  </div>
</div>
<div class="accordion-item">
  <h3 class="accordion-header" id="pfH-post-rn-2">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pfC-post-rn-2" aria-expanded="false" aria-controls="pfC-post-rn-2">Is there an admission deadline?</button>
  </h3>
  <div id="pfC-post-rn-2" class="accordion-collapse collapse" aria-labelledby="pfH-post-rn-2" data-bs-parent="#programFaq-post-rn">
    <div class="accordion-body">Deadline information will be announced by the college administration. Please confirm current dates with the admissions office.</div>
  </div>
</div>
<div class="accordion-item">
  <h3 class="accordion-header" id="pfH-post-rn-3">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pfC-post-rn-3" aria-expanded="false" aria-controls="pfC-post-rn-3">Which programs does the college offer?</button>
  </h3>
  <div id="pfC-post-rn-3" class="accordion-collapse collapse" aria-labelledby="pfH-post-rn-3" data-bs-parent="#programFaq-post-rn">
    <div class="accordion-body">The college offers nursing programs including BSN Generic, Post RN, LHV, CMW and CNA, along with allied health programs such as Anesthesia Technician, Radiography Technology, Medical Lab Technology, Dental Technician, Operation Theater Technology, Dispenser and B-Category Pharmacy Technician.</div>
  </div>
</div>
  </div>

  <div class="demo-note mt-4"><i class="bi bi-info-circle me-1"></i>Program duration, eligibility and affiliation details
  are pending confirmation by the college administration and should be verified before publishing.</div>
</article>
      </div>
      <aside class="col-lg-4">
        <div class="card-brand p-4 sticky-side">
<h3 class="h6 mb-3">Program Information</h3>
<ul class="list-unstyled small mb-4">
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Program</span><strong>Post RN</strong></li>
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Category</span><strong>Nursing</strong></li>
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Duration</span><strong>Details to be confirmed by Admissions Office</strong></li>
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Eligibility</span><strong>Details to be confirmed by Admissions Office</strong></li>
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Admission status</span><strong class="text-brand-red">Admissions Open</strong></li>
  <li class="d-flex justify-content-between py-2"><span class="text-soft">How to apply</span><strong>Online form or campus visit</strong></li>
</ul>
<a class="btn btn-brand-red w-100 mb-2" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
<a class="btn btn-outline-brand w-100" href="{{ route('frontend.contact') }}">Talk to Admissions</a>
</div>
      </aside>
    </div>
  </div>
</section>

<section class="section bg-light-soft">
  <div class="container">
    <div class="section-header"><span class="eyebrow">Related</span><h2>Other programs in this category</h2></div>
    <div class="row g-4">
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="1">
  <article class="card-brand program-card d-flex flex-column">
    <div class="media-frame ratio-16x9">
      <span class="badge-brand  badge-float">Nursing</span>
      <img src="{{ asset('frontend/assets/images/hero/hero-nursing.jpg') }}" alt="BSN Generic program at King TAS College" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-heart-pulse text-brand fs-5"></i>
        <h3 class="h6 mb-0">BSN Generic</h3>
      </div>
      <p class="small text-soft flex-grow-1">A professional nursing degree pathway focused on patient care, clinical competence and evidence-based nursing practice.</p>
      <div class="meta-row mb-2">
        <span><i class="bi bi-clock me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="meta-row mb-3">
        <span><i class="bi bi-mortarboard me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-brand btn-sm flex-fill" href="{{ route('frontend.program-details') }}?program=bsn-generic">Learn More</a>
        <a class="btn btn-brand-red btn-sm flex-fill" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
      </div>
    </div>
  </article>
</div>
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="2">
  <article class="card-brand program-card d-flex flex-column">
    <div class="media-frame ratio-16x9">
      <span class="badge-brand  badge-float">Nursing</span>
      <img src="{{ asset('frontend/assets/images/programs/maternal.jpg') }}" alt="LHV (Lady Health Visitor) program at King TAS College" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-people text-brand fs-5"></i>
        <h3 class="h6 mb-0">LHV (Lady Health Visitor)</h3>
      </div>
      <p class="small text-soft flex-grow-1">Community and maternal healthcare training focused on family health education, preventive care and primary healthcare support.</p>
      <div class="meta-row mb-2">
        <span><i class="bi bi-clock me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="meta-row mb-3">
        <span><i class="bi bi-mortarboard me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-brand btn-sm flex-fill" href="{{ route('frontend.program-details') }}?program=lhv">Learn More</a>
        <a class="btn btn-brand-red btn-sm flex-fill" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
      </div>
    </div>
  </article>
</div>
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="3">
  <article class="card-brand program-card d-flex flex-column">
    <div class="media-frame ratio-16x9">
      <span class="badge-brand  badge-float">Nursing</span>
      <img src="{{ asset('frontend/assets/images/programs/maternal.jpg') }}" alt="CMW (Community Midwife) program at King TAS College" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-emoji-smile text-brand fs-5"></i>
        <h3 class="h6 mb-0">CMW (Community Midwife)</h3>
      </div>
      <p class="small text-soft flex-grow-1">Maternal and newborn care training covering antenatal, delivery and postnatal support within community healthcare settings.</p>
      <div class="meta-row mb-2">
        <span><i class="bi bi-clock me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="meta-row mb-3">
        <span><i class="bi bi-mortarboard me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-brand btn-sm flex-fill" href="{{ route('frontend.program-details') }}?program=cmw">Learn More</a>
        <a class="btn btn-brand-red btn-sm flex-fill" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
      </div>
    </div>
  </article>
</div>
</div>
  </div>
</section>
</div>
<div data-program-page="lhv" data-title="LHV (Lady Health Visitor) | King TAS College of Nursing &amp; Allied Health Sciences" hidden>
<header class="page-hero">
  <div class="container">
    <span class="eyebrow eyebrow-light">Nursing Program</span>
    <h1 class="mt-3">LHV (Lady Health Visitor)</h1>
    <p>Community and maternal healthcare training focused on family health education, preventive care and primary healthcare support.</p>
    <nav aria-label="Breadcrumb">
      <ol class="breadcrumb breadcrumb-brand">
        <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('frontend.all_program') }}">Programs</a></li>
        <li class="breadcrumb-item active" aria-current="page">LHV (Lady Health Visitor)</li>
      </ol>
    </nav>
  </div>
</header>

<section class="section">
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-8">
        <div class="media-frame rounded-brand shadow-brand ratio-16x9 mb-4">
          <img src="{{ asset('frontend/assets/images/programs/maternal.jpg') }}" alt="LHV (Lady Health Visitor) training at King TAS College" width="1200" height="675">
        </div>
        <article>
  <h2 class="h4">Overview</h2>
  <p>Community and maternal healthcare training focused on family health education, preventive care and primary healthcare support.</p>
  <p>Teaching combines classroom study with practical skill development so students build the professional habits expected
  in healthcare environments — accuracy, patient safety awareness, hygiene discipline and clear communication.</p>

  <h2 class="h4 mt-5">Who should apply</h2>
  <p>Students who want a healthcare career and are prepared for practical, discipline-focused study in a professional
  learning environment.</p>

  <div class="row g-3 mt-4">
    <div class="col-md-6"><div class="card-brand p-3 h-100"><h3 class="h6"><i class="bi bi-mortarboard text-brand me-2"></i>Eligibility</h3><p class="small mb-0">Details to be confirmed by Admissions Office</p></div></div>
    <div class="col-md-6"><div class="card-brand p-3 h-100"><h3 class="h6"><i class="bi bi-clock text-brand me-2"></i>Duration</h3><p class="small mb-0">Details to be confirmed by Admissions Office</p></div></div>
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
    <span class="badge badge-soft">Lady Health Visitor</span>
<span class="badge badge-soft">Community Health Worker</span>
<span class="badge badge-soft">Primary Healthcare Centre Roles</span>
  </div>

  <h2 class="h4 mt-5">Skills students develop</h2>
  <div class="row g-3">
    <div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-heart-pulse text-brand"></i><span class="small">Patient-centred care</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-shield-check text-brand"></i><span class="small">Safety and infection control</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-chat-dots text-brand"></i><span class="small">Professional communication</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-clipboard-check text-brand"></i><span class="small">Accurate documentation</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-people text-brand"></i><span class="small">Teamwork in clinical settings</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-graph-up text-brand"></i><span class="small">Continuous professional learning</span></div></div>
  </div>

  <h2 class="h4 mt-5">Frequently asked questions</h2>
  <div class="accordion accordion-brand" id="programFaq-lhv">
    <div class="accordion-item">
  <h3 class="accordion-header" id="pfH-lhv-0">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pfC-lhv-0" aria-expanded="false" aria-controls="pfC-lhv-0">How can I apply for admission?</button>
  </h3>
  <div id="pfC-lhv-0" class="accordion-collapse collapse" aria-labelledby="pfH-lhv-0" data-bs-parent="#programFaq-lhv">
    <div class="accordion-body">You can submit the online admission form on this website or visit the campus admissions office. The admissions team will guide you through document requirements and next steps.</div>
  </div>
</div>
<div class="accordion-item">
  <h3 class="accordion-header" id="pfH-lhv-1">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pfC-lhv-1" aria-expanded="false" aria-controls="pfC-lhv-1">Are admissions currently open?</button>
  </h3>
  <div id="pfC-lhv-1" class="accordion-collapse collapse" aria-labelledby="pfH-lhv-1" data-bs-parent="#programFaq-lhv">
    <div class="accordion-body">Admissions are open for session 2026–27 for selected nursing and allied health programs. Please contact the admissions office to confirm availability for a specific program.</div>
  </div>
</div>
<div class="accordion-item">
  <h3 class="accordion-header" id="pfH-lhv-2">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pfC-lhv-2" aria-expanded="false" aria-controls="pfC-lhv-2">Is there an admission deadline?</button>
  </h3>
  <div id="pfC-lhv-2" class="accordion-collapse collapse" aria-labelledby="pfH-lhv-2" data-bs-parent="#programFaq-lhv">
    <div class="accordion-body">Deadline information will be announced by the college administration. Please confirm current dates with the admissions office.</div>
  </div>
</div>
<div class="accordion-item">
  <h3 class="accordion-header" id="pfH-lhv-3">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pfC-lhv-3" aria-expanded="false" aria-controls="pfC-lhv-3">Which programs does the college offer?</button>
  </h3>
  <div id="pfC-lhv-3" class="accordion-collapse collapse" aria-labelledby="pfH-lhv-3" data-bs-parent="#programFaq-lhv">
    <div class="accordion-body">The college offers nursing programs including BSN Generic, Post RN, LHV, CMW and CNA, along with allied health programs such as Anesthesia Technician, Radiography Technology, Medical Lab Technology, Dental Technician, Operation Theater Technology, Dispenser and B-Category Pharmacy Technician.</div>
  </div>
</div>
  </div>

  <div class="demo-note mt-4"><i class="bi bi-info-circle me-1"></i>Program duration, eligibility and affiliation details
  are pending confirmation by the college administration and should be verified before publishing.</div>
</article>
      </div>
      <aside class="col-lg-4">
        <div class="card-brand p-4 sticky-side">
<h3 class="h6 mb-3">Program Information</h3>
<ul class="list-unstyled small mb-4">
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Program</span><strong>LHV (Lady Health Visitor)</strong></li>
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Category</span><strong>Nursing</strong></li>
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Duration</span><strong>Details to be confirmed by Admissions Office</strong></li>
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Eligibility</span><strong>Details to be confirmed by Admissions Office</strong></li>
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Admission status</span><strong class="text-brand-red">Admissions Open</strong></li>
  <li class="d-flex justify-content-between py-2"><span class="text-soft">How to apply</span><strong>Online form or campus visit</strong></li>
</ul>
<a class="btn btn-brand-red w-100 mb-2" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
<a class="btn btn-outline-brand w-100" href="{{ route('frontend.contact') }}">Talk to Admissions</a>
</div>
      </aside>
    </div>
  </div>
</section>

<section class="section bg-light-soft">
  <div class="container">
    <div class="section-header"><span class="eyebrow">Related</span><h2>Other programs in this category</h2></div>
    <div class="row g-4">
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="1">
  <article class="card-brand program-card d-flex flex-column">
    <div class="media-frame ratio-16x9">
      <span class="badge-brand  badge-float">Nursing</span>
      <img src="{{ asset('frontend/assets/images/hero/hero-nursing.jpg') }}" alt="BSN Generic program at King TAS College" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-heart-pulse text-brand fs-5"></i>
        <h3 class="h6 mb-0">BSN Generic</h3>
      </div>
      <p class="small text-soft flex-grow-1">A professional nursing degree pathway focused on patient care, clinical competence and evidence-based nursing practice.</p>
      <div class="meta-row mb-2">
        <span><i class="bi bi-clock me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="meta-row mb-3">
        <span><i class="bi bi-mortarboard me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-brand btn-sm flex-fill" href="{{ route('frontend.program-details') }}?program=bsn-generic">Learn More</a>
        <a class="btn btn-brand-red btn-sm flex-fill" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
      </div>
    </div>
  </article>
</div>
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="2">
  <article class="card-brand program-card d-flex flex-column">
    <div class="media-frame ratio-16x9">
      <span class="badge-brand  badge-float">Nursing</span>
      <img src="{{ asset('frontend/assets/images/programs/clinical.jpg') }}" alt="Post RN program at King TAS College" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-clipboard2-pulse text-brand fs-5"></i>
        <h3 class="h6 mb-0">Post RN</h3>
      </div>
      <p class="small text-soft flex-grow-1">A progression pathway for registered nurses who want to advance academic qualifications and professional responsibility.</p>
      <div class="meta-row mb-2">
        <span><i class="bi bi-clock me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="meta-row mb-3">
        <span><i class="bi bi-mortarboard me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-brand btn-sm flex-fill" href="{{ route('frontend.program-details') }}?program=post-rn">Learn More</a>
        <a class="btn btn-brand-red btn-sm flex-fill" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
      </div>
    </div>
  </article>
</div>
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="3">
  <article class="card-brand program-card d-flex flex-column">
    <div class="media-frame ratio-16x9">
      <span class="badge-brand  badge-float">Nursing</span>
      <img src="{{ asset('frontend/assets/images/programs/maternal.jpg') }}" alt="CMW (Community Midwife) program at King TAS College" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-emoji-smile text-brand fs-5"></i>
        <h3 class="h6 mb-0">CMW (Community Midwife)</h3>
      </div>
      <p class="small text-soft flex-grow-1">Maternal and newborn care training covering antenatal, delivery and postnatal support within community healthcare settings.</p>
      <div class="meta-row mb-2">
        <span><i class="bi bi-clock me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="meta-row mb-3">
        <span><i class="bi bi-mortarboard me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-brand btn-sm flex-fill" href="{{ route('frontend.program-details') }}?program=cmw">Learn More</a>
        <a class="btn btn-brand-red btn-sm flex-fill" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
      </div>
    </div>
  </article>
</div>
</div>
  </div>
</section>
</div>
<div data-program-page="cmw" data-title="CMW (Community Midwife) | King TAS College of Nursing &amp; Allied Health Sciences" hidden>
<header class="page-hero">
  <div class="container">
    <span class="eyebrow eyebrow-light">Nursing Program</span>
    <h1 class="mt-3">CMW (Community Midwife)</h1>
    <p>Maternal and newborn care training covering antenatal, delivery and postnatal support within community healthcare settings.</p>
    <nav aria-label="Breadcrumb">
      <ol class="breadcrumb breadcrumb-brand">
        <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('frontend.all_program') }}">Programs</a></li>
        <li class="breadcrumb-item active" aria-current="page">CMW (Community Midwife)</li>
      </ol>
    </nav>
  </div>
</header>

<section class="section">
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-8">
        <div class="media-frame rounded-brand shadow-brand ratio-16x9 mb-4">
          <img src="{{ asset('frontend/assets/images/programs/maternal.jpg') }}" alt="CMW (Community Midwife) training at King TAS College" width="1200" height="675">
        </div>
        <article>
  <h2 class="h4">Overview</h2>
  <p>Maternal and newborn care training covering antenatal, delivery and postnatal support within community healthcare settings.</p>
  <p>Teaching combines classroom study with practical skill development so students build the professional habits expected
  in healthcare environments — accuracy, patient safety awareness, hygiene discipline and clear communication.</p>

  <h2 class="h4 mt-5">Who should apply</h2>
  <p>Students who want a healthcare career and are prepared for practical, discipline-focused study in a professional
  learning environment.</p>

  <div class="row g-3 mt-4">
    <div class="col-md-6"><div class="card-brand p-3 h-100"><h3 class="h6"><i class="bi bi-mortarboard text-brand me-2"></i>Eligibility</h3><p class="small mb-0">Details to be confirmed by Admissions Office</p></div></div>
    <div class="col-md-6"><div class="card-brand p-3 h-100"><h3 class="h6"><i class="bi bi-clock text-brand me-2"></i>Duration</h3><p class="small mb-0">Details to be confirmed by Admissions Office</p></div></div>
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
    <span class="badge badge-soft">Community Midwife</span>
<span class="badge badge-soft">Maternity Unit Support</span>
<span class="badge badge-soft">Maternal Health Education</span>
  </div>

  <h2 class="h4 mt-5">Skills students develop</h2>
  <div class="row g-3">
    <div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-heart-pulse text-brand"></i><span class="small">Patient-centred care</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-shield-check text-brand"></i><span class="small">Safety and infection control</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-chat-dots text-brand"></i><span class="small">Professional communication</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-clipboard-check text-brand"></i><span class="small">Accurate documentation</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-people text-brand"></i><span class="small">Teamwork in clinical settings</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-graph-up text-brand"></i><span class="small">Continuous professional learning</span></div></div>
  </div>

  <h2 class="h4 mt-5">Frequently asked questions</h2>
  <div class="accordion accordion-brand" id="programFaq-cmw">
    <div class="accordion-item">
  <h3 class="accordion-header" id="pfH-cmw-0">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pfC-cmw-0" aria-expanded="false" aria-controls="pfC-cmw-0">How can I apply for admission?</button>
  </h3>
  <div id="pfC-cmw-0" class="accordion-collapse collapse" aria-labelledby="pfH-cmw-0" data-bs-parent="#programFaq-cmw">
    <div class="accordion-body">You can submit the online admission form on this website or visit the campus admissions office. The admissions team will guide you through document requirements and next steps.</div>
  </div>
</div>
<div class="accordion-item">
  <h3 class="accordion-header" id="pfH-cmw-1">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pfC-cmw-1" aria-expanded="false" aria-controls="pfC-cmw-1">Are admissions currently open?</button>
  </h3>
  <div id="pfC-cmw-1" class="accordion-collapse collapse" aria-labelledby="pfH-cmw-1" data-bs-parent="#programFaq-cmw">
    <div class="accordion-body">Admissions are open for session 2026–27 for selected nursing and allied health programs. Please contact the admissions office to confirm availability for a specific program.</div>
  </div>
</div>
<div class="accordion-item">
  <h3 class="accordion-header" id="pfH-cmw-2">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pfC-cmw-2" aria-expanded="false" aria-controls="pfC-cmw-2">Is there an admission deadline?</button>
  </h3>
  <div id="pfC-cmw-2" class="accordion-collapse collapse" aria-labelledby="pfH-cmw-2" data-bs-parent="#programFaq-cmw">
    <div class="accordion-body">Deadline information will be announced by the college administration. Please confirm current dates with the admissions office.</div>
  </div>
</div>
<div class="accordion-item">
  <h3 class="accordion-header" id="pfH-cmw-3">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pfC-cmw-3" aria-expanded="false" aria-controls="pfC-cmw-3">Which programs does the college offer?</button>
  </h3>
  <div id="pfC-cmw-3" class="accordion-collapse collapse" aria-labelledby="pfH-cmw-3" data-bs-parent="#programFaq-cmw">
    <div class="accordion-body">The college offers nursing programs including BSN Generic, Post RN, LHV, CMW and CNA, along with allied health programs such as Anesthesia Technician, Radiography Technology, Medical Lab Technology, Dental Technician, Operation Theater Technology, Dispenser and B-Category Pharmacy Technician.</div>
  </div>
</div>
  </div>

  <div class="demo-note mt-4"><i class="bi bi-info-circle me-1"></i>Program duration, eligibility and affiliation details
  are pending confirmation by the college administration and should be verified before publishing.</div>
</article>
      </div>
      <aside class="col-lg-4">
        <div class="card-brand p-4 sticky-side">
<h3 class="h6 mb-3">Program Information</h3>
<ul class="list-unstyled small mb-4">
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Program</span><strong>CMW (Community Midwife)</strong></li>
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Category</span><strong>Nursing</strong></li>
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Duration</span><strong>Details to be confirmed by Admissions Office</strong></li>
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Eligibility</span><strong>Details to be confirmed by Admissions Office</strong></li>
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Admission status</span><strong class="text-brand-red">Admissions Open</strong></li>
  <li class="d-flex justify-content-between py-2"><span class="text-soft">How to apply</span><strong>Online form or campus visit</strong></li>
</ul>
<a class="btn btn-brand-red w-100 mb-2" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
<a class="btn btn-outline-brand w-100" href="{{ route('frontend.contact') }}">Talk to Admissions</a>
</div>
      </aside>
    </div>
  </div>
</section>

<section class="section bg-light-soft">
  <div class="container">
    <div class="section-header"><span class="eyebrow">Related</span><h2>Other programs in this category</h2></div>
    <div class="row g-4">
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="1">
  <article class="card-brand program-card d-flex flex-column">
    <div class="media-frame ratio-16x9">
      <span class="badge-brand  badge-float">Nursing</span>
      <img src="{{ asset('frontend/assets/images/hero/hero-nursing.jpg') }}" alt="BSN Generic program at King TAS College" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-heart-pulse text-brand fs-5"></i>
        <h3 class="h6 mb-0">BSN Generic</h3>
      </div>
      <p class="small text-soft flex-grow-1">A professional nursing degree pathway focused on patient care, clinical competence and evidence-based nursing practice.</p>
      <div class="meta-row mb-2">
        <span><i class="bi bi-clock me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="meta-row mb-3">
        <span><i class="bi bi-mortarboard me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-brand btn-sm flex-fill" href="{{ route('frontend.program-details') }}?program=bsn-generic">Learn More</a>
        <a class="btn btn-brand-red btn-sm flex-fill" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
      </div>
    </div>
  </article>
</div>
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="2">
  <article class="card-brand program-card d-flex flex-column">
    <div class="media-frame ratio-16x9">
      <span class="badge-brand  badge-float">Nursing</span>
      <img src="{{ asset('frontend/assets/images/programs/clinical.jpg') }}" alt="Post RN program at King TAS College" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-clipboard2-pulse text-brand fs-5"></i>
        <h3 class="h6 mb-0">Post RN</h3>
      </div>
      <p class="small text-soft flex-grow-1">A progression pathway for registered nurses who want to advance academic qualifications and professional responsibility.</p>
      <div class="meta-row mb-2">
        <span><i class="bi bi-clock me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="meta-row mb-3">
        <span><i class="bi bi-mortarboard me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-brand btn-sm flex-fill" href="{{ route('frontend.program-details') }}?program=post-rn">Learn More</a>
        <a class="btn btn-brand-red btn-sm flex-fill" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
      </div>
    </div>
  </article>
</div>
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="3">
  <article class="card-brand program-card d-flex flex-column">
    <div class="media-frame ratio-16x9">
      <span class="badge-brand  badge-float">Nursing</span>
      <img src="{{ asset('frontend/assets/images/programs/maternal.jpg') }}" alt="LHV (Lady Health Visitor) program at King TAS College" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-people text-brand fs-5"></i>
        <h3 class="h6 mb-0">LHV (Lady Health Visitor)</h3>
      </div>
      <p class="small text-soft flex-grow-1">Community and maternal healthcare training focused on family health education, preventive care and primary healthcare support.</p>
      <div class="meta-row mb-2">
        <span><i class="bi bi-clock me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="meta-row mb-3">
        <span><i class="bi bi-mortarboard me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-brand btn-sm flex-fill" href="{{ route('frontend.program-details') }}?program=lhv">Learn More</a>
        <a class="btn btn-brand-red btn-sm flex-fill" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
      </div>
    </div>
  </article>
</div>
</div>
  </div>
</section>
</div>
<div data-program-page="cna" data-title="CNA (Certified Nursing Assistant) | King TAS College of Nursing &amp; Allied Health Sciences" hidden>
<header class="page-hero">
  <div class="container">
    <span class="eyebrow eyebrow-light">Nursing Program</span>
    <h1 class="mt-3">CNA (Certified Nursing Assistant)</h1>
    <p>Entry-level patient-care training covering basic nursing assistance, hygiene care, vitals monitoring and ward support.</p>
    <nav aria-label="Breadcrumb">
      <ol class="breadcrumb breadcrumb-brand">
        <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('frontend.all_program') }}">Programs</a></li>
        <li class="breadcrumb-item active" aria-current="page">CNA (Certified Nursing Assistant)</li>
      </ol>
    </nav>
  </div>
</header>

<section class="section">
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-8">
        <div class="media-frame rounded-brand shadow-brand ratio-16x9 mb-4">
          <img src="{{ asset('frontend/assets/images/programs/clinical.jpg') }}" alt="CNA (Certified Nursing Assistant) training at King TAS College" width="1200" height="675">
        </div>
        <article>
  <h2 class="h4">Overview</h2>
  <p>Entry-level patient-care training covering basic nursing assistance, hygiene care, vitals monitoring and ward support.</p>
  <p>Teaching combines classroom study with practical skill development so students build the professional habits expected
  in healthcare environments — accuracy, patient safety awareness, hygiene discipline and clear communication.</p>

  <h2 class="h4 mt-5">Who should apply</h2>
  <p>Students who want a healthcare career and are prepared for practical, discipline-focused study in a professional
  learning environment.</p>

  <div class="row g-3 mt-4">
    <div class="col-md-6"><div class="card-brand p-3 h-100"><h3 class="h6"><i class="bi bi-mortarboard text-brand me-2"></i>Eligibility</h3><p class="small mb-0">Details to be confirmed by Admissions Office</p></div></div>
    <div class="col-md-6"><div class="card-brand p-3 h-100"><h3 class="h6"><i class="bi bi-clock text-brand me-2"></i>Duration</h3><p class="small mb-0">Details to be confirmed by Admissions Office</p></div></div>
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
    <span class="badge badge-soft">Nursing Assistant</span>
<span class="badge badge-soft">Patient Care Attendant</span>
<span class="badge badge-soft">Ward Support Staff</span>
  </div>

  <h2 class="h4 mt-5">Skills students develop</h2>
  <div class="row g-3">
    <div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-heart-pulse text-brand"></i><span class="small">Patient-centred care</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-shield-check text-brand"></i><span class="small">Safety and infection control</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-chat-dots text-brand"></i><span class="small">Professional communication</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-clipboard-check text-brand"></i><span class="small">Accurate documentation</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-people text-brand"></i><span class="small">Teamwork in clinical settings</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-graph-up text-brand"></i><span class="small">Continuous professional learning</span></div></div>
  </div>

  <h2 class="h4 mt-5">Frequently asked questions</h2>
  <div class="accordion accordion-brand" id="programFaq-cna">
    <div class="accordion-item">
  <h3 class="accordion-header" id="pfH-cna-0">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pfC-cna-0" aria-expanded="false" aria-controls="pfC-cna-0">How can I apply for admission?</button>
  </h3>
  <div id="pfC-cna-0" class="accordion-collapse collapse" aria-labelledby="pfH-cna-0" data-bs-parent="#programFaq-cna">
    <div class="accordion-body">You can submit the online admission form on this website or visit the campus admissions office. The admissions team will guide you through document requirements and next steps.</div>
  </div>
</div>
<div class="accordion-item">
  <h3 class="accordion-header" id="pfH-cna-1">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pfC-cna-1" aria-expanded="false" aria-controls="pfC-cna-1">Are admissions currently open?</button>
  </h3>
  <div id="pfC-cna-1" class="accordion-collapse collapse" aria-labelledby="pfH-cna-1" data-bs-parent="#programFaq-cna">
    <div class="accordion-body">Admissions are open for session 2026–27 for selected nursing and allied health programs. Please contact the admissions office to confirm availability for a specific program.</div>
  </div>
</div>
<div class="accordion-item">
  <h3 class="accordion-header" id="pfH-cna-2">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pfC-cna-2" aria-expanded="false" aria-controls="pfC-cna-2">Is there an admission deadline?</button>
  </h3>
  <div id="pfC-cna-2" class="accordion-collapse collapse" aria-labelledby="pfH-cna-2" data-bs-parent="#programFaq-cna">
    <div class="accordion-body">Deadline information will be announced by the college administration. Please confirm current dates with the admissions office.</div>
  </div>
</div>
<div class="accordion-item">
  <h3 class="accordion-header" id="pfH-cna-3">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pfC-cna-3" aria-expanded="false" aria-controls="pfC-cna-3">Which programs does the college offer?</button>
  </h3>
  <div id="pfC-cna-3" class="accordion-collapse collapse" aria-labelledby="pfH-cna-3" data-bs-parent="#programFaq-cna">
    <div class="accordion-body">The college offers nursing programs including BSN Generic, Post RN, LHV, CMW and CNA, along with allied health programs such as Anesthesia Technician, Radiography Technology, Medical Lab Technology, Dental Technician, Operation Theater Technology, Dispenser and B-Category Pharmacy Technician.</div>
  </div>
</div>
  </div>

  <div class="demo-note mt-4"><i class="bi bi-info-circle me-1"></i>Program duration, eligibility and affiliation details
  are pending confirmation by the college administration and should be verified before publishing.</div>
</article>
      </div>
      <aside class="col-lg-4">
        <div class="card-brand p-4 sticky-side">
<h3 class="h6 mb-3">Program Information</h3>
<ul class="list-unstyled small mb-4">
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Program</span><strong>CNA (Certified Nursing Assistant)</strong></li>
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Category</span><strong>Nursing</strong></li>
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Duration</span><strong>Details to be confirmed by Admissions Office</strong></li>
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Eligibility</span><strong>Details to be confirmed by Admissions Office</strong></li>
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Admission status</span><strong class="text-brand-red">Admissions Open</strong></li>
  <li class="d-flex justify-content-between py-2"><span class="text-soft">How to apply</span><strong>Online form or campus visit</strong></li>
</ul>
<a class="btn btn-brand-red w-100 mb-2" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
<a class="btn btn-outline-brand w-100" href="{{ route('frontend.contact') }}">Talk to Admissions</a>
</div>
      </aside>
    </div>
  </div>
</section>

<section class="section bg-light-soft">
  <div class="container">
    <div class="section-header"><span class="eyebrow">Related</span><h2>Other programs in this category</h2></div>
    <div class="row g-4">
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="1">
  <article class="card-brand program-card d-flex flex-column">
    <div class="media-frame ratio-16x9">
      <span class="badge-brand  badge-float">Nursing</span>
      <img src="{{ asset('frontend/assets/images/hero/hero-nursing.jpg') }}" alt="BSN Generic program at King TAS College" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-heart-pulse text-brand fs-5"></i>
        <h3 class="h6 mb-0">BSN Generic</h3>
      </div>
      <p class="small text-soft flex-grow-1">A professional nursing degree pathway focused on patient care, clinical competence and evidence-based nursing practice.</p>
      <div class="meta-row mb-2">
        <span><i class="bi bi-clock me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="meta-row mb-3">
        <span><i class="bi bi-mortarboard me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-brand btn-sm flex-fill" href="{{ route('frontend.program-details') }}?program=bsn-generic">Learn More</a>
        <a class="btn btn-brand-red btn-sm flex-fill" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
      </div>
    </div>
  </article>
</div>
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="2">
  <article class="card-brand program-card d-flex flex-column">
    <div class="media-frame ratio-16x9">
      <span class="badge-brand  badge-float">Nursing</span>
      <img src="{{ asset('frontend/assets/images/programs/clinical.jpg') }}" alt="Post RN program at King TAS College" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-clipboard2-pulse text-brand fs-5"></i>
        <h3 class="h6 mb-0">Post RN</h3>
      </div>
      <p class="small text-soft flex-grow-1">A progression pathway for registered nurses who want to advance academic qualifications and professional responsibility.</p>
      <div class="meta-row mb-2">
        <span><i class="bi bi-clock me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="meta-row mb-3">
        <span><i class="bi bi-mortarboard me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-brand btn-sm flex-fill" href="{{ route('frontend.program-details') }}?program=post-rn">Learn More</a>
        <a class="btn btn-brand-red btn-sm flex-fill" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
      </div>
    </div>
  </article>
</div>
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="3">
  <article class="card-brand program-card d-flex flex-column">
    <div class="media-frame ratio-16x9">
      <span class="badge-brand  badge-float">Nursing</span>
      <img src="{{ asset('frontend/assets/images/programs/maternal.jpg') }}" alt="LHV (Lady Health Visitor) program at King TAS College" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-people text-brand fs-5"></i>
        <h3 class="h6 mb-0">LHV (Lady Health Visitor)</h3>
      </div>
      <p class="small text-soft flex-grow-1">Community and maternal healthcare training focused on family health education, preventive care and primary healthcare support.</p>
      <div class="meta-row mb-2">
        <span><i class="bi bi-clock me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="meta-row mb-3">
        <span><i class="bi bi-mortarboard me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-brand btn-sm flex-fill" href="{{ route('frontend.program-details') }}?program=lhv">Learn More</a>
        <a class="btn btn-brand-red btn-sm flex-fill" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
      </div>
    </div>
  </article>
</div>
</div>
  </div>
</section>
</div>
<div data-program-page="anesthesia-technician" data-title="Anesthesia Technician | King TAS College of Nursing &amp; Allied Health Sciences" hidden>
<header class="page-hero">
  <div class="container">
    <span class="eyebrow eyebrow-light">Allied Health Program</span>
    <h1 class="mt-3">Anesthesia Technician</h1>
    <p>Technical training in anesthesia equipment handling, operating room preparation and perioperative patient support.</p>
    <nav aria-label="Breadcrumb">
      <ol class="breadcrumb breadcrumb-brand">
        <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('frontend.all_program') }}">Programs</a></li>
        <li class="breadcrumb-item active" aria-current="page">Anesthesia Technician</li>
      </ol>
    </nav>
  </div>
</header>

<section class="section">
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-8">
        <div class="media-frame rounded-brand shadow-brand ratio-16x9 mb-4">
          <img src="{{ asset('frontend/assets/images/programs/ot.jpg') }}" alt="Anesthesia Technician training at King TAS College" width="1200" height="675">
        </div>
        <article>
  <h2 class="h4">Overview</h2>
  <p>Technical training in anesthesia equipment handling, operating room preparation and perioperative patient support.</p>
  <p>Teaching combines classroom study with practical skill development so students build the professional habits expected
  in healthcare environments — accuracy, patient safety awareness, hygiene discipline and clear communication.</p>

  <h2 class="h4 mt-5">Who should apply</h2>
  <p>Students who want a healthcare career and are prepared for practical, discipline-focused study in a professional
  learning environment.</p>

  <div class="row g-3 mt-4">
    <div class="col-md-6"><div class="card-brand p-3 h-100"><h3 class="h6"><i class="bi bi-mortarboard text-brand me-2"></i>Eligibility</h3><p class="small mb-0">Details to be confirmed by Admissions Office</p></div></div>
    <div class="col-md-6"><div class="card-brand p-3 h-100"><h3 class="h6"><i class="bi bi-clock text-brand me-2"></i>Duration</h3><p class="small mb-0">Details to be confirmed by Admissions Office</p></div></div>
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
    <span class="badge badge-soft">Anesthesia Technician</span>
<span class="badge badge-soft">Operating Room Technician</span>
<span class="badge badge-soft">Recovery Room Support</span>
  </div>

  <h2 class="h4 mt-5">Skills students develop</h2>
  <div class="row g-3">
    <div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-heart-pulse text-brand"></i><span class="small">Patient-centred care</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-shield-check text-brand"></i><span class="small">Safety and infection control</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-chat-dots text-brand"></i><span class="small">Professional communication</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-clipboard-check text-brand"></i><span class="small">Accurate documentation</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-people text-brand"></i><span class="small">Teamwork in clinical settings</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-graph-up text-brand"></i><span class="small">Continuous professional learning</span></div></div>
  </div>

  <h2 class="h4 mt-5">Frequently asked questions</h2>
  <div class="accordion accordion-brand" id="programFaq-anesthesia-technician">
    <div class="accordion-item">
  <h3 class="accordion-header" id="pfH-anesthesia-technician-0">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pfC-anesthesia-technician-0" aria-expanded="false" aria-controls="pfC-anesthesia-technician-0">How can I apply for admission?</button>
  </h3>
  <div id="pfC-anesthesia-technician-0" class="accordion-collapse collapse" aria-labelledby="pfH-anesthesia-technician-0" data-bs-parent="#programFaq-anesthesia-technician">
    <div class="accordion-body">You can submit the online admission form on this website or visit the campus admissions office. The admissions team will guide you through document requirements and next steps.</div>
  </div>
</div>
<div class="accordion-item">
  <h3 class="accordion-header" id="pfH-anesthesia-technician-1">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pfC-anesthesia-technician-1" aria-expanded="false" aria-controls="pfC-anesthesia-technician-1">Are admissions currently open?</button>
  </h3>
  <div id="pfC-anesthesia-technician-1" class="accordion-collapse collapse" aria-labelledby="pfH-anesthesia-technician-1" data-bs-parent="#programFaq-anesthesia-technician">
    <div class="accordion-body">Admissions are open for session 2026–27 for selected nursing and allied health programs. Please contact the admissions office to confirm availability for a specific program.</div>
  </div>
</div>
<div class="accordion-item">
  <h3 class="accordion-header" id="pfH-anesthesia-technician-2">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pfC-anesthesia-technician-2" aria-expanded="false" aria-controls="pfC-anesthesia-technician-2">Is there an admission deadline?</button>
  </h3>
  <div id="pfC-anesthesia-technician-2" class="accordion-collapse collapse" aria-labelledby="pfH-anesthesia-technician-2" data-bs-parent="#programFaq-anesthesia-technician">
    <div class="accordion-body">Deadline information will be announced by the college administration. Please confirm current dates with the admissions office.</div>
  </div>
</div>
<div class="accordion-item">
  <h3 class="accordion-header" id="pfH-anesthesia-technician-3">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pfC-anesthesia-technician-3" aria-expanded="false" aria-controls="pfC-anesthesia-technician-3">Which programs does the college offer?</button>
  </h3>
  <div id="pfC-anesthesia-technician-3" class="accordion-collapse collapse" aria-labelledby="pfH-anesthesia-technician-3" data-bs-parent="#programFaq-anesthesia-technician">
    <div class="accordion-body">The college offers nursing programs including BSN Generic, Post RN, LHV, CMW and CNA, along with allied health programs such as Anesthesia Technician, Radiography Technology, Medical Lab Technology, Dental Technician, Operation Theater Technology, Dispenser and B-Category Pharmacy Technician.</div>
  </div>
</div>
  </div>

  <div class="demo-note mt-4"><i class="bi bi-info-circle me-1"></i>Program duration, eligibility and affiliation details
  are pending confirmation by the college administration and should be verified before publishing.</div>
</article>
      </div>
      <aside class="col-lg-4">
        <div class="card-brand p-4 sticky-side">
<h3 class="h6 mb-3">Program Information</h3>
<ul class="list-unstyled small mb-4">
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Program</span><strong>Anesthesia Technician</strong></li>
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Category</span><strong>Allied Health</strong></li>
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Duration</span><strong>Details to be confirmed by Admissions Office</strong></li>
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Eligibility</span><strong>Details to be confirmed by Admissions Office</strong></li>
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Admission status</span><strong class="text-brand-red">Admissions Open</strong></li>
  <li class="d-flex justify-content-between py-2"><span class="text-soft">How to apply</span><strong>Online form or campus visit</strong></li>
</ul>
<a class="btn btn-brand-red w-100 mb-2" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
<a class="btn btn-outline-brand w-100" href="{{ route('frontend.contact') }}">Talk to Admissions</a>
</div>
      </aside>
    </div>
  </div>
</section>

<section class="section bg-light-soft">
  <div class="container">
    <div class="section-header"><span class="eyebrow">Related</span><h2>Other programs in this category</h2></div>
    <div class="row g-4">
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="1">
  <article class="card-brand program-card d-flex flex-column">
    <div class="media-frame ratio-16x9">
      <span class="badge-brand badge-brand-red badge-float">Allied Health</span>
      <img src="{{ asset('frontend/assets/images/programs/radiology.jpg') }}" alt="Radiography Technology + F.Sc program at King TAS College" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-broadcast text-brand fs-5"></i>
        <h3 class="h6 mb-0">Radiography Technology + F.Sc</h3>
      </div>
      <p class="small text-soft flex-grow-1">Diagnostic imaging training combined with an F.Sc pathway, covering radiographic techniques, positioning and radiation safety.</p>
      <div class="meta-row mb-2">
        <span><i class="bi bi-clock me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="meta-row mb-3">
        <span><i class="bi bi-mortarboard me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-brand btn-sm flex-fill" href="{{ route('frontend.program-details') }}?program=radiography-technology">Learn More</a>
        <a class="btn btn-brand-red btn-sm flex-fill" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
      </div>
    </div>
  </article>
</div>
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="2">
  <article class="card-brand program-card d-flex flex-column">
    <div class="media-frame ratio-16x9">
      <span class="badge-brand badge-brand-red badge-float">Allied Health</span>
      <img src="{{ asset('frontend/assets/images/programs/lab.jpg') }}" alt="Medical Lab Technology + F.Sc program at King TAS College" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-eyedropper text-brand fs-5"></i>
        <h3 class="h6 mb-0">Medical Lab Technology + F.Sc</h3>
      </div>
      <p class="small text-soft flex-grow-1">Laboratory science training with an F.Sc pathway, covering sample handling, clinical testing and laboratory quality practices.</p>
      <div class="meta-row mb-2">
        <span><i class="bi bi-clock me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="meta-row mb-3">
        <span><i class="bi bi-mortarboard me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-brand btn-sm flex-fill" href="{{ route('frontend.program-details') }}?program=medical-lab-technology">Learn More</a>
        <a class="btn btn-brand-red btn-sm flex-fill" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
      </div>
    </div>
  </article>
</div>
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="3">
  <article class="card-brand program-card d-flex flex-column">
    <div class="media-frame ratio-16x9">
      <span class="badge-brand badge-brand-red badge-float">Allied Health</span>
      <img src="{{ asset('frontend/assets/images/programs/lab.jpg') }}" alt="Dental Technician program at King TAS College" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-emoji-laughing text-brand fs-5"></i>
        <h3 class="h6 mb-0">Dental Technician</h3>
      </div>
      <p class="small text-soft flex-grow-1">Dental laboratory and chair-side assistance training covering dental materials, appliance work and clinic support skills.</p>
      <div class="meta-row mb-2">
        <span><i class="bi bi-clock me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="meta-row mb-3">
        <span><i class="bi bi-mortarboard me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-brand btn-sm flex-fill" href="{{ route('frontend.program-details') }}?program=dental-technician">Learn More</a>
        <a class="btn btn-brand-red btn-sm flex-fill" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
      </div>
    </div>
  </article>
</div>
</div>
  </div>
</section>
</div>
<div data-program-page="radiography-technology" data-title="Radiography Technology + F.Sc | King TAS College of Nursing &amp; Allied Health Sciences" hidden>
<header class="page-hero">
  <div class="container">
    <span class="eyebrow eyebrow-light">Allied Health Program</span>
    <h1 class="mt-3">Radiography Technology + F.Sc</h1>
    <p>Diagnostic imaging training combined with an F.Sc pathway, covering radiographic techniques, positioning and radiation safety.</p>
    <nav aria-label="Breadcrumb">
      <ol class="breadcrumb breadcrumb-brand">
        <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('frontend.all_program') }}">Programs</a></li>
        <li class="breadcrumb-item active" aria-current="page">Radiography Technology + F.Sc</li>
      </ol>
    </nav>
  </div>
</header>

<section class="section">
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-8">
        <div class="media-frame rounded-brand shadow-brand ratio-16x9 mb-4">
          <img src="{{ asset('frontend/assets/images/programs/radiology.jpg') }}" alt="Radiography Technology + F.Sc training at King TAS College" width="1200" height="675">
        </div>
        <article>
  <h2 class="h4">Overview</h2>
  <p>Diagnostic imaging training combined with an F.Sc pathway, covering radiographic techniques, positioning and radiation safety.</p>
  <p>Teaching combines classroom study with practical skill development so students build the professional habits expected
  in healthcare environments — accuracy, patient safety awareness, hygiene discipline and clear communication.</p>

  <h2 class="h4 mt-5">Who should apply</h2>
  <p>Students who want a healthcare career and are prepared for practical, discipline-focused study in a professional
  learning environment.</p>

  <div class="row g-3 mt-4">
    <div class="col-md-6"><div class="card-brand p-3 h-100"><h3 class="h6"><i class="bi bi-mortarboard text-brand me-2"></i>Eligibility</h3><p class="small mb-0">Details to be confirmed by Admissions Office</p></div></div>
    <div class="col-md-6"><div class="card-brand p-3 h-100"><h3 class="h6"><i class="bi bi-clock text-brand me-2"></i>Duration</h3><p class="small mb-0">Details to be confirmed by Admissions Office</p></div></div>
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
    <span class="badge badge-soft">Radiography Technician</span>
<span class="badge badge-soft">Imaging Department Roles</span>
<span class="badge badge-soft">Diagnostic Centre Technician</span>
  </div>

  <h2 class="h4 mt-5">Skills students develop</h2>
  <div class="row g-3">
    <div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-heart-pulse text-brand"></i><span class="small">Patient-centred care</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-shield-check text-brand"></i><span class="small">Safety and infection control</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-chat-dots text-brand"></i><span class="small">Professional communication</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-clipboard-check text-brand"></i><span class="small">Accurate documentation</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-people text-brand"></i><span class="small">Teamwork in clinical settings</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-graph-up text-brand"></i><span class="small">Continuous professional learning</span></div></div>
  </div>

  <h2 class="h4 mt-5">Frequently asked questions</h2>
  <div class="accordion accordion-brand" id="programFaq-radiography-technology">
    <div class="accordion-item">
  <h3 class="accordion-header" id="pfH-radiography-technology-0">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pfC-radiography-technology-0" aria-expanded="false" aria-controls="pfC-radiography-technology-0">How can I apply for admission?</button>
  </h3>
  <div id="pfC-radiography-technology-0" class="accordion-collapse collapse" aria-labelledby="pfH-radiography-technology-0" data-bs-parent="#programFaq-radiography-technology">
    <div class="accordion-body">You can submit the online admission form on this website or visit the campus admissions office. The admissions team will guide you through document requirements and next steps.</div>
  </div>
</div>
<div class="accordion-item">
  <h3 class="accordion-header" id="pfH-radiography-technology-1">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pfC-radiography-technology-1" aria-expanded="false" aria-controls="pfC-radiography-technology-1">Are admissions currently open?</button>
  </h3>
  <div id="pfC-radiography-technology-1" class="accordion-collapse collapse" aria-labelledby="pfH-radiography-technology-1" data-bs-parent="#programFaq-radiography-technology">
    <div class="accordion-body">Admissions are open for session 2026–27 for selected nursing and allied health programs. Please contact the admissions office to confirm availability for a specific program.</div>
  </div>
</div>
<div class="accordion-item">
  <h3 class="accordion-header" id="pfH-radiography-technology-2">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pfC-radiography-technology-2" aria-expanded="false" aria-controls="pfC-radiography-technology-2">Is there an admission deadline?</button>
  </h3>
  <div id="pfC-radiography-technology-2" class="accordion-collapse collapse" aria-labelledby="pfH-radiography-technology-2" data-bs-parent="#programFaq-radiography-technology">
    <div class="accordion-body">Deadline information will be announced by the college administration. Please confirm current dates with the admissions office.</div>
  </div>
</div>
<div class="accordion-item">
  <h3 class="accordion-header" id="pfH-radiography-technology-3">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pfC-radiography-technology-3" aria-expanded="false" aria-controls="pfC-radiography-technology-3">Which programs does the college offer?</button>
  </h3>
  <div id="pfC-radiography-technology-3" class="accordion-collapse collapse" aria-labelledby="pfH-radiography-technology-3" data-bs-parent="#programFaq-radiography-technology">
    <div class="accordion-body">The college offers nursing programs including BSN Generic, Post RN, LHV, CMW and CNA, along with allied health programs such as Anesthesia Technician, Radiography Technology, Medical Lab Technology, Dental Technician, Operation Theater Technology, Dispenser and B-Category Pharmacy Technician.</div>
  </div>
</div>
  </div>

  <div class="demo-note mt-4"><i class="bi bi-info-circle me-1"></i>Program duration, eligibility and affiliation details
  are pending confirmation by the college administration and should be verified before publishing.</div>
</article>
      </div>
      <aside class="col-lg-4">
        <div class="card-brand p-4 sticky-side">
<h3 class="h6 mb-3">Program Information</h3>
<ul class="list-unstyled small mb-4">
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Program</span><strong>Radiography Technology + F.Sc</strong></li>
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Category</span><strong>Allied Health</strong></li>
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Duration</span><strong>Details to be confirmed by Admissions Office</strong></li>
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Eligibility</span><strong>Details to be confirmed by Admissions Office</strong></li>
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Admission status</span><strong class="text-brand-red">Admissions Open</strong></li>
  <li class="d-flex justify-content-between py-2"><span class="text-soft">How to apply</span><strong>Online form or campus visit</strong></li>
</ul>
<a class="btn btn-brand-red w-100 mb-2" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
<a class="btn btn-outline-brand w-100" href="{{ route('frontend.contact') }}">Talk to Admissions</a>
</div>
      </aside>
    </div>
  </div>
</section>

<section class="section bg-light-soft">
  <div class="container">
    <div class="section-header"><span class="eyebrow">Related</span><h2>Other programs in this category</h2></div>
    <div class="row g-4">
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="1">
  <article class="card-brand program-card d-flex flex-column">
    <div class="media-frame ratio-16x9">
      <span class="badge-brand badge-brand-red badge-float">Allied Health</span>
      <img src="{{ asset('frontend/assets/images/programs/ot.jpg') }}" alt="Anesthesia Technician program at King TAS College" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-lungs text-brand fs-5"></i>
        <h3 class="h6 mb-0">Anesthesia Technician</h3>
      </div>
      <p class="small text-soft flex-grow-1">Technical training in anesthesia equipment handling, operating room preparation and perioperative patient support.</p>
      <div class="meta-row mb-2">
        <span><i class="bi bi-clock me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="meta-row mb-3">
        <span><i class="bi bi-mortarboard me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-brand btn-sm flex-fill" href="{{ route('frontend.program-details') }}?program=anesthesia-technician">Learn More</a>
        <a class="btn btn-brand-red btn-sm flex-fill" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
      </div>
    </div>
  </article>
</div>
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="2">
  <article class="card-brand program-card d-flex flex-column">
    <div class="media-frame ratio-16x9">
      <span class="badge-brand badge-brand-red badge-float">Allied Health</span>
      <img src="{{ asset('frontend/assets/images/programs/lab.jpg') }}" alt="Medical Lab Technology + F.Sc program at King TAS College" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-eyedropper text-brand fs-5"></i>
        <h3 class="h6 mb-0">Medical Lab Technology + F.Sc</h3>
      </div>
      <p class="small text-soft flex-grow-1">Laboratory science training with an F.Sc pathway, covering sample handling, clinical testing and laboratory quality practices.</p>
      <div class="meta-row mb-2">
        <span><i class="bi bi-clock me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="meta-row mb-3">
        <span><i class="bi bi-mortarboard me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-brand btn-sm flex-fill" href="{{ route('frontend.program-details') }}?program=medical-lab-technology">Learn More</a>
        <a class="btn btn-brand-red btn-sm flex-fill" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
      </div>
    </div>
  </article>
</div>
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="3">
  <article class="card-brand program-card d-flex flex-column">
    <div class="media-frame ratio-16x9">
      <span class="badge-brand badge-brand-red badge-float">Allied Health</span>
      <img src="{{ asset('frontend/assets/images/programs/lab.jpg') }}" alt="Dental Technician program at King TAS College" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-emoji-laughing text-brand fs-5"></i>
        <h3 class="h6 mb-0">Dental Technician</h3>
      </div>
      <p class="small text-soft flex-grow-1">Dental laboratory and chair-side assistance training covering dental materials, appliance work and clinic support skills.</p>
      <div class="meta-row mb-2">
        <span><i class="bi bi-clock me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="meta-row mb-3">
        <span><i class="bi bi-mortarboard me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-brand btn-sm flex-fill" href="{{ route('frontend.program-details') }}?program=dental-technician">Learn More</a>
        <a class="btn btn-brand-red btn-sm flex-fill" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
      </div>
    </div>
  </article>
</div>
</div>
  </div>
</section>
</div>
<div data-program-page="medical-lab-technology" data-title="Medical Lab Technology + F.Sc | King TAS College of Nursing &amp; Allied Health Sciences" hidden>
<header class="page-hero">
  <div class="container">
    <span class="eyebrow eyebrow-light">Allied Health Program</span>
    <h1 class="mt-3">Medical Lab Technology + F.Sc</h1>
    <p>Laboratory science training with an F.Sc pathway, covering sample handling, clinical testing and laboratory quality practices.</p>
    <nav aria-label="Breadcrumb">
      <ol class="breadcrumb breadcrumb-brand">
        <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('frontend.all_program') }}">Programs</a></li>
        <li class="breadcrumb-item active" aria-current="page">Medical Lab Technology + F.Sc</li>
      </ol>
    </nav>
  </div>
</header>

<section class="section">
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-8">
        <div class="media-frame rounded-brand shadow-brand ratio-16x9 mb-4">
          <img src="{{ asset('frontend/assets/images/programs/lab.jpg') }}" alt="Medical Lab Technology + F.Sc training at King TAS College" width="1200" height="675">
        </div>
        <article>
  <h2 class="h4">Overview</h2>
  <p>Laboratory science training with an F.Sc pathway, covering sample handling, clinical testing and laboratory quality practices.</p>
  <p>Teaching combines classroom study with practical skill development so students build the professional habits expected
  in healthcare environments — accuracy, patient safety awareness, hygiene discipline and clear communication.</p>

  <h2 class="h4 mt-5">Who should apply</h2>
  <p>Students who want a healthcare career and are prepared for practical, discipline-focused study in a professional
  learning environment.</p>

  <div class="row g-3 mt-4">
    <div class="col-md-6"><div class="card-brand p-3 h-100"><h3 class="h6"><i class="bi bi-mortarboard text-brand me-2"></i>Eligibility</h3><p class="small mb-0">Details to be confirmed by Admissions Office</p></div></div>
    <div class="col-md-6"><div class="card-brand p-3 h-100"><h3 class="h6"><i class="bi bi-clock text-brand me-2"></i>Duration</h3><p class="small mb-0">Details to be confirmed by Admissions Office</p></div></div>
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
    <span class="badge badge-soft">Lab Technician</span>
<span class="badge badge-soft">Pathology Lab Roles</span>
<span class="badge badge-soft">Diagnostic Laboratory Technician</span>
  </div>

  <h2 class="h4 mt-5">Skills students develop</h2>
  <div class="row g-3">
    <div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-heart-pulse text-brand"></i><span class="small">Patient-centred care</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-shield-check text-brand"></i><span class="small">Safety and infection control</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-chat-dots text-brand"></i><span class="small">Professional communication</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-clipboard-check text-brand"></i><span class="small">Accurate documentation</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-people text-brand"></i><span class="small">Teamwork in clinical settings</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-graph-up text-brand"></i><span class="small">Continuous professional learning</span></div></div>
  </div>

  <h2 class="h4 mt-5">Frequently asked questions</h2>
  <div class="accordion accordion-brand" id="programFaq-medical-lab-technology">
    <div class="accordion-item">
  <h3 class="accordion-header" id="pfH-medical-lab-technology-0">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pfC-medical-lab-technology-0" aria-expanded="false" aria-controls="pfC-medical-lab-technology-0">How can I apply for admission?</button>
  </h3>
  <div id="pfC-medical-lab-technology-0" class="accordion-collapse collapse" aria-labelledby="pfH-medical-lab-technology-0" data-bs-parent="#programFaq-medical-lab-technology">
    <div class="accordion-body">You can submit the online admission form on this website or visit the campus admissions office. The admissions team will guide you through document requirements and next steps.</div>
  </div>
</div>
<div class="accordion-item">
  <h3 class="accordion-header" id="pfH-medical-lab-technology-1">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pfC-medical-lab-technology-1" aria-expanded="false" aria-controls="pfC-medical-lab-technology-1">Are admissions currently open?</button>
  </h3>
  <div id="pfC-medical-lab-technology-1" class="accordion-collapse collapse" aria-labelledby="pfH-medical-lab-technology-1" data-bs-parent="#programFaq-medical-lab-technology">
    <div class="accordion-body">Admissions are open for session 2026–27 for selected nursing and allied health programs. Please contact the admissions office to confirm availability for a specific program.</div>
  </div>
</div>
<div class="accordion-item">
  <h3 class="accordion-header" id="pfH-medical-lab-technology-2">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pfC-medical-lab-technology-2" aria-expanded="false" aria-controls="pfC-medical-lab-technology-2">Is there an admission deadline?</button>
  </h3>
  <div id="pfC-medical-lab-technology-2" class="accordion-collapse collapse" aria-labelledby="pfH-medical-lab-technology-2" data-bs-parent="#programFaq-medical-lab-technology">
    <div class="accordion-body">Deadline information will be announced by the college administration. Please confirm current dates with the admissions office.</div>
  </div>
</div>
<div class="accordion-item">
  <h3 class="accordion-header" id="pfH-medical-lab-technology-3">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pfC-medical-lab-technology-3" aria-expanded="false" aria-controls="pfC-medical-lab-technology-3">Which programs does the college offer?</button>
  </h3>
  <div id="pfC-medical-lab-technology-3" class="accordion-collapse collapse" aria-labelledby="pfH-medical-lab-technology-3" data-bs-parent="#programFaq-medical-lab-technology">
    <div class="accordion-body">The college offers nursing programs including BSN Generic, Post RN, LHV, CMW and CNA, along with allied health programs such as Anesthesia Technician, Radiography Technology, Medical Lab Technology, Dental Technician, Operation Theater Technology, Dispenser and B-Category Pharmacy Technician.</div>
  </div>
</div>
  </div>

  <div class="demo-note mt-4"><i class="bi bi-info-circle me-1"></i>Program duration, eligibility and affiliation details
  are pending confirmation by the college administration and should be verified before publishing.</div>
</article>
      </div>
      <aside class="col-lg-4">
        <div class="card-brand p-4 sticky-side">
<h3 class="h6 mb-3">Program Information</h3>
<ul class="list-unstyled small mb-4">
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Program</span><strong>Medical Lab Technology + F.Sc</strong></li>
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Category</span><strong>Allied Health</strong></li>
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Duration</span><strong>Details to be confirmed by Admissions Office</strong></li>
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Eligibility</span><strong>Details to be confirmed by Admissions Office</strong></li>
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Admission status</span><strong class="text-brand-red">Admissions Open</strong></li>
  <li class="d-flex justify-content-between py-2"><span class="text-soft">How to apply</span><strong>Online form or campus visit</strong></li>
</ul>
<a class="btn btn-brand-red w-100 mb-2" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
<a class="btn btn-outline-brand w-100" href="{{ route('frontend.contact') }}">Talk to Admissions</a>
</div>
      </aside>
    </div>
  </div>
</section>

<section class="section bg-light-soft">
  <div class="container">
    <div class="section-header"><span class="eyebrow">Related</span><h2>Other programs in this category</h2></div>
    <div class="row g-4">
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="1">
  <article class="card-brand program-card d-flex flex-column">
    <div class="media-frame ratio-16x9">
      <span class="badge-brand badge-brand-red badge-float">Allied Health</span>
      <img src="{{ asset('frontend/assets/images/programs/ot.jpg') }}" alt="Anesthesia Technician program at King TAS College" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-lungs text-brand fs-5"></i>
        <h3 class="h6 mb-0">Anesthesia Technician</h3>
      </div>
      <p class="small text-soft flex-grow-1">Technical training in anesthesia equipment handling, operating room preparation and perioperative patient support.</p>
      <div class="meta-row mb-2">
        <span><i class="bi bi-clock me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="meta-row mb-3">
        <span><i class="bi bi-mortarboard me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-brand btn-sm flex-fill" href="{{ route('frontend.program-details') }}?program=anesthesia-technician">Learn More</a>
        <a class="btn btn-brand-red btn-sm flex-fill" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
      </div>
    </div>
  </article>
</div>
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="2">
  <article class="card-brand program-card d-flex flex-column">
    <div class="media-frame ratio-16x9">
      <span class="badge-brand badge-brand-red badge-float">Allied Health</span>
      <img src="{{ asset('frontend/assets/images/programs/radiology.jpg') }}" alt="Radiography Technology + F.Sc program at King TAS College" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-broadcast text-brand fs-5"></i>
        <h3 class="h6 mb-0">Radiography Technology + F.Sc</h3>
      </div>
      <p class="small text-soft flex-grow-1">Diagnostic imaging training combined with an F.Sc pathway, covering radiographic techniques, positioning and radiation safety.</p>
      <div class="meta-row mb-2">
        <span><i class="bi bi-clock me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="meta-row mb-3">
        <span><i class="bi bi-mortarboard me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-brand btn-sm flex-fill" href="{{ route('frontend.program-details') }}?program=radiography-technology">Learn More</a>
        <a class="btn btn-brand-red btn-sm flex-fill" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
      </div>
    </div>
  </article>
</div>
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="3">
  <article class="card-brand program-card d-flex flex-column">
    <div class="media-frame ratio-16x9">
      <span class="badge-brand badge-brand-red badge-float">Allied Health</span>
      <img src="{{ asset('frontend/assets/images/programs/lab.jpg') }}" alt="Dental Technician program at King TAS College" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-emoji-laughing text-brand fs-5"></i>
        <h3 class="h6 mb-0">Dental Technician</h3>
      </div>
      <p class="small text-soft flex-grow-1">Dental laboratory and chair-side assistance training covering dental materials, appliance work and clinic support skills.</p>
      <div class="meta-row mb-2">
        <span><i class="bi bi-clock me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="meta-row mb-3">
        <span><i class="bi bi-mortarboard me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-brand btn-sm flex-fill" href="{{ route('frontend.program-details') }}?program=dental-technician">Learn More</a>
        <a class="btn btn-brand-red btn-sm flex-fill" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
      </div>
    </div>
  </article>
</div>
</div>
  </div>
</section>
</div>
<div data-program-page="dental-technician" data-title="Dental Technician | King TAS College of Nursing &amp; Allied Health Sciences" hidden>
<header class="page-hero">
  <div class="container">
    <span class="eyebrow eyebrow-light">Allied Health Program</span>
    <h1 class="mt-3">Dental Technician</h1>
    <p>Dental laboratory and chair-side assistance training covering dental materials, appliance work and clinic support skills.</p>
    <nav aria-label="Breadcrumb">
      <ol class="breadcrumb breadcrumb-brand">
        <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('frontend.all_program') }}">Programs</a></li>
        <li class="breadcrumb-item active" aria-current="page">Dental Technician</li>
      </ol>
    </nav>
  </div>
</header>

<section class="section">
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-8">
        <div class="media-frame rounded-brand shadow-brand ratio-16x9 mb-4">
          <img src="{{ asset('frontend/assets/images/programs/lab.jpg') }}" alt="Dental Technician training at King TAS College" width="1200" height="675">
        </div>
        <article>
  <h2 class="h4">Overview</h2>
  <p>Dental laboratory and chair-side assistance training covering dental materials, appliance work and clinic support skills.</p>
  <p>Teaching combines classroom study with practical skill development so students build the professional habits expected
  in healthcare environments — accuracy, patient safety awareness, hygiene discipline and clear communication.</p>

  <h2 class="h4 mt-5">Who should apply</h2>
  <p>Students who want a healthcare career and are prepared for practical, discipline-focused study in a professional
  learning environment.</p>

  <div class="row g-3 mt-4">
    <div class="col-md-6"><div class="card-brand p-3 h-100"><h3 class="h6"><i class="bi bi-mortarboard text-brand me-2"></i>Eligibility</h3><p class="small mb-0">Details to be confirmed by Admissions Office</p></div></div>
    <div class="col-md-6"><div class="card-brand p-3 h-100"><h3 class="h6"><i class="bi bi-clock text-brand me-2"></i>Duration</h3><p class="small mb-0">Details to be confirmed by Admissions Office</p></div></div>
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
    <span class="badge badge-soft">Dental Technician</span>
<span class="badge badge-soft">Dental Laboratory Assistant</span>
<span class="badge badge-soft">Dental Clinic Support</span>
  </div>

  <h2 class="h4 mt-5">Skills students develop</h2>
  <div class="row g-3">
    <div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-heart-pulse text-brand"></i><span class="small">Patient-centred care</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-shield-check text-brand"></i><span class="small">Safety and infection control</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-chat-dots text-brand"></i><span class="small">Professional communication</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-clipboard-check text-brand"></i><span class="small">Accurate documentation</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-people text-brand"></i><span class="small">Teamwork in clinical settings</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-graph-up text-brand"></i><span class="small">Continuous professional learning</span></div></div>
  </div>

  <h2 class="h4 mt-5">Frequently asked questions</h2>
  <div class="accordion accordion-brand" id="programFaq-dental-technician">
    <div class="accordion-item">
  <h3 class="accordion-header" id="pfH-dental-technician-0">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pfC-dental-technician-0" aria-expanded="false" aria-controls="pfC-dental-technician-0">How can I apply for admission?</button>
  </h3>
  <div id="pfC-dental-technician-0" class="accordion-collapse collapse" aria-labelledby="pfH-dental-technician-0" data-bs-parent="#programFaq-dental-technician">
    <div class="accordion-body">You can submit the online admission form on this website or visit the campus admissions office. The admissions team will guide you through document requirements and next steps.</div>
  </div>
</div>
<div class="accordion-item">
  <h3 class="accordion-header" id="pfH-dental-technician-1">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pfC-dental-technician-1" aria-expanded="false" aria-controls="pfC-dental-technician-1">Are admissions currently open?</button>
  </h3>
  <div id="pfC-dental-technician-1" class="accordion-collapse collapse" aria-labelledby="pfH-dental-technician-1" data-bs-parent="#programFaq-dental-technician">
    <div class="accordion-body">Admissions are open for session 2026–27 for selected nursing and allied health programs. Please contact the admissions office to confirm availability for a specific program.</div>
  </div>
</div>
<div class="accordion-item">
  <h3 class="accordion-header" id="pfH-dental-technician-2">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pfC-dental-technician-2" aria-expanded="false" aria-controls="pfC-dental-technician-2">Is there an admission deadline?</button>
  </h3>
  <div id="pfC-dental-technician-2" class="accordion-collapse collapse" aria-labelledby="pfH-dental-technician-2" data-bs-parent="#programFaq-dental-technician">
    <div class="accordion-body">Deadline information will be announced by the college administration. Please confirm current dates with the admissions office.</div>
  </div>
</div>
<div class="accordion-item">
  <h3 class="accordion-header" id="pfH-dental-technician-3">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pfC-dental-technician-3" aria-expanded="false" aria-controls="pfC-dental-technician-3">Which programs does the college offer?</button>
  </h3>
  <div id="pfC-dental-technician-3" class="accordion-collapse collapse" aria-labelledby="pfH-dental-technician-3" data-bs-parent="#programFaq-dental-technician">
    <div class="accordion-body">The college offers nursing programs including BSN Generic, Post RN, LHV, CMW and CNA, along with allied health programs such as Anesthesia Technician, Radiography Technology, Medical Lab Technology, Dental Technician, Operation Theater Technology, Dispenser and B-Category Pharmacy Technician.</div>
  </div>
</div>
  </div>

  <div class="demo-note mt-4"><i class="bi bi-info-circle me-1"></i>Program duration, eligibility and affiliation details
  are pending confirmation by the college administration and should be verified before publishing.</div>
</article>
      </div>
      <aside class="col-lg-4">
        <div class="card-brand p-4 sticky-side">
<h3 class="h6 mb-3">Program Information</h3>
<ul class="list-unstyled small mb-4">
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Program</span><strong>Dental Technician</strong></li>
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Category</span><strong>Allied Health</strong></li>
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Duration</span><strong>Details to be confirmed by Admissions Office</strong></li>
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Eligibility</span><strong>Details to be confirmed by Admissions Office</strong></li>
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Admission status</span><strong class="text-brand-red">Admissions Open</strong></li>
  <li class="d-flex justify-content-between py-2"><span class="text-soft">How to apply</span><strong>Online form or campus visit</strong></li>
</ul>
<a class="btn btn-brand-red w-100 mb-2" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
<a class="btn btn-outline-brand w-100" href="{{ route('frontend.contact') }}">Talk to Admissions</a>
</div>
      </aside>
    </div>
  </div>
</section>

<section class="section bg-light-soft">
  <div class="container">
    <div class="section-header"><span class="eyebrow">Related</span><h2>Other programs in this category</h2></div>
    <div class="row g-4">
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="1">
  <article class="card-brand program-card d-flex flex-column">
    <div class="media-frame ratio-16x9">
      <span class="badge-brand badge-brand-red badge-float">Allied Health</span>
      <img src="{{ asset('frontend/assets/images/programs/ot.jpg') }}" alt="Anesthesia Technician program at King TAS College" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-lungs text-brand fs-5"></i>
        <h3 class="h6 mb-0">Anesthesia Technician</h3>
      </div>
      <p class="small text-soft flex-grow-1">Technical training in anesthesia equipment handling, operating room preparation and perioperative patient support.</p>
      <div class="meta-row mb-2">
        <span><i class="bi bi-clock me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="meta-row mb-3">
        <span><i class="bi bi-mortarboard me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-brand btn-sm flex-fill" href="{{ route('frontend.program-details') }}?program=anesthesia-technician">Learn More</a>
        <a class="btn btn-brand-red btn-sm flex-fill" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
      </div>
    </div>
  </article>
</div>
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="2">
  <article class="card-brand program-card d-flex flex-column">
    <div class="media-frame ratio-16x9">
      <span class="badge-brand badge-brand-red badge-float">Allied Health</span>
      <img src="{{ asset('frontend/assets/images/programs/radiology.jpg') }}" alt="Radiography Technology + F.Sc program at King TAS College" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-broadcast text-brand fs-5"></i>
        <h3 class="h6 mb-0">Radiography Technology + F.Sc</h3>
      </div>
      <p class="small text-soft flex-grow-1">Diagnostic imaging training combined with an F.Sc pathway, covering radiographic techniques, positioning and radiation safety.</p>
      <div class="meta-row mb-2">
        <span><i class="bi bi-clock me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="meta-row mb-3">
        <span><i class="bi bi-mortarboard me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-brand btn-sm flex-fill" href="{{ route('frontend.program-details') }}?program=radiography-technology">Learn More</a>
        <a class="btn btn-brand-red btn-sm flex-fill" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
      </div>
    </div>
  </article>
</div>
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="3">
  <article class="card-brand program-card d-flex flex-column">
    <div class="media-frame ratio-16x9">
      <span class="badge-brand badge-brand-red badge-float">Allied Health</span>
      <img src="{{ asset('frontend/assets/images/programs/lab.jpg') }}" alt="Medical Lab Technology + F.Sc program at King TAS College" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-eyedropper text-brand fs-5"></i>
        <h3 class="h6 mb-0">Medical Lab Technology + F.Sc</h3>
      </div>
      <p class="small text-soft flex-grow-1">Laboratory science training with an F.Sc pathway, covering sample handling, clinical testing and laboratory quality practices.</p>
      <div class="meta-row mb-2">
        <span><i class="bi bi-clock me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="meta-row mb-3">
        <span><i class="bi bi-mortarboard me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-brand btn-sm flex-fill" href="{{ route('frontend.program-details') }}?program=medical-lab-technology">Learn More</a>
        <a class="btn btn-brand-red btn-sm flex-fill" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
      </div>
    </div>
  </article>
</div>
</div>
  </div>
</section>
</div>
<div data-program-page="operation-theater-technology" data-title="Operation Theater Technology + F.Sc | King TAS College of Nursing &amp; Allied Health Sciences" hidden>
<header class="page-hero">
  <div class="container">
    <span class="eyebrow eyebrow-light">Allied Health Program</span>
    <h1 class="mt-3">Operation Theater Technology + F.Sc</h1>
    <p>Surgical theatre technology training covering sterilisation, instrument handling, theatre discipline and surgical assistance.</p>
    <nav aria-label="Breadcrumb">
      <ol class="breadcrumb breadcrumb-brand">
        <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('frontend.all_program') }}">Programs</a></li>
        <li class="breadcrumb-item active" aria-current="page">Operation Theater Technology + F.Sc</li>
      </ol>
    </nav>
  </div>
</header>

<section class="section">
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-8">
        <div class="media-frame rounded-brand shadow-brand ratio-16x9 mb-4">
          <img src="{{ asset('frontend/assets/images/programs/ot.jpg') }}" alt="Operation Theater Technology + F.Sc training at King TAS College" width="1200" height="675">
        </div>
        <article>
  <h2 class="h4">Overview</h2>
  <p>Surgical theatre technology training covering sterilisation, instrument handling, theatre discipline and surgical assistance.</p>
  <p>Teaching combines classroom study with practical skill development so students build the professional habits expected
  in healthcare environments — accuracy, patient safety awareness, hygiene discipline and clear communication.</p>

  <h2 class="h4 mt-5">Who should apply</h2>
  <p>Students who want a healthcare career and are prepared for practical, discipline-focused study in a professional
  learning environment.</p>

  <div class="row g-3 mt-4">
    <div class="col-md-6"><div class="card-brand p-3 h-100"><h3 class="h6"><i class="bi bi-mortarboard text-brand me-2"></i>Eligibility</h3><p class="small mb-0">Details to be confirmed by Admissions Office</p></div></div>
    <div class="col-md-6"><div class="card-brand p-3 h-100"><h3 class="h6"><i class="bi bi-clock text-brand me-2"></i>Duration</h3><p class="small mb-0">Details to be confirmed by Admissions Office</p></div></div>
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
    <span class="badge badge-soft">OT Technician</span>
<span class="badge badge-soft">Sterilisation Services</span>
<span class="badge badge-soft">Surgical Support Staff</span>
  </div>

  <h2 class="h4 mt-5">Skills students develop</h2>
  <div class="row g-3">
    <div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-heart-pulse text-brand"></i><span class="small">Patient-centred care</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-shield-check text-brand"></i><span class="small">Safety and infection control</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-chat-dots text-brand"></i><span class="small">Professional communication</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-clipboard-check text-brand"></i><span class="small">Accurate documentation</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-people text-brand"></i><span class="small">Teamwork in clinical settings</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-graph-up text-brand"></i><span class="small">Continuous professional learning</span></div></div>
  </div>

  <h2 class="h4 mt-5">Frequently asked questions</h2>
  <div class="accordion accordion-brand" id="programFaq-operation-theater-technology">
    <div class="accordion-item">
  <h3 class="accordion-header" id="pfH-operation-theater-technology-0">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pfC-operation-theater-technology-0" aria-expanded="false" aria-controls="pfC-operation-theater-technology-0">How can I apply for admission?</button>
  </h3>
  <div id="pfC-operation-theater-technology-0" class="accordion-collapse collapse" aria-labelledby="pfH-operation-theater-technology-0" data-bs-parent="#programFaq-operation-theater-technology">
    <div class="accordion-body">You can submit the online admission form on this website or visit the campus admissions office. The admissions team will guide you through document requirements and next steps.</div>
  </div>
</div>
<div class="accordion-item">
  <h3 class="accordion-header" id="pfH-operation-theater-technology-1">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pfC-operation-theater-technology-1" aria-expanded="false" aria-controls="pfC-operation-theater-technology-1">Are admissions currently open?</button>
  </h3>
  <div id="pfC-operation-theater-technology-1" class="accordion-collapse collapse" aria-labelledby="pfH-operation-theater-technology-1" data-bs-parent="#programFaq-operation-theater-technology">
    <div class="accordion-body">Admissions are open for session 2026–27 for selected nursing and allied health programs. Please contact the admissions office to confirm availability for a specific program.</div>
  </div>
</div>
<div class="accordion-item">
  <h3 class="accordion-header" id="pfH-operation-theater-technology-2">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pfC-operation-theater-technology-2" aria-expanded="false" aria-controls="pfC-operation-theater-technology-2">Is there an admission deadline?</button>
  </h3>
  <div id="pfC-operation-theater-technology-2" class="accordion-collapse collapse" aria-labelledby="pfH-operation-theater-technology-2" data-bs-parent="#programFaq-operation-theater-technology">
    <div class="accordion-body">Deadline information will be announced by the college administration. Please confirm current dates with the admissions office.</div>
  </div>
</div>
<div class="accordion-item">
  <h3 class="accordion-header" id="pfH-operation-theater-technology-3">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pfC-operation-theater-technology-3" aria-expanded="false" aria-controls="pfC-operation-theater-technology-3">Which programs does the college offer?</button>
  </h3>
  <div id="pfC-operation-theater-technology-3" class="accordion-collapse collapse" aria-labelledby="pfH-operation-theater-technology-3" data-bs-parent="#programFaq-operation-theater-technology">
    <div class="accordion-body">The college offers nursing programs including BSN Generic, Post RN, LHV, CMW and CNA, along with allied health programs such as Anesthesia Technician, Radiography Technology, Medical Lab Technology, Dental Technician, Operation Theater Technology, Dispenser and B-Category Pharmacy Technician.</div>
  </div>
</div>
  </div>

  <div class="demo-note mt-4"><i class="bi bi-info-circle me-1"></i>Program duration, eligibility and affiliation details
  are pending confirmation by the college administration and should be verified before publishing.</div>
</article>
      </div>
      <aside class="col-lg-4">
        <div class="card-brand p-4 sticky-side">
<h3 class="h6 mb-3">Program Information</h3>
<ul class="list-unstyled small mb-4">
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Program</span><strong>Operation Theater Technology + F.Sc</strong></li>
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Category</span><strong>Allied Health</strong></li>
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Duration</span><strong>Details to be confirmed by Admissions Office</strong></li>
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Eligibility</span><strong>Details to be confirmed by Admissions Office</strong></li>
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Admission status</span><strong class="text-brand-red">Admissions Open</strong></li>
  <li class="d-flex justify-content-between py-2"><span class="text-soft">How to apply</span><strong>Online form or campus visit</strong></li>
</ul>
<a class="btn btn-brand-red w-100 mb-2" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
<a class="btn btn-outline-brand w-100" href="{{ route('frontend.contact') }}">Talk to Admissions</a>
</div>
      </aside>
    </div>
  </div>
</section>

<section class="section bg-light-soft">
  <div class="container">
    <div class="section-header"><span class="eyebrow">Related</span><h2>Other programs in this category</h2></div>
    <div class="row g-4">
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="1">
  <article class="card-brand program-card d-flex flex-column">
    <div class="media-frame ratio-16x9">
      <span class="badge-brand badge-brand-red badge-float">Allied Health</span>
      <img src="{{ asset('frontend/assets/images/programs/ot.jpg') }}" alt="Anesthesia Technician program at King TAS College" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-lungs text-brand fs-5"></i>
        <h3 class="h6 mb-0">Anesthesia Technician</h3>
      </div>
      <p class="small text-soft flex-grow-1">Technical training in anesthesia equipment handling, operating room preparation and perioperative patient support.</p>
      <div class="meta-row mb-2">
        <span><i class="bi bi-clock me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="meta-row mb-3">
        <span><i class="bi bi-mortarboard me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-brand btn-sm flex-fill" href="{{ route('frontend.program-details') }}?program=anesthesia-technician">Learn More</a>
        <a class="btn btn-brand-red btn-sm flex-fill" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
      </div>
    </div>
  </article>
</div>
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="2">
  <article class="card-brand program-card d-flex flex-column">
    <div class="media-frame ratio-16x9">
      <span class="badge-brand badge-brand-red badge-float">Allied Health</span>
      <img src="{{ asset('frontend/assets/images/programs/radiology.jpg') }}" alt="Radiography Technology + F.Sc program at King TAS College" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-broadcast text-brand fs-5"></i>
        <h3 class="h6 mb-0">Radiography Technology + F.Sc</h3>
      </div>
      <p class="small text-soft flex-grow-1">Diagnostic imaging training combined with an F.Sc pathway, covering radiographic techniques, positioning and radiation safety.</p>
      <div class="meta-row mb-2">
        <span><i class="bi bi-clock me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="meta-row mb-3">
        <span><i class="bi bi-mortarboard me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-brand btn-sm flex-fill" href="{{ route('frontend.program-details') }}?program=radiography-technology">Learn More</a>
        <a class="btn btn-brand-red btn-sm flex-fill" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
      </div>
    </div>
  </article>
</div>
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="3">
  <article class="card-brand program-card d-flex flex-column">
    <div class="media-frame ratio-16x9">
      <span class="badge-brand badge-brand-red badge-float">Allied Health</span>
      <img src="{{ asset('frontend/assets/images/programs/lab.jpg') }}" alt="Medical Lab Technology + F.Sc program at King TAS College" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-eyedropper text-brand fs-5"></i>
        <h3 class="h6 mb-0">Medical Lab Technology + F.Sc</h3>
      </div>
      <p class="small text-soft flex-grow-1">Laboratory science training with an F.Sc pathway, covering sample handling, clinical testing and laboratory quality practices.</p>
      <div class="meta-row mb-2">
        <span><i class="bi bi-clock me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="meta-row mb-3">
        <span><i class="bi bi-mortarboard me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-brand btn-sm flex-fill" href="{{ route('frontend.program-details') }}?program=medical-lab-technology">Learn More</a>
        <a class="btn btn-brand-red btn-sm flex-fill" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
      </div>
    </div>
  </article>
</div>
</div>
  </div>
</section>
</div>
<div data-program-page="dispenser" data-title="Dispenser + F.Sc | King TAS College of Nursing &amp; Allied Health Sciences" hidden>
<header class="page-hero">
  <div class="container">
    <span class="eyebrow eyebrow-light">Allied Health Program</span>
    <h1 class="mt-3">Dispenser + F.Sc</h1>
    <p>Medicine dispensing training covering prescription handling, dosage awareness, storage practices and patient counselling basics.</p>
    <nav aria-label="Breadcrumb">
      <ol class="breadcrumb breadcrumb-brand">
        <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('frontend.all_program') }}">Programs</a></li>
        <li class="breadcrumb-item active" aria-current="page">Dispenser + F.Sc</li>
      </ol>
    </nav>
  </div>
</header>

<section class="section">
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-8">
        <div class="media-frame rounded-brand shadow-brand ratio-16x9 mb-4">
          <img src="{{ asset('frontend/assets/images/programs/pharmacy.jpg') }}" alt="Dispenser + F.Sc training at King TAS College" width="1200" height="675">
        </div>
        <article>
  <h2 class="h4">Overview</h2>
  <p>Medicine dispensing training covering prescription handling, dosage awareness, storage practices and patient counselling basics.</p>
  <p>Teaching combines classroom study with practical skill development so students build the professional habits expected
  in healthcare environments — accuracy, patient safety awareness, hygiene discipline and clear communication.</p>

  <h2 class="h4 mt-5">Who should apply</h2>
  <p>Students who want a healthcare career and are prepared for practical, discipline-focused study in a professional
  learning environment.</p>

  <div class="row g-3 mt-4">
    <div class="col-md-6"><div class="card-brand p-3 h-100"><h3 class="h6"><i class="bi bi-mortarboard text-brand me-2"></i>Eligibility</h3><p class="small mb-0">Details to be confirmed by Admissions Office</p></div></div>
    <div class="col-md-6"><div class="card-brand p-3 h-100"><h3 class="h6"><i class="bi bi-clock text-brand me-2"></i>Duration</h3><p class="small mb-0">Details to be confirmed by Admissions Office</p></div></div>
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
    <span class="badge badge-soft">Dispenser</span>
<span class="badge badge-soft">Pharmacy Assistant</span>
<span class="badge badge-soft">Hospital Dispensary Roles</span>
  </div>

  <h2 class="h4 mt-5">Skills students develop</h2>
  <div class="row g-3">
    <div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-heart-pulse text-brand"></i><span class="small">Patient-centred care</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-shield-check text-brand"></i><span class="small">Safety and infection control</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-chat-dots text-brand"></i><span class="small">Professional communication</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-clipboard-check text-brand"></i><span class="small">Accurate documentation</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-people text-brand"></i><span class="small">Teamwork in clinical settings</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-graph-up text-brand"></i><span class="small">Continuous professional learning</span></div></div>
  </div>

  <h2 class="h4 mt-5">Frequently asked questions</h2>
  <div class="accordion accordion-brand" id="programFaq-dispenser">
    <div class="accordion-item">
  <h3 class="accordion-header" id="pfH-dispenser-0">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pfC-dispenser-0" aria-expanded="false" aria-controls="pfC-dispenser-0">How can I apply for admission?</button>
  </h3>
  <div id="pfC-dispenser-0" class="accordion-collapse collapse" aria-labelledby="pfH-dispenser-0" data-bs-parent="#programFaq-dispenser">
    <div class="accordion-body">You can submit the online admission form on this website or visit the campus admissions office. The admissions team will guide you through document requirements and next steps.</div>
  </div>
</div>
<div class="accordion-item">
  <h3 class="accordion-header" id="pfH-dispenser-1">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pfC-dispenser-1" aria-expanded="false" aria-controls="pfC-dispenser-1">Are admissions currently open?</button>
  </h3>
  <div id="pfC-dispenser-1" class="accordion-collapse collapse" aria-labelledby="pfH-dispenser-1" data-bs-parent="#programFaq-dispenser">
    <div class="accordion-body">Admissions are open for session 2026–27 for selected nursing and allied health programs. Please contact the admissions office to confirm availability for a specific program.</div>
  </div>
</div>
<div class="accordion-item">
  <h3 class="accordion-header" id="pfH-dispenser-2">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pfC-dispenser-2" aria-expanded="false" aria-controls="pfC-dispenser-2">Is there an admission deadline?</button>
  </h3>
  <div id="pfC-dispenser-2" class="accordion-collapse collapse" aria-labelledby="pfH-dispenser-2" data-bs-parent="#programFaq-dispenser">
    <div class="accordion-body">Deadline information will be announced by the college administration. Please confirm current dates with the admissions office.</div>
  </div>
</div>
<div class="accordion-item">
  <h3 class="accordion-header" id="pfH-dispenser-3">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pfC-dispenser-3" aria-expanded="false" aria-controls="pfC-dispenser-3">Which programs does the college offer?</button>
  </h3>
  <div id="pfC-dispenser-3" class="accordion-collapse collapse" aria-labelledby="pfH-dispenser-3" data-bs-parent="#programFaq-dispenser">
    <div class="accordion-body">The college offers nursing programs including BSN Generic, Post RN, LHV, CMW and CNA, along with allied health programs such as Anesthesia Technician, Radiography Technology, Medical Lab Technology, Dental Technician, Operation Theater Technology, Dispenser and B-Category Pharmacy Technician.</div>
  </div>
</div>
  </div>

  <div class="demo-note mt-4"><i class="bi bi-info-circle me-1"></i>Program duration, eligibility and affiliation details
  are pending confirmation by the college administration and should be verified before publishing.</div>
</article>
      </div>
      <aside class="col-lg-4">
        <div class="card-brand p-4 sticky-side">
<h3 class="h6 mb-3">Program Information</h3>
<ul class="list-unstyled small mb-4">
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Program</span><strong>Dispenser + F.Sc</strong></li>
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Category</span><strong>Allied Health</strong></li>
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Duration</span><strong>Details to be confirmed by Admissions Office</strong></li>
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Eligibility</span><strong>Details to be confirmed by Admissions Office</strong></li>
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Admission status</span><strong class="text-brand-red">Admissions Open</strong></li>
  <li class="d-flex justify-content-between py-2"><span class="text-soft">How to apply</span><strong>Online form or campus visit</strong></li>
</ul>
<a class="btn btn-brand-red w-100 mb-2" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
<a class="btn btn-outline-brand w-100" href="{{ route('frontend.contact') }}">Talk to Admissions</a>
</div>
      </aside>
    </div>
  </div>
</section>

<section class="section bg-light-soft">
  <div class="container">
    <div class="section-header"><span class="eyebrow">Related</span><h2>Other programs in this category</h2></div>
    <div class="row g-4">
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="1">
  <article class="card-brand program-card d-flex flex-column">
    <div class="media-frame ratio-16x9">
      <span class="badge-brand badge-brand-red badge-float">Allied Health</span>
      <img src="{{ asset('frontend/assets/images/programs/ot.jpg') }}" alt="Anesthesia Technician program at King TAS College" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-lungs text-brand fs-5"></i>
        <h3 class="h6 mb-0">Anesthesia Technician</h3>
      </div>
      <p class="small text-soft flex-grow-1">Technical training in anesthesia equipment handling, operating room preparation and perioperative patient support.</p>
      <div class="meta-row mb-2">
        <span><i class="bi bi-clock me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="meta-row mb-3">
        <span><i class="bi bi-mortarboard me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-brand btn-sm flex-fill" href="{{ route('frontend.program-details') }}?program=anesthesia-technician">Learn More</a>
        <a class="btn btn-brand-red btn-sm flex-fill" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
      </div>
    </div>
  </article>
</div>
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="2">
  <article class="card-brand program-card d-flex flex-column">
    <div class="media-frame ratio-16x9">
      <span class="badge-brand badge-brand-red badge-float">Allied Health</span>
      <img src="{{ asset('frontend/assets/images/programs/radiology.jpg') }}" alt="Radiography Technology + F.Sc program at King TAS College" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-broadcast text-brand fs-5"></i>
        <h3 class="h6 mb-0">Radiography Technology + F.Sc</h3>
      </div>
      <p class="small text-soft flex-grow-1">Diagnostic imaging training combined with an F.Sc pathway, covering radiographic techniques, positioning and radiation safety.</p>
      <div class="meta-row mb-2">
        <span><i class="bi bi-clock me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="meta-row mb-3">
        <span><i class="bi bi-mortarboard me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-brand btn-sm flex-fill" href="{{ route('frontend.program-details') }}?program=radiography-technology">Learn More</a>
        <a class="btn btn-brand-red btn-sm flex-fill" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
      </div>
    </div>
  </article>
</div>
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="3">
  <article class="card-brand program-card d-flex flex-column">
    <div class="media-frame ratio-16x9">
      <span class="badge-brand badge-brand-red badge-float">Allied Health</span>
      <img src="{{ asset('frontend/assets/images/programs/lab.jpg') }}" alt="Medical Lab Technology + F.Sc program at King TAS College" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-eyedropper text-brand fs-5"></i>
        <h3 class="h6 mb-0">Medical Lab Technology + F.Sc</h3>
      </div>
      <p class="small text-soft flex-grow-1">Laboratory science training with an F.Sc pathway, covering sample handling, clinical testing and laboratory quality practices.</p>
      <div class="meta-row mb-2">
        <span><i class="bi bi-clock me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="meta-row mb-3">
        <span><i class="bi bi-mortarboard me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-brand btn-sm flex-fill" href="{{ route('frontend.program-details') }}?program=medical-lab-technology">Learn More</a>
        <a class="btn btn-brand-red btn-sm flex-fill" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
      </div>
    </div>
  </article>
</div>
</div>
  </div>
</section>
</div>
<div data-program-page="b-category-pharmacy-technician" data-title="B-Category Pharmacy Technician | King TAS College of Nursing &amp; Allied Health Sciences" hidden>
<header class="page-hero">
  <div class="container">
    <span class="eyebrow eyebrow-light">Allied Health Program</span>
    <h1 class="mt-3">B-Category Pharmacy Technician</h1>
    <p>Pharmacy technician training focused on medicine handling, inventory practices, dispensing support and pharmacy operations.</p>
    <nav aria-label="Breadcrumb">
      <ol class="breadcrumb breadcrumb-brand">
        <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('frontend.all_program') }}">Programs</a></li>
        <li class="breadcrumb-item active" aria-current="page">B-Category Pharmacy Technician</li>
      </ol>
    </nav>
  </div>
</header>

<section class="section">
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-8">
        <div class="media-frame rounded-brand shadow-brand ratio-16x9 mb-4">
          <img src="{{ asset('frontend/assets/images/programs/pharmacy.jpg') }}" alt="B-Category Pharmacy Technician training at King TAS College" width="1200" height="675">
        </div>
        <article>
  <h2 class="h4">Overview</h2>
  <p>Pharmacy technician training focused on medicine handling, inventory practices, dispensing support and pharmacy operations.</p>
  <p>Teaching combines classroom study with practical skill development so students build the professional habits expected
  in healthcare environments — accuracy, patient safety awareness, hygiene discipline and clear communication.</p>

  <h2 class="h4 mt-5">Who should apply</h2>
  <p>Students who want a healthcare career and are prepared for practical, discipline-focused study in a professional
  learning environment.</p>

  <div class="row g-3 mt-4">
    <div class="col-md-6"><div class="card-brand p-3 h-100"><h3 class="h6"><i class="bi bi-mortarboard text-brand me-2"></i>Eligibility</h3><p class="small mb-0">Details to be confirmed by Admissions Office</p></div></div>
    <div class="col-md-6"><div class="card-brand p-3 h-100"><h3 class="h6"><i class="bi bi-clock text-brand me-2"></i>Duration</h3><p class="small mb-0">Details to be confirmed by Admissions Office</p></div></div>
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
    <span class="badge badge-soft">Pharmacy Technician</span>
<span class="badge badge-soft">Retail Pharmacy Roles</span>
<span class="badge badge-soft">Hospital Pharmacy Support</span>
  </div>

  <h2 class="h4 mt-5">Skills students develop</h2>
  <div class="row g-3">
    <div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-heart-pulse text-brand"></i><span class="small">Patient-centred care</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-shield-check text-brand"></i><span class="small">Safety and infection control</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-chat-dots text-brand"></i><span class="small">Professional communication</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-clipboard-check text-brand"></i><span class="small">Accurate documentation</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-people text-brand"></i><span class="small">Teamwork in clinical settings</span></div></div>
<div class="col-sm-6"><div class="d-flex gap-2 align-items-center"><i class="bi bi-graph-up text-brand"></i><span class="small">Continuous professional learning</span></div></div>
  </div>

  <h2 class="h4 mt-5">Frequently asked questions</h2>
  <div class="accordion accordion-brand" id="programFaq-b-category-pharmacy-technician">
    <div class="accordion-item">
  <h3 class="accordion-header" id="pfH-b-category-pharmacy-technician-0">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pfC-b-category-pharmacy-technician-0" aria-expanded="false" aria-controls="pfC-b-category-pharmacy-technician-0">How can I apply for admission?</button>
  </h3>
  <div id="pfC-b-category-pharmacy-technician-0" class="accordion-collapse collapse" aria-labelledby="pfH-b-category-pharmacy-technician-0" data-bs-parent="#programFaq-b-category-pharmacy-technician">
    <div class="accordion-body">You can submit the online admission form on this website or visit the campus admissions office. The admissions team will guide you through document requirements and next steps.</div>
  </div>
</div>
<div class="accordion-item">
  <h3 class="accordion-header" id="pfH-b-category-pharmacy-technician-1">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pfC-b-category-pharmacy-technician-1" aria-expanded="false" aria-controls="pfC-b-category-pharmacy-technician-1">Are admissions currently open?</button>
  </h3>
  <div id="pfC-b-category-pharmacy-technician-1" class="accordion-collapse collapse" aria-labelledby="pfH-b-category-pharmacy-technician-1" data-bs-parent="#programFaq-b-category-pharmacy-technician">
    <div class="accordion-body">Admissions are open for session 2026–27 for selected nursing and allied health programs. Please contact the admissions office to confirm availability for a specific program.</div>
  </div>
</div>
<div class="accordion-item">
  <h3 class="accordion-header" id="pfH-b-category-pharmacy-technician-2">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pfC-b-category-pharmacy-technician-2" aria-expanded="false" aria-controls="pfC-b-category-pharmacy-technician-2">Is there an admission deadline?</button>
  </h3>
  <div id="pfC-b-category-pharmacy-technician-2" class="accordion-collapse collapse" aria-labelledby="pfH-b-category-pharmacy-technician-2" data-bs-parent="#programFaq-b-category-pharmacy-technician">
    <div class="accordion-body">Deadline information will be announced by the college administration. Please confirm current dates with the admissions office.</div>
  </div>
</div>
<div class="accordion-item">
  <h3 class="accordion-header" id="pfH-b-category-pharmacy-technician-3">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pfC-b-category-pharmacy-technician-3" aria-expanded="false" aria-controls="pfC-b-category-pharmacy-technician-3">Which programs does the college offer?</button>
  </h3>
  <div id="pfC-b-category-pharmacy-technician-3" class="accordion-collapse collapse" aria-labelledby="pfH-b-category-pharmacy-technician-3" data-bs-parent="#programFaq-b-category-pharmacy-technician">
    <div class="accordion-body">The college offers nursing programs including BSN Generic, Post RN, LHV, CMW and CNA, along with allied health programs such as Anesthesia Technician, Radiography Technology, Medical Lab Technology, Dental Technician, Operation Theater Technology, Dispenser and B-Category Pharmacy Technician.</div>
  </div>
</div>
  </div>

  <div class="demo-note mt-4"><i class="bi bi-info-circle me-1"></i>Program duration, eligibility and affiliation details
  are pending confirmation by the college administration and should be verified before publishing.</div>
</article>
      </div>
      <aside class="col-lg-4">
        <div class="card-brand p-4 sticky-side">
<h3 class="h6 mb-3">Program Information</h3>
<ul class="list-unstyled small mb-4">
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Program</span><strong>B-Category Pharmacy Technician</strong></li>
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Category</span><strong>Allied Health</strong></li>
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Duration</span><strong>Details to be confirmed by Admissions Office</strong></li>
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Eligibility</span><strong>Details to be confirmed by Admissions Office</strong></li>
  <li class="d-flex justify-content-between border-bottom py-2"><span class="text-soft">Admission status</span><strong class="text-brand-red">Admissions Open</strong></li>
  <li class="d-flex justify-content-between py-2"><span class="text-soft">How to apply</span><strong>Online form or campus visit</strong></li>
</ul>
<a class="btn btn-brand-red w-100 mb-2" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
<a class="btn btn-outline-brand w-100" href="{{ route('frontend.contact') }}">Talk to Admissions</a>
</div>
      </aside>
    </div>
  </div>
</section>

<section class="section bg-light-soft">
  <div class="container">
    <div class="section-header"><span class="eyebrow">Related</span><h2>Other programs in this category</h2></div>
    <div class="row g-4">
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="1">
  <article class="card-brand program-card d-flex flex-column">
    <div class="media-frame ratio-16x9">
      <span class="badge-brand badge-brand-red badge-float">Allied Health</span>
      <img src="{{ asset('frontend/assets/images/programs/ot.jpg') }}" alt="Anesthesia Technician program at King TAS College" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-lungs text-brand fs-5"></i>
        <h3 class="h6 mb-0">Anesthesia Technician</h3>
      </div>
      <p class="small text-soft flex-grow-1">Technical training in anesthesia equipment handling, operating room preparation and perioperative patient support.</p>
      <div class="meta-row mb-2">
        <span><i class="bi bi-clock me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="meta-row mb-3">
        <span><i class="bi bi-mortarboard me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-brand btn-sm flex-fill" href="{{ route('frontend.program-details') }}?program=anesthesia-technician">Learn More</a>
        <a class="btn btn-brand-red btn-sm flex-fill" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
      </div>
    </div>
  </article>
</div>
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="2">
  <article class="card-brand program-card d-flex flex-column">
    <div class="media-frame ratio-16x9">
      <span class="badge-brand badge-brand-red badge-float">Allied Health</span>
      <img src="{{ asset('frontend/assets/images/programs/radiology.jpg') }}" alt="Radiography Technology + F.Sc program at King TAS College" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-broadcast text-brand fs-5"></i>
        <h3 class="h6 mb-0">Radiography Technology + F.Sc</h3>
      </div>
      <p class="small text-soft flex-grow-1">Diagnostic imaging training combined with an F.Sc pathway, covering radiographic techniques, positioning and radiation safety.</p>
      <div class="meta-row mb-2">
        <span><i class="bi bi-clock me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="meta-row mb-3">
        <span><i class="bi bi-mortarboard me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-brand btn-sm flex-fill" href="{{ route('frontend.program-details') }}?program=radiography-technology">Learn More</a>
        <a class="btn btn-brand-red btn-sm flex-fill" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
      </div>
    </div>
  </article>
</div>
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="3">
  <article class="card-brand program-card d-flex flex-column">
    <div class="media-frame ratio-16x9">
      <span class="badge-brand badge-brand-red badge-float">Allied Health</span>
      <img src="{{ asset('frontend/assets/images/programs/lab.jpg') }}" alt="Medical Lab Technology + F.Sc program at King TAS College" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-eyedropper text-brand fs-5"></i>
        <h3 class="h6 mb-0">Medical Lab Technology + F.Sc</h3>
      </div>
      <p class="small text-soft flex-grow-1">Laboratory science training with an F.Sc pathway, covering sample handling, clinical testing and laboratory quality practices.</p>
      <div class="meta-row mb-2">
        <span><i class="bi bi-clock me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="meta-row mb-3">
        <span><i class="bi bi-mortarboard me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-brand btn-sm flex-fill" href="{{ route('frontend.program-details') }}?program=medical-lab-technology">Learn More</a>
        <a class="btn btn-brand-red btn-sm flex-fill" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
      </div>
    </div>
  </article>
</div>
</div>
  </div>
</section>
</div>

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
