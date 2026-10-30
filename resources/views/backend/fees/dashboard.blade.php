@extends('backend.layouts.layout')
@section('title', 'Fee Management - King TAS College')
@section('content')
@php $F = \App\Support\FeeHelper::class; @endphp
<div class="page-wrapper"><div class="content">
    <div class="page-header">
        <div class="page-title"><h4>Fee Management</h4><h6>{{ $stats['month_label'] }}</h6></div>
        <div class="page-btn">
            <a href="{{ route('fees.payments.create') }}" class="btn btn-added me-2">Record fee payment</a>
            <a href="{{ route('fees.plans.bulk') }}" class="btn btn-added me-2">Fee plans for a class</a>
            <a href="{{ route('fees.vouchers.bulk') }}" class="btn btn-added me-2">Create monthly vouchers</a>
            <a href="{{ route('fees.vouchers.create') }}" class="btn btn-added">Create one voucher</a>
        </div>
    </div>
    @if (empty(\App\Models\FeeSetting::get('bank_name')) || empty(\App\Models\FeeSetting::get('account_number')))
        <div class="alert alert-warning">Add the bank name and account number in Fee Settings to print them on vouchers. <a href="{{ route('fees.settings') }}">Open Fee Settings</a></div>
    @endif
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-3"><div class="card mb-0"><div class="card-body"><small class="text-muted">Collected today</small><h3 class="mt-1 mb-0 text-success">{{ $F::money($stats['today']) }}</h3></div></div></div>
        <div class="col-xl-3 col-md-6 mb-3"><div class="card mb-0"><div class="card-body"><small class="text-muted">Collected this month</small><h3 class="mt-1 mb-0 text-success">{{ $F::money($stats['month']) }}</h3></div></div></div>
        <div class="col-xl-3 col-md-6 mb-3"><div class="card mb-0"><div class="card-body"><small class="text-muted">Outstanding</small><h3 class="mt-1 mb-0 text-danger">{{ $F::money($stats['outstanding']) }}</h3><a href="{{ route('fees.accounts', ['balance' => 'due']) }}" class="small">View student balances</a></div></div></div>
        <div class="col-xl-3 col-md-6 mb-3"><div class="card mb-0"><div class="card-body"><small class="text-muted">Overdue</small><h3 class="mt-1 mb-0 text-danger">{{ $F::money($stats['overdue_amount']) }}</h3><a href="{{ route('fees.accounts', ['balance' => 'overdue']) }}" class="small">{{ $stats['overdue_students'] }} student(s)</a></div></div></div>
    </div>
    {{-- Installment / fee plan analytics --}}
    <h5 class="mb-3 mt-2">Fee plans &amp; installments</h5>
    @if ($plan['plans'] === 0)
        <div class="alert alert-info">No fee plans yet. Open a student's account book to set one up, or <a href="{{ route('fees.plans.bulk') }}">create plans for a whole class</a>.</div>
    @else
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-3"><div class="card mb-0 h-100"><div class="card-body"><small class="text-muted">Total fee under plans</small><h3 class="mt-1 mb-0">{{ $F::money($plan['expected']) }}</h3><small class="text-muted">{{ $plan['plans'] }} student plan(s), {{ $plan['installments'] }} installments</small></div></div></div>
        <div class="col-xl-3 col-md-6 mb-3"><div class="card mb-0 h-100"><div class="card-body"><small class="text-muted">Collected</small><h3 class="mt-1 mb-0 text-success">{{ $F::money($plan['collected']) }}</h3>
            <div class="progress mt-2" style="height:8px"><div class="progress-bar bg-success" style="width: {{ $plan['percent'] }}%"></div></div><small class="text-muted">{{ $plan['percent'] }}% of the total</small></div></div></div>
        <div class="col-xl-3 col-md-6 mb-3"><div class="card mb-0 h-100"><div class="card-body"><small class="text-muted">Still to collect</small><h3 class="mt-1 mb-0 text-danger">{{ $F::money($plan['remaining']) }}</h3><small class="text-muted">{{ $F::money($plan['month_due']) }} falls due this month</small></div></div></div>
        <div class="col-xl-3 col-md-6 mb-3"><div class="card mb-0 h-100"><div class="card-body"><small class="text-muted">Overdue installments</small><h3 class="mt-1 mb-0 text-danger">{{ $F::money($plan['overdue_amount']) }}</h3><a href="{{ route('fees.accounts', ['balance' => 'overdue']) }}" class="small">{{ $plan['overdue_count'] }} installment(s) · {{ $plan['overdue_students'] }} student(s)</a></div></div></div>
    </div>

    <div class="row">
        <div class="col-xl-4 col-md-6 mb-3"><div class="card mb-0 h-100"><div class="card-body">
            <h6 class="mb-3">Installment status</h6>
            @foreach ([['Paid', $plan['paid_count'], 'success'], ['Part paid', $plan['partial_count'], 'warning'], ['Unpaid', $plan['unpaid_count'], 'danger']] as [$label, $n, $color])
                <div class="d-flex justify-content-between small mb-1"><span>{{ $label }}</span><strong>{{ $n }}</strong></div>
                <div class="progress mb-3" style="height:6px"><div class="progress-bar bg-{{ $color }}" style="width: {{ $plan['installments'] ? round($n / $plan['installments'] * 100) : 0 }}%"></div></div>
            @endforeach
            <div class="small text-muted">Due in the next 7 days: <strong>{{ $plan['soon_count'] }}</strong> installment(s), {{ $F::money($plan['soon_amount']) }}</div>
        </div></div></div>

        <div class="col-xl-4 col-md-6 mb-3"><div class="card mb-0 h-100"><div class="card-body">
            <h6 class="mb-3">Students with a fee plan</h6>
            <h3 class="mb-0">{{ $plan['with_plan'] }} <small class="text-muted fs-6">of {{ $plan['active_students'] }} active</small></h3>
            <div class="progress my-2" style="height:8px"><div class="progress-bar" style="width: {{ $plan['active_students'] ? round($plan['with_plan'] / $plan['active_students'] * 100) : 0 }}%"></div></div>
            @if ($plan['without_plan'] > 0)<small class="text-muted">{{ $plan['without_plan'] }} student(s) have no plan yet. <a href="{{ route('fees.plans.bulk') }}">Set up plans</a></small>@else<small class="text-success">Every active student has a plan.</small>@endif
        </div></div></div>

        <div class="col-xl-4 col-md-12 mb-3"><div class="card mb-0 h-100"><div class="card-body">
            <h6 class="mb-3">Collected per month</h6>
            @php $maxM = max(1, $plan['months']->max()); @endphp
            <div class="d-flex align-items-end justify-content-between" style="height:110px">
                @foreach ($plan['months'] as $ym => $amt)
                    <div class="text-center flex-fill" title="{{ $F::money($amt) }}">
                        <div style="height: {{ max(2, round($amt / $maxM * 90)) }}px; background:#28a745; margin:0 4px; border-radius:3px 3px 0 0"></div>
                        <small class="text-muted" style="font-size:10px">{{ \Carbon\Carbon::createFromFormat('Y-m', $ym)->format('M') }}</small>
                    </div>
                @endforeach
            </div>
            <small class="text-muted">All verified payments, last 6 months. This month: {{ $F::money($plan['months']->last()) }}</small>
        </div></div></div>
    </div>

    <div class="row">
        <div class="col-xl-6 mb-3"><div class="card mb-0 h-100"><div class="card-body">
            <h6 class="mb-3">Next installments due</h6>
            <div class="table-responsive"><table class="table table-sm mb-0"><tbody>
            @forelse ($plan['upcoming'] as $v)
                <tr><td><a href="{{ route('fees.accounts.show', $v->student_id) }}">{{ $v->student->full_name }}</a> <small class="text-muted">{{ $v->student->roll_number }}</small></td>
                    <td>Inst. {{ $v->installment_no }}</td><td class="text-nowrap">{{ $v->due_date->format('d M Y') }}</td><td class="text-end">{{ $F::number($v->balance) }}</td></tr>
            @empty<tr><td class="text-muted">Nothing upcoming.</td></tr>@endforelse
            </tbody></table></div>
        </div></div></div>
        <div class="col-xl-6 mb-3"><div class="card mb-0 h-100"><div class="card-body">
            <h6 class="mb-3">Biggest overdue balances</h6>
            <div class="table-responsive"><table class="table table-sm mb-0"><tbody>
            @forelse ($plan['top_overdue'] as $r)
                <tr><td><a href="{{ route('fees.accounts.show', $r->student_id) }}">{{ $r->student?->full_name }}</a> <small class="text-muted">{{ $r->student?->roll_number }}</small></td>
                    <td>{{ $r->n }} installment(s)</td><td class="text-nowrap small text-muted">since {{ \Carbon\Carbon::parse($r->oldest)->format('d M Y') }}</td><td class="text-end text-danger">{{ $F::number($r->amount) }}</td></tr>
            @empty<tr><td class="text-success">No overdue installments.</td></tr>@endforelse
            </tbody></table></div>
        </div></div></div>
    </div>

    @if ($plan['by_class']->isNotEmpty())
    <div class="card"><div class="card-body">
        <h6 class="mb-3">Collection by class</h6>
        <div class="table-responsive"><table class="table table-sm mb-0">
            <thead><tr><th>Class</th><th class="text-end">Total fee</th><th class="text-end">Collected</th><th class="text-end">Remaining</th><th style="min-width:150px">Progress</th></tr></thead>
            <tbody>@foreach ($plan['by_class'] as $c)
                <tr><td>{{ $c['name'] }}</td><td class="text-end">{{ $F::number($c['total']) }}</td><td class="text-end text-success">{{ $F::number($c['paid']) }}</td><td class="text-end text-danger">{{ $F::number($c['balance']) }}</td>
                    <td><div class="progress" style="height:8px"><div class="progress-bar bg-success" style="width: {{ $c['percent'] }}%"></div></div><small class="text-muted">{{ $c['percent'] }}%</small></td></tr>
            @endforeach</tbody>
        </table></div>
    </div></div>
    @endif
    @endif

    <div class="card"><div class="card-body">
        <h5 class="mb-3">{{ $stats['month_label'] }} monthly vouchers (students without a fee plan)</h5>
        @foreach (\App\Models\FeeVoucher::STATUSES as $key => $label)
            @continue($key === 'cancelled')
            <a href="{{ route('fees.vouchers', ['period' => \App\Support\FeeHelper::today()->format('Y-m'), 'status' => $key]) }}" class="btn btn-sm btn-outline-{{ \App\Models\FeeVoucher::STATUS_COLORS[$key] }} me-1">{{ $label }}: {{ $stats['month_vouchers'][$key] ?? 0 }}</a>
        @endforeach
        <p class="small text-muted mt-3 mb-0">Record cash when received. Record a payment only after the cash or bank deposit has been received.</p>
    </div></div>
    <div class="card"><div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3"><h5 class="mb-0">Recent payments</h5><a href="{{ route('fees.payments') }}">All payments</a></div>
        <div class="table-responsive"><table class="table"><thead><tr><th>Date</th><th>Receipt</th><th>Student</th><th>Method</th><th class="text-end">Amount</th><th></th></tr></thead><tbody>
        @forelse ($stats['recent'] as $payment)
            <tr><td>{{ $payment->payment_date->format('d M Y') }}</td><td>{{ $payment->receipt_number }}</td><td>{{ $payment->student->full_name }} <small class="text-muted">{{ $payment->student->roll_number }}</small></td><td>{{ $payment->method_label }}</td><td class="text-end">{{ $F::money($payment->amount) }}</td><td><a href="{{ route('fees.payments.show', $payment) }}">Open</a></td></tr>
        @empty
            <tr><td colspan="6" class="text-center text-muted">No payments recorded yet.</td></tr>
        @endforelse
        </tbody></table></div>
    </div></div>
</div></div>
@endsection
