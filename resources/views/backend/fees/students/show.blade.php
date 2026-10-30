@extends('backend.layouts.layout')
@section('title', 'Account Book - ' . $student->full_name)
@section('content')
@php
    $F    = \App\Support\FeeHelper::class;
    $plan = $book['plan'];
    $s    = $book['summary'];
    $badge = function ($r) {
        if ($r['status'] === 'paid') return ['success', 'Paid'];
        if ($r['is_overdue']) return ['danger', 'Overdue ' . $r['days_overdue'] . ' day' . ($r['days_overdue'] === 1 ? '' : 's')];
        if ($r['status'] === 'partial') return ['warning', 'Part paid'];
        return ['secondary', 'Upcoming'];
    };
@endphp
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Account Book — {{ $student->full_name }}</h4>
                <h6>Roll No {{ $student->roll_number }} · {{ $student->schoolClass->name }} / {{ $student->section->name }}@if ($student->session) · Session {{ $student->session }}@endif · Father: {{ $student->father_name }}</h6>
            </div>
            <div class="page-btn">
                @if ($book['all_due'] > 0)<a href="{{ route('fees.payments.create', ['student' => $student->id]) }}" class="btn btn-submit me-2">Receive payment</a>@endif
                @if ($plan)
                    <a href="{{ route('fees.plans.edit', $student) }}" class="btn btn-added me-2">Change fee plan</a>
                @else
                    <a href="{{ route('fees.plans.create', $student) }}" class="btn btn-added me-2">Set up fee plan</a>
                @endif
                <a href="{{ route('fees.accounts.statement', $student) }}" target="_blank" class="btn btn-added me-2">Print account book</a>
                <a href="{{ route('fees.accounts') }}" class="btn btn-cancel">Back</a>
            </div>
        </div>

        @if ($book['pending']->isNotEmpty())
            <div class="alert alert-warning">{{ $book['pending']->count() }} payment(s) are waiting for verification and are not counted yet:
                @foreach ($book['pending'] as $p)<a href="{{ route('fees.payments.show', $p) }}">{{ $F::money($p->amount) }}</a>{{ ! $loop->last ? ',' : '' }}@endforeach</div>
        @endif

        @if (! $plan)
            <div class="alert alert-info d-flex justify-content-between align-items-center flex-wrap">
                <span><strong>No fee plan yet.</strong> Enter this student's total course fee and split it into installments, so the account book can show how much is paid and how much remains.</span>
                <a href="{{ route('fees.plans.create', $student) }}" class="btn btn-sm btn-submit mt-2 mt-md-0">Set up fee plan</a>
            </div>
        @else
            {{-- Summary cards --}}
            <div class="row">
                <div class="col-xl-3 col-md-6 mb-3"><div class="card mb-0 h-100"><div class="card-body py-3">
                    <small class="text-muted">Total payable fee</small>
                    <h3 class="mb-0">{{ $F::money($s['net_fee']) }}</h3>
                    <small class="text-muted">@if ($s['discount'] > 0)Fee {{ $F::number($s['total_fee']) }} − discount {{ $F::number($s['discount']) }}@else Whole course fee @endif
                        @if ($s['late_fee'] > 0)<br>+ late fees {{ $F::money($s['late_fee']) }}@endif</small>
                </div></div></div>
                <div class="col-xl-3 col-md-6 mb-3"><div class="card mb-0 h-100"><div class="card-body py-3">
                    <small class="text-muted">Paid so far</small>
                    <h3 class="mb-0 text-success">{{ $F::money($s['paid']) }}</h3>
                    <small class="text-muted">{{ $s['paid_count'] }} of {{ $s['count'] }} installment(s) fully paid</small>
                </div></div></div>
                <div class="col-xl-3 col-md-6 mb-3"><div class="card mb-0 h-100"><div class="card-body py-3">
                    <small class="text-muted">Remaining</small>
                    <h3 class="mb-0 {{ $s['remaining'] > 0 ? 'text-danger' : 'text-success' }}">{{ $F::money($s['remaining']) }}</h3>
                    <small class="text-muted">{{ $s['remaining_count'] }} installment(s) left</small>
                </div></div></div>
                <div class="col-xl-3 col-md-6 mb-3"><div class="card mb-0 h-100"><div class="card-body py-3">
                    @if ($s['remaining'] <= 0)
                        <small class="text-muted">Status</small><h3 class="mb-0 text-success">Fee cleared</h3><small class="text-muted">Nothing left to pay</small>
                    @elseif ($s['overdue_count'] > 0)
                        <small class="text-muted">Overdue now</small><h3 class="mb-0 text-danger">{{ $F::money($s['overdue_amount']) }}</h3><small class="text-muted">{{ $s['overdue_count'] }} installment(s) past due date</small>
                    @elseif ($s['next'])
                        <small class="text-muted">Next installment</small><h3 class="mb-0">{{ $F::money($s['next']['remaining']) }}</h3><small class="text-muted">Due {{ $s['next']['voucher']->due_date->format('d M Y') }}</small>
                    @endif
                </div></div></div>
            </div>

            <div class="card"><div class="card-body py-3">
                <div class="d-flex justify-content-between small mb-1"><span>Fee paid</span><strong>{{ $s['percent'] }}%</strong></div>
                <div class="progress" style="height:12px"><div class="progress-bar bg-success" style="width: {{ $s['percent'] }}%"></div></div>
            </div></div>

            {{-- Installments --}}
            <div class="card"><div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                    <h5 class="mb-0">Installments</h5>
                    @if ($plan->notes)<span class="small text-muted">Note: {{ $plan->notes }}</span>@endif
                </div>
                <div class="table-responsive"><table class="table">
                    <thead><tr><th>#</th><th>Due date</th><th class="text-end">Installment</th><th class="text-end">Late fee</th><th class="text-end">Paid</th><th class="text-end">Remaining</th><th>Status</th><th>Voucher</th></tr></thead>
                    <tbody>
                    @foreach ($book['installments'] as $r)
                        @php [$color, $label] = $badge($r); @endphp
                        <tr>
                            <td><strong>{{ $r['no'] }}</strong></td>
                            <td class="text-nowrap">{{ $r['voucher']->due_date->format('d M Y') }}</td>
                            <td class="text-end">{{ $F::number($r['base']) }}</td>
                            <td class="text-end {{ $r['late_fee'] > 0 ? 'text-danger' : 'text-muted' }}">{{ $r['late_fee'] > 0 ? $F::number($r['late_fee']) : '—' }}</td>
                            <td class="text-end text-success">
                                {{ $r['paid'] > 0 ? $F::number($r['paid']) : '—' }}
                                @foreach ($r['payments'] as $a)<div class="small text-muted">{{ $a->payment->payment_date->format('d M') }} · {{ $F::number($a->amount) }}</div>@endforeach
                            </td>
                            <td class="text-end"><strong class="{{ $r['remaining'] > 0 ? 'text-danger' : 'text-success' }}">{{ $F::number($r['remaining']) }}</strong></td>
                            <td><span class="badge rounded-pill bg-{{ $color }}">{{ $label }}</span></td>
                            <td class="text-nowrap"><a href="{{ route('fees.vouchers.show', $r['voucher']) }}">{{ $r['voucher']->voucher_number }}</a>
                                <a href="{{ route('fees.vouchers.pdf', $r['voucher']) }}" target="_blank" class="ms-1 small">Print</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr><th colspan="2" class="text-end">Total</th>
                            <th class="text-end">{{ $F::number($book['installments']->sum('base')) }}</th>
                            <th class="text-end">{{ $s['late_fee'] > 0 ? $F::number($s['late_fee']) : '—' }}</th>
                            <th class="text-end text-success">{{ $F::number($s['paid']) }}</th>
                            <th class="text-end text-danger">{{ $F::number($s['remaining']) }}</th><th colspan="2"></th></tr>
                    </tfoot>
                </table></div>
                <small class="text-muted">A payment is applied to the oldest unpaid installment first. Late fees (if enabled in Fee Settings) are added automatically when an installment is paid after its due date.</small>
            </div></div>
        @endif

        {{-- Other charges --}}
        @if ($book['others']->isNotEmpty())
            <div class="card"><div class="card-body">
                <h5 class="mb-3">{{ $plan ? 'Other charges (outside the fee plan)' : 'Fee vouchers' }}</h5>
                <div class="table-responsive"><table class="table table-sm">
                    <thead><tr><th>Voucher</th><th>For</th><th>Due date</th><th class="text-end">Total</th><th class="text-end">Paid</th><th class="text-end">Remaining</th><th>Status</th></tr></thead>
                    <tbody>
                    @foreach ($book['others'] as $r)
                        @php [$color, $label] = $badge($r); @endphp
                        <tr><td><a href="{{ route('fees.vouchers.show', $r['voucher']) }}">{{ $r['voucher']->voucher_number }}</a></td>
                            <td>{{ $r['voucher']->type_label }} · {{ $r['voucher']->period_label }}</td>
                            <td>{{ $r['voucher']->due_date->format('d M Y') }}</td>
                            <td class="text-end">{{ $F::number($r['total']) }}</td><td class="text-end text-success">{{ $F::number($r['paid']) }}</td>
                            <td class="text-end"><strong>{{ $F::number($r['remaining']) }}</strong></td>
                            <td><span class="badge rounded-pill bg-{{ $color }}">{{ $label }}</span></td></tr>
                    @endforeach
                    </tbody>
                </table></div>
            </div></div>
        @endif

        @if ($plan && $book['others_due'] > 0)
            <div class="alert alert-secondary">Total outstanding including other charges: <strong>{{ $F::money($book['all_due']) }}</strong></div>
        @endif

        {{-- Payments received --}}
        <div class="card"><div class="card-body">
            <h5 class="mb-3">Payments received</h5>
            <div class="table-responsive"><table class="table table-sm">
                <thead><tr><th>Date</th><th>Receipt</th><th>Method</th><th>Applied to</th><th class="text-end">Amount</th><th></th></tr></thead>
                <tbody>
                @forelse ($book['payments'] as $p)
                    <tr><td class="text-nowrap">{{ $p->payment_date->format('d M Y') }}</td>
                        <td><a href="{{ route('fees.payments.show', $p) }}">{{ $p->receipt_number }}</a></td>
                        <td>{{ $p->method_label }}</td>
                        <td class="small">@foreach ($p->allocations as $a){{ $a->voucher->type === 'installment' && $a->voucher->installment_no ? 'Installment ' . $a->voucher->installment_no : $a->voucher->voucher_number }} ({{ $F::number($a->amount) }}){{ ! $loop->last ? ', ' : '' }}@endforeach</td>
                        <td class="text-end text-success"><strong>{{ $F::number($p->amount) }}</strong></td>
                        <td><a href="{{ route('fees.payments.receipt', $p) }}" target="_blank" class="small">Receipt</a></td></tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted">No payments received yet.</td></tr>
                @endforelse
                </tbody>
            </table></div>
        </div></div>

        {{-- Full ledger --}}
        <div class="card"><div class="card-body">
            <details>
                <summary class="h5 mb-0" style="cursor:pointer">Full ledger (every charge and payment)</summary>
                <div class="table-responsive mt-3"><table class="table table-sm">
                    <thead><tr><th>Date</th><th>Details</th><th class="text-end">Charged</th><th class="text-end">Paid / Less</th><th class="text-end">Balance</th></tr></thead>
                    <tbody>
                    @forelse ($statement['rows'] as $r)
                        <tr><td class="text-nowrap">{{ date('d M Y', strtotime($r['date'])) }}</td><td>{{ $r['text'] }}</td>
                            <td class="text-end">{{ $r['debit'] ? $F::number($r['debit']) : '' }}</td>
                            <td class="text-end text-success">{{ $r['credit'] ? $F::number($r['credit']) : '' }}</td>
                            <td class="text-end"><strong>{{ $F::number($r['balance']) }}</strong></td></tr>
                    @empty<tr><td colspan="5" class="text-center text-muted">No fee history yet.</td></tr>@endforelse
                    </tbody>
                </table></div>
            </details>
        </div></div>

        @if ($plan)
            <details class="mb-4">
                <summary class="text-danger small" style="cursor:pointer">Cancel this fee plan</summary>
                <form action="{{ route('fees.plans.cancel', $student) }}" method="POST" class="mt-2 col-lg-5" onsubmit="return confirm('Cancel the whole fee plan? All unpaid installments will be cancelled.');">@csrf
                    <input type="text" name="reason" class="form-control mb-2" required maxlength="255" placeholder="Reason">
                    <button class="btn btn-sm btn-danger">Cancel fee plan</button>
                    <div class="small text-muted mt-1">Only possible while no payment is applied to the plan.</div>
                </form>
            </details>
        @endif
    </div>
</div>
@endsection
