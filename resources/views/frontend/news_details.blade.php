@extends('frontend.layouts.layout')
@section('title', 'News Article | King TAS College of Nursing & Allied Health Sciences')
@section('description', 'Read the latest announcement from King TAS College of Nursing & Allied Health Sciences, Gojra.')
@section('content')
<main id="main">
<div data-article-page="admissions-open-2026" data-title="Admissions open for session 2026–27 | King TAS College of Nursing &amp; Allied Health Sciences">
<header class="page-hero">
  <div class="container">
    <h1>Admissions open for session 2026–27</h1>
    <nav aria-label="Breadcrumb">
      <ol class="breadcrumb breadcrumb-brand">
        <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('frontend.news') }}">News</a></li>
        <li class="breadcrumb-item active" aria-current="page">Admissions open for session 2026–27</li>
      </ol>
    </nav>
  </div>
</header>

<section class="section">
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-8">
        <div class="news-meta mb-3">
  <span class="badge badge-soft">Admissions</span>
  <span><i class="bi bi-calendar3 me-1"></i>10 Aug 2026</span>
  <span><i class="bi bi-person me-1"></i>College Administration</span>
</div>
        <div class="media-frame rounded-brand shadow-brand ratio-16x9 mb-4">
          <img src="{{ asset('frontend/assets/images/campus/campus.jpg') }}" alt="Admissions open for session 2026–27" width="1200" height="675">
        </div>
        <article>
  <p class="lead-text">Applications are being accepted for selected nursing and allied health programs. Visit the campus or contact the admissions office for guidance.</p>
  <p>The college shares academic and admission updates through this news section so students and families can follow
  developments related to programs, schedules and campus activities.</p>
  <p>For details specific to this announcement, students are encouraged to contact the admissions office directly. Final
  details are confirmed by the college administration.</p>
  <div class="demo-note mt-4"><i class="bi bi-info-circle me-1"></i>Sample article body — replace with the official
  announcement text supplied by the college.</div>
</article>
      </div>
      <aside class="col-lg-4">
        <div class="card-brand p-4 sticky-side">
          <h2 class="h6">Admissions open 2026–27</h2>
          <p class="small text-soft">Applications are being accepted for selected nursing and allied health programs.</p>
          <a class="btn btn-brand-red w-100 mb-2" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
          <a class="btn btn-outline-brand w-100" href="{{ route('frontend.all_program') }}">Explore Programs</a>
        </div>
      </aside>
    </div>
  </div>
</section>

<section class="section bg-light-soft">
  <div class="container">
    <div class="section-header"><span class="eyebrow">More news</span><h2>Related articles</h2></div>
    <div class="row g-4">
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="1">
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
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="2">
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
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="3">
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
</div>
  </div>
</section>
</div>
<div data-article-page="skills-lab-session" data-title="Nursing skills lab practice sessions scheduled | King TAS College of Nursing &amp; Allied Health Sciences" hidden>
<header class="page-hero">
  <div class="container">
    <h1>Nursing skills lab practice sessions scheduled</h1>
    <nav aria-label="Breadcrumb">
      <ol class="breadcrumb breadcrumb-brand">
        <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('frontend.news') }}">News</a></li>
        <li class="breadcrumb-item active" aria-current="page">Nursing skills lab practice sessions scheduled</li>
      </ol>
    </nav>
  </div>
</header>

<section class="section">
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-8">
        <div class="news-meta mb-3">
  <span class="badge badge-soft">Academic</span>
  <span><i class="bi bi-calendar3 me-1"></i>28 Jul 2026</span>
  <span><i class="bi bi-person me-1"></i>College Administration</span>
</div>
        <div class="media-frame rounded-brand shadow-brand ratio-16x9 mb-4">
          <img src="{{ asset('frontend/assets/images/hero/hero-nursing.jpg') }}" alt="Nursing skills lab practice sessions scheduled" width="1200" height="675">
        </div>
        <article>
  <p class="lead-text">Structured skills lab sessions help students practise core nursing procedures in a supervised learning environment.</p>
  <p>The college shares academic and admission updates through this news section so students and families can follow
  developments related to programs, schedules and campus activities.</p>
  <p>For details specific to this announcement, students are encouraged to contact the admissions office directly. Final
  details are confirmed by the college administration.</p>
  <div class="demo-note mt-4"><i class="bi bi-info-circle me-1"></i>Sample article body — replace with the official
  announcement text supplied by the college.</div>
</article>
      </div>
      <aside class="col-lg-4">
        <div class="card-brand p-4 sticky-side">
          <h2 class="h6">Admissions open 2026–27</h2>
          <p class="small text-soft">Applications are being accepted for selected nursing and allied health programs.</p>
          <a class="btn btn-brand-red w-100 mb-2" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
          <a class="btn btn-outline-brand w-100" href="{{ route('frontend.all_program') }}">Explore Programs</a>
        </div>
      </aside>
    </div>
  </div>
</section>

<section class="section bg-light-soft">
  <div class="container">
    <div class="section-header"><span class="eyebrow">More news</span><h2>Related articles</h2></div>
    <div class="row g-4">
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="1">
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
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="2">
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
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="3">
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
</div>
  </div>
</section>
</div>
<div data-article-page="health-awareness-seminar" data-title="Health awareness seminar for students | King TAS College of Nursing &amp; Allied Health Sciences" hidden>
<header class="page-hero">
  <div class="container">
    <h1>Health awareness seminar for students</h1>
    <nav aria-label="Breadcrumb">
      <ol class="breadcrumb breadcrumb-brand">
        <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('frontend.news') }}">News</a></li>
        <li class="breadcrumb-item active" aria-current="page">Health awareness seminar for students</li>
      </ol>
    </nav>
  </div>
</header>

<section class="section">
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-8">
        <div class="news-meta mb-3">
  <span class="badge badge-soft">Seminars</span>
  <span><i class="bi bi-calendar3 me-1"></i>15 Jul 2026</span>
  <span><i class="bi bi-person me-1"></i>College Administration</span>
</div>
        <div class="media-frame rounded-brand shadow-brand ratio-16x9 mb-4">
          <img src="{{ asset('frontend/assets/images/campus/classroom.jpg') }}" alt="Health awareness seminar for students" width="1200" height="675">
        </div>
        <article>
  <p class="lead-text">A student seminar focused on community health awareness, hygiene practices and preventive healthcare communication.</p>
  <p>The college shares academic and admission updates through this news section so students and families can follow
  developments related to programs, schedules and campus activities.</p>
  <p>For details specific to this announcement, students are encouraged to contact the admissions office directly. Final
  details are confirmed by the college administration.</p>
  <div class="demo-note mt-4"><i class="bi bi-info-circle me-1"></i>Sample article body — replace with the official
  announcement text supplied by the college.</div>
</article>
      </div>
      <aside class="col-lg-4">
        <div class="card-brand p-4 sticky-side">
          <h2 class="h6">Admissions open 2026–27</h2>
          <p class="small text-soft">Applications are being accepted for selected nursing and allied health programs.</p>
          <a class="btn btn-brand-red w-100 mb-2" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
          <a class="btn btn-outline-brand w-100" href="{{ route('frontend.all_program') }}">Explore Programs</a>
        </div>
      </aside>
    </div>
  </div>
</section>

<section class="section bg-light-soft">
  <div class="container">
    <div class="section-header"><span class="eyebrow">More news</span><h2>Related articles</h2></div>
    <div class="row g-4">
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="1">
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
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="2">
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
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="3">
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
</div>
  </div>
</section>
</div>
<div data-article-page="lab-workshop" data-title="Laboratory techniques workshop | King TAS College of Nursing &amp; Allied Health Sciences" hidden>
<header class="page-hero">
  <div class="container">
    <h1>Laboratory techniques workshop</h1>
    <nav aria-label="Breadcrumb">
      <ol class="breadcrumb breadcrumb-brand">
        <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('frontend.news') }}">News</a></li>
        <li class="breadcrumb-item active" aria-current="page">Laboratory techniques workshop</li>
      </ol>
    </nav>
  </div>
</header>

<section class="section">
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-8">
        <div class="news-meta mb-3">
  <span class="badge badge-soft">Workshops</span>
  <span><i class="bi bi-calendar3 me-1"></i>30 Jun 2026</span>
  <span><i class="bi bi-person me-1"></i>College Administration</span>
</div>
        <div class="media-frame rounded-brand shadow-brand ratio-16x9 mb-4">
          <img src="{{ asset('frontend/assets/images/programs/lab.jpg') }}" alt="Laboratory techniques workshop" width="1200" height="675">
        </div>
        <article>
  <p class="lead-text">Allied health students attended a practical workshop covering sample handling and laboratory safety fundamentals.</p>
  <p>The college shares academic and admission updates through this news section so students and families can follow
  developments related to programs, schedules and campus activities.</p>
  <p>For details specific to this announcement, students are encouraged to contact the admissions office directly. Final
  details are confirmed by the college administration.</p>
  <div class="demo-note mt-4"><i class="bi bi-info-circle me-1"></i>Sample article body — replace with the official
  announcement text supplied by the college.</div>
</article>
      </div>
      <aside class="col-lg-4">
        <div class="card-brand p-4 sticky-side">
          <h2 class="h6">Admissions open 2026–27</h2>
          <p class="small text-soft">Applications are being accepted for selected nursing and allied health programs.</p>
          <a class="btn btn-brand-red w-100 mb-2" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
          <a class="btn btn-outline-brand w-100" href="{{ route('frontend.all_program') }}">Explore Programs</a>
        </div>
      </aside>
    </div>
  </div>
</section>

<section class="section bg-light-soft">
  <div class="container">
    <div class="section-header"><span class="eyebrow">More news</span><h2>Related articles</h2></div>
    <div class="row g-4">
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="1">
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
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="2">
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
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="3">
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
</div>
  </div>
</section>
</div>
<div data-article-page="orientation-day" data-title="Orientation day for new students | King TAS College of Nursing &amp; Allied Health Sciences" hidden>
<header class="page-hero">
  <div class="container">
    <h1>Orientation day for new students</h1>
    <nav aria-label="Breadcrumb">
      <ol class="breadcrumb breadcrumb-brand">
        <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('frontend.news') }}">News</a></li>
        <li class="breadcrumb-item active" aria-current="page">Orientation day for new students</li>
      </ol>
    </nav>
  </div>
</header>

<section class="section">
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-8">
        <div class="news-meta mb-3">
  <span class="badge badge-soft">Student Activities</span>
  <span><i class="bi bi-calendar3 me-1"></i>12 Jun 2026</span>
  <span><i class="bi bi-person me-1"></i>College Administration</span>
</div>
        <div class="media-frame rounded-brand shadow-brand ratio-16x9 mb-4">
          <img src="{{ asset('frontend/assets/images/campus/classroom.jpg') }}" alt="Orientation day for new students" width="1200" height="675">
        </div>
        <article>
  <p class="lead-text">New students were introduced to academic expectations, campus facilities and professional conduct in healthcare settings.</p>
  <p>The college shares academic and admission updates through this news section so students and families can follow
  developments related to programs, schedules and campus activities.</p>
  <p>For details specific to this announcement, students are encouraged to contact the admissions office directly. Final
  details are confirmed by the college administration.</p>
  <div class="demo-note mt-4"><i class="bi bi-info-circle me-1"></i>Sample article body — replace with the official
  announcement text supplied by the college.</div>
</article>
      </div>
      <aside class="col-lg-4">
        <div class="card-brand p-4 sticky-side">
          <h2 class="h6">Admissions open 2026–27</h2>
          <p class="small text-soft">Applications are being accepted for selected nursing and allied health programs.</p>
          <a class="btn btn-brand-red w-100 mb-2" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
          <a class="btn btn-outline-brand w-100" href="{{ route('frontend.all_program') }}">Explore Programs</a>
        </div>
      </aside>
    </div>
  </div>
</section>

<section class="section bg-light-soft">
  <div class="container">
    <div class="section-header"><span class="eyebrow">More news</span><h2>Related articles</h2></div>
    <div class="row g-4">
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="1">
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
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="2">
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
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="3">
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
</div>
  </div>
</section>
</div>
<div data-article-page="class-schedule-update" data-title="Updated class schedule announcement | King TAS College of Nursing &amp; Allied Health Sciences" hidden>
<header class="page-hero">
  <div class="container">
    <h1>Updated class schedule announcement</h1>
    <nav aria-label="Breadcrumb">
      <ol class="breadcrumb breadcrumb-brand">
        <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('frontend.news') }}">News</a></li>
        <li class="breadcrumb-item active" aria-current="page">Updated class schedule announcement</li>
      </ol>
    </nav>
  </div>
</header>

<section class="section">
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-8">
        <div class="news-meta mb-3">
  <span class="badge badge-soft">Announcements</span>
  <span><i class="bi bi-calendar3 me-1"></i>29 May 2026</span>
  <span><i class="bi bi-person me-1"></i>College Administration</span>
</div>
        <div class="media-frame rounded-brand shadow-brand ratio-16x9 mb-4">
          <img src="{{ asset('frontend/assets/images/campus/campus.jpg') }}" alt="Updated class schedule announcement" width="1200" height="675">
        </div>
        <article>
  <p class="lead-text">Revised timetables for theory and practical sessions have been shared with students through the notice board.</p>
  <p>The college shares academic and admission updates through this news section so students and families can follow
  developments related to programs, schedules and campus activities.</p>
  <p>For details specific to this announcement, students are encouraged to contact the admissions office directly. Final
  details are confirmed by the college administration.</p>
  <div class="demo-note mt-4"><i class="bi bi-info-circle me-1"></i>Sample article body — replace with the official
  announcement text supplied by the college.</div>
</article>
      </div>
      <aside class="col-lg-4">
        <div class="card-brand p-4 sticky-side">
          <h2 class="h6">Admissions open 2026–27</h2>
          <p class="small text-soft">Applications are being accepted for selected nursing and allied health programs.</p>
          <a class="btn btn-brand-red w-100 mb-2" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
          <a class="btn btn-outline-brand w-100" href="{{ route('frontend.all_program') }}">Explore Programs</a>
        </div>
      </aside>
    </div>
  </div>
</section>

<section class="section bg-light-soft">
  <div class="container">
    <div class="section-header"><span class="eyebrow">More news</span><h2>Related articles</h2></div>
    <div class="row g-4">
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="1">
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
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="2">
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
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="3">
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
</div>
  </div>
</section>
</div>
</main>
@endsection
