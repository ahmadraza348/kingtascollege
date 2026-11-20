<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Monthly Fee Report - {{ $report['period_label'] }}</title>
<style>
    @page { margin: 22px 24px; }
    body { font-family: 'DejaVu Sans', sans-serif; font-size: 8.5px; color: #1f2937; }
    table { border-collapse: collapse; width: 100%; }
    .college { font-size: 15px; font-weight: bold; color: #10233f; }
    .small { font-size: 7.5px; color: #4b5563; }
    .title { font-size: 13px; font-weight: bold; color: #10233f; text-align: center; margin: 10px 0 4px; }
    .subtitle { text-align: center; color: #4b5563; font-size: 9px; margin-bottom: 10px; }
    .summary td { border: 1px solid #cbd5e1; padding: 5px 6px; }
    .grid { margin-top: 7px; }
    .grid td, .grid th { border: 1px solid #cbd5e1; padding: 4px 4px; vertical-align: top; }
    .grid th { background: #e2e8f0; font-weight: bold; text-align: left; }
    .right { text-align: right; white-space: nowrap; }
    .class-title { margin-top: 13px; margin-bottom: 4px; font-size: 10px; font-weight: bold; color: #10233f; }
    .totals td { background: #f1f5f9; font-weight: bold; }
    .muted { color: #6b7280; }
    .status-no { color: #b91c1c; font-weight: bold; }
    .status-yes { color: #15803d; font-weight: bold; }
    .page-break { page-break-after: always; }
</style>
</head>
<body>
<table>
    <tr>
        <td style="width:48px; vertical-align:top;">@if (!empty($letterhead['logo']))<img src="{{ $letterhead['logo'] }}" width="42" height="42">@endif</td>
        <td style="vertical-align:top;"><div class="college">{{ $letterhead['name'] }}</div><div class="small">{{ $letterhead['address'] }}</div><div class="small">{{ $letterhead['phone'] }}</div></td>
        <td style="text-align:right; vertical-align:top;" class="small">Generated: {{ $report['generated_at'] }}</td>
    </tr>
</table>
<div class="title">MONTHLY CLASS-WISE FEE REPORT</div>
<div class="subtitle">{{ $report['period_label'] }} · Collected amounts are based on verified payments dated in the selected month</div>

<table class="summary">
    <tr>
        <td><strong>Active students</strong><br>{{ number_format($report['totals']['active_students']) }}</td>
        <td><strong>Total finalized fee</strong><br>Rs. {{ \App\Support\FeeHelper::number($report['totals']['total_fee']) }}</td>
        <td><strong>Remaining finalized fee</strong><br>Rs. {{ \App\Support\FeeHelper::number($report['totals']['remaining_fee']) }}</td>
        <td><strong>Collected in {{ $report['period_label'] }}</strong><br>Rs. {{ \App\Support\FeeHelper::number($report['totals']['month_collected']) }}</td>
        <td><strong>Students with no payment</strong><br>{{ number_format($report['totals']['students_unpaid_this_month']) }}</td>
    </tr>
    <tr>
        <td><strong>Voucher amount for month</strong><br>Rs. {{ \App\Support\FeeHelper::number($report['totals']['period_voucher_total']) }}</td>
        <td><strong>Voucher balance for month</strong><br>Rs. {{ \App\Support\FeeHelper::number($report['totals']['period_voucher_balance']) }}</td>
        <td><strong>Late fines on monthly vouchers</strong><br>Rs. {{ \App\Support\FeeHelper::number($report['totals']['period_late_fine']) }}</td>
        <td><strong>Absent fines on monthly vouchers</strong><br>Rs. {{ \App\Support\FeeHelper::number($report['totals']['period_absent_fine']) }}</td>
        <td><strong>Active students without fee set</strong><br>{{ number_format($report['totals']['students_without_fee']) }}</td>
    </tr>
</table>

@forelse ($report['classes'] as $class)
    <div class="class-title">Class: {{ $class['name'] }} @if ($class['code']) ({{ $class['code'] }}) @endif</div>
    <table class="summary">
        <tr>
            <td><strong>Active students</strong><br>{{ number_format($class['active_students']) }}</td>
            <td><strong>Total fee</strong><br>Rs. {{ \App\Support\FeeHelper::number($class['total_fee']) }}</td>
            <td><strong>Remaining fee</strong><br>Rs. {{ \App\Support\FeeHelper::number($class['remaining_fee']) }}</td>
            <td><strong>Collected this month</strong><br>Rs. {{ \App\Support\FeeHelper::number($class['month_collected']) }}</td>
            <td><strong>No payment this month</strong><br>{{ number_format($class['students_unpaid_this_month']) }}</td>
        </tr>
    </table>
    <table class="grid">
        <thead><tr>
            <th style="width:6%;">Roll No.</th><th style="width:16%;">Student</th><th style="width:11%;">Section</th>
            <th class="right">Finalized fee</th><th class="right">Received this month</th><th class="right">Remaining fee</th>
            <th class="right">Voucher billed</th><th class="right">Voucher paid</th><th class="right">Voucher balance</th>
            <th class="right">Late fine</th><th class="right">Absent fine</th><th style="width:9%;">Voucher status</th><th style="width:8%;">Payment</th>
        </tr></thead>
        <tbody>
        @forelse ($class['students'] as $row)
            <tr>
                <td>{{ $row['student']->roll_number }}</td>
                <td>{{ $row['student']->full_name }}<div class="small">{{ $row['student']->father_name }}</div></td>
                <td>{{ $row['student']->section?->name ?? '—' }}</td>
                <td class="right">{{ $row['finalized_fee'] === null ? 'Not set' : \App\Support\FeeHelper::number($row['finalized_fee']) }}</td>
                <td class="right">{{ \App\Support\FeeHelper::number($row['month_received']) }}</td>
                <td class="right">{{ $row['remaining_fee'] === null ? '—' : \App\Support\FeeHelper::number($row['remaining_fee']) }}</td>
                <td class="right">{{ \App\Support\FeeHelper::number($row['period_voucher_total']) }}</td>
                <td class="right">{{ \App\Support\FeeHelper::number($row['period_voucher_paid']) }}</td>
                <td class="right">{{ \App\Support\FeeHelper::number($row['period_voucher_balance']) }}</td>
                <td class="right">{{ \App\Support\FeeHelper::number($row['period_late_fine']) }}</td>
                <td class="right">{{ \App\Support\FeeHelper::number($row['period_absent_fine']) }}</td>
                <td>{{ $row['voucher_status'] }}</td>
                <td class="{{ $row['paid_this_month'] ? 'status-yes' : 'status-no' }}">{{ $row['paid_this_month'] ? 'Paid' : 'No payment' }}</td>
            </tr>
        @empty
            <tr><td colspan="13" style="text-align:center;">No active students in this class.</td></tr>
        @endforelse
        <tr class="totals">
            <td colspan="3">Class totals</td>
            <td class="right">{{ \App\Support\FeeHelper::number($class['total_fee']) }}</td>
            <td class="right">{{ \App\Support\FeeHelper::number($class['month_collected']) }}</td>
            <td class="right">{{ \App\Support\FeeHelper::number($class['remaining_fee']) }}</td>
            <td class="right">{{ \App\Support\FeeHelper::number($class['period_voucher_total']) }}</td>
            <td class="right">{{ \App\Support\FeeHelper::number($class['period_voucher_total'] - $class['period_voucher_balance']) }}</td>
            <td class="right">{{ \App\Support\FeeHelper::number($class['period_voucher_balance']) }}</td>
            <td class="right">{{ \App\Support\FeeHelper::number($class['period_late_fine']) }}</td>
            <td class="right">{{ \App\Support\FeeHelper::number($class['period_absent_fine']) }}</td>
            <td colspan="2"></td>
        </tr>
        </tbody>
    </table>
@empty
    <p>No classes found.</p>
@endforelse

<p class="small" style="margin-top:10px;">Notes: A student is counted as paid when at least one verified payment has a payment date within {{ $report['period_label'] }}. Voucher balances cover active vouchers whose billing period is {{ $report['period_label'] }}. Fine charges are additional to the finalized course fee. Remaining finalized fee deducts amounts allocated to non-fine voucher lines; the monthly collection figure includes all verified payments.</p>
</body>
</html>
