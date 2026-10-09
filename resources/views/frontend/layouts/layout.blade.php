<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>King TAS College of Nursing & Allied Health Sciences | Gojra</title>
    <meta name="description" content="Nursing and allied health sciences education in Gojra, Punjab. Admissions open for session 2026–27 — explore BSN Generic, Post RN, LHV, CMW, CNA and allied health programs.">
    <link rel="canonical" href="/">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="King TAS College of Nursing &amp; Allied Health Sciences">
    <meta property="og:title" content="King TAS College of Nursing & Allied Health Sciences | Gojra">
    <meta property="og:description" content="Nursing and allied health sciences education in Gojra, Punjab. Admissions open for session 2026–27 — explore BSN Generic, Post RN, LHV, CMW, CNA and allied health programs.">
    <meta property="og:url" content="/">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="King TAS College of Nursing & Allied Health Sciences | Gojra">
    <meta name="twitter:description" content="Nursing and allied health sciences education in Gojra, Punjab. Admissions open for session 2026–27 — explore BSN Generic, Post RN, LHV, CMW, CNA and allied health programs.">
    <link rel="icon" href="{{ asset('frontend/assets/images/logo/logo.png') }}" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@400;500;600&family=Noto+Nastaliq+Urdu:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/animations.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/responsive.css') }}">
    @verbatim
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "EducationalOrganization",
            "name": "King TAS College of Nursing & Allied Health Sciences",
            "url": "https://kingtascollege.example/",
            "telephone": ["+92-302-8098542", "+92-326-0298542"],
            "address": {
                "@type": "PostalAddress",
                "streetAddress": "Main Painsara Road, College Road, Near Model City Phase 3",
                "addressLocality": "Gojra",
                "addressRegion": "Punjab",
                "addressCountry": "PK"
            },
            "sameAs": ["https://www.facebook.com/people/King-TAS-college-of-Nursing-and-Allied-Health-Sciences/100063958600873/"]
        }
    </script>
    @endverbatim
</head>

<body>
    <a class="skip-link" href="#main">Skip to main content</a>
    <div class="scroll-progress" id="scrollProgress" aria-hidden="true"></div>

    @include('frontend.layouts.header')

    @yield('content')
   
   @include('frontend.layouts.footer')

    <div class="floating-actions">
        <a class="fab-whatsapp" href="https://wa.me/923028098542?text=Hello%2C%20I%20would%20like%20information%20about%20admissions%20at%20King%20TAS%20College." target="_blank" rel="noopener" aria-label="WhatsApp admissions"><i class="bi bi-whatsapp"></i></a>
        <a class="fab-call" href="tel:+923028098542" aria-label="Call admissions"><i class="bi bi-telephone-fill"></i></a>
        <a class="fab-apply" href="admissions.html#apply" aria-label="Apply now">Apply</a>
    </div>
    <button class="back-to-top" id="backToTop" type="button" aria-label="Back to top"><i class="bi bi-arrow-up"></i></button>

    <nav class="mobile-action-bar" aria-label="Quick actions">
        <a href="tel:+923028098542"><i class="bi bi-telephone-fill"></i>Call</a>
        <a class="whatsapp" href="https://wa.me/923028098542?text=Hello%2C%20I%20would%20like%20information%20about%20admissions%20at%20King%20TAS%20College." target="_blank" rel="noopener"><i class="bi bi-whatsapp"></i>WhatsApp</a>
        <a class="apply" href="admissions.html#apply"><i class="bi bi-pencil-square"></i>Apply</a>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="{{ asset('frontend/assets/js/main.js') }}" defer></script>
    <script src="{{ asset('frontend/assets/js/animations.js') }}" defer></script>
    <script src="{{ asset('frontend/assets/js/filters.js') }}" defer></script>
    <script src="{{ asset('frontend/assets/js/gallery.js') }}" defer></script>
    <script src="{{ asset('frontend/assets/js/forms.js') }}" defer></script>
</body>

</html>