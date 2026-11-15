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
@php
    $F = \App\Support\FeeHelper::class;
    $summary = $book['summary'];
@endphp
<table><tr>
    <td style="width:46px;">@if ($letterhead['logo'])<img src="{{ $letterhead['logo'] }}" width="40" height="40">@endif</td>
    <td><div class="college">{{ $letterhead['name'] }}</div><div class="small">{{ $letterhead['address'] }}</div><div class="small">{{ $letterhead['phone'] }}</div></td>
</tr></table>
<div class="title">STUDENT FEE ACCOUNT STATEMENT</div>

<table class="grid">
    <tr><th style="width:18%;">Student</th><td>{{ $student->full_name }}</td><th style="width:18%;">Roll No</th><td>{{ $student->roll_number }}</td></tr>
    <tr><th>Father</th><td>{{ $student->father_name }}</td><th>Class</th><td>{{ $student->schoolClass?->name ?? '—' }} / {{ $student->section?->name ?? '—' }}</td></tr>
    <tr><th>Session</th><td>{{ $student->session }}</td><th>Printed on</th><td>{{ \App\Support\FeeHelper::today()->format('d M Y') }}</td></tr>
</table>

<table class="grid" style="margin-top:8px;">
    <tr><th style="width:25%;">Finalized total fee</th><td>{{ $summary['total_fee'] === null ? 'Not set' : $F::money($summary['total_fee']) }}</td>
        <th style="width:25%;">Verified payments received</th><td>{{ $F::money($summary['paid']) }}</td></tr>
    <tr><th>Remaining student balance</th><td><strong>{{ $summary['total_fee'] === null ? 'Not set' : $F::money($summary['remaining']) }}</strong></td>
        <th>Amount billed in vouchers</th><td>{{ $F::money($summary['voucher_billed']) }}</td></tr>
</table>

<div class="title" style="margin-top:10px;">ISSUED VOUCHERS</div>
<table class="grid">
    <tr><th>Voucher No.</th><th>Description</th><th>Issue Date</th><th>Due Date</th><th class="r">Amount</th><th class="r">Paid</th><th class="r">Voucher Balance</th><th>Status</th></tr>
    @forelse ($book['vouchers'] as $row)
        <tr>
            <td>{{ $row['voucher']->voucher_number }}</td>
            <td>{{ $row['voucher']->items->pluck('title')->implode(', ') ?: $row['voucher']->type_label }}</td>
            <td>{{ $row['voucher']->issue_date->format('d M Y') }}</td>
            <td>{{ $row['voucher']->due_date->format('d M Y') }}</td>
            <td class="r">{{ $F::number($row['total']) }}</td>
            <td class="r">{{ $F::number($row['paid']) }}</td>
            <td class="r">{{ $F::number($row['remaining']) }}</td>
            <td>{{ $row['status'] === 'paid' ? 'Paid' : ($row['is_overdue'] ? 'Overdue' : ($row['status'] === 'partial' ? 'Partly paid' : 'Unpaid')) }}</td>
        </tr>
    @empty
        <tr><td colspan="8" style="text-align:center;">No vouchers have been issued.</td></tr>
    @endforelse
</table>

<div class="title" style="margin-top:10px;">TRANSACTION HISTORY</div>
<table class="grid">
    <tr><th style="width:68px;">Date</th><th>Details</th><th class="r" style="width:62px;">Charged</th><th class="r" style="width:62px;">Paid / Less</th><th class="r" style="width:66px;">Ledger Balance</th></tr>
    @forelse ($statement['rows'] as $row)
        <tr><td>{{ date('d M Y', strtotime($row['date'])) }}</td><td>{{ $row['text'] }}</td>
            <td class="r">{{ $row['debit'] ? $F::number($row['debit']) : '' }}</td><td class="r">{{ $row['credit'] ? $F::number($row['credit']) : '' }}</td><td class="r">{{ $F::number($row['balance']) }}</td></tr>
    @empty
        <tr><td colspan="5" style="text-align:center;">No transaction history found.</td></tr>
    @endforelse
    <tr><th colspan="2" class="r">Ledger totals</th><th class="r">{{ $F::number($statement['debit']) }}</th><th class="r">{{ $F::number($statement['credit']) }}</th><th class="r">{{ $F::number($statement['balance']) }}</th></tr>
</table>
<p><strong>Student's remaining finalized-fee balance: {{ $summary['total_fee'] === null ? 'Not set' : $F::money($summary['remaining']) }}</strong></p>
@if ($statement['pending']->isNotEmpty())
    <p class="small">{{ $statement['pending']->count() }} pending payment record(s) totalling {{ $F::money($statement['pending']->sum('amount')) }} are not included in the verified received amount.</p>
@endif
</body>
</html>
