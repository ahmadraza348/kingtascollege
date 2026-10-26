@extends('backend.layouts.layout')
@section('title', 'Voucher ' . $voucher->voucher_number . ' - King TAS College')
@section('content')
@php $F = \App\Support\FeeHelper::class; $s = $voucher->student; $open = in_array($voucher->status, ['unpaid', 'partial']); @endphp
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title"><h4>Voucher {{ $voucher->voucher_number }}</h4><h6>{{ $voucher->type_label }} · {{ $voucher->period_label }}</h6></div>
            <div class="page-btn">
                @if ($voucher->status !== 'cancelled')<a href="{{ route('fees.vouchers.pdf', $voucher) }}" target="_blank" class="btn btn-added me-2">Print voucher (PDF)</a>@endif
                @if ($open)<a href="{{ route('fees.payments.create', ['student' => $voucher->student_id, 'voucher' => $voucher->id]) }}" class="btn btn-submit me-2">Receive payment</a>@endif
                <a href="{{ route('fees.vouchers') }}" class="btn btn-cancel">Back</a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <div class="card"><div class="card-body">
                    <h5 class="mb-1"><a href="{{ route('fees.accounts.show', $s) }}">{{ $s->full_name }}</a></h5>
                    <p class="text-muted mb-2">Father: {{ $s->father_name }}</p>
                    <div>Roll No: <strong>{{ $voucher->roll_number }}</strong></div>
                    <div>Class: {{ $voucher->schoolClass->name }} / {{ $voucher->section->name }}</div>
                    <hr>
                    <div>Issued: {{ $voucher->issue_date->format('d M Y') }}</div>
                    <div>Due: <strong>{{ $voucher->due_date->format('d M Y') }}</strong> @if ($voucher->is_overdue)<span class="badge bg-danger">Overdue</span>@endif</div>
                    <div class="mt-2"><span class="badge rounded-pill bg-{{ $voucher->status_color }}">{{ $voucher->status_label }}</span>
                    </div>
                    @if ($voucher->status === 'cancelled')<div class="text-danger mt-2">Cancelled: {{ $voucher->cancel_reason }}</div>@endif
                </div></div>

                @if ($open)
                <div class="card"><div class="card-body">
                    <h5 class="mb-3">Voucher actions</h5>
                    @unless ($voucher->allocations->count())
                    <details><summary class="text-danger" style="cursor:pointer">Cancel an incorrect voucher</summary>
                        <form action="{{ route('fees.vouchers.cancel', $voucher) }}" method="POST" class="mt-2" onsubmit="return confirm('Cancel this voucher?');">@csrf
                            <input type="text" name="reason" class="form-control mb-2" required maxlength="255" placeholder="Reason">
                            <button class="btn btn-sm btn-danger">Cancel voucher</button>
                        </form></details>
                    @endunless
                </div></div>
                @endif
            </div>

            <div class="col-lg-8">
                <div class="card"><div class="card-body">
                    <h5 class="mb-3">Charges</h5>
                    <div class="table-responsive"><table class="table">
                        <thead><tr><th>Description</th><th>Date</th><th class="text-end">Amount (Rs.)</th></tr></thead>
                        <tbody>
                        @foreach ($voucher->items as $item)
                            <tr>
                                <td>{{ $item->title }} @if ($item->note)<div class="small text-muted">{{ $item->note }}</div>@endif</td>
                                <td>{{ $item->charged_on->format('d M Y') }}</td>
                                <td class="text-end {{ $item->amount < 0 ? 'text-success' : '' }}">{{ $F::number($item->amount) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr><th colspan="2" class="text-end">Voucher total</th><th class="text-end">{{ $F::number($voucher->total_amount) }}</th></tr>
                            <tr><td colspan="2" class="text-end">Paid so far</td><td class="text-end text-success">{{ $F::number($voucher->paid_amount) }}</td></tr>
                            <tr><th colspan="2" class="text-end">Balance of this voucher</th><th class="text-end text-danger">{{ $F::number($voucher->balance) }}</th></tr>
                            @if ($lateExtra > 0)
                                <tr><td colspan="2" class="text-end">Additional late fee through today</td><td class="text-end text-danger">{{ $F::number($lateExtra) }}</td></tr>
                            @endif
                            <tr><th colspan="2" class="text-end">Older unpaid dues (including late fees)</th><td class="text-end">{{ $F::number($arrearsTotal) }}</td></tr>
                            <tr><th colspan="2" class="text-end">Total payable today</th><th class="text-end text-danger">{{ $F::number($voucher->balance + $lateExtra + $arrearsTotal) }}</th></tr>
                        </tfoot>
                    </table></div>

                    @if ($arrears->isNotEmpty())
                        <div class="alert alert-warning mb-0">
                            <strong>Older unpaid vouchers:</strong>
                            <ul class="mb-0">@foreach ($arrears as $a)<li><a href="{{ route('fees.vouchers.show', $a->id) }}">{{ $a->voucher_number }}</a> ({{ \App\Support\FeeHelper::periodLabel($a->period) }}): {{ $F::money($a->payable_today) }}@if ($a->late_fee_extra > 0) — includes {{ $F::money($a->late_fee_extra) }} late fee @endif</li>@endforeach</ul>
                        </div>
                    @endif
                </div></div>

                <div class="card"><div class="card-body">
                    <h5 class="mb-3">Payments applied</h5>
                    @forelse ($voucher->allocations as $a)
                        <div class="d-flex justify-content-between border-bottom py-2">
                            <span><a href="{{ route('fees.payments.show', $a->payment) }}">{{ $a->payment->receipt_number }}</a> · {{ $a->payment->payment_date->format('d M Y') }} · {{ $a->payment->method_label }}</span>
                            <strong>{{ $F::money($a->amount) }}</strong>
                        </div>
                    @empty <p class="text-muted mb-0">No payment yet.</p> @endforelse
                </div></div>

            </div>
        </div>
    </div>
</div>
@endsection
