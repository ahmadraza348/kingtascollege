@extends('backend.layouts.layout')
@section('title', 'Fee Account - ' . $student->full_name)
@section('content')
@php
    $F = \App\Support\FeeHelper::class;
    $s = $book['summary'];
    $badge = function ($row) {
        if ($row['status'] === 'paid') return ['success', 'Paid'];
        if ($row['is_overdue']) return ['danger', 'Overdue'];
        if ($row['status'] === 'partial') return ['warning', 'Partly paid'];
        return ['secondary', 'Unpaid'];
    };
@endphp
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Fee Account — {{ $student->full_name }}</h4>
                <h6>Roll No {{ $student->roll_number }} · {{ $student->schoolClass?->name ?? '—' }} / {{ $student->section?->name ?? '—' }}@if ($student->session) · Session {{ $student->session }}@endif</h6>
            </div>
            <div class="page-btn">
                <a href="{{ route('student.edit', $student) }}" class="btn btn-added me-2">Edit student fee</a>
                <a href="{{ route('fees.vouchers.create', ['student' => $student->id]) }}" class="btn btn-added me-2">Create voucher</a>
                <a href="{{ route('fees.accounts.statement', $student) }}" target="_blank" class="btn btn-cancel">Print statement</a>
            </div>
        </div>

        @if ($book['pending']->isNotEmpty())
            <div class="alert alert-warning">There are {{ $book['pending']->count() }} pending payment record(s) that are not included in the received total.</div>
        @endif

        @if ($student->finalized_fee === null)
            <div class="alert alert-warning">The student's finalized total fee has not been set. <a href="{{ route('student.edit', $student) }}">Edit the student record</a> and enter the agreed final fee before creating vouchers or receiving payments.</div>
        @endif

        <div class="row">
            <div class="col-xl-4 col-md-6 mb-3"><div class="card mb-0 h-100"><div class="card-body py-3">
                <small class="text-muted">Finalized total fee</small>
                <h3 class="mb-0">{{ $s['total_fee'] === null ? 'Not set' : $F::money($s['total_fee']) }}</h3>
                <small class="text-muted">Individual student fee</small>
            </div></div></div>
            <div class="col-xl-4 col-md-6 mb-3"><div class="card mb-0 h-100"><div class="card-body py-3">
                <small class="text-muted">Payments received</small>
                <h3 class="mb-0 text-success">{{ $F::money($s['paid']) }}</h3>
                <small class="text-muted">Verified receipts only</small>
            </div></div></div>
            <div class="col-xl-4 col-md-6 mb-3"><div class="card mb-0 h-100"><div class="card-body py-3">
                <small class="text-muted">Remaining student balance</small>
                <h3 class="mb-0 {{ $s['remaining'] > 0 ? 'text-danger' : 'text-success' }}">{{ $F::money($s['remaining']) }}</h3>
                <small class="text-muted">Finalized fee minus received payments</small>
            </div></div></div>
        </div>

        @if ($s['total_fee'] !== null && $s['total_fee'] > 0)
            <div class="card"><div class="card-body py-3">
                <div class="d-flex justify-content-between small mb-1"><span>Fee collection progress</span><strong>{{ $s['percent'] }}%</strong></div>
                <div class="progress" style="height:12px"><div class="progress-bar bg-success" style="width: {{ $s['percent'] }}%"></div></div>
            </div></div>
        @endif

        <div class="card"><div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                <div><h5 class="mb-0">Fee Vouchers</h5><small class="text-muted">Every fee charge for this student is recorded through an individual voucher.</small></div>
                <div class="text-end"><small class="text-muted d-block">Voucher balance</small><strong class="{{ $s['voucher_due'] > 0 ? 'text-danger' : 'text-success' }}">{{ $F::money($s['voucher_due']) }}</strong></div>
            </div>
            <div class="table-responsive"><table class="table table-sm">
                <thead><tr><th>Voucher</th><th>Description</th><th>Issue date</th><th>Due date</th><th class="text-end">Amount</th><th class="text-end">Paid</th><th class="text-end">Remaining</th><th>Status</th><th>Actions</th></tr></thead>
                <tbody>
                @forelse ($book['vouchers'] as $row)
                    @php [$color, $label] = $badge($row); @endphp
                    <tr>
                        <td><a href="{{ route('fees.vouchers.show', $row['voucher']) }}">{{ $row['voucher']->voucher_number }}</a></td>
                        <td>{{ $row['voucher']->items->pluck('title')->implode(', ') ?: $row['voucher']->type_label }}</td>
                        <td class="text-nowrap">{{ $row['voucher']->issue_date->format('d M Y') }}</td>
                        <td class="text-nowrap">{{ $row['voucher']->due_date->format('d M Y') }}</td>
                        <td class="text-end">{{ $F::number($row['total']) }}</td>
                        <td class="text-end text-success">{{ $F::number($row['paid']) }}</td>
                        <td class="text-end"><strong class="{{ $row['remaining'] > 0 ? 'text-danger' : 'text-success' }}">{{ $F::number($row['remaining']) }}</strong></td>
                        <td><span class="badge rounded-pill bg-{{ $color }}">{{ $label }}</span></td>
                        <td class="text-nowrap"><a href="{{ route('fees.vouchers.show', $row['voucher']) }}">View</a> · <a href="{{ route('fees.vouchers.pdf', $row['voucher']) }}" target="_blank">Print</a></td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="text-center text-muted py-4">No vouchers have been created for this student yet.</td></tr>
                @endforelse
                </tbody>
                @if ($book['vouchers']->isNotEmpty())
                    <tfoot><tr><th colspan="4" class="text-end">Total</th><th class="text-end">{{ $F::number($book['vouchers']->sum('total')) }}</th><th class="text-end text-success">{{ $F::number($book['vouchers']->sum('paid')) }}</th><th class="text-end text-danger">{{ $F::number($book['vouchers']->sum('remaining')) }}</th><th colspan="2"></th></tr></tfoot>
                @endif
            </table></div>
        </div></div>

        <div class="card"><div class="card-body">
            <h5 class="mb-3">Payments Received</h5>
            <div class="table-responsive"><table class="table table-sm">
                <thead><tr><th>Date</th><th>Receipt</th><th>Method</th><th>Applied to voucher</th><th class="text-end">Amount</th><th></th></tr></thead>
                <tbody>
                @forelse ($book['payments'] as $payment)
                    <tr>
                        <td class="text-nowrap">{{ $payment->payment_date->format('d M Y') }}</td>
                        <td><a href="{{ route('fees.payments.show', $payment) }}">{{ $payment->receipt_number }}</a></td>
                        <td>{{ $payment->method_label }}</td>
                        <td class="small">@foreach ($payment->allocations as $allocation){{ $allocation->voucher->voucher_number }} ({{ $F::number($allocation->amount) }}){{ ! $loop->last ? ', ' : '' }}@endforeach</td>
                        <td class="text-end text-success"><strong>{{ $F::number($payment->amount) }}</strong></td>
                        <td><a href="{{ route('fees.payments.receipt', $payment) }}" target="_blank" class="small">Receipt</a></td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted">No payments received yet.</td></tr>
                @endforelse
                </tbody>
            </table></div>
        </div></div>

        <div class="card"><div class="card-body">
            <details>
                <summary class="h5 mb-0" style="cursor:pointer">Full fee ledger</summary>
                <div class="table-responsive mt-3"><table class="table table-sm">
                    <thead><tr><th>Date</th><th>Details</th><th class="text-end">Charged</th><th class="text-end">Paid / Less</th><th class="text-end">Running balance</th></tr></thead>
                    <tbody>
                    @forelse ($statement['rows'] as $row)
                        <tr><td class="text-nowrap">{{ date('d M Y', strtotime($row['date'])) }}</td><td>{{ $row['text'] }}</td>
                            <td class="text-end">{{ $row['debit'] ? $F::number($row['debit']) : '' }}</td>
                            <td class="text-end text-success">{{ $row['credit'] ? $F::number($row['credit']) : '' }}</td>
                            <td class="text-end"><strong>{{ $F::number($row['balance']) }}</strong></td></tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted">No voucher or payment history found.</td></tr>
                    @endforelse
                    </tbody>
                </table></div>
            </details>
        </div></div>
    </div>
</div>
@endsection
