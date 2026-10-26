<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Receipt {{ $payment->receipt_number }}</title>
<style>
    @page { margin: 22px 30px; }
    body { font-family: 'DejaVu Sans', sans-serif; font-size: 10px; color: #1f2937; }
    table { border-collapse: collapse; width: 100%; }
    .head td { padding: 4px; vertical-align: middle; }
    .college { font-size: 14px; font-weight: bold; color: #10233f; }
    .small { font-size: 8px; color: #4b5563; }
    .title { background: #10233f; color: #fff; text-align: center; font-weight: bold; padding: 5px; letter-spacing: 1px; margin: 6px 0; }
    .grid td, .grid th { border: 1px solid #cbd5e1; padding: 5px 7px; }
    .grid th { background: #e2e8f0; text-align: left; }
    .k { background: #f1f5f9; width: 22%; color: #475569; }
    .r { text-align: right; }
    .copy { border-bottom: 1px dashed #6b7280; padding-bottom: 14px; margin-bottom: 14px; }
</style>
</head>
<body>
@php $F = \App\Support\FeeHelper::class; $s = $payment->student; @endphp
@foreach (['OFFICE COPY', 'STUDENT COPY'] as $copy)
<div class="{{ $loop->first ? 'copy' : '' }}">
    <table class="head"><tr>
        <td style="width:46px;">@if ($letterhead['logo'])<img src="{{ $letterhead['logo'] }}" width="40" height="40">@endif</td>
        <td><div class="college">{{ $letterhead['name'] }}</div><div class="small">{{ $letterhead['address'] }}</div><div class="small">{{ $letterhead['phone'] }}</div></td>
        <td class="r small">{{ $copy }}</td>
    </tr></table>
    <div class="title">FEE PAYMENT RECEIPT</div>

    <table class="grid">
        <tr><td class="k">Receipt No</td><td><strong>{{ $payment->receipt_number }}</strong></td><td class="k">Payment date</td><td>{{ $payment->payment_date->format('d M Y') }}</td></tr>
        <tr><td class="k">Received from</td><td><strong>{{ $s->full_name }}</strong></td><td class="k">Roll No</td><td>{{ $s->roll_number }}</td></tr>
        <tr><td class="k">Father</td><td>{{ $s->father_name }}</td><td class="k">Class</td><td>{{ $s->schoolClass->name }} / {{ $s->section->name }}</td></tr>
        <tr><td class="k">Method</td><td>{{ $payment->method_label }}</td><td class="k">Bank / Reference</td><td>{{ trim($payment->bank_name . ' ' . $payment->reference_no) ?: '—' }}</td></tr>
    </table>

    <table class="grid" style="margin-top:6px;">
        <tr><th>Applied to voucher</th><th>Fee month</th><th class="r">Amount (Rs.)</th></tr>
        @foreach ($payment->allocations as $a)
            <tr><td>{{ $a->voucher->voucher_number }}</td><td>{{ $a->voucher->period_label }}</td><td class="r">{{ $F::number($a->amount) }}</td></tr>
        @endforeach
        <tr><th colspan="2" class="r">Total received</th><th class="r">{{ $F::number($payment->amount) }}</th></tr>
    </table>
    <p style="margin:5px 0 0;"><strong>In words:</strong> {{ $F::words((float) $payment->amount) }}</p>
    <p style="margin:2px 0 0;"><strong>Balance remaining after this payment:</strong> {{ $F::money($payment->balance_after) }}</p>

    <table style="margin-top:22px;"><tr>
        <td style="width:50%;text-align:center;border-top:1px solid #6b7280;padding-top:3px;">Received by: {{ $payment->receiver?->full_name }}</td>
        <td style="text-align:center;border-top:1px solid #6b7280;padding-top:3px;">Stamp &amp; signature</td>
    </tr></table>
</div>
@endforeach
</body>
</html>