@extends('frontend.layouts.layout')
@section('title', 'Notice Board | King TAS College of Nursing & Allied Health Sciences')
@section('description', 'Student notices from King TAS College, Gojra — admissions announcements, class schedules, examination notices and general updates.')
@section('content')
<main id="main">
<header class="page-hero">
  <div class="container">
    <h1>Notice board</h1>
    <p>Official notices for students: admissions, class schedules, examinations and general announcements.</p>
    <nav aria-label="Breadcrumb">
      <ol class="breadcrumb breadcrumb-brand"><li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li><li class="breadcrumb-item active" aria-current="page">Notices</li></ol>
    </nav>
  </div>
</header>
<section class="section">
  <div class="container">
    <div class="d-flex flex-wrap gap-2 mb-4" id="noticeFilters" role="group" aria-label="Notice filters">
      <button class="filter-chip active" data-filter="all">All</button>
      <button class="filter-chip" data-filter="Admissions">Admissions</button>
      <button class="filter-chip" data-filter="Academic">Academic</button>
      <button class="filter-chip" data-filter="Examination">Examination</button>
      <button class="filter-chip" data-filter="General">General</button>
    </div>
    <ul class="list-unstyled mb-0" id="noticeList">
<li class="notice-row mb-2" data-reveal data-item data-category="Admissions">
  <i class="bi bi-file-earmark-pdf file-icon" aria-hidden="true"></i>
  <div class="flex-grow-1">
    <p class="fw-600 mb-0">Admissions announcement — session 2026–27</p>
    <p class="small text-soft mb-0">
      <span class="badge badge-soft me-2">Admissions</span>
      <i class="bi bi-calendar3 me-1"></i>10 Aug 2026
    </p>
  </div>
  <a class="btn btn-outline-brand btn-sm" href="#" onclick="return false;" aria-label="View notice: Admissions announcement — session 2026–27">
    <i class="bi bi-eye me-1"></i>View
  </a>
</li>
<li class="notice-row mb-2" data-reveal data-item data-category="Academic">
  <i class="bi bi-file-earmark-pdf file-icon" aria-hidden="true"></i>
  <div class="flex-grow-1">
    <p class="fw-600 mb-0">Class schedule for theory and practical sessions</p>
    <p class="small text-soft mb-0">
      <span class="badge badge-soft me-2">Academic</span>
      <i class="bi bi-calendar3 me-1"></i>4 Aug 2026
    </p>
  </div>
  <a class="btn btn-outline-brand btn-sm" href="#" onclick="return false;" aria-label="View notice: Class schedule for theory and practical sessions">
    <i class="bi bi-eye me-1"></i>View
  </a>
</li>
<li class="notice-row mb-2" data-reveal data-item data-category="Examination">
  <i class="bi bi-file-earmark-pdf file-icon" aria-hidden="true"></i>
  <div class="flex-grow-1">
    <p class="fw-600 mb-0">Examination notice — internal assessments</p>
    <p class="small text-soft mb-0">
      <span class="badge badge-soft me-2">Examination</span>
      <i class="bi bi-calendar3 me-1"></i>25 Jul 2026
    </p>
  </div>
  <a class="btn btn-outline-brand btn-sm" href="#" onclick="return false;" aria-label="View notice: Examination notice — internal assessments">
    <i class="bi bi-eye me-1"></i>View
  </a>
</li>
<li class="notice-row mb-2" data-reveal data-item data-category="Admissions">
  <i class="bi bi-file-earmark-pdf file-icon" aria-hidden="true"></i>
  <div class="flex-grow-1">
    <p class="fw-600 mb-0">Merit list publication procedure</p>
    <p class="small text-soft mb-0">
      <span class="badge badge-soft me-2">Admissions</span>
      <i class="bi bi-calendar3 me-1"></i>18 Jul 2026
    </p>
  </div>
  <a class="btn btn-outline-brand btn-sm" href="#" onclick="return false;" aria-label="View notice: Merit list publication procedure">
    <i class="bi bi-eye me-1"></i>View
  </a>
</li>
<li class="notice-row mb-2" data-reveal data-item data-category="General">
  <i class="bi bi-file-earmark-pdf file-icon" aria-hidden="true"></i>
  <div class="flex-grow-1">
    <p class="fw-600 mb-0">Holiday notice</p>
    <p class="small text-soft mb-0">
      <span class="badge badge-soft me-2">General</span>
      <i class="bi bi-calendar3 me-1"></i>5 Jul 2026
    </p>
  </div>
  <a class="btn btn-outline-brand btn-sm" href="#" onclick="return false;" aria-label="View notice: Holiday notice">
    <i class="bi bi-eye me-1"></i>View
  </a>
</li>
<li class="notice-row mb-2" data-reveal data-item data-category="General">
  <i class="bi bi-file-earmark-pdf file-icon" aria-hidden="true"></i>
  <div class="flex-grow-1">
    <p class="fw-600 mb-0">Important student announcement — uniform and ID cards</p>
    <p class="small text-soft mb-0">
      <span class="badge badge-soft me-2">General</span>
      <i class="bi bi-calendar3 me-1"></i>22 Jun 2026
    </p>
  </div>
  <a class="btn btn-outline-brand btn-sm" href="#" onclick="return false;" aria-label="View notice: Important student announcement — uniform and ID cards">
    <i class="bi bi-eye me-1"></i>View
  </a>
</li>
<li class="empty-state d-none" data-empty><i class="bi bi-inbox d-block mb-2"></i>No notices in this category yet.</li>
</ul>
    <p class="placeholder-note mt-4 mb-0">Sample notices with placeholder documents — attach official PDF files before publishing.</p>
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
