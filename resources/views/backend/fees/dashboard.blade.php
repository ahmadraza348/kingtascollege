@extends('backend.layouts.layout')
@section('title', 'Fee Management - King TAS College')
@section('content')
@php $F = \App\Support\FeeHelper::class; @endphp
<div class="page-wrapper"><div class="content">
    <div class="page-header">
        <div class="page-title"><h4>Fee Management</h4><h6>{{ $stats['month_label'] }}</h6></div>
        <div class="page-btn">
            <a href="{{ route('fees.accounts') }}" class="btn btn-cancel me-2">Student Accounts</a>
            <a href="{{ route('fees.vouchers.create') }}" class="btn btn-added me-2">Create Student Voucher</a>
            <a href="{{ route('fees.payments.create') }}" class="btn btn-added">Receive Payment</a>
        </div>
    </div>

    @if ($stats['students_without_fee'] > 0)
        <div class="alert alert-warning">{{ $stats['students_without_fee'] }} active student(s) do not have a finalized total fee yet. Set each amount from the Student record before creating vouchers or receiving payments.</div>
    @endif
    @if (empty(\App\Models\FeeSetting::get('bank_name')) || empty(\App\Models\FeeSetting::get('account_number')))
        <div class="alert alert-warning">Add the bank name and account number in Fee Settings to print them on vouchers. <a href="{{ route('fees.settings') }}">Open Fee Settings</a></div>
    @endif

    <div class="row">
        <div class="col-xl-3 col-md-6 mb-3"><div class="card mb-0"><div class="card-body"><small class="text-muted">Collected today</small><h3 class="mt-1 mb-0 text-success">{{ $F::money($stats['today']) }}</h3></div></div></div>
        <div class="col-xl-3 col-md-6 mb-3"><div class="card mb-0"><div class="card-body"><small class="text-muted">Collected this month</small><h3 class="mt-1 mb-0 text-success">{{ $F::money($stats['month']) }}</h3></div></div></div>
        <div class="col-xl-3 col-md-6 mb-3"><div class="card mb-0"><div class="card-body"><small class="text-muted">Total finalized fees</small><h3 class="mt-1 mb-0">{{ $F::money($stats['finalized_total']) }}</h3><small class="text-muted">Active students</small></div></div></div>
        <div class="col-xl-3 col-md-6 mb-3"><div class="card mb-0"><div class="card-body"><small class="text-muted">Remaining student balances</small><h3 class="mt-1 mb-0 text-danger">{{ $F::money($stats['remaining_total']) }}</h3><a href="{{ route('fees.accounts', ['balance' => 'due']) }}" class="small">View students with a balance</a></div></div></div>
    </div>

    <div class="row">
        <div class="col-xl-6 col-md-6 mb-3"><div class="card mb-0"><div class="card-body"><small class="text-muted">Outstanding on issued vouchers</small><h3 class="mt-1 mb-0 text-danger">{{ $F::money($stats['outstanding']) }}</h3><a href="{{ route('fees.vouchers', ['status' => 'unpaid']) }}" class="small">View unpaid vouchers</a></div></div></div>
        <div class="col-xl-6 col-md-6 mb-3"><div class="card mb-0"><div class="card-body"><small class="text-muted">Overdue vouchers</small><h3 class="mt-1 mb-0 text-danger">{{ $F::money($stats['overdue_amount']) }}</h3><a href="{{ route('fees.accounts', ['balance' => 'overdue']) }}" class="small">{{ $stats['overdue_students'] }} student(s)</a></div></div></div>
    </div>

    <div class="card"><div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3"><h5 class="mb-0">Recent payments received</h5><a href="{{ route('fees.payments') }}">View all payments</a></div>
        <div class="table-responsive"><table class="table table-sm mb-0">
            <thead><tr><th>Date</th><th>Receipt</th><th>Student</th><th>Method</th><th class="text-end">Amount</th></tr></thead>
            <tbody>
            @forelse ($stats['recent'] as $payment)
                <tr>
                    <td>{{ $payment->payment_date->format('d M Y') }}</td>
                    <td><a href="{{ route('fees.payments.show', $payment) }}">{{ $payment->receipt_number }}</a></td>
                    <td><a href="{{ route('fees.accounts.show', $payment->student_id) }}">{{ $payment->student?->full_name ?? 'Deleted student' }}</a> <small class="text-muted">{{ $payment->student?->roll_number }}</small></td>
                    <td>{{ $payment->method_label }}</td>
                    <td class="text-end text-success"><strong>{{ $F::money($payment->amount) }}</strong></td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted">No payments received yet.</td></tr>
            @endforelse
            </tbody>
        </table></div>
    </div></div>
</div></div>
@endsection
