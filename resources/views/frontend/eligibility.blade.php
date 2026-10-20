@extends('frontend.layouts.layout')
@section('title', 'Eligibility Criteria | King TAS College of Nursing & Allied Health Sciences')
@section('description', 'Program-by-program eligibility for nursing and allied health admissions at King TAS College, Gojra — qualification, age limit, duration and required documents.')
@section('content')
@php
    // Eligibility data supplied by the college. Edit the text here and the page updates.
    $pmfQualification = 'Matriculation with Science (Physics, Chemistry and Biology) in at least 2nd Division (unadjusted).';
    $pmfScience       = 'Combined total of science subjects must not be less than 45%.';
    $pmfAge           = 'Maximum 35 years of age.';

    $nursing = [
        [
            'name' => 'BSN Generic', 'duration' => '4 years (Degree Program)',
            'qualification' => 'FSc (Pre-Medical) with a minimum of 50% marks.',
            'subjects' => 'Physics, Chemistry & Biology (compulsory).',
            'age' => '14 – 35 years',
            'notes' => ['Gender ratio: open merit.'],
        ],
        [
            'name' => 'Post RN', 'duration' => '2 years (Post RN BSN / Post RN BSM Degree Program)',
            'qualification' => 'Matric with Science (Biology, Chemistry & Physics as compulsory subjects) OR Matric Arts as per HEC. Some universities also accept FSc.',
            'subjects' => 'Physics, Chemistry & Biology (for Matric Science).',
            'age' => 'Generally between 35 and 55 years',
            'notes' => [
                'Mandatory diplomas: 3-year Diploma in General Nursing.',
                '1-year Diploma in Midwifery (for female nurses).',
                'For male nurses: 1-year specialized post-basic diploma in lieu of midwifery.',
                'Clinical experience: minimum 1 to 2 years of post-qualification clinical experience as a Registered Nurse.',
            ],
        ],
        [
            'name' => 'LHV (Lady Health Visitor)', 'duration' => '2 years (Diploma Program)',
            'qualification' => 'FSc (Pre-Medical) with minimum 45% marks, OR Matric (Science) with minimum 45% marks.',
            'subjects' => 'Physics, Chemistry & Biology (compulsory).',
            'age' => '14 – 35 years',
            'notes' => [],
        ],
        [
            'name' => 'CMW (Community Midwife)', 'duration' => '18 months (Diploma Program)',
            'qualification' => 'Matric (either Arts or Science) with 40% marks.',
            'subjects' => 'Arts or Science group accepted.',
            'age' => '14 – 40 years',
            'notes' => [],
        ],
        [
            'name' => 'CNA (Certified Nursing Assistant)', 'duration' => '2 years (Diploma Program)',
            'qualification' => 'FSc (Pre-Medical) with minimum 45% marks, OR Matric (Science) with minimum 45% marks, OR Matric (Arts) with 50% marks, OR FA with 50% marks.',
            'subjects' => 'Physics, Chemistry & Biology (for FSc / Matric Science).',
            'age' => '14 – 35 years',
            'notes' => [],
        ],
    ];

    $pmfPrograms = [
        'Radiography Technology + F.Sc',
        'Medical Lab Technology + F.Sc',
        'Dental Technician',
        'Operation Theater Technology + F.Sc',
        'Dispenser + F.Sc',
    ];

    $allied = [];
    foreach ($pmfPrograms as $program) {
        $allied[] = [
            'name' => $program, 'duration' => 'Confirm with the Admissions Office',
            'qualification' => $pmfQualification,
            'subjects' => 'Physics, Chemistry & Biology. ' . $pmfScience,
            'age' => $pmfAge,
            'notes' => [],
        ];
    }
    $allied[] = [
        'name' => 'B-Category Pharmacy Technician', 'duration' => 'Confirm with the Admissions Office',
        'qualification' => 'Matriculation with Science (Physics, Chemistry and Biology) — Computer Science is also acceptable — in at least 2nd Division (unadjusted).',
        'subjects' => 'Physics, Chemistry & Biology (or Computer Science). ' . $pmfScience,
        'age' => 'No age limit',
        'notes' => [],
    ];
    // Anesthesia Technician is listed last among the allied health programs.
    $allied[] = [
        'name' => 'Anesthesia Technician', 'duration' => 'Confirm with the Admissions Office',
        'qualification' => $pmfQualification,
        'subjects' => 'Physics, Chemistry & Biology. ' . $pmfScience,
        'age' => $pmfAge,
        'notes' => [],
    ];

    $groups = [
        ['label' => 'Nursing', 'items' => $nursing],
        ['label' => 'Allied Health', 'items' => $allied],
    ];

    $documents = [
        ['bi-person-vcard', 'Original CNIC'],
        ['bi-file-earmark-text', 'Original Matric & Intermediate degree'],
        ['bi-geo', 'Original Domicile'],
        ['bi-person-vcard', "Father's CNIC copy"],
        ['bi-telephone', 'Phone number'],
    ];
@endphp
<main id="main">
<header class="page-hero">
  <div class="container">
    <h1>Eligibility</h1>
    <p>Program-specific entry requirements, age limits and the documents you need. Final criteria are confirmed by the admissions office before an application is accepted.</p>
    <nav aria-label="Breadcrumb">
      <ol class="breadcrumb breadcrumb-brand"><li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li><li class="breadcrumb-item"><a href="{{ route('frontend.admission') }}">Admissions</a></li><li class="breadcrumb-item active" aria-current="page">Eligibility</li></ol>
    </nav>
  </div>
</header>

<section class="section">
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-8">
        <div class="accordion accordion-brand" id="eligibilityAccordion">
          @php $i = 0; @endphp
          @foreach ($groups as $group)
            <div class="eligibility-group-label" data-reveal><i class="bi bi-chevron-double-down me-2"></i>{{ $group['label'] }} Programs</div>
            @foreach ($group['items'] as $p)
              <div class="accordion-item" data-reveal>
                <h3 class="accordion-header" id="elH{{ $i }}">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#elC{{ $i }}" aria-expanded="false" aria-controls="elC{{ $i }}">
                    {{ $p['name'] }} <span class="badge badge-soft ms-2">{{ $group['label'] }}</span>
                  </button>
                </h3>
                <div id="elC{{ $i }}" class="accordion-collapse collapse" aria-labelledby="elH{{ $i }}" data-bs-parent="#eligibilityAccordion">
                  <div class="accordion-body">
                    <div class="row g-3">
                      <div class="col-12"><strong class="d-block small text-dark">Minimum qualification</strong>
                        <span class="small">{{ $p['qualification'] }}</span></div>
                      <div class="col-md-6"><strong class="d-block small text-dark">Required subjects</strong>
                        <span class="small">{{ $p['subjects'] }}</span></div>
                      <div class="col-md-3"><strong class="d-block small text-dark">Age limit</strong>
                        <span class="small">{{ $p['age'] }}</span></div>
                      <div class="col-md-3"><strong class="d-block small text-dark">Duration</strong>
                        <span class="small">{{ $p['duration'] }}</span></div>
                      @if (! empty($p['notes']))
                        <div class="col-12"><strong class="d-block small text-dark">Additional requirements</strong>
                          <ul class="small mb-0 ps-3">@foreach ($p['notes'] as $note)<li>{{ $note }}</li>@endforeach</ul></div>
                      @endif
                    </div>
                    <a class="btn btn-brand btn-sm mt-3" href="{{ route('frontend.admission') }}#apply">Apply for {{ $p['name'] }}</a>
                  </div>
                </div>
              </div>
              @php $i++; @endphp
            @endforeach
          @endforeach
        </div>
      </div>

      <div class="col-lg-4">
        <div class="card-brand p-4 sticky-side" data-reveal="right">
          <h2 class="h6"><i class="bi bi-folder-check me-2"></i>Required documents</h2>
          <ul class="list-check small">
            @foreach ($documents as $doc)
              <li><i class="bi {{ $doc[0] }}"></i><span>{{ $doc[1] }}</span></li>
            @endforeach
          </ul>
          <div class="demo-note mt-3"><i class="bi bi-info-circle me-1"></i>Bring the originals to the college for verification. Upload clear scans with the online form.</div>
          <a class="btn btn-brand w-100 mt-3" href="{{ route('frontend.admission') }}#apply">Apply online</a>
          <a class="btn btn-outline-brand w-100 mt-2" href="{{ route('frontend.admission.view-form') }}"><i class="bi bi-eye me-1"></i>View admission form</a>
        </div>
      </div>
    </div>
  </div>
</section>
</main>
<style>
  .eligibility-group-label { font-family: var(--font-heading); font-weight: 600; color: var(--primary-dark); margin: 1.5rem 0 .75rem; font-size: 1.05rem; }
  .eligibility-group-label:first-child { margin-top: 0; }
</style>
@endsection
