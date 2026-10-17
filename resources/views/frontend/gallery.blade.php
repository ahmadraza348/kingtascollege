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
    @if ($images->isEmpty())
      <div class="empty-state"><i class="bi bi-images d-block mb-2"></i>Photos will be added soon. Please check back later.</div>
    @else
      <div class="gallery-grid" id="galleryGrid">
        @foreach ($images as $image)
          <a class="gallery-item" href="{{ $image->url }}" data-item data-caption="{{ $image->title }}" aria-label="Open image{{ $image->title ? ': ' . $image->title : '' }}">
            <img src="{{ $image->url }}" alt="{{ $image->title ?: 'King TAS College gallery image' }}" loading="lazy">
            @if ($image->title)
              <span class="caption">{{ $image->title }}</span>
            @endif
          </a>
        @endforeach
      </div>
    @endif

  </div>
</section>

</main>
@endsection
