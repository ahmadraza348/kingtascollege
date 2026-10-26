@php
    $F = \App\Support\FeeHelper::class;
    $v = $data['voucher'];
    $s = $v->student;
    $b = $data['breakdown'];
    $lateRate = \App\Models\FeeSetting::enabled('late_fee_enabled') ? \App\Models\FeeSetting::number('late_fee_per_day') : 0;
@endphp
<div class="copy-title">{{ $label }}</div>
<div class="college-name">{{ $letterhead['name'] }}</div>
<div class="bank-line">
    BANK: {{ strtoupper($bank['name'] ?: '—') }}
    @if (!empty($bank['branch'])) &nbsp; BRANCH: {{ strtoupper($bank['branch']) }} @endif
    @if (!empty($bank['account_title']))<br>ACCOUNT TITLE: {{ strtoupper($bank['account_title']) }}@endif
    <br>ACCOUNT NO: {{ strtoupper($bank['account_number'] ?: '—') }}
</div>
<table class="fields">
    <tr><td class="key">Issue Date</td><td class="value">{{ $v->issue_date->format('d-M-y') }}</td></tr>
    <tr class="installment"><td class="key">INSTALLMENT</td><td class="value">{{ $F::number($data['installment']) }}</td></tr>
    <tr><td class="key">Student Name:</td><td class="value">{{ $s->full_name }}</td></tr>
    <tr><td class="key">Class/Section:</td><td class="value">{{ $v->schoolClass?->name ?? '—' }} / {{ $v->section?->name ?? '—' }}</td></tr>
    <tr><td class="key">Roll Number:</td><td class="value">{{ $v->roll_number }}</td></tr>
    <tr class="fee-head"><th>Particulars</th><th class="money">Amount in Rs.</th></tr>
    <tr><td>ADMISSION Fee</td><td class="money">{{ $F::number($b['admission']) }}</td></tr>
    <tr><td>Tuition Fee</td><td class="money">{{ $F::number($b['tuition']) }}</td></tr>
    <tr><td>Examination Fee</td><td class="money">{{ $F::number($b['exam']) }}</td></tr>
    <tr><td>Arrears</td><td class="money">{{ $F::number($b['arrears']) }}</td></tr>
    <tr><td>Absent Fine</td><td class="money">{{ $F::number($b['absent_fine']) }}</td></tr>
    <tr><td>Late fee fine</td><td class="money">{{ $F::number($b['late_fee']) }}</td></tr>
    <tr class="total"><td>Total</td><td class="money">{{ $F::number($data['payable']) }}</td></tr>
    <tr class="due"><td>Due Date</td><td>{{ $v->due_date->format('d/m/y') }}</td></tr>
    <tr class="late"><td>After Due Date late Fine will be</td><td>{{ $F::number($lateRate) }} PER DAY</td></tr>
</table>
<div class="terms">
    @foreach ($policies as $line)
        <div class="term">{{ $line }}</div>
    @endforeach
</div>
