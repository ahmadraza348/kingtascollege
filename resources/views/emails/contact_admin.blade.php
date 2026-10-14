@extends('emails.layout')

@section('title', 'New website query')
@section('preheader', 'New query from ' . $contactMessage->name . ': ' . $contactMessage->subject)

@section('content')
<h1 style="margin:0 0 6px 0;font-size:22px;color:#10233f;">New query from the website</h1>
<p style="margin:0 0 18px 0;font-size:15px;line-height:1.7;">
  A visitor has sent a message through the Contact Us form.
</p>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #e5e7eb;border-radius:12px;margin-bottom:22px;font-size:14px;">
  <tr style="background:#f6f9fc;"><td colspan="2" style="padding:10px 16px;font-weight:bold;color:#10233f;border-bottom:1px solid #e5e7eb;">Visitor details</td></tr>
  @foreach ([
      'Name' => $contactMessage->name,
      'Phone' => $contactMessage->phone,
      'Email' => $contactMessage->email,
      'Program of interest' => $contactMessage->program ?: '-',
      'Subject' => $contactMessage->subject,
      'Received on' => $contactMessage->created_at->format('d M Y, h:i A'),
  ] as $label => $value)
  <tr>
    <td style="padding:9px 16px;color:#64748b;width:38%;border-bottom:1px solid #f0f2f5;">{{ $label }}</td>
    <td style="padding:9px 16px;color:#10233f;font-weight:bold;border-bottom:1px solid #f0f2f5;">{{ $value }}</td>
  </tr>
  @endforeach
</table>

<div style="font-size:12px;color:#64748b;text-transform:uppercase;letter-spacing:.08em;margin-bottom:8px;">Message</div>
<div style="background:#f6f9fc;border-left:4px solid #075db8;border-radius:8px;padding:14px 16px;font-size:15px;line-height:1.7;color:#10233f;margin-bottom:22px;">
  {!! nl2br(e($contactMessage->message)) !!}
</div>

<p style="margin:0 0 18px 0;font-size:13px;color:#64748b;line-height:1.6;">
  You can reply directly to this email to reach the visitor.
</p>
@endsection
