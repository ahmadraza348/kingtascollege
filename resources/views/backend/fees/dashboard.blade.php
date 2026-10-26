@extends('backend.layouts.layout')
@section('title', 'Fee Management - King TAS College')
@section('content')
@php $F = \App\Support\FeeHelper::class; @endphp
<div class="page-wrapper"><div class="content">
    <div class="page-header">
        <div class="page-title"><h4>Fee Management</h4><h6>{{ $stats['month_label'] }}</h6></div>
        <div class="page-btn">
            <a href="{{ route('fees.payments.create') }}" class="btn btn-added me-2">Record fee payment</a>
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
    <div class="card"><div class="card-body">
        <h5 class="mb-3">{{ $stats['month_label'] }} monthly vouchers</h5>
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
