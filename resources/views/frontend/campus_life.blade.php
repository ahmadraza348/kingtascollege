@extends('frontend.layouts.layout')
@section('title', 'Campus & Student Life | King TAS College of Nursing & Allied Health Sciences')
@section('description', 'Campus environment, classrooms, laboratories, skills training, seminars, workshops and student activities at King TAS College, Gojra.')
@section('content')
<main id="main">
<header class="page-hero">
  <div class="container">
    <h1>Campus &amp; student life</h1>
    <p>Learning, activities and student experience at King TAS College — inside classrooms, laboratories and beyond.</p>
    <nav aria-label="Breadcrumb">
      <ol class="breadcrumb breadcrumb-brand"><li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li><li class="breadcrumb-item active" aria-current="page">Campus Life</li></ol>
    </nav>
  </div>
</header>
<section class="section">
  <div class="container">
    <div class="row g-5 align-items-center mb-5">
      <div class="col-lg-7" data-reveal="left"><div class="media-frame rounded-brand shadow-brand ratio-16x9">
        <img src="{{ asset('frontend/assets/images/campus/classroom.jpg') }}" alt="Students in a classroom session" loading="lazy" width="1200" height="800"></div></div>
      <div class="col-lg-5" data-reveal="right">
        <span class="eyebrow">Everyday learning</span>
        <h2 class="mt-3">A disciplined, supportive study environment</h2>
        <p class="lead-text">Students move between theory sessions, skills practice and group learning, guided by instructors
        who set clear professional expectations.</p>
      </div>
    </div>
    <div class="row g-5 align-items-center">
      <div class="col-lg-7 order-lg-2" data-reveal="right"><div class="media-frame rounded-brand shadow-brand ratio-16x9">
        <img src="{{ asset('frontend/assets/images/hero/hero-nursing.jpg') }}" alt="Students practising nursing skills" loading="lazy" width="1920" height="1080"></div></div>
      <div class="col-lg-5" data-reveal="left">
        <span class="eyebrow">Skills practice</span>
        <h2 class="mt-3">Practice that builds professional habits</h2>
        <p class="lead-text">Skills sessions give students repeated, supervised opportunities to build accuracy and confidence
        before working with patients.</p>
      </div>
    </div>
  </div>
</section>

<section class="section bg-light-soft">
  <div class="container">
    <div class="section-header"><span class="eyebrow">Student life</span><h2>Activities beyond the classroom</h2>
      <p>Activities listed here are examples of the college's student programme and will be updated with actual events.</p></div>
    <div class="row g-4">
      
      <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="1">
        <div class="card-brand p-4 h-100">
          <span class="icon-badge mb-3"><i class="bi bi-mic"></i></span>
          <h3 class="h6">Seminars</h3>
          <p class="small text-soft mb-0">Academic and healthcare awareness seminars for students.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="2">
        <div class="card-brand p-4 h-100">
          <span class="icon-badge mb-3"><i class="bi bi-tools"></i></span>
          <h3 class="h6">Workshops</h3>
          <p class="small text-soft mb-0">Practical workshops focused on clinical and technical skills.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="3">
        <div class="card-brand p-4 h-100">
          <span class="icon-badge mb-3"><i class="bi bi-heart"></i></span>
          <h3 class="h6">Health awareness activities</h3>
          <p class="small text-soft mb-0">Student participation in community health awareness efforts.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="1">
        <div class="card-brand p-4 h-100">
          <span class="icon-badge mb-3"><i class="bi bi-people"></i></span>
          <h3 class="h6">Student interaction</h3>
          <p class="small text-soft mb-0">Group learning, peer support and team-based activities.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="2">
        <div class="card-brand p-4 h-100">
          <span class="icon-badge mb-3"><i class="bi bi-stars"></i></span>
          <h3 class="h6">Student achievements</h3>
          <p class="small text-soft mb-0">Recognition of academic and practical achievement.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="3">
        <div class="card-brand p-4 h-100">
          <span class="icon-badge mb-3"><i class="bi bi-globe"></i></span>
          <h3 class="h6">Community activities</h3>
          <p class="small text-soft mb-0">Supervised community-focused healthcare education activities.</p>
        </div>
      </div>
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
