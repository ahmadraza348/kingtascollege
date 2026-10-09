/* ==========================================================================
   Content data layer.
   Everything the site renders dynamically lives here so the college can edit
   content without touching markup. Replace values marked TBC once the
   administration confirms official information.
   ========================================================================== */

const COLLEGE = {
  name: "King TAS College of Nursing & Allied Health Sciences",
  shortName: "King TAS College",
  address:
    "Main Painsara Road, College Road, Near Model City Phase 3, Gojra, District Toba Tek Singh, Punjab, Pakistan",
  phones: ["0302-8098542", "0326-0298542"],
  // Placeholder — replace with the official college email address.
  email: "info@kingtascollege.edu.pk",
  facebook:
    "https://www.facebook.com/people/King-TAS-college-of-Nursing-and-Allied-Health-Sciences/100063958600873/",
  whatsapp: "923028098542",
  whatsappMessage:
    "Hello, I would like information about admissions at King TAS College.",
  session: "2026–27",
  // Office hours are a placeholder until confirmed by the college.
  hours: "Monday – Saturday, 9:00 AM – 4:00 PM (to be confirmed)",
};

const TBC = "Details to be confirmed by Admissions Office";

/* --------------------------------------------------------------------------
   Programs — names taken from the college's promotional artwork.
   duration / eligibility are intentionally empty until verified.
   -------------------------------------------------------------------------- */
const PROGRAMS = [
  {
    id: "bsn-generic",
    title: "BSN Generic",
    category: "Nursing",
    tags: ["4-Year", "Professional Track"],
    image: "assets/images/hero/hero-nursing.jpg",
    icon: "bi-heart-pulse",
    duration: "",
    eligibility: "",
    description:
      "A professional nursing degree pathway focused on patient care, clinical competence and evidence-based nursing practice.",
    careers: ["Staff Nurse", "Clinical Nurse", "Community Health Nursing", "Further Nursing Studies"],
    status: "Admissions Open",
  },
  {
    id: "post-rn",
    title: "Post RN",
    category: "Nursing",
    tags: ["2-Year", "Professional Track"],
    image: "assets/images/programs/clinical.jpg",
    icon: "bi-clipboard2-pulse",
    duration: "",
    eligibility: "",
    description:
      "A progression pathway for registered nurses who want to advance academic qualifications and professional responsibility.",
    careers: ["Senior Staff Nurse", "Ward Supervisor", "Nursing Instructor", "Specialised Nursing Roles"],
    status: "Admissions Open",
  },
  {
    id: "lhv",
    title: "LHV (Lady Health Visitor)",
    category: "Nursing",
    tags: ["2-Year", "Professional Track"],
    image: "assets/images/programs/maternal.jpg",
    icon: "bi-people",
    duration: "",
    eligibility: "",
    description:
      "Community and maternal healthcare training focused on family health education, preventive care and primary healthcare support.",
    careers: ["Lady Health Visitor", "Community Health Worker", "Primary Healthcare Centre Roles"],
    status: "Admissions Open",
  },
  {
    id: "cmw",
    title: "CMW (Community Midwife)",
    category: "Nursing",
    tags: ["2-Year", "Professional Track"],
    image: "assets/images/programs/maternal.jpg",
    icon: "bi-emoji-smile",
    duration: "",
    eligibility: "",
    description:
      "Maternal and newborn care training covering antenatal, delivery and postnatal support within community healthcare settings.",
    careers: ["Community Midwife", "Maternity Unit Support", "Maternal Health Education"],
    status: "Admissions Open",
  },
  {
    id: "cna",
    title: "CNA (Certified Nursing Assistant)",
    category: "Nursing",
    tags: ["Professional Track"],
    image: "assets/images/programs/clinical.jpg",
    icon: "bi-bandaid",
    duration: "",
    eligibility: "",
    description:
      "Entry-level patient-care training covering basic nursing assistance, hygiene care, vitals monitoring and ward support.",
    careers: ["Nursing Assistant", "Patient Care Attendant", "Ward Support Staff"],
    status: "Admissions Open",
  },
  {
    id: "anesthesia-technician",
    title: "Anesthesia Technician",
    category: "Allied Health",
    tags: ["2-Year", "Professional Track"],
    image: "assets/images/programs/ot.jpg",
    icon: "bi-lungs",
    duration: "",
    eligibility: "",
    description:
      "Technical training in anesthesia equipment handling, operating room preparation and perioperative patient support.",
    careers: ["Anesthesia Technician", "Operating Room Technician", "Recovery Room Support"],
    status: "Admissions Open",
  },
  {
    id: "radiography-technology",
    title: "Radiography Technology + F.Sc",
    category: "Allied Health",
    tags: ["2-Year", "F.Sc Based"],
    image: "assets/images/programs/radiology.jpg",
    icon: "bi-broadcast",
    duration: "",
    eligibility: "",
    description:
      "Diagnostic imaging training combined with an F.Sc pathway, covering radiographic techniques, positioning and radiation safety.",
    careers: ["Radiography Technician", "Imaging Department Roles", "Diagnostic Centre Technician"],
    status: "Admissions Open",
  },
  {
    id: "medical-lab-technology",
    title: "Medical Lab Technology + F.Sc",
    category: "Allied Health",
    tags: ["2-Year", "F.Sc Based"],
    image: "assets/images/programs/lab.jpg",
    icon: "bi-eyedropper",
    duration: "",
    eligibility: "",
    description:
      "Laboratory science training with an F.Sc pathway, covering sample handling, clinical testing and laboratory quality practices.",
    careers: ["Lab Technician", "Pathology Lab Roles", "Diagnostic Laboratory Technician"],
    status: "Admissions Open",
  },
  {
    id: "dental-technician",
    title: "Dental Technician",
    category: "Allied Health",
    tags: ["2-Year", "Professional Track"],
    image: "assets/images/programs/lab.jpg",
    icon: "bi-emoji-laughing",
    duration: "",
    eligibility: "",
    description:
      "Dental laboratory and chair-side assistance training covering dental materials, appliance work and clinic support skills.",
    careers: ["Dental Technician", "Dental Laboratory Assistant", "Dental Clinic Support"],
    status: "Admissions Open",
  },
  {
    id: "operation-theater-technology",
    title: "Operation Theater Technology + F.Sc",
    category: "Allied Health",
    tags: ["2-Year", "F.Sc Based"],
    image: "assets/images/programs/ot.jpg",
    icon: "bi-scissors",
    duration: "",
    eligibility: "",
    description:
      "Surgical theatre technology training covering sterilisation, instrument handling, theatre discipline and surgical assistance.",
    careers: ["OT Technician", "Sterilisation Services", "Surgical Support Staff"],
    status: "Admissions Open",
  },
  {
    id: "dispenser",
    title: "Dispenser + F.Sc",
    category: "Allied Health",
    tags: ["F.Sc Based", "Professional Track"],
    image: "assets/images/programs/pharmacy.jpg",
    icon: "bi-capsule",
    duration: "",
    eligibility: "",
    description:
      "Medicine dispensing training covering prescription handling, dosage awareness, storage practices and patient counselling basics.",
    careers: ["Dispenser", "Pharmacy Assistant", "Hospital Dispensary Roles"],
    status: "Admissions Open",
  },
  {
    id: "b-category-pharmacy-technician",
    title: "B-Category Pharmacy Technician",
    category: "Allied Health",
    tags: ["Professional Track"],
    image: "assets/images/programs/pharmacy.jpg",
    icon: "bi-prescription2",
    duration: "",
    eligibility: "",
    description:
      "Pharmacy technician training focused on medicine handling, inventory practices, dispensing support and pharmacy operations.",
    careers: ["Pharmacy Technician", "Retail Pharmacy Roles", "Hospital Pharmacy Support"],
    status: "Admissions Open",
  },
];

/* --------------------------------------------------------------------------
   News — sample entries, clearly editable by the administration.
   -------------------------------------------------------------------------- */
const NEWS = [
  {
    id: "admissions-open-2026",
    title: "Admissions open for session 2026–27",
    category: "Admissions",
    date: "2026-08-10",
    image: "assets/images/campus/campus.jpg",
    summary:
      "Applications are being accepted for selected nursing and allied health programs. Visit the campus or contact the admissions office for guidance.",
  },
  {
    id: "skills-lab-session",
    title: "Nursing skills lab practice sessions scheduled",
    category: "Academic",
    date: "2026-07-28",
    image: "assets/images/hero/hero-nursing.jpg",
    summary:
      "Structured skills lab sessions help students practise core nursing procedures in a supervised learning environment.",
  },
  {
    id: "health-awareness-seminar",
    title: "Health awareness seminar for students",
    category: "Seminars",
    date: "2026-07-15",
    image: "assets/images/campus/classroom.jpg",
    summary:
      "A student seminar focused on community health awareness, hygiene practices and preventive healthcare communication.",
  },
  {
    id: "lab-workshop",
    title: "Laboratory techniques workshop",
    category: "Workshops",
    date: "2026-06-30",
    image: "assets/images/programs/lab.jpg",
    summary:
      "Allied health students attended a practical workshop covering sample handling and laboratory safety fundamentals.",
  },
  {
    id: "orientation-day",
    title: "Orientation day for new students",
    category: "Student Activities",
    date: "2026-06-12",
    image: "assets/images/campus/classroom.jpg",
    summary:
      "New students were introduced to academic expectations, campus facilities and professional conduct in healthcare settings.",
  },
  {
    id: "class-schedule-update",
    title: "Updated class schedule announcement",
    category: "Announcements",
    date: "2026-05-29",
    image: "assets/images/campus/campus.jpg",
    summary:
      "Revised timetables for theory and practical sessions have been shared with students through the notice board.",
  },
];

const EVENTS = [
  {
    id: "admission-guidance-day",
    title: "Admission guidance day",
    date: "2026-09-05",
    location: "King TAS College Campus, Gojra",
    image: "assets/images/campus/campus.jpg",
    description:
      "Meet the admissions team, tour the campus and discuss program options, eligibility and application steps.",
    status: "Open",
  },
  {
    id: "clinical-skills-workshop",
    title: "Clinical skills workshop",
    date: "2026-09-19",
    location: "Skills Laboratory",
    image: "assets/images/hero/hero-nursing.jpg",
    description:
      "A hands-on session covering patient assessment basics, vitals monitoring and infection-control practice.",
    status: "Registration soon",
  },
  {
    id: "community-health-camp",
    title: "Community health awareness activity",
    date: "2026-10-03",
    location: "Gojra, District Toba Tek Singh",
    image: "assets/images/programs/maternal.jpg",
    description:
      "Students participate in a supervised community health awareness activity focused on preventive care education.",
    status: "Planned",
  },
  {
    id: "lab-open-day",
    title: "Allied health laboratory open day",
    date: "2026-10-21",
    location: "Science & Medical Laboratories",
    image: "assets/images/programs/lab.jpg",
    description:
      "Prospective students can view laboratory learning spaces and talk to instructors about allied health programs.",
    status: "Planned",
  },
];

const NOTICES = [
  { title: "Admissions announcement — session 2026–27", category: "Admissions", date: "2026-08-10" },
  { title: "Class schedule for theory and practical sessions", category: "Academic", date: "2026-08-04" },
  { title: "Examination notice — internal assessments", category: "Examination", date: "2026-07-25" },
  { title: "Merit list publication procedure", category: "Admissions", date: "2026-07-18" },
  { title: "Holiday notice", category: "General", date: "2026-07-05" },
  { title: "Important student announcement — uniform and ID cards", category: "General", date: "2026-06-22" },
];

/* Placeholder faculty records — replace with verified staff information. */
const FACULTY = [
  { name: "Faculty Member Name", designation: "Principal", qualification: "Qualification to be provided", department: "Administration", bio: "Profile details will be provided by the college administration.", expertise: "Institutional leadership" },
  { name: "Faculty Member Name", designation: "Nursing Instructor", qualification: "Qualification to be provided", department: "Nursing", bio: "Profile details will be provided by the college administration.", expertise: "Fundamentals of nursing" },
  { name: "Faculty Member Name", designation: "Clinical Instructor", qualification: "Qualification to be provided", department: "Clinical", bio: "Profile details will be provided by the college administration.", expertise: "Clinical skills supervision" },
  { name: "Faculty Member Name", designation: "Midwifery Instructor", qualification: "Qualification to be provided", department: "Nursing", bio: "Profile details will be provided by the college administration.", expertise: "Maternal and newborn care" },
  { name: "Faculty Member Name", designation: "Medical Lab Instructor", qualification: "Qualification to be provided", department: "Allied Health", bio: "Profile details will be provided by the college administration.", expertise: "Laboratory techniques" },
  { name: "Faculty Member Name", designation: "Radiography Instructor", qualification: "Qualification to be provided", department: "Allied Health", bio: "Profile details will be provided by the college administration.", expertise: "Diagnostic imaging" },
  { name: "Faculty Member Name", designation: "Admissions Officer", qualification: "Qualification to be provided", department: "Administration", bio: "Profile details will be provided by the college administration.", expertise: "Admissions guidance" },
  { name: "Faculty Member Name", designation: "Senior Clinical Supervisor", qualification: "Qualification to be provided", department: "Clinical", bio: "Profile details will be provided by the college administration.", expertise: "Ward-based learning" },
];

const GALLERY = [
  { src: "assets/images/hero/hero-nursing.jpg", category: "Nursing", caption: "Nursing skills practice session" },
  { src: "assets/images/campus/campus.jpg", category: "Campus", caption: "College campus" },
  { src: "assets/images/campus/classroom.jpg", category: "Students", caption: "Classroom learning" },
  { src: "assets/images/programs/lab.jpg", category: "Laboratories", caption: "Medical laboratory practice" },
  { src: "assets/images/programs/clinical.jpg", category: "Clinical Training", caption: "Patient care training" },
  { src: "assets/images/programs/ot.jpg", category: "Clinical Training", caption: "Operation theatre exposure" },
  { src: "assets/images/programs/radiology.jpg", category: "Laboratories", caption: "Diagnostic imaging learning" },
  { src: "assets/images/programs/maternal.jpg", category: "Nursing", caption: "Maternal and newborn care" },
  { src: "assets/images/programs/pharmacy.jpg", category: "Activities", caption: "Dispensing practice" },
  { src: "assets/images/campus/classroom.jpg", category: "Seminars", caption: "Student seminar session" },
  { src: "assets/images/campus/campus.jpg", category: "Events", caption: "Campus event" },
  { src: "assets/images/hero/hero-nursing.jpg", category: "Students", caption: "Students in uniform" },
];

const FAQS = [
  { category: "Admissions", q: "How can I apply for admission?", a: "You can submit the online admission form on this website or visit the campus admissions office. The admissions team will guide you through document requirements and next steps." },
  { category: "Admissions", q: "Are admissions currently open?", a: "Admissions are open for session 2026–27 for selected nursing and allied health programs. Please contact the admissions office to confirm availability for a specific program." },
  { category: "Admissions", q: "Is there an admission deadline?", a: "Deadline information will be announced by the college administration. Please confirm current dates with the admissions office." },
  { category: "Programs", q: "Which programs does the college offer?", a: "The college offers nursing programs including BSN Generic, Post RN, LHV, CMW and CNA, along with allied health programs such as Anesthesia Technician, Radiography Technology, Medical Lab Technology, Dental Technician, Operation Theater Technology, Dispenser and B-Category Pharmacy Technician." },
  { category: "Programs", q: "Can I change my program after applying?", a: "Program change requests are handled by the admissions office and depend on eligibility and seat availability." },
  { category: "Eligibility", q: "What are the eligibility requirements?", a: "Eligibility criteria differ per program and are confirmed by the admissions office. Please refer to the eligibility page and contact the college for final requirements." },
  { category: "Eligibility", q: "Is there an age requirement?", a: "Age requirements, where applicable, will be confirmed by the admissions office." },
  { category: "Fees", q: "What is the fee structure?", a: "Fee information will be provided by the college administration. Please contact the admissions office for the current fee schedule and payment options." },
  { category: "Clinical Training", q: "Is clinical training part of the programs?", a: "Practical and clinical skill development is a core part of healthcare education at the college. Specific clinical arrangements are confirmed by the administration." },
  { category: "Student Life", q: "What activities are available for students?", a: "Students take part in seminars, workshops, health awareness activities and academic sessions organised through the college." },
  { category: "Documents", q: "Which documents do I need to submit?", a: "Typically educational certificates, CNIC or B-Form, photographs and other supporting documents. Please confirm the final checklist with the admissions office." },
  { category: "Contact", q: "How do I contact the admissions office?", a: "Call 0302-8098542 or 0326-0298542, message the college on WhatsApp, or visit the campus at Main Painsara Road, College Road, Near Model City Phase 3, Gojra." },
];

/* Testimonials are placeholders on purpose — no invented student quotes. */
const TESTIMONIALS = [
  { name: "Student name placeholder", program: "Nursing program", session: "Session placeholder", quote: "Student testimonial placeholder — this space is reserved for a verified student experience provided by the college." },
  { name: "Student name placeholder", program: "Allied health program", session: "Session placeholder", quote: "Student testimonial placeholder — the administration can replace this text with an approved student statement." },
  { name: "Student name placeholder", program: "Program placeholder", session: "Session placeholder", quote: "Student testimonial placeholder — add a real, verified testimonial before publishing the website." },
];

/* Expose for pages loaded as classic scripts. */
window.KT = { COLLEGE, TBC, PROGRAMS, NEWS, EVENTS, NOTICES, FACULTY, GALLERY, FAQS, TESTIMONIALS };
