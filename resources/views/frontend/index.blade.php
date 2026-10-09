@extends('frontend.layouts.layout')

@section('content')
 <main id="main">
        <section class="hero">
            <div class="hero-bg" style="background-image:url('{{ asset('frontend/assets/images/hero/hero-nursing.jpg') }}')" role="img" aria-label="Nursing students training in a skills laboratory"></div>
            <span class="hero-shape s1" aria-hidden="true"></span>
            <span class="hero-shape s2" aria-hidden="true"></span>
            <svg class="hero-ecg" viewBox="0 0 1200 80" preserveAspectRatio="none" height="60" aria-hidden="true">
                <path d="M0 40 H180 l20 -26 l18 52 l20 -26 H520 l22 -34 l20 68 l18 -34 H900 l24 -20 l18 40 l16 -20 H1200"
                    fill="none" stroke="#7fb3ea" stroke-width="2"></path>
            </svg>
            <div class="container">
                <div class="row align-items-center g-5">
                    <div class="col-lg-7">
                        <span class="eyebrow eyebrow-light">King TAS College of Nursing &amp; Allied Health Sciences</span>
                        <h1>Empowering the next generation of healthcare professionals</h1>
                        <p class="hero-text">Build your future in nursing and allied health sciences through practical learning, professional
                            development and healthcare-focused education in Gojra, District Toba Tek Singh.</p>
                        <div class="hero-actions">
                            <a class="btn btn-brand-red btn-lg" href="admissions.html#apply">Apply Now</a>
                            <a class="btn btn-outline-light-brand btn-lg" href="programs.html">Explore Programs</a>
                            <a class="btn btn-ghost-brand btn-lg text-white" href="contact.html">Contact Admissions <i class="bi bi-arrow-right ms-1"></i></a>
                        </div>
                        <div class="hero-facts">
                            <span class="hero-fact"><i class="bi bi-heart-pulse"></i>Nursing programs</span>
                            <span class="hero-fact"><i class="bi bi-activity"></i>Allied health programs</span>
                            <span class="hero-fact"><i class="bi bi-geo-alt"></i>Gojra, Punjab</span>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="hero-card">
                            <span class="eyebrow eyebrow-red mb-3">Admissions Open</span>
                            <h3>Session 2026–27</h3>
                            <p class="small text-soft">Applications are being accepted for selected nursing and allied health programs.</p>
                            <ul class="list-check mb-3">
                                <li><i class="bi bi-check-circle-fill"></i><span>Nursing: BSN Generic, Post RN, LHV, CMW, CNA</span></li>
                                <li><i class="bi bi-check-circle-fill"></i><span>Allied Health: Lab, Radiography, OT, Anesthesia and more</span></li>
                                <li><i class="bi bi-check-circle-fill"></i><span>Guidance from the admissions office at every step</span></li>
                            </ul>
                            <a class="btn btn-brand w-100 mb-2" href="admissions.html#apply">Start your application</a>
                            <a class="btn btn-outline-brand w-100" href="tel:+923028098542"><i class="bi bi-telephone me-2"></i>0302-8098542</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-sm">
            <div class="container">
                <div class="admissions-banner d-flex flex-wrap align-items-center gap-4" data-reveal>
                    <i class="bi bi-megaphone-fill banner-icon d-none d-md-block" aria-hidden="true"></i>
                    <div class="flex-grow-1">
                        <h2 class="h4 mb-1">Admissions open 2026–27</h2>
                        <p class="mb-0 small">Applications are now being accepted for selected nursing and allied health programs.
                            Admission deadlines will be announced by the college administration.</p>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <a class="btn btn-light" href="admissions.html#apply">Apply for Admission</a>
                        <a class="btn btn-outline-light-brand" href="programs.html">View Programs</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-sm">
            <div class="container">
                <div class="row g-4">

                    <div class="col-6 col-lg-3" data-reveal data-reveal-delay="1">
                        <div class="card-brand p-4 h-100">
                            <span class="icon-badge mb-3"><i class="bi bi-heart-pulse"></i></span>
                            <h3 class="h6">Nursing</h3>
                            <p class="small text-soft mb-0">Professional nursing education pathways.</p>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3" data-reveal data-reveal-delay="2">
                        <div class="card-brand p-4 h-100">
                            <span class="icon-badge mb-3"><i class="bi bi-activity"></i></span>
                            <h3 class="h6">Allied Health</h3>
                            <p class="small text-soft mb-0">Healthcare technical training programs.</p>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3" data-reveal data-reveal-delay="3">
                        <div class="card-brand p-4 h-100">
                            <span class="icon-badge mb-3"><i class="bi bi-clipboard2-pulse"></i></span>
                            <h3 class="h6">Practical Learning</h3>
                            <p class="small text-soft mb-0">Hands-on skill development sessions.</p>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3" data-reveal data-reveal-delay="1">
                        <div class="card-brand p-4 h-100">
                            <span class="icon-badge mb-3"><i class="bi bi-briefcase"></i></span>
                            <h3 class="h6">Career Focused</h3>
                            <p class="small text-soft mb-0">Preparation for healthcare workplaces.</p>
                        </div>
                    </div>
                </div>
                <p class="placeholder-note text-center mt-3 mb-0">Qualitative highlights — verified institutional statistics will be added by the college administration.</p>
            </div>
        </section>

        <section class="section bg-light-soft">
            <div class="container">
                <div class="row align-items-center g-5">
                    <div class="col-lg-6" data-reveal="left">
                        <div class="media-frame rounded-brand shadow-brand ratio-4x3">
                            <img src="{{ asset('frontend/assets/images/campus/campus.jpg') }}" alt="King TAS College campus building" loading="lazy" width="1280" height="900">
                        </div>
                    </div>
                    <div class="col-lg-6" data-reveal="right">
                        <span class="eyebrow">About the college</span>
                        <h2 class="mt-3">A healthcare-focused institute in Gojra</h2>
                        <p class="lead-text">King TAS College of Nursing &amp; Allied Health Sciences focuses on nursing and allied health
                            education, preparing students for professional healthcare environments through structured study and practical training.</p>
                        <div class="row g-3 mt-2">
                            <div class="col-sm-6">
                                <div class="card-brand p-3 h-100">
                                    <h3 class="h6"><i class="bi bi-bullseye text-brand me-2"></i>Mission</h3>
                                    <p class="small mb-0">Deliver healthcare education that develops competent, responsible and compassionate professionals.</p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card-brand p-3 h-100">
                                    <h3 class="h6"><i class="bi bi-eye text-brand me-2"></i>Vision</h3>
                                    <p class="small mb-0">Be a trusted regional institute for nursing and allied health learning.</p>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap gap-2 mt-4">
                            <span class="badge badge-soft">Professionalism</span><span class="badge badge-soft">Compassion</span>
                            <span class="badge badge-soft">Integrity</span><span class="badge badge-soft">Patient Safety</span>
                            <span class="badge badge-soft">Excellence</span><span class="badge badge-soft">Lifelong Learning</span>
                        </div>
                        <p class="placeholder-note mt-3">Suggested mission, vision and values — to be approved by the college administration.</p>
                        <a class="btn btn-brand mt-2" href="about.html">More about us</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="section">
            <div class="container">
                <div class="section-header">
                    <span class="eyebrow">Programs</span>
                    <h2>Featured nursing &amp; allied health programs</h2>
                    <p>Explore healthcare programs offered at King TAS College. Duration and eligibility details are confirmed by the admissions office.</p>
                </div>
                <div class="row g-4" id="programGrid">
                    <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="1">
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
                                    <span><i class="bi bi-clock me-1"></i>Details to be confirmed by Admissions Office</span>
                                </div>
                                <div class="meta-row mb-3">
                                    <span><i class="bi bi-mortarboard me-1"></i>Details to be confirmed by Admissions Office</span>
                                </div>
                                <div class="d-flex gap-2">
                                    <a class="btn btn-outline-brand btn-sm flex-fill" href="program-details.html?program=bsn-generic">Learn More</a>
                                    <a class="btn btn-brand-red btn-sm flex-fill" href="admissions.html#apply">Apply Now</a>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="2">
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
                                    <span><i class="bi bi-clock me-1"></i>Details to be confirmed by Admissions Office</span>
                                </div>
                                <div class="meta-row mb-3">
                                    <span><i class="bi bi-mortarboard me-1"></i>Details to be confirmed by Admissions Office</span>
                                </div>
                                <div class="d-flex gap-2">
                                    <a class="btn btn-outline-brand btn-sm flex-fill" href="program-details.html?program=post-rn">Learn More</a>
                                    <a class="btn btn-brand-red btn-sm flex-fill" href="admissions.html#apply">Apply Now</a>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="3">
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
                                    <span><i class="bi bi-clock me-1"></i>Details to be confirmed by Admissions Office</span>
                                </div>
                                <div class="meta-row mb-3">
                                    <span><i class="bi bi-mortarboard me-1"></i>Details to be confirmed by Admissions Office</span>
                                </div>
                                <div class="d-flex gap-2">
                                    <a class="btn btn-outline-brand btn-sm flex-fill" href="program-details.html?program=lhv">Learn More</a>
                                    <a class="btn btn-brand-red btn-sm flex-fill" href="admissions.html#apply">Apply Now</a>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="1">
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
                                    <span><i class="bi bi-clock me-1"></i>Details to be confirmed by Admissions Office</span>
                                </div>
                                <div class="meta-row mb-3">
                                    <span><i class="bi bi-mortarboard me-1"></i>Details to be confirmed by Admissions Office</span>
                                </div>
                                <div class="d-flex gap-2">
                                    <a class="btn btn-outline-brand btn-sm flex-fill" href="program-details.html?program=cmw">Learn More</a>
                                    <a class="btn btn-brand-red btn-sm flex-fill" href="admissions.html#apply">Apply Now</a>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="2">
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
                                    <span><i class="bi bi-clock me-1"></i>Details to be confirmed by Admissions Office</span>
                                </div>
                                <div class="meta-row mb-3">
                                    <span><i class="bi bi-mortarboard me-1"></i>Details to be confirmed by Admissions Office</span>
                                </div>
                                <div class="d-flex gap-2">
                                    <a class="btn btn-outline-brand btn-sm flex-fill" href="program-details.html?program=cna">Learn More</a>
                                    <a class="btn btn-brand-red btn-sm flex-fill" href="admissions.html#apply">Apply Now</a>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="3">
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
                                    <span><i class="bi bi-mortarboard me-1"></i>Details to be confirmed by Admissions Office</span>
                                </div>
                                <div class="d-flex gap-2">
                                    <a class="btn btn-outline-brand btn-sm flex-fill" href="program-details.html?program=anesthesia-technician">Learn More</a>
                                    <a class="btn btn-brand-red btn-sm flex-fill" href="admissions.html#apply">Apply Now</a>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
                <div class="text-center mt-4"><a class="btn btn-outline-brand btn-lg" href="programs.html">View all programs</a></div>
            </div>
        </section>

        <section class="section bg-light-soft">
            <div class="container">
                <div class="section-header">
                    <span class="eyebrow">Why King TAS</span>
                    <h2>Why students &amp; families choose us</h2>
                    <p>An academic environment built around healthcare careers, practical skill and student support.</p>
                </div>
                <div class="row g-4">

                    <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="1">
                        <div class="card-brand p-4 h-100">
                            <span class="icon-badge mb-3"><i class="bi bi-clipboard2-pulse"></i></span>
                            <h3 class="h6">Practical healthcare training</h3>
                            <p class="small text-soft mb-0">Focus on practical skills and real healthcare environments.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="2">
                        <div class="card-brand p-4 h-100">
                            <span class="icon-badge mb-3"><i class="bi bi-mortarboard"></i></span>
                            <h3 class="h6">Professional learning environment</h3>
                            <p class="small text-soft mb-0">An academic setting designed around healthcare education.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="3">
                        <div class="card-brand p-4 h-100">
                            <span class="icon-badge mb-3"><i class="bi bi-heart-pulse"></i></span>
                            <h3 class="h6">Nursing &amp; allied health focus</h3>
                            <p class="small text-soft mb-0">Programs specifically oriented toward healthcare careers.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="1">
                        <div class="card-brand p-4 h-100">
                            <span class="icon-badge mb-3"><i class="bi bi-bandaid"></i></span>
                            <h3 class="h6">Clinical skill development</h3>
                            <p class="small text-soft mb-0">Emphasis on hands-on training and professional competencies.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="2">
                        <div class="card-brand p-4 h-100">
                            <span class="icon-badge mb-3"><i class="bi bi-briefcase"></i></span>
                            <h3 class="h6">Career preparation</h3>
                            <p class="small text-soft mb-0">Preparing learners for healthcare workplace environments.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="3">
                        <div class="card-brand p-4 h-100">
                            <span class="icon-badge mb-3"><i class="bi bi-people"></i></span>
                            <h3 class="h6">Student support</h3>
                            <p class="small text-soft mb-0">Admission guidance and student-focused support.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section">
            <div class="container">
                <div class="row align-items-center g-5">
                    <div class="col-lg-6 order-lg-2" data-reveal="right">
                        <div class="media-frame rounded-brand shadow-brand ratio-4x3">
                            <img src="{{ asset('frontend/assets/images/programs/clinical.jpg') }}" alt="Nurse checking a patient's blood pressure during clinical training" loading="lazy" width="1200" height="800">
                        </div>
                    </div>
                    <div class="col-lg-6" data-reveal="left">
                        <span class="eyebrow">Clinical training</span>
                        <h2 class="mt-3">Learning that moves from classroom to bedside</h2>
                        <p class="lead-text">Students practise procedures under supervision, building confidence in patient care, safety and
                            professional communication.</p>
                        <ul class="list-check">
                            <li><i class="bi bi-check-circle-fill"></i><span>Practical nursing and patient-care skills</span></li>
                            <li><i class="bi bi-check-circle-fill"></i><span>Clinical procedures and laboratory skills</span></li>
                            <li><i class="bi bi-check-circle-fill"></i><span>Emergency-care learning and infection-control awareness</span></li>
                            <li><i class="bi bi-check-circle-fill"></i><span>Professional communication with patients and teams</span></li>
                        </ul>
                        <a class="btn btn-brand mt-3" href="clinical-training.html">Explore clinical training</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="section bg-light-soft">
            <div class="container">
                <div class="section-header">
                    <span class="eyebrow">Campus &amp; facilities</span>
                    <h2>Learning spaces designed for healthcare study</h2>
                    <p>Facilities shown here are indicative during development and will be confirmed by the college administration.</p>
                </div>
                <div class="row g-4">

                    <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="1">
                        <div class="card-brand p-4 h-100">
                            <span class="icon-badge mb-3"><i class="bi bi-hospital"></i></span>
                            <h3 class="h6">Skills laboratory</h3>
                            <p class="small text-soft mb-0">A nursing skills practice environment for supervised procedure training.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="2">
                        <div class="card-brand p-4 h-100">
                            <span class="icon-badge mb-3"><i class="bi bi-eyedropper"></i></span>
                            <h3 class="h6">Science laboratories</h3>
                            <p class="small text-soft mb-0">Laboratory and practical learning spaces for allied health subjects.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="3">
                        <div class="card-brand p-4 h-100">
                            <span class="icon-badge mb-3"><i class="bi bi-easel"></i></span>
                            <h3 class="h6">Classrooms</h3>
                            <p class="small text-soft mb-0">Professional teaching spaces for theory and discussion sessions.</p>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-4"><a class="btn btn-outline-brand" href="facilities.html">See all facilities</a></div>
            </div>
        </section>

        <section class="section">
            <div class="container">
                <div class="section-header">
                    <span class="eyebrow">Student experience</span>
                    <h2>Student voices</h2>
                    <p>Testimonials are placeholders until verified student statements are supplied by the college.</p>
                </div>
                <div class="row g-4" id="testimonialGrid">
                    <div class="col-md-4" data-reveal data-reveal-delay="1">
                        <div class="card-brand testimonial-card h-100">
                            <i class="bi bi-quote quote-mark" aria-hidden="true"></i>
                            <p class="small">Student testimonial placeholder — this space is reserved for a verified student experience provided by the college.</p>
                            <div class="d-flex align-items-center gap-2 mt-3">
                                <i class="bi bi-person-circle fs-3 text-brand" aria-hidden="true"></i>
                                <div>
                                    <p class="fw-600 mb-0 small">Student name placeholder</p>
                                    <p class="small text-soft mb-0">Nursing program · Session placeholder</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4" data-reveal data-reveal-delay="2">
                        <div class="card-brand testimonial-card h-100">
                            <i class="bi bi-quote quote-mark" aria-hidden="true"></i>
                            <p class="small">Student testimonial placeholder — the administration can replace this text with an approved student statement.</p>
                            <div class="d-flex align-items-center gap-2 mt-3">
                                <i class="bi bi-person-circle fs-3 text-brand" aria-hidden="true"></i>
                                <div>
                                    <p class="fw-600 mb-0 small">Student name placeholder</p>
                                    <p class="small text-soft mb-0">Allied health program · Session placeholder</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4" data-reveal data-reveal-delay="3">
                        <div class="card-brand testimonial-card h-100">
                            <i class="bi bi-quote quote-mark" aria-hidden="true"></i>
                            <p class="small">Student testimonial placeholder — add a real, verified testimonial before publishing the website.</p>
                            <div class="d-flex align-items-center gap-2 mt-3">
                                <i class="bi bi-person-circle fs-3 text-brand" aria-hidden="true"></i>
                                <div>
                                    <p class="fw-600 mb-0 small">Student name placeholder</p>
                                    <p class="small text-soft mb-0">Program placeholder · Session placeholder</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section bg-light-soft">
            <div class="container">
                <div class="section-header">
                    <span class="eyebrow">Latest news</span>
                    <h2>News from the college</h2>
                    <p>Academic updates, admission announcements and campus activities.</p>
                </div>
                <div class="row g-4" id="newsGrid">
                    <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="1">
                        <article class="card-brand news-card d-flex flex-column">
                            <a class="media-frame ratio-16x9 d-block" href="news-details.html?article=admissions-open-2026">
                                <img src="{{ asset('frontend/assets/images/campus/campus.jpg') }}" alt="Admissions open for session 2026–27" loading="lazy" width="1200" height="675">
                            </a>
                            <div class="p-4 d-flex flex-column flex-grow-1">
                                <div class="news-meta mb-2">
                                    <span class="badge badge-soft">Admissions</span>
                                    <span><i class="bi bi-calendar3 me-1"></i>10 Aug 2026</span>
                                </div>
                                <h3><a class="text-reset" href="news-details.html?article=admissions-open-2026">Admissions open for session 2026–27</a></h3>
                                <p class="small text-soft flex-grow-1">Applications are being accepted for selected nursing and allied health programs. Visit the campus or contact the admissions office for guidance.</p>
                                <a class="fw-600 small" href="news-details.html?article=admissions-open-2026">Read More <i class="bi bi-arrow-right ms-1"></i></a>
                            </div>
                        </article>
                    </div>
                    <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="2">
                        <article class="card-brand news-card d-flex flex-column">
                            <a class="media-frame ratio-16x9 d-block" href="news-details.html?article=skills-lab-session">
                                <img src="{{ asset('frontend/assets/images/hero/hero-nursing.jpg') }}" alt="Nursing skills lab practice sessions scheduled" loading="lazy" width="1200" height="675">
                            </a>
                            <div class="p-4 d-flex flex-column flex-grow-1">
                                <div class="news-meta mb-2">
                                    <span class="badge badge-soft">Academic</span>
                                    <span><i class="bi bi-calendar3 me-1"></i>28 Jul 2026</span>
                                </div>
                                <h3><a class="text-reset" href="news-details.html?article=skills-lab-session">Nursing skills lab practice sessions scheduled</a></h3>
                                <p class="small text-soft flex-grow-1">Structured skills lab sessions help students practise core nursing procedures in a supervised learning environment.</p>
                                <a class="fw-600 small" href="news-details.html?article=skills-lab-session">Read More <i class="bi bi-arrow-right ms-1"></i></a>
                            </div>
                        </article>
                    </div>
                    <div class="col-md-6 col-lg-4" data-reveal data-reveal-delay="3">
                        <article class="card-brand news-card d-flex flex-column">
                            <a class="media-frame ratio-16x9 d-block" href="news-details.html?article=health-awareness-seminar">
                                <img src="{{ asset('frontend/assets/images/campus/classroom.jpg') }}" alt="Health awareness seminar for students" loading="lazy" width="1200" height="675">
                            </a>
                            <div class="p-4 d-flex flex-column flex-grow-1">
                                <div class="news-meta mb-2">
                                    <span class="badge badge-soft">Seminars</span>
                                    <span><i class="bi bi-calendar3 me-1"></i>15 Jul 2026</span>
                                </div>
                                <h3><a class="text-reset" href="news-details.html?article=health-awareness-seminar">Health awareness seminar for students</a></h3>
                                <p class="small text-soft flex-grow-1">A student seminar focused on community health awareness, hygiene practices and preventive healthcare communication.</p>
                                <a class="fw-600 small" href="news-details.html?article=health-awareness-seminar">Read More <i class="bi bi-arrow-right ms-1"></i></a>
                            </div>
                        </article>
                    </div>
                </div>
                <div class="text-center mt-4"><a class="btn btn-outline-brand" href="news.html">All news</a></div>
            </div>
        </section>

        <section class="section">
            <div class="container">
                <div class="section-header">
                    <span class="eyebrow">Upcoming events</span>
                    <h2>What's happening next</h2>
                    <p>Guidance days, workshops and student activities at King TAS College.</p>
                </div>
                <div class="row g-4" id="eventsGrid">
                    <div class="col-md-6" data-reveal data-reveal-delay="1">
                        <article class="card-brand h-100">
                            <div class="media-frame ratio-16x9">
                                <img src="{{ asset('frontend/assets/images/campus/campus.jpg') }}" alt="Admission guidance day" loading="lazy" width="1200" height="675">
                            </div>
                            <div class="p-4 d-flex gap-3">
                                <div class="event-date">
                                    <span class="day">5</span>
                                    <span class="mon">Sep</span>
                                </div>
                                <div>
                                    <h3 class="h6 mb-1">Admission guidance day</h3>
                                    <p class="small text-soft mb-2"><i class="bi bi-geo-alt me-1"></i>King TAS College Campus, Gojra</p>
                                    <p class="small text-soft mb-2">Meet the admissions team, tour the campus and discuss program options, eligibility and application steps.</p>
                                    <span class="badge badge-soft">Open</span>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="col-md-6" data-reveal data-reveal-delay="2">
                        <article class="card-brand h-100">
                            <div class="media-frame ratio-16x9">
                                <img src="{{ asset('frontend/assets/images/hero/hero-nursing.jpg') }}" alt="Clinical skills workshop" loading="lazy" width="1200" height="675">
                            </div>
                            <div class="p-4 d-flex gap-3">
                                <div class="event-date">
                                    <span class="day">19</span>
                                    <span class="mon">Sep</span>
                                </div>
                                <div>
                                    <h3 class="h6 mb-1">Clinical skills workshop</h3>
                                    <p class="small text-soft mb-2"><i class="bi bi-geo-alt me-1"></i>Skills Laboratory</p>
                                    <p class="small text-soft mb-2">A hands-on session covering patient assessment basics, vitals monitoring and infection-control practice.</p>
                                    <span class="badge badge-soft">Registration soon</span>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
                <div class="text-center mt-4"><a class="btn btn-outline-brand" href="events.html">View all events</a></div>
            </div>
        </section>

        <section class="section bg-light-soft">
            <div class="container">
                <div class="section-header">
                    <span class="eyebrow">Gallery</span>
                    <h2>Life at King TAS College</h2>
                    <p>A look at classrooms, laboratories and practical learning sessions.</p>
                </div>
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
                </div>
                <div class="text-center mt-4"><a class="btn btn-outline-brand" href="gallery.html">Open full gallery</a></div>
            </div>
        </section>

        <section class="section">
            <div class="container">
                <div class="row g-5">
                    <div class="col-lg-5">
                        <span class="eyebrow">FAQ</span>
                        <h2 class="mt-3">Questions from students and parents</h2>
                        <p class="lead-text">Answers about applying, eligibility and studying at King TAS College.</p>
                        <a class="btn btn-outline-brand" href="faq.html">Browse all FAQs</a>
                    </div>
                    <div class="col-lg-7">
                        <div class="accordion accordion-brand" id="faqAccordion">
                            <div class="accordion-item" data-reveal data-item data-category="Admissions" data-search="how can i apply for admission? you can submit the online admission form on this website or visit the campus admissions office. the admissions team will guide you through document requirements and next steps.">
                                <h3 class="accordion-header" id="faqH0">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#faqC0" aria-expanded="false" aria-controls="faqC0">
                                        How can I apply for admission?
                                    </button>
                                </h3>
                                <div id="faqC0" class="accordion-collapse collapse" aria-labelledby="faqH0" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">You can submit the online admission form on this website or visit the campus admissions office. The admissions team will guide you through document requirements and next steps.</div>
                                </div>
                            </div>
                            <div class="accordion-item" data-reveal data-item data-category="Admissions" data-search="are admissions currently open? admissions are open for session 2026–27 for selected nursing and allied health programs. please contact the admissions office to confirm availability for a specific program.">
                                <h3 class="accordion-header" id="faqH1">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#faqC1" aria-expanded="false" aria-controls="faqC1">
                                        Are admissions currently open?
                                    </button>
                                </h3>
                                <div id="faqC1" class="accordion-collapse collapse" aria-labelledby="faqH1" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">Admissions are open for session 2026–27 for selected nursing and allied health programs. Please contact the admissions office to confirm availability for a specific program.</div>
                                </div>
                            </div>
                            <div class="accordion-item" data-reveal data-item data-category="Admissions" data-search="is there an admission deadline? deadline information will be announced by the college administration. please confirm current dates with the admissions office.">
                                <h3 class="accordion-header" id="faqH2">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#faqC2" aria-expanded="false" aria-controls="faqC2">
                                        Is there an admission deadline?
                                    </button>
                                </h3>
                                <div id="faqC2" class="accordion-collapse collapse" aria-labelledby="faqH2" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">Deadline information will be announced by the college administration. Please confirm current dates with the admissions office.</div>
                                </div>
                            </div>
                            <div class="accordion-item" data-reveal data-item data-category="Programs" data-search="which programs does the college offer? the college offers nursing programs including bsn generic, post rn, lhv, cmw and cna, along with allied health programs such as anesthesia technician, radiography technology, medical lab technology, dental technician, operation theater technology, dispenser and b-category pharmacy technician.">
                                <h3 class="accordion-header" id="faqH3">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#faqC3" aria-expanded="false" aria-controls="faqC3">
                                        Which programs does the college offer?
                                    </button>
                                </h3>
                                <div id="faqC3" class="accordion-collapse collapse" aria-labelledby="faqH3" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">The college offers nursing programs including BSN Generic, Post RN, LHV, CMW and CNA, along with allied health programs such as Anesthesia Technician, Radiography Technology, Medical Lab Technology, Dental Technician, Operation Theater Technology, Dispenser and B-Category Pharmacy Technician.</div>
                                </div>
                            </div>
                            <div class="accordion-item" data-reveal data-item data-category="Programs" data-search="can i change my program after applying? program change requests are handled by the admissions office and depend on eligibility and seat availability.">
                                <h3 class="accordion-header" id="faqH4">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#faqC4" aria-expanded="false" aria-controls="faqC4">
                                        Can I change my program after applying?
                                    </button>
                                </h3>
                                <div id="faqC4" class="accordion-collapse collapse" aria-labelledby="faqH4" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">Program change requests are handled by the admissions office and depend on eligibility and seat availability.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-sm">
            <div class="container">
                <div class="card-brand p-4 d-flex flex-wrap align-items-center gap-3" data-reveal>
                    <i class="bi bi-facebook fs-2 text-brand" aria-hidden="true"></i>
                    <div class="flex-grow-1">
                        <h2 class="h6 mb-1">Follow King TAS College</h2>
                        <p class="small text-soft mb-0">Admission updates and campus activity announcements are shared on the official Facebook page.</p>
                    </div>
                    <a class="btn btn-brand" href="https://www.facebook.com/people/King-TAS-college-of-Nursing-and-Allied-Health-Sciences/100063958600873/" target="_blank" rel="noopener">Follow Us on Facebook</a>
                </div>
            </div>
        </section>

        <section class="section">
            <div class="container">
                <div class="cta-band text-center" data-reveal>
                    <span class="eyebrow eyebrow-light mb-3">Admissions Open — Session 2026–27</span>
                    <h2>Begin your healthcare career</h2>
                    <p class="mb-4">Choose the right program and take the first step toward your professional healthcare journey.</p>
                    <div class="d-flex flex-wrap justify-content-center gap-2">
                        <a class="btn btn-brand-red btn-lg" href="admissions.html#apply">Apply Now</a>
                        <a class="btn btn-outline-light-brand btn-lg" href="contact.html">Talk to Admissions</a>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection