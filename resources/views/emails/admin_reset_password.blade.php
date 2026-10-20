@extends('emails.layout')

@section('title', 'Reset your admin password')
@section('preheader', 'Use the link inside to choose a new admin password. It expires in ' . $minutes . ' minutes.')

@section('content')
<h1 style="margin:0 0 6px 0;font-size:22px;color:#10233f;">Reset your password</h1>
<p style="margin:0 0 18px 0;font-size:15px;line-height:1.7;">
  Hello <strong>{{ $admin->first_name }}</strong>,<br>
  We received a request to reset the password of your King TAS College admin account. Click the button below to choose a new password.
</p>

<table role="presentation" cellpadding="0" cellspacing="0" style="margin:0 0 22px 0;">
  <tr>
    <td style="background:#d71919;border-radius:10px;">
      <a href="{{ $resetUrl }}" target="_blank" style="display:inline-block;padding:13px 28px;color:#ffffff;text-decoration:none;font-size:15px;font-weight:bold;">Reset Password</a>
    </td>
  </tr>
</table>

<p style="margin:0 0 14px 0;font-size:13px;line-height:1.7;color:#64748b;">
  This link is valid for {{ $minutes }} minutes and can be used only once. If the button does not work, copy and paste this address into your browser:
</p>
<p style="margin:0 0 22px 0;font-size:12px;line-height:1.6;word-break:break-all;color:#075db8;">{{ $resetUrl }}</p>

<p style="margin:0 0 18px 0;font-size:13px;line-height:1.7;color:#64748b;">
  If you did not ask for this, you can safely ignore this e-mail. Your password will not change.
</p>
@endsection
