@extends('frontend.layouts.layout')
@section('title', 'Application Submitted | King TAS College of Nursing & Allied Health Sciences')
@section('description', 'Your admission application has been submitted to King TAS College, Gojra.')
@section('content')
<main id="main">
<header class="page-hero">
  <div class="container">
    <h1>Application Submitted</h1>
    <p>Thank you for applying to King TAS College of Nursing &amp; Allied Health Sciences.</p>
    <nav aria-label="Breadcrumb">
      <ol class="breadcrumb breadcrumb-brand">
        <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('frontend.admission') }}">Admissions</a></li>
        <li class="breadcrumb-item active" aria-current="page">Success</li>
      </ol>
    </nav>
  </div>
</header>

<section class="section">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-7">
        <div class="card-brand p-4 p-md-5 text-center">
          <div class="mb-3" style="font-size:4rem;line-height:1;color:#198754">
            <i class="bi bi-check-circle-fill"></i>
          </div>
          <h2 class="h3 mb-2">Admission form submitted successfully</h2>
          <p class="mb-4">
            Dear <strong>{{ $admission['full_name'] }}</strong>, your application for
            <strong>{{ $admission['program'] }}</strong> has been received.
          </p>

          <div class="mx-auto mb-4 p-3"
               style="max-width:380px;background:var(--primary-soft);border:2px dashed var(--primary);border-radius:var(--radius)">
            <div class="small text-uppercase" style="color:var(--muted-text);letter-spacing:.08em">Your admission form number</div>
            <div style="font-family:var(--font-heading);font-weight:700;font-size:1.8rem;color:var(--primary-dark);letter-spacing:.04em">
              {{ $admission['form_number'] }}
            </div>
          </div>

          <div class="alert alert-info text-start mb-4" role="status">
            <i class="bi bi-envelope-check me-2"></i>
            You will receive an <strong>admission confirmation email</strong>
            @if (! empty($admission['email']))
              at <strong>{{ $admission['email'] }}</strong>
            @endif
            shortly, with a copy of your admission form (PDF) attached.
            Please also check your Spam / Junk folder.
          </div>

          <p class="small text-soft mb-4">
            Please keep your form number safe and quote it whenever you contact the admissions office.
            Our team will review your application and get in touch with you.
          </p>

          <div class="d-flex flex-wrap gap-2 justify-content-center">
            <a class="btn btn-brand" href="{{ route('frontend.home') }}"><i class="bi bi-house me-1"></i>Back to Home</a>
            <a class="btn btn-outline-primary" href="{{ route('frontend.contact') }}"><i class="bi bi-telephone me-1"></i>Contact Us</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</main>
@endsection
