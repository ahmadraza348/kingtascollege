<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Fee Statement</title>
<style>
    @page { margin: 24px 30px; }
    body { font-family: 'DejaVu Sans', sans-serif; font-size: 9.5px; color: #1f2937; }
    table { border-collapse: collapse; width: 100%; }
    .college { font-size: 14px; font-weight: bold; color: #10233f; }
    .small { font-size: 8px; color: #4b5563; }
    .title { background: #10233f; color: #fff; text-align: center; font-weight: bold; padding: 5px; margin: 8px 0; }
    .grid td, .grid th { border: 1px solid #cbd5e1; padding: 4px 6px; }
    .grid th { background: #e2e8f0; text-align: left; }
    .r { text-align: right; }
</style>
</head>
<body>
@php $F = \App\Support\FeeHelper::class; @endphp
<table><tr>
    <td style="width:46px;">@if ($letterhead['logo'])<img src="{{ $letterhead['logo'] }}" width="40" height="40">@endif</td>
    <td><div class="college">{{ $letterhead['name'] }}</div><div class="small">{{ $letterhead['address'] }}</div><div class="small">{{ $letterhead['phone'] }}</div></td>
</tr></table>
<div class="title">STUDENT FEE STATEMENT</div>

<table class="grid">
    <tr><th style="width:18%;">Student</th><td>{{ $student->full_name }}</td><th style="width:18%;">Roll No</th><td>{{ $student->roll_number }}</td></tr>
    <tr><th>Father</th><td>{{ $student->father_name }}</td><th>Class</th><td>{{ $student->schoolClass->name }} / {{ $student->section->name }}</td></tr>
    <tr><th>Session</th><td>{{ $student->session }}</td><th>Printed on</th><td>{{ \App\Support\FeeHelper::today()->format('d M Y') }}</td></tr>
</table>

<table class="grid" style="margin-top:8px;">
    <tr><th style="width:68px;">Date</th><th>Details</th><th class="r" style="width:62px;">Charged</th><th class="r" style="width:62px;">Paid / Less</th><th class="r" style="width:66px;">Balance</th></tr>
    @foreach ($statement['rows'] as $r)
        <tr><td>{{ date('d M Y', strtotime($r['date'])) }}</td><td>{{ $r['text'] }}</td>
            <td class="r">{{ $r['debit'] ? $F::number($r['debit']) : '' }}</td><td class="r">{{ $r['credit'] ? $F::number($r['credit']) : '' }}</td><td class="r">{{ $F::number($r['balance']) }}</td></tr>
    @endforeach
    <tr><th colspan="2" class="r">Totals</th><th class="r">{{ $F::number($statement['debit']) }}</th><th class="r">{{ $F::number($statement['credit']) }}</th><th class="r">{{ $F::number($statement['balance']) }}</th></tr>
</table>
<p><strong>Remaining balance: {{ $F::money($statement['balance']) }}</strong></p>
@if ($statement['pending']->isNotEmpty())
    <p class="small">{{ $statement['pending']->count() }} bank deposit(s) totalling {{ $F::money($statement['pending']->sum('amount')) }} are waiting for verification and are not included.</p>
@endif
</body>
</html>