@extends('frontend.layouts.layout')
@section('title', 'Events | King TAS College of Nursing & Allied Health Sciences')
@section('description', 'Upcoming events at King TAS College, Gojra — admission guidance days, clinical skills workshops and community health activities.')
@section('content')
<main id="main">
<header class="page-hero">
  <div class="container">
    <h1>Events</h1>
    <p>Guidance days, workshops and student activities organised by the college.</p>
    <nav aria-label="Breadcrumb">
      <ol class="breadcrumb breadcrumb-brand"><li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li><li class="breadcrumb-item active" aria-current="page">Events</li></ol>
    </nav>
  </div>
</header>
<section class="section">
  <div class="container">
    <div class="row g-4" id="eventsGrid">
<div class="col-md-6" data-reveal data-reveal-delay="1">
  <article class="card-brand h-100">
    <div class="media-frame ratio-16x9">
      <img src="{{ asset('frontend/assets/images/campus/campus.jpg') }}" alt="Admission guidance day" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex gap-3">
      <div class="event-date">
        <span class="day">5</span>
        <span class="mon">Sep</span>
      </div>
      <div>
        <h3 class="h6 mb-1">Admission guidance day</h3>
        <p class="small text-soft mb-2"><i class="bi bi-geo-alt me-1"></i>King TAS College Campus, Gojra</p>
        <p class="small text-soft mb-2">Meet the admissions team, tour the campus and discuss program options, eligibility and application steps.</p>
        <span class="badge badge-soft">Open</span>
      </div>
    </div>
  </article>
</div>
<div class="col-md-6" data-reveal data-reveal-delay="2">
  <article class="card-brand h-100">
    <div class="media-frame ratio-16x9">
      <img src="{{ asset('frontend/assets/images/hero/hero-nursing.jpg') }}" alt="Clinical skills workshop" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex gap-3">
      <div class="event-date">
        <span class="day">19</span>
        <span class="mon">Sep</span>
      </div>
      <div>
        <h3 class="h6 mb-1">Clinical skills workshop</h3>
        <p class="small text-soft mb-2"><i class="bi bi-geo-alt me-1"></i>Skills Laboratory</p>
        <p class="small text-soft mb-2">A hands-on session covering patient assessment basics, vitals monitoring and infection-control practice.</p>
        <span class="badge badge-soft">Registration soon</span>
      </div>
    </div>
  </article>
</div>
<div class="col-md-6" data-reveal data-reveal-delay="3">
  <article class="card-brand h-100">
    <div class="media-frame ratio-16x9">
      <img src="{{ asset('frontend/assets/images/programs/maternal.jpg') }}" alt="Community health awareness activity" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex gap-3">
      <div class="event-date">
        <span class="day">3</span>
        <span class="mon">Oct</span>
      </div>
      <div>
        <h3 class="h6 mb-1">Community health awareness activity</h3>
        <p class="small text-soft mb-2"><i class="bi bi-geo-alt me-1"></i>Gojra, District Toba Tek Singh</p>
        <p class="small text-soft mb-2">Students participate in a supervised community health awareness activity focused on preventive care education.</p>
        <span class="badge badge-soft">Planned</span>
      </div>
    </div>
  </article>
</div>
<div class="col-md-6" data-reveal data-reveal-delay="1">
  <article class="card-brand h-100">
    <div class="media-frame ratio-16x9">
      <img src="{{ asset('frontend/assets/images/programs/lab.jpg') }}" alt="Allied health laboratory open day" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex gap-3">
      <div class="event-date">
        <span class="day">21</span>
        <span class="mon">Oct</span>
      </div>
      <div>
        <h3 class="h6 mb-1">Allied health laboratory open day</h3>
        <p class="small text-soft mb-2"><i class="bi bi-geo-alt me-1"></i>Science &amp; Medical Laboratories</p>
        <p class="small text-soft mb-2">Prospective students can view laboratory learning spaces and talk to instructors about allied health programs.</p>
        <span class="badge badge-soft">Planned</span>
      </div>
    </div>
  </article>
</div>
</div>
  </div>
</section>
<section class="section bg-light-soft">
  <div class="container">
    <div class="section-header"><span class="eyebrow">Schedule</span><h2>Upcoming event schedule</h2>
      <p>A compact month-by-month view of planned activities.</p></div>
    <ul class="list-unstyled mb-0" id="eventsList">
<li class="notice-row mb-2">
  <div class="event-date"><span class="day">5</span><span class="mon">Sep</span></div>
  <div class="flex-grow-1">
    <p class="fw-600 mb-0">Admission guidance day</p>
    <p class="small text-soft mb-0"><i class="bi bi-geo-alt me-1"></i>King TAS College Campus, Gojra</p>
  </div>
  <span class="badge badge-soft">Open</span>
</li>
<li class="notice-row mb-2">
  <div class="event-date"><span class="day">19</span><span class="mon">Sep</span></div>
  <div class="flex-grow-1">
    <p class="fw-600 mb-0">Clinical skills workshop</p>
    <p class="small text-soft mb-0"><i class="bi bi-geo-alt me-1"></i>Skills Laboratory</p>
  </div>
  <span class="badge badge-soft">Registration soon</span>
</li>
<li class="notice-row mb-2">
  <div class="event-date"><span class="day">3</span><span class="mon">Oct</span></div>
  <div class="flex-grow-1">
    <p class="fw-600 mb-0">Community health awareness activity</p>
    <p class="small text-soft mb-0"><i class="bi bi-geo-alt me-1"></i>Gojra, District Toba Tek Singh</p>
  </div>
  <span class="badge badge-soft">Planned</span>
</li>
<li class="notice-row mb-2">
  <div class="event-date"><span class="day">21</span><span class="mon">Oct</span></div>
  <div class="flex-grow-1">
    <p class="fw-600 mb-0">Allied health laboratory open day</p>
    <p class="small text-soft mb-0"><i class="bi bi-geo-alt me-1"></i>Science &amp; Medical Laboratories</p>
  </div>
  <span class="badge badge-soft">Planned</span>
</li>
</ul>
    <p class="placeholder-note mt-4 mb-0">Sample events — dates and details are confirmed by the college administration.</p>
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
