@extends('frontend.layouts.layout')
@section('title', 'Programs | Nursing & Allied Health Courses in Gojra')
@section('description', 'Nursing programs (BSN Generic, Post RN, LHV, CMW, CNA) and allied health programs including Medical Lab Technology, Radiography, Anesthesia and Operation Theater Technology.')
@section('content')
<main id="main">
<header class="page-hero">
  <div class="container">
    <h1>Our programs</h1>
    <p>Explore nursing and allied health programs designed around healthcare education and professional development.</p>
    <nav aria-label="Breadcrumb">
      <ol class="breadcrumb breadcrumb-brand"><li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li><li class="breadcrumb-item active" aria-current="page">Programs</li></ol>
    </nav>
  </div>
</header>
<section class="section">
  <div class="container">
    <div class="filter-bar mb-4" data-reveal>
      <div class="row g-3 align-items-center">
        <div class="col-lg-5">
          <label class="visually-hidden" for="programSearch">Search a program</label>
          <div class="search-field">
            <i class="bi bi-search" aria-hidden="true"></i>
            <input class="form-control" type="search" id="programSearch" placeholder="Search a program...">
          </div>
        </div>
        <div class="col-lg-7">
          <div class="d-flex flex-wrap gap-2 justify-content-lg-end" id="programFilters" role="group" aria-label="Program filters">
            <button class="filter-chip active" data-filter="all">All</button>
            <button class="filter-chip" data-filter="Nursing">Nursing</button>
            <button class="filter-chip" data-filter="Allied Health">Allied Health</button>
            <button class="filter-chip" data-filter="2-Year">2-Year</button>
            <button class="filter-chip" data-filter="4-Year">4-Year</button>
            <button class="filter-chip" data-filter="F.Sc Based">F.Sc Based</button>
            <button class="filter-chip" data-filter="Professional Track">Professional Track</button>
          </div>
        </div>
      </div>
      <p class="small text-soft mb-0 mt-3"><span id="programCount">12</span> programs shown. Program names are taken from the
      college's promotional material and require institutional verification before publishing.</p>
    </div>
    <div class="row g-4" id="programGrid">
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="1" data-item data-category="Nursing" data-tags="4-Year|Professional Track" data-search="bsn generic nursing a professional nursing degree pathway focused on patient care, clinical competence and evidence-based nursing practice. 4-year professional track">
  <article class="card-brand program-card d-flex flex-column">
    <div class="media-frame ratio-16x9">
      <span class="badge-brand  badge-float">Nursing</span>
      <img src="{{ asset('frontend/assets/images/hero/hero-nursing.jpg') }}" alt="BSN Generic program at King TAS College" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-heart-pulse text-brand fs-5"></i>
        <h3 class="h6 mb-0">BSN Generic</h3>
      </div>
      <p class="small text-soft flex-grow-1">A professional nursing degree pathway focused on patient care, clinical competence and evidence-based nursing practice.</p>
      <div class="meta-row mb-2">
        <span><i class="bi bi-clock me-1"></i>4 years (Degree Program)</span>
      </div>
      <div class="meta-row mb-3">
        <span><i class="bi bi-mortarboard me-1"></i>FSc Pre-Medical, min. 50% &bull; Age 14&ndash;35</span>
      </div>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-brand btn-sm flex-fill" href="{{ route('frontend.program-details') }}?program=bsn-generic">Learn More</a>
        <a class="btn btn-brand-red btn-sm flex-fill" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
      </div>
    </div>
  </article>
</div>
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="2" data-item data-category="Nursing" data-tags="2-Year|Professional Track" data-search="post rn nursing a progression pathway for registered nurses who want to advance academic qualifications and professional responsibility. 2-year professional track">
  <article class="card-brand program-card d-flex flex-column">
    <div class="media-frame ratio-16x9">
      <span class="badge-brand  badge-float">Nursing</span>
      <img src="{{ asset('frontend/assets/images/programs/clinical.jpg') }}" alt="Post RN program at King TAS College" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-clipboard2-pulse text-brand fs-5"></i>
        <h3 class="h6 mb-0">Post RN</h3>
      </div>
      <p class="small text-soft flex-grow-1">A progression pathway for registered nurses who want to advance academic qualifications and professional responsibility.</p>
      <div class="meta-row mb-2">
        <span><i class="bi bi-clock me-1"></i>2 years (Post RN BSN / BSM Degree Program)</span>
      </div>
      <div class="meta-row mb-3">
        <span><i class="bi bi-mortarboard me-1"></i>Nursing diploma + 1&ndash;2 yrs experience &bull; Age 35&ndash;55</span>
      </div>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-brand btn-sm flex-fill" href="{{ route('frontend.program-details') }}?program=post-rn">Learn More</a>
        <a class="btn btn-brand-red btn-sm flex-fill" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
      </div>
    </div>
  </article>
</div>
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="3" data-item data-category="Nursing" data-tags="2-Year|Professional Track" data-search="lhv (lady health visitor) nursing community and maternal healthcare training focused on family health education, preventive care and primary healthcare support. 2-year professional track">
  <article class="card-brand program-card d-flex flex-column">
    <div class="media-frame ratio-16x9">
      <span class="badge-brand  badge-float">Nursing</span>
      <img src="{{ asset('frontend/assets/images/programs/maternal.jpg') }}" alt="LHV (Lady Health Visitor) program at King TAS College" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-people text-brand fs-5"></i>
        <h3 class="h6 mb-0">LHV (Lady Health Visitor)</h3>
      </div>
      <p class="small text-soft flex-grow-1">Community and maternal healthcare training focused on family health education, preventive care and primary healthcare support.</p>
      <div class="meta-row mb-2">
        <span><i class="bi bi-clock me-1"></i>2 years (Diploma Program)</span>
      </div>
      <div class="meta-row mb-3">
        <span><i class="bi bi-mortarboard me-1"></i>FSc / Matric Science, min. 45% &bull; Age 14&ndash;35</span>
      </div>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-brand btn-sm flex-fill" href="{{ route('frontend.program-details') }}?program=lhv">Learn More</a>
        <a class="btn btn-brand-red btn-sm flex-fill" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
      </div>
    </div>
  </article>
</div>
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="1" data-item data-category="Nursing" data-tags="2-Year|Professional Track" data-search="cmw (community midwife) nursing maternal and newborn care training covering antenatal, delivery and postnatal support within community healthcare settings. 2-year professional track">
  <article class="card-brand program-card d-flex flex-column">
    <div class="media-frame ratio-16x9">
      <span class="badge-brand  badge-float">Nursing</span>
      <img src="{{ asset('frontend/assets/images/programs/maternal.jpg') }}" alt="CMW (Community Midwife) program at King TAS College" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-emoji-smile text-brand fs-5"></i>
        <h3 class="h6 mb-0">CMW (Community Midwife)</h3>
      </div>
      <p class="small text-soft flex-grow-1">Maternal and newborn care training covering antenatal, delivery and postnatal support within community healthcare settings.</p>
      <div class="meta-row mb-2">
        <span><i class="bi bi-clock me-1"></i>18 months (Diploma Program)</span>
      </div>
      <div class="meta-row mb-3">
        <span><i class="bi bi-mortarboard me-1"></i>Matric (Arts or Science), min. 40% &bull; Age 14&ndash;40</span>
      </div>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-brand btn-sm flex-fill" href="{{ route('frontend.program-details') }}?program=cmw">Learn More</a>
        <a class="btn btn-brand-red btn-sm flex-fill" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
      </div>
    </div>
  </article>
</div>
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="2" data-item data-category="Nursing" data-tags="Professional Track" data-search="cna (certified nursing assistant) nursing entry-level patient-care training covering basic nursing assistance, hygiene care, vitals monitoring and ward support. professional track">
  <article class="card-brand program-card d-flex flex-column">
    <div class="media-frame ratio-16x9">
      <span class="badge-brand  badge-float">Nursing</span>
      <img src="{{ asset('frontend/assets/images/programs/clinical.jpg') }}" alt="CNA (Certified Nursing Assistant) program at King TAS College" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-bandaid text-brand fs-5"></i>
        <h3 class="h6 mb-0">CNA (Certified Nursing Assistant)</h3>
      </div>
      <p class="small text-soft flex-grow-1">Entry-level patient-care training covering basic nursing assistance, hygiene care, vitals monitoring and ward support.</p>
      <div class="meta-row mb-2">
        <span><i class="bi bi-clock me-1"></i>2 years (Diploma Program)</span>
      </div>
      <div class="meta-row mb-3">
        <span><i class="bi bi-mortarboard me-1"></i>FSc / Matric Science 45%, or Matric Arts / FA 50% &bull; Age 14&ndash;35</span>
      </div>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-brand btn-sm flex-fill" href="{{ route('frontend.program-details') }}?program=cna">Learn More</a>
        <a class="btn btn-brand-red btn-sm flex-fill" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
      </div>
    </div>
  </article>
</div>
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="3" data-item data-category="Allied Health" data-tags="2-Year|Professional Track" data-search="anesthesia technician allied health technical training in anesthesia equipment handling, operating room preparation and perioperative patient support. 2-year professional track">
  <article class="card-brand program-card d-flex flex-column">
    <div class="media-frame ratio-16x9">
      <span class="badge-brand badge-brand-red badge-float">Allied Health</span>
      <img src="{{ asset('frontend/assets/images/programs/ot.jpg') }}" alt="Anesthesia Technician program at King TAS College" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-lungs text-brand fs-5"></i>
        <h3 class="h6 mb-0">Anesthesia Technician</h3>
      </div>
      <p class="small text-soft flex-grow-1">Technical training in anesthesia equipment handling, operating room preparation and perioperative patient support.</p>
      <div class="meta-row mb-2">
        <span><i class="bi bi-clock me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="meta-row mb-3">
        <span><i class="bi bi-mortarboard me-1"></i>Matric Science, 2nd Div., science 45% &bull; Max age 35</span>
      </div>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-brand btn-sm flex-fill" href="{{ route('frontend.program-details') }}?program=anesthesia-technician">Learn More</a>
        <a class="btn btn-brand-red btn-sm flex-fill" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
      </div>
    </div>
  </article>
</div>
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="1" data-item data-category="Allied Health" data-tags="2-Year|F.Sc Based" data-search="radiography technology + f.sc allied health diagnostic imaging training combined with an f.sc pathway, covering radiographic techniques, positioning and radiation safety. 2-year f.sc based">
  <article class="card-brand program-card d-flex flex-column">
    <div class="media-frame ratio-16x9">
      <span class="badge-brand badge-brand-red badge-float">Allied Health</span>
      <img src="{{ asset('frontend/assets/images/programs/radiology.jpg') }}" alt="Radiography Technology + F.Sc program at King TAS College" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-broadcast text-brand fs-5"></i>
        <h3 class="h6 mb-0">Radiography Technology + F.Sc</h3>
      </div>
      <p class="small text-soft flex-grow-1">Diagnostic imaging training combined with an F.Sc pathway, covering radiographic techniques, positioning and radiation safety.</p>
      <div class="meta-row mb-2">
        <span><i class="bi bi-clock me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="meta-row mb-3">
        <span><i class="bi bi-mortarboard me-1"></i>Matric Science, 2nd Div., science 45% &bull; Max age 35</span>
      </div>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-brand btn-sm flex-fill" href="{{ route('frontend.program-details') }}?program=radiography-technology">Learn More</a>
        <a class="btn btn-brand-red btn-sm flex-fill" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
      </div>
    </div>
  </article>
</div>
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="2" data-item data-category="Allied Health" data-tags="2-Year|F.Sc Based" data-search="medical lab technology + f.sc allied health laboratory science training with an f.sc pathway, covering sample handling, clinical testing and laboratory quality practices. 2-year f.sc based">
  <article class="card-brand program-card d-flex flex-column">
    <div class="media-frame ratio-16x9">
      <span class="badge-brand badge-brand-red badge-float">Allied Health</span>
      <img src="{{ asset('frontend/assets/images/programs/lab.jpg') }}" alt="Medical Lab Technology + F.Sc program at King TAS College" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-eyedropper text-brand fs-5"></i>
        <h3 class="h6 mb-0">Medical Lab Technology + F.Sc</h3>
      </div>
      <p class="small text-soft flex-grow-1">Laboratory science training with an F.Sc pathway, covering sample handling, clinical testing and laboratory quality practices.</p>
      <div class="meta-row mb-2">
        <span><i class="bi bi-clock me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="meta-row mb-3">
        <span><i class="bi bi-mortarboard me-1"></i>Matric Science, 2nd Div., science 45% &bull; Max age 35</span>
      </div>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-brand btn-sm flex-fill" href="{{ route('frontend.program-details') }}?program=medical-lab-technology">Learn More</a>
        <a class="btn btn-brand-red btn-sm flex-fill" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
      </div>
    </div>
  </article>
</div>
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="3" data-item data-category="Allied Health" data-tags="2-Year|Professional Track" data-search="dental technician allied health dental laboratory and chair-side assistance training covering dental materials, appliance work and clinic support skills. 2-year professional track">
  <article class="card-brand program-card d-flex flex-column">
    <div class="media-frame ratio-16x9">
      <span class="badge-brand badge-brand-red badge-float">Allied Health</span>
      <img src="{{ asset('frontend/assets/images/programs/lab.jpg') }}" alt="Dental Technician program at King TAS College" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-emoji-laughing text-brand fs-5"></i>
        <h3 class="h6 mb-0">Dental Technician</h3>
      </div>
      <p class="small text-soft flex-grow-1">Dental laboratory and chair-side assistance training covering dental materials, appliance work and clinic support skills.</p>
      <div class="meta-row mb-2">
        <span><i class="bi bi-clock me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="meta-row mb-3">
        <span><i class="bi bi-mortarboard me-1"></i>Matric Science, 2nd Div., science 45% &bull; Max age 35</span>
      </div>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-brand btn-sm flex-fill" href="{{ route('frontend.program-details') }}?program=dental-technician">Learn More</a>
        <a class="btn btn-brand-red btn-sm flex-fill" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
      </div>
    </div>
  </article>
</div>
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="1" data-item data-category="Allied Health" data-tags="2-Year|F.Sc Based" data-search="operation theater technology + f.sc allied health surgical theatre technology training covering sterilisation, instrument handling, theatre discipline and surgical assistance. 2-year f.sc based">
  <article class="card-brand program-card d-flex flex-column">
    <div class="media-frame ratio-16x9">
      <span class="badge-brand badge-brand-red badge-float">Allied Health</span>
      <img src="{{ asset('frontend/assets/images/programs/ot.jpg') }}" alt="Operation Theater Technology + F.Sc program at King TAS College" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-scissors text-brand fs-5"></i>
        <h3 class="h6 mb-0">Operation Theater Technology + F.Sc</h3>
      </div>
      <p class="small text-soft flex-grow-1">Surgical theatre technology training covering sterilisation, instrument handling, theatre discipline and surgical assistance.</p>
      <div class="meta-row mb-2">
        <span><i class="bi bi-clock me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="meta-row mb-3">
        <span><i class="bi bi-mortarboard me-1"></i>Matric Science, 2nd Div., science 45% &bull; Max age 35</span>
      </div>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-brand btn-sm flex-fill" href="{{ route('frontend.program-details') }}?program=operation-theater-technology">Learn More</a>
        <a class="btn btn-brand-red btn-sm flex-fill" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
      </div>
    </div>
  </article>
</div>
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="2" data-item data-category="Allied Health" data-tags="F.Sc Based|Professional Track" data-search="dispenser + f.sc allied health medicine dispensing training covering prescription handling, dosage awareness, storage practices and patient counselling basics. f.sc based professional track">
  <article class="card-brand program-card d-flex flex-column">
    <div class="media-frame ratio-16x9">
      <span class="badge-brand badge-brand-red badge-float">Allied Health</span>
      <img src="{{ asset('frontend/assets/images/programs/pharmacy.jpg') }}" alt="Dispenser + F.Sc program at King TAS College" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-capsule text-brand fs-5"></i>
        <h3 class="h6 mb-0">Dispenser + F.Sc</h3>
      </div>
      <p class="small text-soft flex-grow-1">Medicine dispensing training covering prescription handling, dosage awareness, storage practices and patient counselling basics.</p>
      <div class="meta-row mb-2">
        <span><i class="bi bi-clock me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="meta-row mb-3">
        <span><i class="bi bi-mortarboard me-1"></i>Matric Science, 2nd Div., science 45% &bull; Max age 35</span>
      </div>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-brand btn-sm flex-fill" href="{{ route('frontend.program-details') }}?program=dispenser">Learn More</a>
        <a class="btn btn-brand-red btn-sm flex-fill" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
      </div>
    </div>
  </article>
</div>
<div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="3" data-item data-category="Allied Health" data-tags="Professional Track" data-search="b-category pharmacy technician allied health pharmacy technician training focused on medicine handling, inventory practices, dispensing support and pharmacy operations. professional track">
  <article class="card-brand program-card d-flex flex-column">
    <div class="media-frame ratio-16x9">
      <span class="badge-brand badge-brand-red badge-float">Allied Health</span>
      <img src="{{ asset('frontend/assets/images/programs/pharmacy.jpg') }}" alt="B-Category Pharmacy Technician program at King TAS College" loading="lazy" width="1200" height="675">
    </div>
    <div class="p-4 d-flex flex-column flex-grow-1">
      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-prescription2 text-brand fs-5"></i>
        <h3 class="h6 mb-0">B-Category Pharmacy Technician</h3>
      </div>
      <p class="small text-soft flex-grow-1">Pharmacy technician training focused on medicine handling, inventory practices, dispensing support and pharmacy operations.</p>
      <div class="meta-row mb-2">
        <span><i class="bi bi-clock me-1"></i>Details to be confirmed by Admissions Office</span>
      </div>
      <div class="meta-row mb-3">
        <span><i class="bi bi-mortarboard me-1"></i>Matric Science or Computer Science, 2nd Div. &bull; No age limit</span>
      </div>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-brand btn-sm flex-fill" href="{{ route('frontend.program-details') }}?program=b-category-pharmacy-technician">Learn More</a>
        <a class="btn btn-brand-red btn-sm flex-fill" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
      </div>
    </div>
  </article>
</div>
<div class="col-12 d-none" data-empty><div class="empty-state">
  <i class="bi bi-search d-block mb-2"></i>
  <p class="mb-0">No programs match your search. Try a different keyword or filter.</p>
</div></div>
</div>
  </div>
</section>

<!-- <section class="section">
  <div class="container">
    <div class="cta-band text-center" data-reveal>
      <span class="eyebrow eyebrow-light mb-3">Admissions Open — Session 2026–27</span>
      <h2>Begin your healthcare career</h2>
      <p class="mb-4">Choose the right program and take the first step toward your professional healthcare journey.</p>
      <div class="d-flex flex-wrap justify-content-center gap-2">
        <a class="btn btn-brand-red btn-lg" href="{{ route('frontend.admission') }}#apply">Apply Now</a>
        <a class="btn btn-outline-light-brand btn-lg" href="{{ route('frontend.contact') }}">Talk to Admissions</a>
      </div>
    </div>
  </div>
</section> -->
</main>
@endsection
