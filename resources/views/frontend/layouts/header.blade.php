<div class="topbar">
  <div class="container d-flex flex-wrap align-items-center justify-content-between gap-2">
    <div class="d-flex align-items-center flex-wrap">
      <a class="topbar-item" href="tel:+923028098542"><i class="bi bi-telephone-fill"></i>0302-8098542</a>
      <span class="divider d-none d-sm-inline">|</span>
      <a class="topbar-item d-none d-sm-inline-flex" href="tel:+923260298542"><i class="bi bi-telephone"></i>0326-0298542</a>
      <span class="divider d-none d-lg-inline">|</span>
      <a class="topbar-item d-none d-lg-inline-flex" href="mailto:info@kingtascollege.com">info@kingtascollege.com</a>
    </div>
    <div class="d-flex align-items-center gap-3">
      <span class="admission-pill"><span class="dot" aria-hidden="true"></span>Admissions Open — Session 2026–27</span>
      <span class="social-links d-none d-md-inline-flex gap-1">
        <a href="https://www.facebook.com/people/King-TAS-college-of-Nursing-and-Allied-Health-Sciences/100063958600873/" target="_blank" rel="noopener" aria-label="King TAS College on Facebook"><i class="bi bi-facebook"></i></a>
        <a href="https://www.instagram.com/king.tas.college/" target="_blank" rel="noopener" aria-label="King TAS College on Instagram"><i class="bi bi-instagram"></i></a>
        <a href="https://wa.me/923028098542?text=Hello%2C%20I%20would%20like%20information%20about%20admissions%20at%20King%20TAS%20College." target="_blank" rel="noopener" aria-label="WhatsApp the admissions office"><i class="bi bi-whatsapp"></i></a>
      </span>
    </div>
  </div>
</div>

<nav class="navbar navbar-expand-lg site-navbar" id="siteNavbar" aria-label="Main navigation">
  <div class="container">
    <a class="navbar-brand navbar-brand-block" href="{{ route('frontend.home') }}">
      <img src="{{ asset('frontend/assets/images/logo/logo.png') }}" alt="King TAS College logo" width="48" height="48">
      <span>
        <span class="brand-name d-block">King TAS College</span>
        <span class="brand-sub">Nursing &amp; Allied Health Sciences</span>
      </span>
    </a>
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
      aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav ms-auto align-items-lg-center">
        <li class="nav-item"><a class="nav-link" href="{{ route('frontend.home') }}">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('frontend.about') }}">About</a></li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="{{ route('frontend.all_program') }}" role="button" data-bs-toggle="dropdown" aria-expanded="false">Programs</a>
          <ul class="dropdown-menu">
            <li><h6 class="dropdown-header">Nursing Programs</h6></li>
            <li><a class="dropdown-item" href="{{ route('frontend.program-details') }}?program=bsn-generic">BSN Generic</a></li><li><a class="dropdown-item" href="{{ route('frontend.program-details') }}?program=post-rn">Post RN</a></li><li><a class="dropdown-item" href="{{ route('frontend.program-details') }}?program=lhv">LHV</a></li><li><a class="dropdown-item" href="{{ route('frontend.program-details') }}?program=cmw">CMW</a></li><li><a class="dropdown-item" href="{{ route('frontend.program-details') }}?program=cna">CNA</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><h6 class="dropdown-header">Allied Health Programs</h6></li>
            <li><a class="dropdown-item" href="{{ route('frontend.program-details') }}?program=anesthesia-technician">Anesthesia Technician</a></li><li><a class="dropdown-item" href="{{ route('frontend.program-details') }}?program=radiography-technology">Radiography Technology</a></li><li><a class="dropdown-item" href="{{ route('frontend.program-details') }}?program=medical-lab-technology">Medical Lab Technology</a></li><li><a class="dropdown-item" href="{{ route('frontend.program-details') }}?program=dental-technician">Dental Technician</a></li><li><a class="dropdown-item" href="{{ route('frontend.program-details') }}?program=operation-theater-technology">Operation Theater Technology</a></li><li><a class="dropdown-item" href="{{ route('frontend.program-details') }}?program=dispenser">Dispenser</a></li><li><a class="dropdown-item" href="{{ route('frontend.program-details') }}?program=b-category-pharmacy-technician">B-Category Pharmacy Technician</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item fw-600" href="{{ route('frontend.all_program') }}">View all programs</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="{{ route('frontend.admission') }}" role="button" data-bs-toggle="dropdown" aria-expanded="false">Admissions</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('frontend.admission') }}">Admission Process</a></li>
            <li><a class="dropdown-item" href="{{ route('frontend.admission') }}#apply">Online Application</a></li>
            <li><a class="dropdown-item" href="{{ route('frontend.eligibility') }}">Eligibility</a></li>
            <li><a class="dropdown-item" href="{{ route('frontend.admission') }}#scholarships">Financial Support</a></li>
            <li><a class="dropdown-item" href="{{ route('frontend.faq') }}">Admission FAQs</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Academics</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('frontend.clinical-training') }}">Clinical Training</a></li>
            <li><a class="dropdown-item" href="{{ route('frontend.facilities') }}">Facilities</a></li>
            <!-- <li><a class="dropdown-item" href="{{ route('frontend.faculty') }}">Faculty</a></li> -->
            <!-- <li><a class="dropdown-item" href="{{ route('frontend.notices') }}">Notice Board</a></li> -->
          </ul>
        </li>
        <!-- <li class="nav-item"><a class="nav-link" href="{{ route('frontend.campus-life') }}">Campus</a></li> -->
        <!-- <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="{{ route('frontend.news') }}" role="button" data-bs-toggle="dropdown" aria-expanded="false">News &amp; Events</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('frontend.news') }}">News</a></li>
            <li><a class="dropdown-item" href="{{ route('frontend.events') }}">Events</a></li>
            <li><a class="dropdown-item" href="{{ route('frontend.notices') }}">Notices</a></li>
          </ul>
        </li> -->
        <li class="nav-item"><a class="nav-link" href="{{ route('frontend.gallery') }}">Gallery</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('frontend.contact') }}">Contact</a></li>
        <li class="nav-item ms-lg-2 my-2 my-lg-0">
          <a class="btn btn-brand-red btn-sm w-100" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
