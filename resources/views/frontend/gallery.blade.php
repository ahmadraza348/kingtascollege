@extends('frontend.layouts.layout')
@section('title', 'Gallery | King TAS College of Nursing & Allied Health Sciences')
@section('description', 'Photo gallery of campus, classrooms, laboratories, clinical training and student activities at King TAS College, Gojra.')
@section('content')
<main id="main">
<header class="page-hero">
  <div class="container">
    <h1>Gallery</h1>
    <p>Photographs of campus spaces, classrooms, laboratories and practical learning sessions.</p>
    <nav aria-label="Breadcrumb">
      <ol class="breadcrumb breadcrumb-brand"><li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li><li class="breadcrumb-item active" aria-current="page">Gallery</li></ol>
    </nav>
  </div>
</header>
<section class="section">
  <div class="container">
    <!-- <div class="d-flex flex-wrap gap-2 mb-4" id="galleryFilters" role="group" aria-label="Gallery filters">
      <button class="filter-chip active" data-filter="all">All</button>
      <button class="filter-chip" data-filter="Campus">Campus</button>
      <button class="filter-chip" data-filter="Students">Students</button>
      <button class="filter-chip" data-filter="Nursing">Nursing</button>
      <button class="filter-chip" data-filter="Laboratories">Laboratories</button>
      <button class="filter-chip" data-filter="Events">Events</button>
      <button class="filter-chip" data-filter="Seminars">Seminars</button>
      <button class="filter-chip" data-filter="Clinical Training">Clinical Training</button>
      <button class="filter-chip" data-filter="Activities">Activities</button>
    </div> -->
    <div class="gallery-grid" id="galleryGrid">
<a class="gallery-item" href="{{ asset('frontend/assets/images/hero/hero-nursing.jpg') }}" data-item data-category="Nursing" data-caption="Nursing skills practice session" aria-label="Open image: Nursing skills practice session">
  <img src="{{ asset('frontend/assets/images/hero/hero-nursing.jpg') }}" alt="Nursing skills practice session" loading="lazy">
  <span class="caption">Nursing skills practice session <em class="d-block text-white-50">Nursing</em></span>
</a>
<a class="gallery-item" href="{{ asset('frontend/assets/images/campus/campus.jpg') }}" data-item data-category="Campus" data-caption="College campus" aria-label="Open image: College campus">
  <img src="{{ asset('frontend/assets/images/campus/campus.jpg') }}" alt="College campus" loading="lazy">
  <span class="caption">College campus <em class="d-block text-white-50">Campus</em></span>
</a>
<a class="gallery-item" href="{{ asset('frontend/assets/images/campus/classroom.jpg') }}" data-item data-category="Students" data-caption="Classroom learning" aria-label="Open image: Classroom learning">
  <img src="{{ asset('frontend/assets/images/campus/classroom.jpg') }}" alt="Classroom learning" loading="lazy">
  <span class="caption">Classroom learning <em class="d-block text-white-50">Students</em></span>
</a>
<a class="gallery-item" href="{{ asset('frontend/assets/images/programs/lab.jpg') }}" data-item data-category="Laboratories" data-caption="Medical laboratory practice" aria-label="Open image: Medical laboratory practice">
  <img src="{{ asset('frontend/assets/images/programs/lab.jpg') }}" alt="Medical laboratory practice" loading="lazy">
  <span class="caption">Medical laboratory practice <em class="d-block text-white-50">Laboratories</em></span>
</a>
<a class="gallery-item" href="{{ asset('frontend/assets/images/programs/clinical.jpg') }}" data-item data-category="Clinical Training" data-caption="Patient care training" aria-label="Open image: Patient care training">
  <img src="{{ asset('frontend/assets/images/programs/clinical.jpg') }}" alt="Patient care training" loading="lazy">
  <span class="caption">Patient care training <em class="d-block text-white-50">Clinical Training</em></span>
</a>
<a class="gallery-item" href="{{ asset('frontend/assets/images/programs/ot.jpg') }}" data-item data-category="Clinical Training" data-caption="Operation theatre exposure" aria-label="Open image: Operation theatre exposure">
  <img src="{{ asset('frontend/assets/images/programs/ot.jpg') }}" alt="Operation theatre exposure" loading="lazy">
  <span class="caption">Operation theatre exposure <em class="d-block text-white-50">Clinical Training</em></span>
</a>
<a class="gallery-item" href="{{ asset('frontend/assets/images/programs/radiology.jpg') }}" data-item data-category="Laboratories" data-caption="Diagnostic imaging learning" aria-label="Open image: Diagnostic imaging learning">
  <img src="{{ asset('frontend/assets/images/programs/radiology.jpg') }}" alt="Diagnostic imaging learning" loading="lazy">
  <span class="caption">Diagnostic imaging learning <em class="d-block text-white-50">Laboratories</em></span>
</a>
<a class="gallery-item" href="{{ asset('frontend/assets/images/programs/maternal.jpg') }}" data-item data-category="Nursing" data-caption="Maternal and newborn care" aria-label="Open image: Maternal and newborn care">
  <img src="{{ asset('frontend/assets/images/programs/maternal.jpg') }}" alt="Maternal and newborn care" loading="lazy">
  <span class="caption">Maternal and newborn care <em class="d-block text-white-50">Nursing</em></span>
</a>
<a class="gallery-item" href="{{ asset('frontend/assets/images/programs/pharmacy.jpg') }}" data-item data-category="Activities" data-caption="Dispensing practice" aria-label="Open image: Dispensing practice">
  <img src="{{ asset('frontend/assets/images/programs/pharmacy.jpg') }}" alt="Dispensing practice" loading="lazy">
  <span class="caption">Dispensing practice <em class="d-block text-white-50">Activities</em></span>
</a>
<a class="gallery-item" href="{{ asset('frontend/assets/images/campus/classroom.jpg') }}" data-item data-category="Seminars" data-caption="Student seminar session" aria-label="Open image: Student seminar session">
  <img src="{{ asset('frontend/assets/images/campus/classroom.jpg') }}" alt="Student seminar session" loading="lazy">
  <span class="caption">Student seminar session <em class="d-block text-white-50">Seminars</em></span>
</a>
<a class="gallery-item" href="{{ asset('frontend/assets/images/campus/campus.jpg') }}" data-item data-category="Events" data-caption="Campus event" aria-label="Open image: Campus event">
  <img src="{{ asset('frontend/assets/images/campus/campus.jpg') }}" alt="Campus event" loading="lazy">
  <span class="caption">Campus event <em class="d-block text-white-50">Events</em></span>
</a>
<a class="gallery-item" href="{{ asset('frontend/assets/images/hero/hero-nursing.jpg') }}" data-item data-category="Students" data-caption="Students in uniform" aria-label="Open image: Students in uniform">
  <img src="{{ asset('frontend/assets/images/hero/hero-nursing.jpg') }}" alt="Students in uniform" loading="lazy">
  <span class="caption">Students in uniform <em class="d-block text-white-50">Students</em></span>
</a>
<div class="empty-state d-none" data-empty><i class="bi bi-images d-block mb-2"></i>No images in this category yet.</div>
</div>

  </div>
</section>

</main>
@endsection
