@extends('emails.layout')

@section('title', 'Admission form received')
@section('preheader', 'Your admission form ' . $admission->form_number . ' is under process.')

@section('content')
<h1 style="margin:0 0 6px 0;font-size:22px;color:#10233f;">Your admission form is under process</h1>
<p style="margin:0 0 18px 0;font-size:15px;line-height:1.7;">
  Dear <strong>{{ $admission->full_name }}</strong>,<br>
  Thank you for applying to <strong>King TAS College of Nursing &amp; Allied Health Sciences</strong>.
  We have received your admission form and it is now <strong style="color:#d71919;">under process</strong>.
  A copy of your admission form is attached to this email as a PDF.
</p>

{{-- Form number --}}
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin:0 0 20px 0;">
  <tr>
    <td align="center" style="background:#e8f1fb;border:2px dashed #075db8;border-radius:12px;padding:16px;">
      <div style="font-size:12px;color:#64748b;text-transform:uppercase;letter-spacing:.08em;">Admission form number</div>
      <div style="font-size:26px;font-weight:bold;color:#06478a;letter-spacing:.04em;margin-top:4px;">{{ $admission->form_number }}</div>
    </td>
  </tr>
</table>

{{-- Summary --}}
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #e5e7eb;border-radius:12px;margin-bottom:22px;font-size:14px;">
  <tr style="background:#f6f9fc;"><td colspan="2" style="padding:10px 16px;font-weight:bold;color:#10233f;border-bottom:1px solid #e5e7eb;">Application summary</td></tr>
  <tr><td style="padding:9px 16px;color:#64748b;width:38%;border-bottom:1px solid #f0f2f5;">Program</td><td style="padding:9px 16px;color:#10233f;font-weight:bold;border-bottom:1px solid #f0f2f5;">{{ $admission->program }}</td></tr>
  <tr><td style="padding:9px 16px;color:#64748b;border-bottom:1px solid #f0f2f5;">Session</td><td style="padding:9px 16px;color:#10233f;border-bottom:1px solid #f0f2f5;">{{ $admission->session }}</td></tr>
  <tr><td style="padding:9px 16px;color:#64748b;border-bottom:1px solid #f0f2f5;">Father's name</td><td style="padding:9px 16px;color:#10233f;border-bottom:1px solid #f0f2f5;">{{ $admission->father_name }}</td></tr>
  <tr><td style="padding:9px 16px;color:#64748b;border-bottom:1px solid #f0f2f5;">Phone</td><td style="padding:9px 16px;color:#10233f;border-bottom:1px solid #f0f2f5;">{{ $admission->phone }}</td></tr>
  <tr><td style="padding:9px 16px;color:#64748b;border-bottom:1px solid #f0f2f5;">Submitted on</td><td style="padding:9px 16px;color:#10233f;border-bottom:1px solid #f0f2f5;">{{ $admission->created_at->format('d M Y, h:i A') }}</td></tr>
  <tr><td style="padding:9px 16px;color:#64748b;">Status</td><td style="padding:9px 16px;"><span style="background:#fff3cd;color:#8a6d00;font-weight:bold;font-size:12px;padding:4px 12px;border-radius:20px;">Under Process</span></td></tr>
</table>

<h2 style="margin:0 0 10px 0;font-size:16px;color:#10233f;">What happens next?</h2>
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="font-size:14px;line-height:1.6;margin-bottom:22px;">
  <tr><td width="34" valign="top" style="padding:4px 0;"><span style="display:inline-block;width:24px;height:24px;line-height:24px;text-align:center;background:#075db8;color:#fff;border-radius:50%;font-weight:bold;font-size:12px;">1</span></td><td style="padding:4px 0;">Our admissions team reviews your form and documents.</td></tr>
  <tr><td valign="top" style="padding:4px 0;"><span style="display:inline-block;width:24px;height:24px;line-height:24px;text-align:center;background:#075db8;color:#fff;border-radius:50%;font-weight:bold;font-size:12px;">2</span></td><td style="padding:4px 0;">We will contact you on your phone or email with the next steps.</td></tr>
  <tr><td valign="top" style="padding:4px 0;"><span style="display:inline-block;width:24px;height:24px;line-height:24px;text-align:center;background:#075db8;color:#fff;border-radius:50%;font-weight:bold;font-size:12px;">3</span></td><td style="padding:4px 0;">Keep your form number <strong>{{ $admission->form_number }}</strong> handy for any inquiry.</td></tr>
</table>

<table role="presentation" cellpadding="0" cellspacing="0" align="center" style="margin:0 auto 20px auto;">
  <tr><td align="center" style="background:#d71919;border-radius:30px;">
    <a href="mailto:info@kingtascollege.com?subject=Admission%20Inquiry%20{{ urlencode($admission->form_number) }}" style="display:inline-block;padding:13px 28px;color:#ffffff;text-decoration:none;font-weight:bold;font-size:14px;">Contact Admissions Office</a>
  </td></tr>
</table>

<p style="margin:0 0 6px 0;font-size:13px;color:#64748b;line-height:1.6;">
  If you did not submit this form, please ignore this email or write to us at
  <a href="mailto:info@kingtascollege.com" style="color:#075db8;">info@kingtascollege.com</a>.
</p>
@endsection
