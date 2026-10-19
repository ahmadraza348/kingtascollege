@extends('frontend.layouts.layout')

@section('title', 'View Admission Form | King TAS College of Nursing & Allied Health Sciences')
@section('description', 'Preview the King TAS College admission form for session 2026–27 and download the printable PDF.')

@section('content')
<main id="main">
    <header class="page-hero">
        <div class="container">
            <h1>Admission form</h1>
            <p>This is how the admission form looks. Review it here, then download the PDF to print and fill in.</p>
            <nav aria-label="Breadcrumb">
                <ol class="breadcrumb breadcrumb-brand">
                    <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('frontend.admission') }}">Admissions</a></li>
                    <li class="breadcrumb-item active" aria-current="page">View form</li>
                </ol>
            </nav>
        </div>
    </header>

    <section class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9 col-xl-8">

                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                        <div>
                            <span class="eyebrow">Session 2026–27</span>
                            <h2 class="h5 mt-2 mb-0">King TAS College — Admission Form</h2>
                        </div>
                        <a class="btn btn-brand" href="{{ route('frontend.admission.download') }}">
                            <i class="bi bi-download me-2"></i>Download PDF
                        </a>
                    </div>

                    @if ($canPreview)
                        <div class="form-preview-frame card-brand p-2">
                            <iframe
                                src="{{ route('frontend.admission.form-preview') }}#toolbar=0&navpanes=0&view=FitH"
                                title="Admission form preview"
                                loading="lazy"></iframe>
                        </div>
                        <p class="small text-soft mt-3 mb-0">
                            <i class="bi bi-info-circle me-1"></i>
                            If the preview does not appear on your phone,
                            <a href="{{ route('frontend.admission.form-preview') }}" target="_blank" rel="noopener">open the form in a new tab</a>
                            or use the Download PDF button.
                        </p>
                    @else
                        <div class="card-brand p-4 text-center">
                            <span class="icon-badge mx-auto mb-3"><i class="bi bi-file-earmark-text"></i></span>
                            <h3 class="h6">Preview is not available for this file type</h3>
                            <p class="small text-soft">Use the Download button to save the admission form to your device.</p>
                        </div>
                    @endif

                    <div class="d-flex flex-wrap gap-2 mt-4">
                        <a class="btn btn-brand" href="{{ route('frontend.admission.download') }}"><i class="bi bi-download me-2"></i>Download PDF</a>
                        <a class="btn btn-outline-brand" href="{{ route('frontend.admission') }}#apply"><i class="bi bi-pencil-square me-2"></i>Apply online instead</a>
                        <a class="btn btn-outline-brand" href="{{ route('frontend.eligibility') }}">Check eligibility</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<style>
    .form-preview-frame iframe {
        display: block; width: 100%; height: 78vh; min-height: 520px;
        border: 0; border-radius: .5rem; background: #f1f5f9;
    }
    @media (max-width: 575.98px) { .form-preview-frame iframe { height: 65vh; min-height: 420px; } }
</style>
@endsection
