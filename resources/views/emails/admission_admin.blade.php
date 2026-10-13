@extends('emails.layout')

@section('title', 'New admission form')
@section('preheader', 'New admission form from ' . $admission->full_name . ' (' . $admission->form_number . ')')

@section('content')
<h1 style="margin:0 0 6px 0;font-size:22px;color:#10233f;">New student filled the admission form</h1>
<p style="margin:0 0 18px 0;font-size:15px;line-height:1.7;">
  A new student has submitted an online admission application. The complete admission form is attached as a PDF.
</p>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin:0 0 20px 0;">
  <tr>
    <td align="center" style="background:#e8f1fb;border:2px dashed #075db8;border-radius:12px;padding:14px;">
      <div style="font-size:12px;color:#64748b;text-transform:uppercase;letter-spacing:.08em;">Admission form number</div>
      <div style="font-size:24px;font-weight:bold;color:#06478a;letter-spacing:.04em;margin-top:4px;">{{ $admission->form_number }}</div>
    </td>
  </tr>
</table>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #e5e7eb;border-radius:12px;margin-bottom:22px;font-size:14px;">
  <tr style="background:#f6f9fc;"><td colspan="2" style="padding:10px 16px;font-weight:bold;color:#10233f;border-bottom:1px solid #e5e7eb;">Applicant details</td></tr>
  @foreach ([
      'Full name' => $admission->full_name,
      "Father's name" => $admission->father_name,
      'CNIC / B-Form' => $admission->cnic,
      'Program' => $admission->program,
      'Session' => $admission->session,
      'Phone' => $admission->phone,
      'WhatsApp' => $admission->whatsapp ?: '-',
      'Email' => $admission->email ?: '-',
      'City' => $admission->city,
      'Qualification' => $admission->qualification,
      'Submitted on' => $admission->created_at->format('d M Y, h:i A'),
  ] as $label => $value)
  <tr>
    <td style="padding:9px 16px;color:#64748b;width:38%;border-bottom:1px solid #f0f2f5;">{{ $label }}</td>
    <td style="padding:9px 16px;color:#10233f;font-weight:bold;border-bottom:1px solid #f0f2f5;">{{ $value }}</td>
  </tr>
  @endforeach
</table>

<p style="margin:0 0 18px 0;font-size:13px;color:#64748b;line-height:1.6;">
  Uploaded documents (CNIC, domicile, certificates, photo) are stored securely on the server.
  You can reply directly to this email to reach the student.
</p>
@endsection
