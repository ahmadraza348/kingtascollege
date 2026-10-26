@extends('backend.layouts.layout')
@section('title', 'Fee Payments - King TAS College')
@section('content')
@php $F = \App\Support\FeeHelper::class; @endphp
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title"><h4>Fee Payments</h4><h6>Payments recorded by the admin.</h6></div>
            <div class="page-btn"><a href="{{ route('fees.payments.create') }}" class="btn btn-added">Receive payment</a></div>
        </div>

        <div class="mb-3">
            <a href="{{ route('fees.payments') }}" class="btn btn-sm {{ empty($filters['status']) ? 'btn-primary' : 'btn-outline-primary' }}">All</a>
            @foreach (\App\Models\FeePayment::STATUSES as $k => $l)
                <a href="{{ route('fees.payments', ['status' => $k]) }}" class="btn btn-sm {{ ($filters['status'] ?? '') === $k ? 'btn-' : 'btn-outline-' }}{{ \App\Models\FeePayment::STATUS_COLORS[$k] }}">{{ $l }} ({{ $counts[$k] ?? 0 }})</a>
            @endforeach
        </div>

        <div class="card"><div class="card-body">
            <form action="{{ route('fees.payments') }}" method="GET" class="row align-items-end">
                @if (! empty($filters['status']))<input type="hidden" name="status" value="{{ $filters['status'] }}">@endif
                <div class="col-lg-4 col-md-6"><div class="form-group"><label>Search</label><input type="text" name="q" value="{{ $filters['q'] ?? '' }}" class="form-control" placeholder="Student, roll no, receipt or reference"></div></div>
                <div class="col-lg-2 col-md-6"><div class="form-group"><label>Method</label><select name="method" class="form-select"><option value="">All</option>
                    @foreach (\App\Models\FeePayment::METHODS as $k => $l)<option value="{{ $k }}" @selected(($filters['method'] ?? '') === $k)>{{ $l }}</option>@endforeach</select></div></div>
                <div class="col-lg-2 col-md-6"><div class="form-group"><label>From</label><input type="date" name="from" value="{{ $filters['from'] ?? '' }}" class="form-control"></div></div>
                <div class="col-lg-2 col-md-6"><div class="form-group"><label>To</label><input type="date" name="to" value="{{ $filters['to'] ?? '' }}" class="form-control"></div></div>
                <div class="col-lg-2 col-12"><div class="form-group"><button class="btn btn-submit">Filter</button></div></div>
            </form>
        </div></div>

        <div class="card"><div class="card-body">
            <div class="table-responsive"><table class="table">
                <thead><tr><th>Date</th><th>Receipt</th><th>Student</th><th>Method</th><th>Bank / Reference</th><th>Status</th><th class="text-end">Amount</th><th></th></tr></thead>
                <tbody>
                @forelse ($payments as $p)
                    <tr>
                        <td>{{ $p->payment_date->format('d M Y') }}</td>
                        <td>{{ $p->receipt_number ?: '—' }}</td>
                        <td>{{ $p->student->full_name }}<div class="small text-muted">{{ $p->student->roll_number }}</div></td>
                        <td>{{ $p->method_label }}</td>
                        <td>{{ trim($p->bank_name . ' ' . $p->reference_no) ?: '—' }}</td>
                        <td><span class="badge rounded-pill bg-{{ $p->status_color }}">{{ $p->status_label }}</span></td>
                        <td class="text-end">{{ $F::money($p->amount) }}</td>
                        <td><a href="{{ route('fees.payments.show', $p) }}">{{ $p->status === 'pending' ? 'Verify' : 'Open' }}</a></td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center text-muted py-4">No payments found.</td></tr>
                @endforelse
                </tbody>
            </table></div>
            {{ $payments->links('pagination::bootstrap-5') }}
        </div></div>
    </div>
</div>
@endsection
