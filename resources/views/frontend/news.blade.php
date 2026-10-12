@extends('frontend.layouts.layout')
@section('title', 'News | King TAS College of Nursing & Allied Health Sciences')
@section('description', 'Latest news, admission announcements, academic updates and student activities from King TAS College, Gojra.')
@section('content')
<main id="main">
<header class="page-hero">
  <div class="container">
    <h1>News</h1>
    <p>Academic updates, admission announcements and campus activities from King TAS College.</p>
    <nav aria-label="Breadcrumb">
      <ol class="breadcrumb breadcrumb-brand"><li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li><li class="breadcrumb-item active" aria-current="page">News</li></ol>
    </nav>
  </div>
</header>
<section class="section">
  <div class="container">
    <div class="d-flex flex-wrap gap-2 mb-4" id="newsFilters" role="group" aria-label="News filters">
      <button class="filter-chip active" data-filter="all">All</button>
      <button class="filter-chip" data-filter="Admissions">Admissions</button>
      <button class="filter-chip" data-filter="Academic">Academic</button>
      <button class="filter-chip" data-filter="Events">Events</button>
      <button class="filter-chip" data-filter="Student Activities">Student Activities</button>
      <button class="filter-chip" data-filter="Announcements">Announcements</button>
      <button class="filter-chip" data-filter="Workshops">Workshops</button>
      <button class="filter-chip" data-filter="Seminars">Seminars</button>
    </div>
    <div class="row g-4" id="newsGrid">
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="1" data-item data-category="Admissions" data-search="admissions open for session 2026–27 applications are being accepted for selected nursing and allied health programs. visit the campus or contact the admissions office for guidance.">
  <article class="card-brand news-card d-flex flex-column">
    <a class="media-frame ratio-16x9 d-block" href="{{ route('frontend.news-details') }}?article=admissions-open-2026">
      <img src="{{ asset('frontend/assets/images/campus/campus.jpg') }}" alt="Admissions open for session 2026–27" loading="lazy" width="1200" height="675">
    </a>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="news-meta mb-2">
        <span class="badge badge-soft">Admissions</span>
        <span><i class="bi bi-calendar3 me-1"></i>10 Aug 2026</span>
      </div>
      <h3><a class="text-reset" href="{{ route('frontend.news-details') }}?article=admissions-open-2026">Admissions open for session 2026–27</a></h3>
      <p class="small text-soft flex-grow-1">Applications are being accepted for selected nursing and allied health programs. Visit the campus or contact the admissions office for guidance.</p>
      <a class="fw-600 small" href="{{ route('frontend.news-details') }}?article=admissions-open-2026">Read More <i class="bi bi-arrow-right ms-1"></i></a>
    </div>
  </article>
</div>
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="2" data-item data-category="Academic" data-search="nursing skills lab practice sessions scheduled structured skills lab sessions help students practise core nursing procedures in a supervised learning environment.">
  <article class="card-brand news-card d-flex flex-column">
    <a class="media-frame ratio-16x9 d-block" href="{{ route('frontend.news-details') }}?article=skills-lab-session">
      <img src="{{ asset('frontend/assets/images/hero/hero-nursing.jpg') }}" alt="Nursing skills lab practice sessions scheduled" loading="lazy" width="1200" height="675">
    </a>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="news-meta mb-2">
        <span class="badge badge-soft">Academic</span>
        <span><i class="bi bi-calendar3 me-1"></i>28 Jul 2026</span>
      </div>
      <h3><a class="text-reset" href="{{ route('frontend.news-details') }}?article=skills-lab-session">Nursing skills lab practice sessions scheduled</a></h3>
      <p class="small text-soft flex-grow-1">Structured skills lab sessions help students practise core nursing procedures in a supervised learning environment.</p>
      <a class="fw-600 small" href="{{ route('frontend.news-details') }}?article=skills-lab-session">Read More <i class="bi bi-arrow-right ms-1"></i></a>
    </div>
  </article>
</div>
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="3" data-item data-category="Seminars" data-search="health awareness seminar for students a student seminar focused on community health awareness, hygiene practices and preventive healthcare communication.">
  <article class="card-brand news-card d-flex flex-column">
    <a class="media-frame ratio-16x9 d-block" href="{{ route('frontend.news-details') }}?article=health-awareness-seminar">
      <img src="{{ asset('frontend/assets/images/campus/classroom.jpg') }}" alt="Health awareness seminar for students" loading="lazy" width="1200" height="675">
    </a>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="news-meta mb-2">
        <span class="badge badge-soft">Seminars</span>
        <span><i class="bi bi-calendar3 me-1"></i>15 Jul 2026</span>
      </div>
      <h3><a class="text-reset" href="{{ route('frontend.news-details') }}?article=health-awareness-seminar">Health awareness seminar for students</a></h3>
      <p class="small text-soft flex-grow-1">A student seminar focused on community health awareness, hygiene practices and preventive healthcare communication.</p>
      <a class="fw-600 small" href="{{ route('frontend.news-details') }}?article=health-awareness-seminar">Read More <i class="bi bi-arrow-right ms-1"></i></a>
    </div>
  </article>
</div>
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="1" data-item data-category="Workshops" data-search="laboratory techniques workshop allied health students attended a practical workshop covering sample handling and laboratory safety fundamentals.">
  <article class="card-brand news-card d-flex flex-column">
    <a class="media-frame ratio-16x9 d-block" href="{{ route('frontend.news-details') }}?article=lab-workshop">
      <img src="{{ asset('frontend/assets/images/programs/lab.jpg') }}" alt="Laboratory techniques workshop" loading="lazy" width="1200" height="675">
    </a>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="news-meta mb-2">
        <span class="badge badge-soft">Workshops</span>
        <span><i class="bi bi-calendar3 me-1"></i>30 Jun 2026</span>
      </div>
      <h3><a class="text-reset" href="{{ route('frontend.news-details') }}?article=lab-workshop">Laboratory techniques workshop</a></h3>
      <p class="small text-soft flex-grow-1">Allied health students attended a practical workshop covering sample handling and laboratory safety fundamentals.</p>
      <a class="fw-600 small" href="{{ route('frontend.news-details') }}?article=lab-workshop">Read More <i class="bi bi-arrow-right ms-1"></i></a>
    </div>
  </article>
</div>
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="2" data-item data-category="Student Activities" data-search="orientation day for new students new students were introduced to academic expectations, campus facilities and professional conduct in healthcare settings.">
  <article class="card-brand news-card d-flex flex-column">
    <a class="media-frame ratio-16x9 d-block" href="{{ route('frontend.news-details') }}?article=orientation-day">
      <img src="{{ asset('frontend/assets/images/campus/classroom.jpg') }}" alt="Orientation day for new students" loading="lazy" width="1200" height="675">
    </a>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="news-meta mb-2">
        <span class="badge badge-soft">Student Activities</span>
        <span><i class="bi bi-calendar3 me-1"></i>12 Jun 2026</span>
      </div>
      <h3><a class="text-reset" href="{{ route('frontend.news-details') }}?article=orientation-day">Orientation day for new students</a></h3>
      <p class="small text-soft flex-grow-1">New students were introduced to academic expectations, campus facilities and professional conduct in healthcare settings.</p>
      <a class="fw-600 small" href="{{ route('frontend.news-details') }}?article=orientation-day">Read More <i class="bi bi-arrow-right ms-1"></i></a>
    </div>
  </article>
</div>
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="3" data-item data-category="Announcements" data-search="updated class schedule announcement revised timetables for theory and practical sessions have been shared with students through the notice board.">
  <article class="card-brand news-card d-flex flex-column">
    <a class="media-frame ratio-16x9 d-block" href="{{ route('frontend.news-details') }}?article=class-schedule-update">
      <img src="{{ asset('frontend/assets/images/campus/campus.jpg') }}" alt="Updated class schedule announcement" loading="lazy" width="1200" height="675">
    </a>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="news-meta mb-2">
        <span class="badge badge-soft">Announcements</span>
        <span><i class="bi bi-calendar3 me-1"></i>29 May 2026</span>
      </div>
      <h3><a class="text-reset" href="{{ route('frontend.news-details') }}?article=class-schedule-update">Updated class schedule announcement</a></h3>
      <p class="small text-soft flex-grow-1">Revised timetables for theory and practical sessions have been shared with students through the notice board.</p>
      <a class="fw-600 small" href="{{ route('frontend.news-details') }}?article=class-schedule-update">Read More <i class="bi bi-arrow-right ms-1"></i></a>
    </div>
  </article>
</div>
<div class="col-12 d-none" data-empty><div class="empty-state">
  <i class="bi bi-search d-block mb-2"></i>
  <p class="mb-0">No articles in this category yet.</p>
</div></div>
</div>
    <p class="placeholder-note mt-4 mb-0">Sample articles — replace with official announcements from the college administration.</p>
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
