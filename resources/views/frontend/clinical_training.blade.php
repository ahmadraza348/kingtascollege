@extends('frontend.layouts.layout')
@section('title', 'Clinical Training | King TAS College of Nursing & Allied Health Sciences')
@section('description', 'Supervised clinical training in patient care, clinical procedures, laboratory skills, infection control and professional communication at King TAS College, Gojra.')
@section('content')
<main id="main">
<header class="page-hero">
  <div class="container">
    <h1>Clinical training</h1>
    <p>Practical, supervised learning that builds the patient-care skills expected in professional healthcare settings.</p>
    <nav aria-label="Breadcrumb">
      <ol class="breadcrumb breadcrumb-brand"><li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li><li class="breadcrumb-item active" aria-current="page">Clinical Training</li></ol>
    </nav>
  </div>
</header>
<section class="section">
  <div class="container">
    <div class="row g-5 align-items-center">
      <div class="col-lg-6" data-reveal="left"><div class="media-frame rounded-brand shadow-brand ratio-4x3">
        <img src="{{ asset('frontend/assets/images/programs/clinical.jpg') }}" alt="Nursing student practising patient assessment" loading="lazy" width="1200" height="800"></div></div>
      <div class="col-lg-6" data-reveal="right">
        <span class="eyebrow">Practice-based learning</span>
        <h2 class="mt-3">From supervised practice to confident care</h2>
        <p class="lead-text">Clinical learning moves in stages: demonstration, supervised rehearsal, then applied practice —
        so students build competence safely and progressively.</p>
        <ul class="list-check">
          <li><i class="bi bi-check-circle-fill"></i><span>Skills demonstrated by instructors before student practice</span></li>
          <li><i class="bi bi-check-circle-fill"></i><span>Feedback and assessment at each stage of learning</span></li>
          <li><i class="bi bi-check-circle-fill"></i><span>Emphasis on patient dignity, safety and consent</span></li>
        </ul>
      </div>
    </div>
  </div>
</section>

<section class="section bg-light-soft">
  <div class="container">
    <div class="section-header"><span class="eyebrow">Areas of practice</span><h2>What clinical learning covers</h2></div>
    <div class="row g-4">
      
      <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="1">
        <div class="card-brand p-4 h-100">
          <span class="icon-badge mb-3"><i class="bi bi-heart-pulse"></i></span>
          <h3 class="h6">Practical nursing</h3>
          <p class="small text-soft mb-0">Core nursing procedures practised in a supervised skills environment.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="2">
        <div class="card-brand p-4 h-100">
          <span class="icon-badge mb-3"><i class="bi bi-person-hearts"></i></span>
          <h3 class="h6">Patient-care skills</h3>
          <p class="small text-soft mb-0">Comfort, hygiene, mobility support and respectful patient interaction.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="3">
        <div class="card-brand p-4 h-100">
          <span class="icon-badge mb-3"><i class="bi bi-clipboard2-pulse"></i></span>
          <h3 class="h6">Clinical procedures</h3>
          <p class="small text-soft mb-0">Vitals monitoring, documentation and procedural accuracy.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="1">
        <div class="card-brand p-4 h-100">
          <span class="icon-badge mb-3"><i class="bi bi-hospital"></i></span>
          <h3 class="h6">Hospital exposure</h3>
          <p class="small text-soft mb-0">Learning in real healthcare settings as arranged by the college.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="2">
        <div class="card-brand p-4 h-100">
          <span class="icon-badge mb-3"><i class="bi bi-eyedropper"></i></span>
          <h3 class="h6">Laboratory skills</h3>
          <p class="small text-soft mb-0">Sample handling and laboratory practice for allied health students.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="3">
        <div class="card-brand p-4 h-100">
          <span class="icon-badge mb-3"><i class="bi bi-truck-front"></i></span>
          <h3 class="h6">Emergency-care learning</h3>
          <p class="small text-soft mb-0">Recognising urgency and responding within professional limits.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="1">
        <div class="card-brand p-4 h-100">
          <span class="icon-badge mb-3"><i class="bi bi-chat-dots"></i></span>
          <h3 class="h6">Professional communication</h3>
          <p class="small text-soft mb-0">Clear, respectful communication with patients, families and teams.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="2">
        <div class="card-brand p-4 h-100">
          <span class="icon-badge mb-3"><i class="bi bi-shield-check"></i></span>
          <h3 class="h6">Infection control</h3>
          <p class="small text-soft mb-0">Hand hygiene, PPE discipline and safe handling practices.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="3">
        <div class="card-brand p-4 h-100">
          <span class="icon-badge mb-3"><i class="bi bi-journal-check"></i></span>
          <h3 class="h6">Reflective practice</h3>
          <p class="small text-soft mb-0">Reviewing performance and improving with instructor feedback.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-header"><span class="eyebrow">Practical Learning / Internship</span><h2>3 Hospitals for hands-on practice</h2>
    <p>Students gain practical learning and internship experience in real hospital settings at these partner hospitals in Gojra.</p></div>
    <div class="row g-4 justify-content-center">
      <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="1">
        <div class="card-brand p-4 h-100 text-center">
          <span class="icon-badge mb-3"><i class="bi bi-hospital"></i></span>
          <h3 class="h6 mb-0">Albarkat Hospital Gojra</h3>
        </div>
      </div>
      <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="2">
        <div class="card-brand p-4 h-100 text-center">
          <span class="icon-badge mb-3"><i class="bi bi-hospital"></i></span>
          <h3 class="h6 mb-0">Hajra Tufail Hospital Gojra</h3>
        </div>
      </div>
      <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="3">
        <div class="card-brand p-4 h-100 text-center">
          <span class="icon-badge mb-3"><i class="bi bi-hospital"></i></span>
          <h3 class="h6 mb-0">THQ Hospital Gojra</h3>
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
