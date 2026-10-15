@extends('emails.layout')

@section('title', 'Admission update')
@section('preheader', 'Your admission ' . $admission->form_number . ' is now ' . $admission->status_label . '.')

@php
    $messages = [
        'under_review'       => 'Our admissions team has started reviewing your application.',
        'documents_required' => 'We need some more information or documents from you before we can continue.',
        'approved'           => 'Congratulations! Your application has been approved. Our office will contact you about the next steps and fee submission.',
        'rejected'           => 'We are sorry, but we are unable to offer you admission at this time.',
        'enrolled'           => 'Welcome to King TAS College! Your admission is complete.',
        'pending'            => 'Your application is waiting for review.',
    ];
@endphp

@section('content')
<h1 style="margin:0 0 6px 0;font-size:22px;color:#10233f;">Admission status update</h1>
<p style="margin:0 0 18px 0;font-size:15px;line-height:1.7;">
  Dear <strong>{{ $admission->full_name }}</strong>,<br>
  {{ $messages[$admission->status] ?? '' }}
</p>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #e5e7eb;border-radius:12px;margin-bottom:22px;font-size:14px;">
  <tr><td style="padding:9px 16px;color:#64748b;width:38%;border-bottom:1px solid #f0f2f5;">Form number</td><td style="padding:9px 16px;color:#10233f;font-weight:bold;border-bottom:1px solid #f0f2f5;">{{ $admission->form_number }}</td></tr>
  <tr><td style="padding:9px 16px;color:#64748b;border-bottom:1px solid #f0f2f5;">Program</td><td style="padding:9px 16px;color:#10233f;border-bottom:1px solid #f0f2f5;">{{ $admission->program }}</td></tr>
  @if($admission->roll_number)
  <tr><td style="padding:9px 16px;color:#64748b;border-bottom:1px solid #f0f2f5;">Roll number</td><td style="padding:9px 16px;color:#10233f;font-weight:bold;border-bottom:1px solid #f0f2f5;">{{ $admission->roll_number }}</td></tr>
  @endif
  <tr><td style="padding:9px 16px;color:#64748b;">Status</td><td style="padding:9px 16px;color:#10233f;font-weight:bold;">{{ $admission->status_label }}</td></tr>
</table>

@if($remarks)
<div style="background:#f6f9fc;border-left:4px solid #075db8;padding:12px 16px;margin-bottom:22px;font-size:14px;line-height:1.6;">
  <strong>Message from the admissions office:</strong><br>
  {!! nl2br(e($remarks)) !!}
</div>
@endif

<p style="margin:0 0 6px 0;font-size:13px;color:#64748b;line-height:1.6;">
  Questions? Write to <a href="mailto:info@kingtascollege.com" style="color:#075db8;">info@kingtascollege.com</a>
  and mention your form number <strong>{{ $admission->form_number }}</strong>.
</p>
@endsection
