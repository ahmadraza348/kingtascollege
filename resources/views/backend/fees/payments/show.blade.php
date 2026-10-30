@extends('backend.layouts.layout')
@section('title', 'Payment - King TAS College')
@section('content')
@php $F = \App\Support\FeeHelper::class; @endphp
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title"><h4>Payment of {{ $F::money($payment->amount) }}</h4><h6>{{ $payment->receipt_number ?: 'No receipt yet' }}</h6></div>
            <div class="page-btn">
                @if ($payment->status === 'verified')<a href="{{ route('fees.payments.receipt', $payment) }}" target="_blank" class="btn btn-added me-2">Print receipt (PDF)</a>@endif
                <a href="{{ route('fees.payments') }}" class="btn btn-cancel">Back</a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-5">
                <div class="card"><div class="card-body">
                    <span class="badge rounded-pill bg-{{ $payment->status_color }} mb-2">{{ $payment->status_label }}</span>
                    <h5><a href="{{ route('fees.accounts.show', $payment->student) }}">{{ $payment->student->full_name }}</a></h5>
                    <div class="text-muted mb-3">{{ $payment->student->roll_number }} · {{ $payment->student->schoolClass->name }} / {{ $payment->student->section->name }}</div>
                    <div>Date: <strong>{{ $payment->payment_date->format('d M Y') }}</strong></div>
                    <div>Method: <strong>{{ $payment->method_label }}</strong></div>
                    @if ($payment->bank_name)<div>Bank: {{ $payment->bank_name }} {{ $payment->branch }}</div>@endif
                    @if ($payment->reference_no)<div>Reference: <strong>{{ $payment->reference_no }}</strong></div>@endif
                    @if ($payment->remarks)<div>Remarks: {{ $payment->remarks }}</div>@endif
                    <div class="text-muted small mt-2">Recorded by {{ $payment->receiver?->full_name ?: '—' }}
                        @if ($payment->verified_at) · verified by {{ $payment->verifier?->full_name ?: '—' }} on {{ $payment->verified_at->timezone(config('fees.timezone'))->format('d M Y, h:i A') }}@endif</div>
                    @if ($payment->status_reason)<div class="text-danger mt-2">Reason: {{ $payment->status_reason }}</div>@endif
                    @if ($payment->status === 'verified')<div class="mt-2">Student balance after this payment: <strong>{{ $F::money($payment->balance_after) }}</strong></div>@endif
                </div></div>

                @if ($payment->status === 'pending')
                <div class="card"><div class="card-body">
                    <div class="alert alert-warning">This deposit is <strong>not counted</strong> yet. Check the bank slip or statement, then verify.</div>
                    <form action="{{ route('fees.payments.verify', $payment) }}" method="POST" class="mb-3" onsubmit="return confirm('Confirm that this deposit is real and received?');">@csrf
                        <button class="btn btn-submit">Verify payment</button></form>
                    <form action="{{ route('fees.payments.reject', $payment) }}" method="POST">@csrf
                        <input type="text" name="reason" class="form-control mb-2" required maxlength="255" placeholder="Reason for rejecting">
                        <button class="btn btn-sm btn-outline-danger">Reject</button></form>
                </div></div>
                @elseif ($payment->status === 'verified')
                <div class="card"><div class="card-body">
                    <details><summary class="text-danger" style="cursor:pointer">Cancel this payment (e.g. bounced cheque)</summary>
                        <form action="{{ route('fees.payments.cancel', $payment) }}" method="POST" class="mt-2" onsubmit="return confirm('Cancel this payment? The vouchers become unpaid again.');">@csrf
                            <input type="text" name="reason" class="form-control mb-2" required maxlength="255" placeholder="Reason">
                            <button class="btn btn-sm btn-danger">Cancel payment</button></form></details>
                </div></div>
                @endif
            </div>

            <div class="col-lg-7">
                <div class="card"><div class="card-body">
                    <h5 class="mb-3">Applied to</h5>
                    @forelse ($payment->allocations as $a)
                        <div class="d-flex justify-content-between border-bottom py-2">
                            <a href="{{ route('fees.vouchers.show', $a->voucher) }}">{{ $a->voucher->voucher_number }} — {{ $a->voucher->display_label }}</a>
                            <strong>{{ $F::money($a->amount) }}</strong></div>
                    @empty <p class="text-muted mb-0">Not applied to any voucher.</p> @endforelse
                </div></div>
                <div class="card"><div class="card-body">
                    <h5 class="mb-3">History</h5>
                    @foreach ($payment->logs as $log)
                        <div class="border-bottom py-1 small"><span class="text-muted">{{ $log->created_at->timezone(config('fees.timezone'))->format('d M Y, h:i A') }} · {{ $log->admin?->full_name ?: 'System' }}</span><br>{{ $log->description }}</div>
                    @endforeach
                </div></div>
            </div>
        </div>
    </div>
</div>
@endsection