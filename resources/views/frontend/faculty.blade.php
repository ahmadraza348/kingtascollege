@extends('frontend.layouts.layout')
@section('title', 'Faculty & Staff | King TAS College of Nursing & Allied Health Sciences')
@section('description', 'Meet the nursing, allied health, clinical and administrative team at King TAS College, Gojra. Faculty profiles are provided by the college administration.')
@section('content')
<main id="main">
<header class="page-hero">
  <div class="container">
    <h1>Faculty &amp; staff</h1>
    <p>The teaching and administrative team supporting nursing and allied health students at King TAS College.</p>
    <nav aria-label="Breadcrumb">
      <ol class="breadcrumb breadcrumb-brand"><li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li><li class="breadcrumb-item active" aria-current="page">Faculty</li></ol>
    </nav>
  </div>
</header>
<section class="section">
  <div class="container">
    <div class="demo-note mb-4"><i class="bi bi-info-circle me-1"></i>Placeholder faculty records — no real staff identities are
    shown. The college administration will supply verified profiles, photographs and qualifications.</div>
    <div class="d-flex flex-wrap gap-2 mb-4" id="facultyFilters" role="group" aria-label="Faculty filters">
      <button class="filter-chip active" data-filter="all">All</button>
      <button class="filter-chip" data-filter="Nursing">Nursing</button>
      <button class="filter-chip" data-filter="Allied Health">Allied Health</button>
      <button class="filter-chip" data-filter="Clinical">Clinical</button>
      <button class="filter-chip" data-filter="Administration">Administration</button>
    </div>
    <div class="row g-4" id="facultyGrid">
<div class="col-sm-6 col-lg-3" data-reveal data-reveal-delay="1" data-item data-category="Administration">
  <article class="card-brand faculty-card text-center h-100">
    <div class="media-frame"><i class="bi bi-person-badge faculty-avatar" aria-hidden="true"></i></div>
    <div class="p-3">
      <h3 class="h6 mb-1">Faculty Member Name</h3>
      <p class="small text-brand fw-600 mb-1">Principal</p>
      <p class="small text-soft mb-1">Qualification to be provided</p>
      <span class="badge badge-soft mb-2">Administration</span>
      <p class="small text-soft mb-1">Profile details will be provided by the college administration.</p>
      <p class="small mb-0"><i class="bi bi-stars text-brand me-1"></i>Institutional leadership</p>
    </div>
  </article>
</div>
<div class="col-sm-6 col-lg-3" data-reveal data-reveal-delay="2" data-item data-category="Nursing">
  <article class="card-brand faculty-card text-center h-100">
    <div class="media-frame"><i class="bi bi-person-badge faculty-avatar" aria-hidden="true"></i></div>
    <div class="p-3">
      <h3 class="h6 mb-1">Faculty Member Name</h3>
      <p class="small text-brand fw-600 mb-1">Nursing Instructor</p>
      <p class="small text-soft mb-1">Qualification to be provided</p>
      <span class="badge badge-soft mb-2">Nursing</span>
      <p class="small text-soft mb-1">Profile details will be provided by the college administration.</p>
      <p class="small mb-0"><i class="bi bi-stars text-brand me-1"></i>Fundamentals of nursing</p>
    </div>
  </article>
</div>
<div class="col-sm-6 col-lg-3" data-reveal data-reveal-delay="3" data-item data-category="Clinical">
  <article class="card-brand faculty-card text-center h-100">
    <div class="media-frame"><i class="bi bi-person-badge faculty-avatar" aria-hidden="true"></i></div>
    <div class="p-3">
      <h3 class="h6 mb-1">Faculty Member Name</h3>
      <p class="small text-brand fw-600 mb-1">Clinical Instructor</p>
      <p class="small text-soft mb-1">Qualification to be provided</p>
      <span class="badge badge-soft mb-2">Clinical</span>
      <p class="small text-soft mb-1">Profile details will be provided by the college administration.</p>
      <p class="small mb-0"><i class="bi bi-stars text-brand me-1"></i>Clinical skills supervision</p>
    </div>
  </article>
</div>
<div class="col-sm-6 col-lg-3" data-reveal data-reveal-delay="4" data-item data-category="Nursing">
  <article class="card-brand faculty-card text-center h-100">
    <div class="media-frame"><i class="bi bi-person-badge faculty-avatar" aria-hidden="true"></i></div>
    <div class="p-3">
      <h3 class="h6 mb-1">Faculty Member Name</h3>
      <p class="small text-brand fw-600 mb-1">Midwifery Instructor</p>
      <p class="small text-soft mb-1">Qualification to be provided</p>
      <span class="badge badge-soft mb-2">Nursing</span>
      <p class="small text-soft mb-1">Profile details will be provided by the college administration.</p>
      <p class="small mb-0"><i class="bi bi-stars text-brand me-1"></i>Maternal and newborn care</p>
    </div>
  </article>
</div>
<div class="col-sm-6 col-lg-3" data-reveal data-reveal-delay="1" data-item data-category="Allied Health">
  <article class="card-brand faculty-card text-center h-100">
    <div class="media-frame"><i class="bi bi-person-badge faculty-avatar" aria-hidden="true"></i></div>
    <div class="p-3">
      <h3 class="h6 mb-1">Faculty Member Name</h3>
      <p class="small text-brand fw-600 mb-1">Medical Lab Instructor</p>
      <p class="small text-soft mb-1">Qualification to be provided</p>
      <span class="badge badge-soft mb-2">Allied Health</span>
      <p class="small text-soft mb-1">Profile details will be provided by the college administration.</p>
      <p class="small mb-0"><i class="bi bi-stars text-brand me-1"></i>Laboratory techniques</p>
    </div>
  </article>
</div>
<div class="col-sm-6 col-lg-3" data-reveal data-reveal-delay="2" data-item data-category="Allied Health">
  <article class="card-brand faculty-card text-center h-100">
    <div class="media-frame"><i class="bi bi-person-badge faculty-avatar" aria-hidden="true"></i></div>
    <div class="p-3">
      <h3 class="h6 mb-1">Faculty Member Name</h3>
      <p class="small text-brand fw-600 mb-1">Radiography Instructor</p>
      <p class="small text-soft mb-1">Qualification to be provided</p>
      <span class="badge badge-soft mb-2">Allied Health</span>
      <p class="small text-soft mb-1">Profile details will be provided by the college administration.</p>
      <p class="small mb-0"><i class="bi bi-stars text-brand me-1"></i>Diagnostic imaging</p>
    </div>
  </article>
</div>
<div class="col-sm-6 col-lg-3" data-reveal data-reveal-delay="3" data-item data-category="Administration">
  <article class="card-brand faculty-card text-center h-100">
    <div class="media-frame"><i class="bi bi-person-badge faculty-avatar" aria-hidden="true"></i></div>
    <div class="p-3">
      <h3 class="h6 mb-1">Faculty Member Name</h3>
      <p class="small text-brand fw-600 mb-1">Admissions Officer</p>
      <p class="small text-soft mb-1">Qualification to be provided</p>
      <span class="badge badge-soft mb-2">Administration</span>
      <p class="small text-soft mb-1">Profile details will be provided by the college administration.</p>
      <p class="small mb-0"><i class="bi bi-stars text-brand me-1"></i>Admissions guidance</p>
    </div>
  </article>
</div>
<div class="col-sm-6 col-lg-3" data-reveal data-reveal-delay="4" data-item data-category="Clinical">
  <article class="card-brand faculty-card text-center h-100">
    <div class="media-frame"><i class="bi bi-person-badge faculty-avatar" aria-hidden="true"></i></div>
    <div class="p-3">
      <h3 class="h6 mb-1">Faculty Member Name</h3>
      <p class="small text-brand fw-600 mb-1">Senior Clinical Supervisor</p>
      <p class="small text-soft mb-1">Qualification to be provided</p>
      <span class="badge badge-soft mb-2">Clinical</span>
      <p class="small text-soft mb-1">Profile details will be provided by the college administration.</p>
      <p class="small mb-0"><i class="bi bi-stars text-brand me-1"></i>Ward-based learning</p>
    </div>
  </article>
</div>
<div class="col-12 d-none" data-empty><div class="empty-state">
  <i class="bi bi-search d-block mb-2"></i>
  <p class="mb-0">No faculty records in this category yet.</p>
</div></div>
</div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="cta-band text-center" data-reveal>
      <span class="eyebrow eyebrow-light mb-3">Admissions Open — Session 2026–27</span>
      <h2>Begin your healthcare career</h2>
      <p class="mb-4">Choose the right program and take the first step toward your professional healthcare journey.</p>
      <div class="d-flex flex-wrap justify-content-center gap-2">
        <a class="btn btn-brand-red btn-lg" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
        <a class="btn btn-outline-light-brand btn-lg" href="{{ route('frontend.contact') }}">Talk to Admissions</a>
      </div>
    </div>
  </div>
</section></main>
@endsection
