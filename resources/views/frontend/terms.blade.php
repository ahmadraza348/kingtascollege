@extends('frontend.layouts.layout')
@section('title', 'Terms & Conditions | King TAS College of Nursing & Allied Health Sciences')
@section('description', 'Terms and conditions placeholder for the King TAS College of Nursing & Allied Health Sciences website, Gojra.')
@section('content')
<main id="main">
<header class="page-hero">
  <div class="container">
    <h1>Terms &amp; conditions</h1>
    <p>Terms covering the use of this website and the information published on it.</p>
    <nav aria-label="Breadcrumb">
      <ol class="breadcrumb breadcrumb-brand"><li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li><li class="breadcrumb-item active" aria-current="page">Terms & Conditions</li></ol>
    </nav>
  </div>
</header>
<section class="section"><div class="container"><div class="row justify-content-center"><div class="col-lg-8">
  <div class="demo-note mb-4"><i class="bi bi-info-circle me-1"></i>Generic, editable terms. Institution-specific legal
  information must be reviewed and customised by the college before publishing.</div>
  <h2 class="h5">Use of this website</h2>
  <p>This website provides general information about programs, admissions and campus activities at King TAS College of Nursing
  &amp; Allied Health Sciences.</p>
  <h2 class="h5 mt-4">Accuracy of information</h2>
  <p>Program names, durations, eligibility criteria and other academic details are subject to confirmation by the college
  administration. Applicants should verify details with the admissions office before making decisions.</p>
  <h2 class="h5 mt-4">Applications</h2>
  <p>Submitting an online form does not guarantee admission. Applications are reviewed by the admissions team according to the
  college's procedures.</p>
  <h2 class="h5 mt-4">Intellectual property</h2>
  <p>The college name, logo and published content belong to the institution and may not be reproduced without permission.</p>
  <h2 class="h5 mt-4">Changes to these terms</h2>
  <p>The college may update these terms; the current version applies from the date it is published.</p>
  <p class="placeholder-note">Editable section — final legal wording to be supplied by the college.</p>
</div></div></div></section>
</main>
@endsection
