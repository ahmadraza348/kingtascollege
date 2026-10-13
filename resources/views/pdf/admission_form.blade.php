<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Admission Form {{ $admission->form_number }}</title>
<style>
    @page { margin: 28px 34px 50px 34px; }
    body { font-family: 'DejaVu Sans', sans-serif; font-size: 10.5px; color: #334155; line-height: 1.45; }
    table { width: 100%; border-collapse: collapse; }
    .header { background: #10233f; color: #fff; border-bottom: 4px solid #d71919; }
    .header td { padding: 12px 14px; vertical-align: middle; }
    .college { font-size: 16px; font-weight: bold; color: #fff; }
    .sub { font-size: 9px; color: #bcd3ee; letter-spacing: .5px; }
    .title-bar { margin: 14px 0 12px 0; }
    .title { font-size: 15px; font-weight: bold; color: #10233f; }
    .badge { background: #e8f1fb; color: #06478a; border: 1px solid #075db8; font-weight: bold; padding: 4px 10px; font-size: 11px; }
    .copy { font-size: 9px; color: #d71919; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; }
    .photo { width: 92px; height: 112px; border: 1px solid #94a3b8; text-align: center; }
    .photo img { width: 92px; height: 112px; }
    .section-title { background: #075db8; color: #fff; font-weight: bold; padding: 6px 10px; font-size: 11px; margin-top: 12px; }
    table.grid td { border: 1px solid #e2e8f0; padding: 6px 9px; vertical-align: top; }
    td.label { background: #f6f9fc; color: #64748b; width: 21%; font-size: 9.5px; }
    td.value { color: #10233f; font-weight: bold; width: 29%; }
    .ok { color: #15803d; font-weight: bold; }
    .status { background: #fff3cd; color: #8a6d00; font-weight: bold; padding: 2px 8px; }
    .declaration { border: 1px solid #e2e8f0; background: #f6f9fc; padding: 8px 10px; margin-top: 4px; font-size: 9.5px; }
    .sign td { padding-top: 34px; text-align: center; font-size: 9.5px; color: #64748b; }
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
<table class="title-bar">
    <tr>
        <td style="vertical-align:top;">
            <div class="title">ADMISSION FORM &mdash; SESSION {{ $admission->session }}</div>
            <div style="margin:8px 0 6px 0;"><span class="badge">Form No: {{ $admission->form_number }}</span></div>
            <div>Submitted on: <strong>{{ $admission->created_at->format('d M Y, h:i A') }}</strong></div>
            <div>Status: <span class="status">{{ ucfirst($admission->status) }}</span></div>
            <div class="copy" style="margin-top:6px;">{{ $copyLabel }}</div>
        </td>
        <td style="width:100px;vertical-align:top;" align="right">
            <div class="photo">
                @if($photo)<img src="{{ $photo }}" alt="Photo">@else<div style="padding-top:48px;color:#94a3b8;">Photo</div>@endif
            </div>
        </td>
    </tr>
</table>

{{-- Personal --}}
<div class="section-title">1. Personal Information</div>
<table class="grid">
    <tr><td class="label">Full name</td><td class="value">{{ $admission->full_name }}</td><td class="label">Father's name</td><td class="value">{{ $admission->father_name }}</td></tr>
    <tr><td class="label">Date of birth</td><td class="value">{{ $admission->date_of_birth->format('d M Y') }}</td><td class="label">Gender</td><td class="value">{{ $admission->gender }}</td></tr>
    <tr><td class="label">CNIC / B-Form</td><td class="value">{{ $admission->cnic }}</td><td class="label">Phone</td><td class="value">{{ $admission->phone }}</td></tr>
    <tr><td class="label">WhatsApp</td><td class="value">{{ $admission->whatsapp ?: '-' }}</td><td class="label">Email</td><td class="value">{{ $admission->email ?: '-' }}</td></tr>
</table>

{{-- Academic --}}
<div class="section-title">2. Academic Information</div>
<table class="grid">
    <tr><td class="label">Qualification</td><td class="value">{{ $admission->qualification }}</td><td class="label">Institution</td><td class="value">{{ $admission->institution }}</td></tr>
    <tr>
        <td class="label">Marks obtained</td><td class="value">{{ $admission->obtained_marks !== null ? rtrim(rtrim(number_format((float) $admission->obtained_marks, 2, '.', ''), '0'), '.') : '-' }}</td>
        <td class="label">Total marks</td><td class="value">{{ $admission->total_marks !== null ? rtrim(rtrim(number_format((float) $admission->total_marks, 2, '.', ''), '0'), '.') : '-' }}</td>
    </tr>
    <tr><td class="label">Percentage</td><td class="value" colspan="3">{{ $admission->percentage !== null ? rtrim(rtrim(number_format((float) $admission->percentage, 2, '.', ''), '0'), '.') . '%' : '-' }}</td></tr>
</table>

{{-- Program --}}
<div class="section-title">3. Program Applied For</div>
<table class="grid">
    <tr><td class="label">Preferred program</td><td class="value">{{ $admission->program }}</td><td class="label">Session</td><td class="value">{{ $admission->session }}</td></tr>
    <tr><td class="label">Applicant notes</td><td class="value" colspan="3" style="font-weight:normal;">{{ $admission->notes ?: '-' }}</td></tr>
</table>

{{-- Address --}}
<div class="section-title">4. Address</div>
<table class="grid">
    <tr><td class="label">Postal address</td><td class="value" colspan="3">{{ $admission->street }}</td></tr>
    <tr><td class="label">City</td><td class="value">{{ $admission->city }}</td><td class="label">District</td><td class="value">{{ $admission->district ?: '-' }}</td></tr>
    <tr><td class="label">Province</td><td class="value" colspan="3">{{ $admission->province ?: '-' }}</td></tr>
</table>

{{-- Documents --}}
<div class="section-title">5. Documents Submitted</div>
<table class="grid">
    <tr><td class="label">CNIC / B-Form (front)</td><td class="value ok">{{ $admission->cnic_front_path ? 'Uploaded' : '-' }}</td><td class="label">CNIC / B-Form (back)</td><td class="value ok">{{ $admission->cnic_back_path ? 'Uploaded' : '-' }}</td></tr>
    <tr><td class="label">Domicile certificate</td><td class="value ok">{{ $admission->domicile_document_path ? 'Uploaded' : '-' }}</td><td class="label">Personal photograph</td><td class="value ok">{{ $admission->personal_picture_path ? 'Uploaded' : '-' }}</td></tr>
    <tr><td class="label">Educational documents</td><td class="value ok">{{ count($admission->degree_documents ?? []) }} file(s)</td><td class="label">Other documents</td><td class="value ok">{{ count($admission->other_documents ?? []) }} file(s)</td></tr>
</table>

{{-- Declaration --}}
<div class="section-title">6. Declaration</div>
<div class="declaration">
    I declare that the information given in this form and the documents uploaded are true and correct to the best of my knowledge.
    I accepted the terms and conditions of King TAS College and understand that incorrect information may lead to cancellation of my admission.
    Terms accepted: <strong>{{ $admission->terms_accepted ? 'Yes' : 'No' }}</strong>.
</div>

<table class="sign">
    <tr>
        <td style="width:33%;"><div class="line">Applicant signature</div></td>
        <td style="width:33%;"><div class="line">Guardian signature</div></td>
        <td style="width:34%;"><div class="line">Admissions office stamp &amp; signature</div></td>
    </tr>
</table>

<div class="footer">
    King TAS College of Nursing &amp; Allied Health Sciences &bull; info@kingtascollege.com &bull; Form {{ $admission->form_number }} &bull; This is a system generated form.
</div>

</body>
</html>
