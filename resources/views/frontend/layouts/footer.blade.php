<footer class="site-footer">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-4">
        <div class="footer-brand">
          <img src="{{ asset('frontend/assets/images/logo/logo.png') }}" alt="King TAS College logo" width="52" height="52" loading="lazy">
          <span>King TAS College<br><small style="font-weight:400;font-size:.75rem">Nursing &amp; Allied Health Sciences</small></span>
        </div>
        <p class="small">A nursing and allied health sciences institute in Gojra, District Toba Tek Singh, focused on practical
        healthcare education and professional student development.</p>
        <div class="footer-social mt-3">
          <a href="https://www.facebook.com/people/King-TAS-college-of-Nursing-and-Allied-Health-Sciences/100063958600873/" target="_blank" rel="noopener" aria-label="Facebook page"><i class="bi bi-facebook"></i></a>
          <a href="https://www.instagram.com/king.tas.college/" target="_blank" rel="noopener" aria-label="Instagram page"><i class="bi bi-instagram"></i></a>
          <a href="https://wa.me/923028098542?text=Hello%2C%20I%20would%20like%20information%20about%20admissions%20at%20King%20TAS%20College." target="_blank" rel="noopener" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
          <a href="tel:+923028098542" aria-label="Call the college"><i class="bi bi-telephone"></i></a>
        </div>
      </div>
      <div class="col-6 col-lg-2">
        <h4>Quick Links</h4>
        <ul>
          <li><a href="{{ route('frontend.about') }}">About</a></li>
          <li><a href="{{ route('frontend.all_program') }}">Programs</a></li>
          <li><a href="{{ route('frontend.admission') }}">Admissions</a></li>
          <!-- <li><a href="{{ route('frontend.faculty') }}">Faculty</a></li> -->
          <!-- <li><a href="{{ route('frontend.campus-life') }}">Campus</a></li> -->
          <li><a href="{{ route('frontend.gallery') }}">Gallery</a></li>
          <li><a href="{{ route('frontend.contact') }}">Contact</a></li>
        </ul>
      </div>
      <div class="col-6 col-lg-3">
        <h4>Programs</h4>
        <ul>
          <li><a href="{{ route('frontend.program-details') }}?program=bsn-generic">BSN Generic</a></li>
          <li><a href="{{ route('frontend.program-details') }}?program=post-rn">Post RN</a></li>
          <li><a href="{{ route('frontend.program-details') }}?program=lhv">LHV</a></li>
          <li><a href="{{ route('frontend.program-details') }}?program=cmw">CMW</a></li>
          <li><a href="{{ route('frontend.program-details') }}?program=medical-lab-technology">Medical Lab Technology</a></li>
          <li><a href="{{ route('frontend.program-details') }}?program=radiography-technology">Radiography Technology</a></li>
          <li><a href="{{ route('frontend.all_program') }}">All programs</a></li>
        </ul>
      </div>
      <div class="col-lg-3">
        <h4>Contact</h4>
        <ul class="footer-contact">
          <li><i class="bi bi-geo-alt"></i><span>Main Painsara Road, College Road, Near Model City Phase 3, Gojra, District Toba Tek Singh, Punjab, Pakistan</span></li>
          <li><i class="bi bi-telephone"></i><span><a href="tel:+923028098542">0302-8098542</a><br><a href="tel:+923260298542">0326-0298542</a></span></li>
          <li><i class="bi bi-envelope"></i><a href="mailto:info@kingtascollege.com">info@kingtascollege.com</a></li>
          <li><i class="bi bi-clock"></i><span>College Time:<br>8:00 AM to 3:00 PM</span></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom d-flex flex-wrap justify-content-between gap-2">
      <p class="mb-0">© <span data-year>2026</span> King TAS College of Nursing &amp; Allied Health Sciences. All rights reserved.</p>
      <p class="mb-0 d-flex gap-3">
        <a href="{{ route('frontend.privacy') }}">Privacy Policy</a>
        <a href="{{ route('frontend.terms') }}">Terms &amp; Conditions</a>
        <!-- <a href="{{ route('frontend.sitemap') }}">Site Map</a> -->
      </p>
    </div>
  </div>
</footer>
