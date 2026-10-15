@extends('frontend.layouts.layout')
@section('title', 'About Us | King TAS College of Nursing & Allied Health Sciences')
@section('description', 'Learn about King TAS College of Nursing & Allied Health Sciences in Gojra — our approach to nursing and allied health education, mission, vision and values.')
@section('content')
<main id="main">
<header class="page-hero">
  <div class="container">
    <h1>About the college</h1>
    <p>King TAS College of Nursing &amp; Allied Health Sciences focuses on healthcare education and professional student development in Gojra, District Toba Tek Singh.</p>
    <nav aria-label="Breadcrumb">
      <ol class="breadcrumb breadcrumb-brand"><li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li><li class="breadcrumb-item active" aria-current="page">About</li></ol>
    </nav>
  </div>
</header>
<section class="section">
  <div class="container">
    <div class="row g-5 align-items-center">
      <div class="col-lg-6" data-reveal="left">
        <div class="media-frame rounded-brand shadow-brand ratio-4x3">
          <img src="{{ asset('frontend/assets/images/campus/campus.jpg') }}" alt="College campus exterior" loading="lazy" width="1280" height="900">
        </div>
      </div>
      <div class="col-lg-6" data-reveal="right">
        <span class="eyebrow">Who we are</span>
        <h2 class="mt-3">Healthcare education with a practical focus</h2>
        <p class="lead-text">The college offers nursing and allied health sciences programs designed to prepare students for
        professional healthcare environments — combining subject knowledge with supervised practical learning.</p>
        <p>Teaching emphasises patient safety, professional conduct and the everyday skills that healthcare employers expect,
        so graduates can step into clinical and technical roles with confidence.</p>
        <ul class="list-check">
          <li><i class="bi bi-check-circle-fill"></i><span>Nursing and allied health programs under one campus</span></li>
          <li><i class="bi bi-check-circle-fill"></i><span>Practical skill development alongside theory</span></li>
          <li><i class="bi bi-check-circle-fill"></i><span>Admissions guidance for students and families</span></li>
        </ul>
      </div>
    </div>
  </div>
</section>

<section class="section bg-light-soft">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-4" data-reveal><div class="card-brand p-4 h-100"><span class="icon-badge mb-3"><i class="bi bi-bullseye"></i></span>
        <h2 class="h5">Mission</h2><p class="small text-soft mb-0">To deliver healthcare education that develops competent,
        responsible and compassionate nursing and allied health professionals.</p></div></div>
      <div class="col-lg-4" data-reveal data-reveal-delay="2"><div class="card-brand p-4 h-100"><span class="icon-badge mb-3"><i class="bi bi-eye"></i></span>
        <h2 class="h5">Vision</h2><p class="small text-soft mb-0">To be a trusted regional institute for nursing and allied health
        learning, recognised for practical training and professional standards.</p></div></div>
      <div class="col-lg-4" data-reveal data-reveal-delay="3"><div class="card-brand p-4 h-100"><span class="icon-badge red mb-3"><i class="bi bi-heart"></i></span>
        <h2 class="h5">Core values</h2>
        <ul class="list-check small mb-0">
          <li><i class="bi bi-dot"></i><span>Professionalism &amp; Integrity</span></li>
          <li><i class="bi bi-dot"></i><span>Compassion &amp; Patient safety</span></li>
          <li><i class="bi bi-dot"></i><span>Excellence &amp; Responsibility</span></li>
          <li><i class="bi bi-dot"></i><span>Lifelong learning</span></li>
        </ul></div></div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-header"><span class="eyebrow">Our approach</span><h2>How students learn here</h2>
      <p>Structured theory, supervised practice and professional habits developed from the first term.</p></div>
    <div class="row g-4">
      
      <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="1">
        <div class="card-brand p-4 h-100">
          <span class="icon-badge mb-3"><i class="bi bi-journal-text"></i></span>
          <h3 class="h6">Structured theory</h3>
          <p class="small text-soft mb-0">Subject knowledge delivered through organised classroom sessions.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="2">
        <div class="card-brand p-4 h-100">
          <span class="icon-badge mb-3"><i class="bi bi-clipboard2-pulse"></i></span>
          <h3 class="h6">Supervised practice</h3>
          <p class="small text-soft mb-0">Skills sessions where students rehearse procedures safely.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="3">
        <div class="card-brand p-4 h-100">
          <span class="icon-badge mb-3"><i class="bi bi-shield-check"></i></span>
          <h3 class="h6">Professional standards</h3>
          <p class="small text-soft mb-0">Hygiene, safety and ethical conduct emphasised throughout.</p>
        </div>
      </div>
    </div>
  </div>
</section>

</main>
@endsection
