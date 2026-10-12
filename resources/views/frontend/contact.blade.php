@extends('frontend.layouts.layout')
@section('title', 'Contact | King TAS College of Nursing & Allied Health Sciences, Gojra')
@section('description', 'Contact King TAS College of Nursing & Allied Health Sciences: 0302-8098542, 0326-0298542, Main Painsara Road, College Road, Near Model City Phase 3, Gojra.')
@section('content')
<main id="main">
<header class="page-hero">
  <div class="container">
    <h1>Contact us</h1>
    <p>Speak with the admissions team about programs, eligibility and applications — by phone, WhatsApp or at the campus.</p>
    <nav aria-label="Breadcrumb">
      <ol class="breadcrumb breadcrumb-brand"><li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li><li class="breadcrumb-item active" aria-current="page">Contact</li></ol>
    </nav>
  </div>
</header>
<section class="section">
  <div class="container">
    <div class="row g-4 mb-5">
      <div class="col-md-6 col-lg-3" data-reveal><div class="card-brand contact-tile h-100">
        <i class="bi bi-geo-alt"></i><div><h2 class="h6 mb-1">Campus address</h2><p class="small text-soft mb-0">Main Painsara Road, College Road, Near Model City Phase 3, Gojra, District Toba Tek Singh, Punjab, Pakistan</p></div></div></div>
      <div class="col-md-6 col-lg-3" data-reveal data-reveal-delay="2"><div class="card-brand contact-tile h-100">
        <i class="bi bi-telephone"></i><div><h2 class="h6 mb-1">Phone</h2>
        <p class="small mb-0"><a href="tel:+923028098542">0302-8098542</a><br><a href="tel:+923260298542">0326-0298542</a></p></div></div></div>
      <div class="col-md-6 col-lg-3" data-reveal data-reveal-delay="3"><div class="card-brand contact-tile h-100">
        <i class="bi bi-whatsapp"></i><div><h2 class="h6 mb-1">WhatsApp</h2>
        <p class="small mb-0"><a href="https://wa.me/923028098542?text=Hello%2C%20I%20would%20like%20information%20about%20admissions%20at%20King%20TAS%20College." target="_blank" rel="noopener">Message admissions</a></p></div></div></div>
      <div class="col-md-6 col-lg-3" data-reveal data-reveal-delay="4"><div class="card-brand contact-tile h-100">
        <i class="bi bi-clock"></i><div><h2 class="h6 mb-1">Office hours</h2>
        <p class="small text-soft mb-0">To be confirmed by the college administration.</p></div></div></div>
    </div>

    <div class="row g-5">
      <div class="col-lg-7">
        <span class="eyebrow">Send an inquiry</span>
        <h2 class="mt-3 mb-4">We'll get back to you</h2>
        <form id="contactForm" class="card-brand p-4" method="post" action="{{ route('frontend.contact.store') }}" novalidate>
@csrf
          @if ($errors->any())
          <div class="alert alert-danger" role="alert">
            <strong>Please fix the following:</strong>
            <ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
          </div>
          @endif
          <div class="row g-3">
            <div class="col-md-6"><label class="form-label" for="cName">Name *</label>
              <input class="form-control" id="cName" name="name" required minlength="3"><div class="invalid-feedback"></div></div>
            <div class="col-md-6"><label class="form-label" for="cPhone">Phone *</label>
              <input class="form-control" id="cPhone" name="phone" data-validate="phone" placeholder="0302-8098542" required><div class="invalid-feedback"></div></div>
            <div class="col-md-6"><label class="form-label" for="cEmail">Email</label>
              <input class="form-control" type="email" id="cEmail" name="email"><div class="invalid-feedback"></div></div>
            <div class="col-md-6"><label class="form-label" for="cSubject">Subject *</label>
              <input class="form-control" id="cSubject" name="subject" required minlength="3"><div class="invalid-feedback"></div></div>
            <div class="col-12"><label class="form-label" for="cProgram">Program of interest</label>
              <select class="form-select" id="cProgram" name="program" data-program-select><option value="">Select a program</option>
  <optgroup label="Nursing Programs">
    <option value="BSN Generic" data-program-id="bsn-generic">BSN Generic</option>
    <option value="Post RN" data-program-id="post-rn">Post RN</option>
    <option value="LHV (Lady Health Visitor)" data-program-id="lhv">LHV (Lady Health Visitor)</option>
    <option value="CMW (Community Midwife)" data-program-id="cmw">CMW (Community Midwife)</option>
    <option value="CNA (Certified Nursing Assistant)" data-program-id="cna">CNA (Certified Nursing Assistant)</option>
  </optgroup>
  <optgroup label="Allied Health Programs">
    <option value="Anesthesia Technician" data-program-id="anesthesia-technician">Anesthesia Technician</option>
    <option value="Radiography Technology + F.Sc" data-program-id="radiography-technology">Radiography Technology + F.Sc</option>
    <option value="Medical Lab Technology + F.Sc" data-program-id="medical-lab-technology">Medical Lab Technology + F.Sc</option>
    <option value="Dental Technician" data-program-id="dental-technician">Dental Technician</option>
    <option value="Operation Theater Technology + F.Sc" data-program-id="operation-theater-technology">Operation Theater Technology + F.Sc</option>
    <option value="Dispenser + F.Sc" data-program-id="dispenser">Dispenser + F.Sc</option>
    <option value="B-Category Pharmacy Technician" data-program-id="b-category-pharmacy-technician">B-Category Pharmacy Technician</option>
  </optgroup>
</select></div>
            <div class="col-12"><label class="form-label" for="cMessage">Message *</label>
              <textarea class="form-control" id="cMessage" name="message" rows="4" required minlength="10" maxlength="1000"></textarea><div class="invalid-feedback"></div></div>
          </div>
          <button class="btn btn-brand mt-4" type="submit">Send inquiry</button>
          <div class="alert d-none" id="contactStatus" role="status"></div>
        </form>
      </div>
      <div class="col-lg-5">
        <span class="eyebrow">Visit the campus</span>
        <h2 class="mt-3 mb-4">Find us in Gojra</h2>
        <div class="map-placeholder mb-3">
          <div>
            <i class="bi bi-map fs-1 text-brand d-block mb-2" aria-hidden="true"></i>
            <p class="fw-600 mb-1">Map embed area</p>
            <p class="small text-soft mb-0">Add the official Google Maps embed here once the college confirms the exact
            campus location pin.<br><span class="placeholder-note">Main Painsara Road, College Road, Near Model City Phase 3, Gojra, District Toba Tek Singh, Punjab, Pakistan</span></p>
          </div>
        </div>
        <div class="card-brand p-4">
          <h3 class="h6">Quick actions</h3>
          <div class="d-grid gap-2">
            <a class="btn btn-brand" href="tel:+923028098542"><i class="bi bi-telephone-fill me-2"></i>Call admissions</a>
            <a class="btn btn-outline-brand" href="https://wa.me/923028098542?text=Hello%2C%20I%20would%20like%20information%20about%20admissions%20at%20King%20TAS%20College." target="_blank" rel="noopener"><i class="bi bi-whatsapp me-2"></i>WhatsApp admissions</a>
            <a class="btn btn-outline-brand" href="https://www.facebook.com/people/King-TAS-college-of-Nursing-and-Allied-Health-Sciences/100063958600873/" target="_blank" rel="noopener"><i class="bi bi-facebook me-2"></i>Follow on Facebook</a>
            <a class="btn btn-brand-red" href="{{ route('frontend.admission') }}#apply"><i class="bi bi-pencil-square me-2"></i>Apply online</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</main>
@endsection
