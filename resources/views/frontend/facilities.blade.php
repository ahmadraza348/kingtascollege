@extends('frontend.layouts.layout')
@section('title', 'Facilities | King TAS College of Nursing & Allied Health Sciences')
@section('description', 'Skills laboratory, science laboratories, classrooms, library, digital learning and student areas at King TAS College, Gojra.')
@section('content')
<main id="main">
<header class="page-hero">
  <div class="container">
    <h1>Campus facilities</h1>
    <p>Learning spaces that support nursing and allied health study, from skills practice to independent academic work.</p>
    <nav aria-label="Breadcrumb">
      <ol class="breadcrumb breadcrumb-brand"><li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li><li class="breadcrumb-item active" aria-current="page">Facilities</li></ol>
    </nav>
  </div>
</header>
<section class="section">
  <div class="container">
    <div class="row g-4">
      
      <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="1">
        <div class="card-brand p-4 h-100">
          <span class="icon-badge mb-3"><i class="bi bi-hospital"></i></span>
          <h3 class="h6">Skills laboratory</h3>
          <p class="small text-soft mb-0">A nursing skills practice environment where students rehearse core procedures under supervision.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="2">
        <div class="card-brand p-4 h-100">
          <span class="icon-badge mb-3"><i class="bi bi-eyedropper"></i></span>
          <h3 class="h6">Science laboratories</h3>
          <p class="small text-soft mb-0">Laboratory spaces supporting practical learning for allied health subjects.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="3">
        <div class="card-brand p-4 h-100">
          <span class="icon-badge mb-3"><i class="bi bi-laptop"></i></span>
          <h3 class="h6">Computer &amp; digital learning</h3>
          <p class="small text-soft mb-0">Technology-enabled academic learning and digital study resources.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="1">
        <div class="card-brand p-4 h-100">
          <span class="icon-badge mb-3"><i class="bi bi-book"></i></span>
          <h3 class="h6">Library</h3>
          <p class="small text-soft mb-0">Academic resources and quiet space for self-study and revision.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="2">
        <div class="card-brand p-4 h-100">
          <span class="icon-badge mb-3"><i class="bi bi-easel"></i></span>
          <h3 class="h6">Classrooms</h3>
          <p class="small text-soft mb-0">Professional teaching environments for theory sessions and discussion.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="3">
        <div class="card-brand p-4 h-100">
          <span class="icon-badge mb-3"><i class="bi bi-heart-pulse"></i></span>
          <h3 class="h6">Clinical practice</h3>
          <p class="small text-soft mb-0">Practical healthcare skill development in supervised settings.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="1">
        <div class="card-brand p-4 h-100">
          <span class="icon-badge mb-3"><i class="bi bi-cup-hot"></i></span>
          <h3 class="h6">Student areas</h3>
          <p class="small text-soft mb-0">Comfortable spaces for students between academic sessions.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="2">
        <div class="card-brand p-4 h-100">
          <span class="icon-badge mb-3"><i class="bi bi-shield-check"></i></span>
          <h3 class="h6">Safe environment</h3>
          <p class="small text-soft mb-0">Emphasis on hygiene, discipline and safety across the campus.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="3">
        <div class="card-brand p-4 h-100">
          <span class="icon-badge mb-3"><i class="bi bi-people"></i></span>
          <h3 class="h6">Student support</h3>
          <p class="small text-soft mb-0">Guidance from academic and administrative staff throughout the session.</p>
        </div>
      </div>
    </div>
    <p class="placeholder-note text-center mt-4 mb-0">Facilities listed during development are indicative. Availability will be
    confirmed and updated by the college administration.</p>
  </div>
</section>

<section class="section bg-light-soft">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-6" data-reveal="left"><div class="media-frame rounded-brand shadow-brand ratio-4x3">
        <img src="{{ asset('frontend/assets/images/campus/classroom.jpg') }}" alt="Classroom at the college" loading="lazy" width="1200" height="800"></div></div>
      <div class="col-lg-6" data-reveal="right"><div class="media-frame rounded-brand shadow-brand ratio-4x3">
        <img src="{{ asset('frontend/assets/images/programs/lab.jpg') }}" alt="Medical laboratory learning space" loading="lazy" width="1200" height="800"></div></div>
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
</section>
</main>
@endsection
