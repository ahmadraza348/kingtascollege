# King TAS College of Nursing & Allied Health Sciences — website

Static frontend built with HTML5, CSS3, Bootstrap 5, Bootstrap Icons and vanilla
JavaScript (no framework). Opening the site root redirects to `index.html`.

## Structure

```
public/
├── index.html, about.html, programs.html, program-details.html,
│   admissions.html, eligibility.html, faculty.html, facilities.html,
│   clinical-training.html, campus-life.html, gallery.html, news.html,
│   news-details.html, events.html, notices.html, faq.html, contact.html,
│   privacy.html, terms.html, sitemap.html, 404.html
└── assets/
    ├── css/  style.css (design tokens + components), animations.css, responsive.css
    ├── js/   data.js (all content), main.js, animations.js, filters.js, gallery.js, forms.js
    └── images/ logo/, hero/, campus/, programs/
```

## Run locally

Any static server works, e.g. `python3 -m http.server` inside `public/`, then
open `http://localhost:8000/index.html`.

## Editing content

All dynamic content lives in `assets/js/data.js`:

- **Programs** — `PROGRAMS` array (`title`, `category`, `tags`, `duration`,
  `eligibility`, `image`, `description`, `careers`). Empty `duration`/`eligibility`
  render as "Details to be confirmed by Admissions Office".
- **News** — `NEWS`; **Events** — `EVENTS`; **Notices** — `NOTICES`;
  **Faculty** — `FACULTY`; **Gallery** — `GALLERY`; **FAQs** — `FAQS`;
  **Testimonials** — `TESTIMONIALS` (placeholders only — never publish invented quotes).
- **Phone numbers, email, address, WhatsApp, Facebook** — the `COLLEGE` object,
  plus the `tel:` links in the shared header/footer markup of each page.

## Replacing images

Drop files into `assets/images/...` keeping the same names, or update the paths in
`data.js`. Keep consistent aspect ratios (16:9 for cards, 4:3 for feature images).

## Connecting the forms to a backend

`assets/js/forms.js` defines `API_BASE_URL`, `ENDPOINTS` and `DEMO_MODE`. Set the
real endpoints, switch `DEMO_MODE` to `false` and uncomment the `fetch` calls in
`initAdmissionForm` / `initContactForm`. Documents must be uploaded to
`ENDPOINTS.fileUpload` as multipart form data. Never put secret keys in this file.

## Urdu / RTL

`main.js` handles the English/اردو switch: it sets `lang` and `dir` on `<html>` and
swaps text on elements carrying a `data-ur="..."` attribute. RTL overrides live at
the end of `style.css` under `html[dir="rtl"]`.

## Deploy

Publish the project from Lovable, or copy `public/` to any static host.

## Content accuracy

Program names, durations, eligibility, faculty, facilities, fees, scholarships and
office hours are unverified placeholders and are labelled as such in the UI. They
must be confirmed by the college administration before publishing.
