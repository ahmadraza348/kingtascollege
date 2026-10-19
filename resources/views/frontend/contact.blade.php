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
        <i class="bi bi-clock"></i><div><h2 class="h6 mb-1">College time</h2>
        <p class="small mb-0">8:00 AM to 3:00 PM</p></div></div></div>
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
              <input class="form-control" id="cName" name="name" value="{{ old('name') }}" required minlength="3"><div class="invalid-feedback"></div></div>
            <div class="col-md-6"><label class="form-label" for="cPhone">Phone *</label>
              <input class="form-control" id="cPhone" name="phone" value="{{ old('phone') }}" data-validate="phone" placeholder="0302-8098542" required><div class="invalid-feedback"></div></div>
            <div class="col-md-6"><label class="form-label" for="cEmail">Email *</label>
              <input class="form-control" type="email" id="cEmail" name="email" value="{{ old('email') }}" required><div class="invalid-feedback"></div></div>
            <div class="col-md-6"><label class="form-label" for="cSubject">Subject *</label>
              <input class="form-control" id="cSubject" name="subject" value="{{ old('subject') }}" required minlength="3"><div class="invalid-feedback"></div></div>
            <div class="col-12"><label class="form-label" for="cProgram">Program of interest</label>
              <select class="form-select" id="cProgram" name="program" data-program-select><option value="">Select a program</option>
  <optgroup label="Nursing Programs">
    <option value="BSN Generic" @selected(old('program') === 'BSN Generic') data-program-id="bsn-generic">BSN Generic</option>
    <option value="Post RN" @selected(old('program') === 'Post RN') data-program-id="post-rn">Post RN</option>
    <option value="LHV (Lady Health Visitor)" @selected(old('program') === 'LHV (Lady Health Visitor)') data-program-id="lhv">LHV (Lady Health Visitor)</option>
    <option value="CMW (Community Midwife)" @selected(old('program') === 'CMW (Community Midwife)') data-program-id="cmw">CMW (Community Midwife)</option>
    <option value="CNA (Certified Nursing Assistant)" @selected(old('program') === 'CNA (Certified Nursing Assistant)') data-program-id="cna">CNA (Certified Nursing Assistant)</option>
  </optgroup>
  <optgroup label="Allied Health Programs">
    <option value="Anesthesia Technician" @selected(old('program') === 'Anesthesia Technician') data-program-id="anesthesia-technician">Anesthesia Technician</option>
    <option value="Radiography Technology + F.Sc" @selected(old('program') === 'Radiography Technology + F.Sc') data-program-id="radiography-technology">Radiography Technology + F.Sc</option>
    <option value="Medical Lab Technology + F.Sc" @selected(old('program') === 'Medical Lab Technology + F.Sc') data-program-id="medical-lab-technology">Medical Lab Technology + F.Sc</option>
    <option value="Dental Technician" @selected(old('program') === 'Dental Technician') data-program-id="dental-technician">Dental Technician</option>
    <option value="Operation Theater Technology + F.Sc" @selected(old('program') === 'Operation Theater Technology + F.Sc') data-program-id="operation-theater-technology">Operation Theater Technology + F.Sc</option>
    <option value="Dispenser + F.Sc" @selected(old('program') === 'Dispenser + F.Sc') data-program-id="dispenser">Dispenser + F.Sc</option>
    <option value="B-Category Pharmacy Technician" @selected(old('program') === 'B-Category Pharmacy Technician') data-program-id="b-category-pharmacy-technician">B-Category Pharmacy Technician</option>
  </optgroup>
</select></div>
            <div class="col-12"><label class="form-label" for="cMessage">Message *</label>
              <textarea class="form-control" id="cMessage" name="message" rows="4" required minlength="10" maxlength="1000">{{ old('message') }}</textarea><div class="invalid-feedback"></div></div>
          </div>
          <button class="btn btn-brand mt-4" type="submit">Send inquiry</button>
          <div class="alert d-none" id="contactStatus" role="status"></div>
        </form>
      </div>
      <div class="col-lg-5">
        <span class="eyebrow">Visit the campus</span>
        <h2 class="mt-3 mb-4">Find us in Gojra</h2>
        <div class="map-frame mb-3">
          <iframe
            title="King TAS College location on Google Maps"
            src="https://maps.google.com/maps?q=31.165816156734085,72.69494871297285&z=16&output=embed"
            width="100%" height="340" style="border:0;" allowfullscreen loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <p class="small mb-3"><i class="bi bi-geo-alt-fill text-brand me-1" aria-hidden="true"></i>Main Painsara Road, College Road, Near Model City Phase 3, Gojra &mdash;
          <a href="https://www.google.com/maps/search/?api=1&query=31.165816156734085,72.69494871297285" target="_blank" rel="noopener">Open in Google Maps</a></p>
        
      </div>
    </div>
  </div>
</section>
</main>
@endsection
