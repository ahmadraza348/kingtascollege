<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>King TAS College - Admission Form (Session 2026-27)</title>
<style>
    @page { margin: 22px 34px 46px 34px; }
    body { font-family: 'DejaVu Sans', sans-serif; font-size: 10px; color: #334155; line-height: 1.3; }
    table { width: 100%; border-collapse: collapse; }
    .header { background: #10233f; color: #fff; border-bottom: 4px solid #d71919; }
    .header td { padding: 9px 14px; vertical-align: middle; }
    .college { font-size: 16px; font-weight: bold; color: #fff; }
    .sub { font-size: 9px; color: #bcd3ee; letter-spacing: .5px; }
    .title { font-size: 15px; font-weight: bold; color: #10233f; }
    .photo { width: 92px; height: 112px; border: 1px dashed #94a3b8; text-align: center; color: #94a3b8; font-size: 8.5px; }
    .section-title { background: #075db8; color: #fff; font-weight: bold; padding: 5px 10px; font-size: 11px; margin-top: 7px; }
    table.grid td { padding: 5px 9px 1px 9px; vertical-align: bottom; }
    td.label { color: #64748b; font-size: 9.5px; width: 17%; white-space: nowrap; }
    td.line { border-bottom: 1px solid #94a3b8; width: 33%; }
    td.choices { padding-top: 5px; font-size: 10px; color: #10233f; vertical-align: top; line-height: 1.35; }
    table.grid td.top { vertical-align: top; }
    .box { font-size: 13px; }
    .note { font-size: 9px; color: #64748b; margin-top: 6px; }
    .declaration { border: 1px solid #e2e8f0; background: #f6f9fc; padding: 8px 10px; margin-top: 4px; font-size: 9.5px; }
    .sign td { padding-top: 22px; text-align: center; font-size: 9.5px; color: #64748b; }
    .sign .line { border-top: 1px solid #94a3b8; padding-top: 4px; }
    .footer { position: fixed; bottom: -30px; left: 0; right: 0; text-align: center; font-size: 8.5px; color: #64748b; border-top: 1px solid #e2e8f0; padding-top: 5px; }
</style>
</head>
<body>

{{-- Letterhead --}}
<table class="header">
    <tr>
        <td style="width:62px;">@if($logo)<img src="{{ $logo }}" width="52" height="52" style="background:#fff;padding:3px;">@endif</td>
        <td>
            <div class="college">King TAS College of Nursing &amp; Allied Health Sciences</div>
            <div class="sub">Main Painsara Road, College Road, Near Model City Phase 3, Gojra, Toba Tek Singh, Punjab</div>
            <div class="sub">Phone: 0302-8098542 | 0326-0298542 &nbsp;&bull;&nbsp; Email: info@kingtascollege.com</div>
        </td>
    </tr>
</table>

{{-- Title + form number + photo --}}
<table style="margin:10px 0 2px 0;">
    <tr>
        <td style="vertical-align:top;">
            <div class="title">ADMISSION FORM &mdash; SESSION 2026&ndash;27</div>
            <table style="margin-top:6px;width:78%;">
                <tr>
                    <td class="label" style="width:22%;">Form No.</td><td class="line" style="width:78%;">&nbsp;</td>
                </tr>
                <tr>
                    <td class="label">Date</td><td class="line">&nbsp;</td>
                </tr>
            </table>
            <div class="note" style="margin-top:3px;">Please fill in this form in block letters and attach photocopies of the documents listed in section 5.</div>
        </td>
        <td style="width:100px;vertical-align:top;" align="right">
            <div class="photo"><div style="padding-top:34px;">Affix recent<br>passport size<br>photograph</div></div>
        </td>
    </tr>
</table>

{{-- 1. Personal --}}
<div class="section-title">1. Personal Information</div>
<table class="grid">
    <tr><td class="label">Full name</td><td class="line">&nbsp;</td><td class="label">Father's name</td><td class="line">&nbsp;</td></tr>
    <tr><td class="label">Date of birth</td><td class="line">&nbsp;</td><td class="label">Gender</td><td class="choices"><span class="box">&#9744;</span> Male &nbsp; <span class="box">&#9744;</span> Female</td></tr>
    <tr><td class="label">CNIC / B-Form</td><td class="line">&nbsp;</td><td class="label">Phone</td><td class="line">&nbsp;</td></tr>
    <tr><td class="label">WhatsApp</td><td class="line">&nbsp;</td><td class="label">Email</td><td class="line">&nbsp;</td></tr>
</table>

{{-- 2. Academic --}}
<div class="section-title">2. Academic Information</div>
<table class="grid">
    <tr>
        <td class="label">Qualification</td>
        <td class="choices" colspan="3">
            <span class="box">&#9744;</span> Matric &nbsp;&nbsp;
            <span class="box">&#9744;</span> F.Sc / Intermediate &nbsp;&nbsp;
            <span class="box">&#9744;</span> Diploma &nbsp;&nbsp;
            <span class="box">&#9744;</span> Bachelor &nbsp;&nbsp;
            <span class="box">&#9744;</span> Other
        </td>
    </tr>
    <tr><td class="label">Institution</td><td class="line" colspan="3">&nbsp;</td></tr>
    <tr><td class="label">Marks obtained</td><td class="line">&nbsp;</td><td class="label">Total marks</td><td class="line">&nbsp;</td></tr>
    <tr><td class="label">Percentage</td><td class="line">&nbsp;</td><td></td><td></td></tr>
</table>

{{-- 3. Program --}}
<div class="section-title">3. Program Applied For (tick one)</div>
<table class="grid">
    <tr>
        <td class="choices top" style="width:50%;">
            <div style="color:#64748b;font-size:9px;">Nursing programs</div>
            <span class="box">&#9744;</span> BSN Generic<br>
            <span class="box">&#9744;</span> Post RN<br>
            <span class="box">&#9744;</span> LHV (Lady Health Visitor)<br>
            <span class="box">&#9744;</span> CMW (Community Midwife)<br>
            <span class="box">&#9744;</span> CNA (Certified Nursing Assistant)
        </td>
        <td class="choices top" style="width:50%;">
            <div style="color:#64748b;font-size:9px;">Allied health programs</div>
            <span class="box">&#9744;</span> Anesthesia Technician<br>
            <span class="box">&#9744;</span> Radiography Technology + F.Sc<br>
            <span class="box">&#9744;</span> Medical Lab Technology + F.Sc<br>
            <span class="box">&#9744;</span> Dental Technician<br>
            <span class="box">&#9744;</span> Operation Theater Technology + F.Sc<br>
            <span class="box">&#9744;</span> Dispenser + F.Sc<br>
            <span class="box">&#9744;</span> B-Category Pharmacy Technician
        </td>
    </tr>
</table>

{{-- 4. Address --}}
<div class="section-title">4. Address</div>
<table class="grid">
    <tr><td class="label">Postal address</td><td class="line" colspan="3">&nbsp;</td></tr>
    <tr><td class="label">City</td><td class="line">&nbsp;</td><td class="label">District</td><td class="line">&nbsp;</td></tr>
    <tr><td class="label">Province</td><td class="line">&nbsp;</td><td></td><td></td></tr>
</table>

{{-- 5. Documents --}}
<div class="section-title">5. Documents Attached</div>
<table class="grid">
    <tr>
        <td class="choices top" style="width:50%;">
            <span class="box">&#9744;</span> CNIC / B-Form (front and back)<br>
            <span class="box">&#9744;</span> Domicile certificate<br>
            <span class="box">&#9744;</span> Personal photograph
        </td>
        <td class="choices top" style="width:50%;">
            <span class="box">&#9744;</span> Educational documents / certificates<br>
            <span class="box">&#9744;</span> Other supporting documents
        </td>
    </tr>
</table>

{{-- 6. Declaration --}}
<div class="section-title">6. Declaration</div>
<div class="declaration">
    I declare that the information given in this form and the documents attached are true and correct to the best of my knowledge.
    I accept the terms and conditions of King TAS College and understand that incorrect information may lead to cancellation of my admission.
</div>

<table class="sign">
    <tr>
        <td style="width:33%;"><div class="line">Applicant signature</div></td>
        <td style="width:33%;"><div class="line">Guardian signature</div></td>
        <td style="width:34%;"><div class="line">Admissions office stamp &amp; signature</div></td>
    </tr>
</table>

<div class="footer">
    King TAS College of Nursing &amp; Allied Health Sciences &bull; info@kingtascollege.com &bull; 0302-8098542
</div>

</body>
</html>
