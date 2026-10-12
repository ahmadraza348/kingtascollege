@extends('frontend.layouts.layout')
@section('title', 'Page Not Found | King TAS College of Nursing & Allied Health Sciences')
@section('description', 'The page you are looking for could not be found on the King TAS College website.')
@section('content')
<main id="main">
<section class="section text-center">
  <div class="container">
    <i class="bi bi-heart-pulse text-brand" style="font-size:3rem" aria-hidden="true"></i>
    <p class="error-code mb-0">404</p>
    <h1 class="h3">Page not found</h1>
    <p class="lead-text">The page you're looking for may have moved or no longer exists.</p>
    <div class="d-flex flex-wrap justify-content-center gap-2 mt-4">
      <a class="btn btn-brand btn-lg" href="{{ route('frontend.home') }}">Return Home</a>
      <a class="btn btn-outline-brand btn-lg" href="{{ route('frontend.all_program') }}">Explore Programs</a>
      <a class="btn btn-brand-red btn-lg" href="{{ route('frontend.contact') }}">Contact Us</a>
    </div>
  </div>
</section>
</main>
@endsection
