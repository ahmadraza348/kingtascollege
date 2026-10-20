<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title', 'King TAS College')</title>
</head>
<body style="margin:0;padding:0;background:#f6f9fc;font-family:Arial,Helvetica,sans-serif;color:#334155;">
@php
    $fb  = 'https://www.facebook.com/people/King-TAS-college-of-Nursing-and-Allied-Health-Sciences/100063958600873/';
    $wa  = 'https://wa.me/923028098542?text=Hello%2C%20I%20would%20like%20information%20about%20admissions%20at%20King%20TAS%20College.';
    $yt  = 'https://www.youtube.com/@Doctor_Tahir';
@endphp
<div style="display:none;max-height:0;overflow:hidden;opacity:0;">@yield('preheader')</div>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f6f9fc;padding:24px 10px;">
<tr><td align="center">

  <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="width:100%;max-width:600px;background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 10px 30px rgba(16,35,63,.10);">

    {{-- Header --}}
    <tr>
      <td style="background:#10233f;padding:26px 30px;border-bottom:5px solid #d71919;">
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
          <tr>
            <td width="70" valign="middle">
              <img src="{{ $message->embed(public_path('frontend/assets/images/logo/logo.png')) }}" width="60" height="60" alt="King TAS College" style="display:block;background:#ffffff;border-radius:12px;padding:4px;">
            </td>
            <td valign="middle" style="padding-left:14px;">
              <div style="font-size:19px;font-weight:bold;color:#ffffff;line-height:1.3;">King TAS College</div>
              <div style="font-size:12px;color:#bcd3ee;letter-spacing:.04em;">Nursing &amp; Allied Health Sciences &bull; Gojra</div>
            </td>
          </tr>
        </table>
      </td>
    </tr>

    {{-- Body --}}
    <tr><td style="padding:32px 30px 8px 30px;">@yield('content')</td></tr>

    {{-- Social / contact --}}
    <tr>
      <td style="padding:8px 30px 28px 30px;" align="center">
        <div style="font-size:12px;color:#64748b;text-transform:uppercase;letter-spacing:.08em;margin-bottom:12px;">Stay connected with us</div>
        <table role="presentation" cellpadding="0" cellspacing="0" align="center">
          <tr>
            <td style="padding:0 5px;"><a href="{{ $fb }}" target="_blank" style="display:inline-block;background:#1877f2;color:#ffffff;text-decoration:none;font-size:13px;font-weight:bold;padding:9px 16px;border-radius:30px;">Facebook</a></td>
            <td style="padding:0 5px;"><a href="{{ $yt }}" target="_blank" style="display:inline-block;background:#ff0000;color:#ffffff;text-decoration:none;font-size:13px;font-weight:bold;padding:9px 16px;border-radius:30px;">YouTube</a></td>
            <td style="padding:0 5px;"><a href="{{ $wa }}" target="_blank" style="display:inline-block;background:#25d366;color:#ffffff;text-decoration:none;font-size:13px;font-weight:bold;padding:9px 16px;border-radius:30px;">WhatsApp</a></td>
            <td style="padding:0 5px;"><a href="tel:+923028098542" style="display:inline-block;background:#075db8;color:#ffffff;text-decoration:none;font-size:13px;font-weight:bold;padding:9px 16px;border-radius:30px;">Call Us</a></td>
            <td style="padding:0 5px;"><a href="{{ url('/') }}" target="_blank" style="display:inline-block;background:#d71919;color:#ffffff;text-decoration:none;font-size:13px;font-weight:bold;padding:9px 16px;border-radius:30px;">Website</a></td>
          </tr>
        </table>
      </td>
    </tr>

    {{-- Footer --}}
    <tr>
      <td style="background:#10233f;padding:22px 30px;text-align:center;">
        <div style="font-size:13px;color:#ffffff;font-weight:bold;margin-bottom:6px;">King TAS College of Nursing &amp; Allied Health Sciences</div>
        <div style="font-size:12px;color:#bcd3ee;line-height:1.7;">
          Main Painsara Road, College Road, Near Model City Phase 3,<br>
          Gojra, District Toba Tek Singh, Punjab, Pakistan<br>
          Phone: 0302-8098542 &nbsp;|&nbsp; 0326-0298542<br>
          <a href="mailto:info@kingtascollege.com" style="color:#ffffff;">info@kingtascollege.com</a>
        </div>
        <div style="font-size:11px;color:#8fa9c9;margin-top:10px;">&copy; {{ date('Y') }} King TAS College. All rights reserved.</div>
      </td>
    </tr>

  </table>

</td></tr>
</table>
</body>
</html>
