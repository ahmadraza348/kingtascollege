@extends('backend.layouts.layout')
@section('title', 'Class-wise Fee Analytics - King TAS College')
@section('content')
@php $F = \App\Support\FeeHelper::class; @endphp
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Class-wise Fee Analytics</h4>
                <h6>Fee balances, monthly collections and students with no payment in {{ $periodLabel }}</h6>
            </div>
            <div class="page-btn">
                <a href="{{ route('fees.analytics.pdf', array_filter(['period' => $period, 'class' => $classId])) }}" target="_blank" class="btn btn-added">Download Monthly PDF</a>
            </div>
        </div>

        <div class="card"><div class="card-body">
            <form action="{{ route('fees.analytics') }}" method="GET" class="row align-items-end">
                <div class="col-lg-3 col-md-5"><div class="form-group">
                    <label for="period">Report month</label>
                    <input type="month" id="period" name="period" value="{{ $period }}" required class="form-control">
                </div></div>
                <div class="col-lg-4 col-md-5"><div class="form-group">
                    <label for="class">Class</label>
                    <select name="class" id="class" class="form-select">
                        <option value="">All classes</option>
                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}" @selected($classId === $class->id)>{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div></div>
                <div class="col-lg-2 col-md-2"><div class="form-group d-flex gap-2">
                    <button type="submit" class="btn btn-submit">Filter</button>
                    <a href="{{ route('fees.analytics') }}" class="btn btn-cancel">Reset</a>
                </div></div>
            </form>
            <small class="text-muted">“Collected this month” counts verified payments by payment date. Remaining finalized fee deducts payments allocated to non-fine voucher lines; fine payments do not reduce the agreed course-fee balance. “Collected this month” remains the total of all verified payments dated in the month.</small>
        </div></div>

        <div class="row">
            <div class="col-xl-3 col-md-6 mb-3"><div class="card mb-0"><div class="card-body"><small class="text-muted">Total finalized fee</small><h3 class="mt-1 mb-0">{{ $F::money($totals['total_fee']) }}</h3><small class="text-muted">{{ number_format($totals['active_students']) }} active students</small></div></div></div>
            <div class="col-xl-3 col-md-6 mb-3"><div class="card mb-0"><div class="card-body"><small class="text-muted">Remaining finalized fee</small><h3 class="mt-1 mb-0 text-danger">{{ $F::money($totals['remaining_fee']) }}</h3><small class="text-muted">Fine lines excluded from course-fee balance</small></div></div></div>
            <div class="col-xl-3 col-md-6 mb-3"><div class="card mb-0"><div class="card-body"><small class="text-muted">Collected in {{ $periodLabel }}</small><h3 class="mt-1 mb-0 text-success">{{ $F::money($totals['month_collected']) }}</h3><small class="text-muted">Verified payments only</small></div></div></div>
            <div class="col-xl-3 col-md-6 mb-3"><div class="card mb-0"><div class="card-body"><small class="text-muted">Students with no payment</small><h3 class="mt-1 mb-0 text-danger">{{ number_format($totals['students_unpaid_this_month']) }}</h3><small class="text-muted">No verified payment dated in {{ $periodLabel }}</small></div></div></div>
        </div>

        <div class="card"><div class="card-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                <div><h5 class="mb-1">Class summary</h5><small class="text-muted">Selected month: {{ $periodLabel }}</small></div>
                <a href="{{ route('fees.analytics.pdf', array_filter(['period' => $period, 'class' => $classId])) }}" target="_blank" class="btn btn-sm btn-outline-primary">PDF report</a>
            </div>
            <div class="table-responsive"><table class="table table-hover">
                <thead><tr>
                    <th>Class</th><th class="text-end">Active students</th><th class="text-end">Fee not set</th>
                    <th class="text-end">Total fee</th><th class="text-end">Received (all payments)</th><th class="text-end">Remaining fee</th>
                    <th class="text-end">Collected this month</th><th class="text-end">Month voucher balance</th><th class="text-end">No payment this month</th><th>Report</th>
                </tr></thead>
                <tbody>
                @forelse ($classRows as $row)
                    <tr>
                        <td><strong>{{ $row['name'] }}</strong>@if ($row['code'])<div class="small text-muted">{{ $row['code'] }}</div>@endif</td>
                        <td class="text-end">{{ number_format($row['active_students']) }}</td>
                        <td class="text-end">{{ number_format($row['students_without_fee']) }}</td>
                        <td class="text-end">{{ $F::number($row['total_fee']) }}</td>
                        <td class="text-end text-success">{{ $F::number($row['received_total']) }}</td>
                        <td class="text-end text-danger"><strong>{{ $F::number($row['remaining_fee']) }}</strong></td>
                        <td class="text-end text-success">{{ $F::number($row['month_collected']) }}</td>
                        <td class="text-end">{{ $F::number($row['period_voucher_balance']) }}</td>
                        <td class="text-end"><a href="#unpaid-students">{{ number_format($row['students_unpaid_this_month']) }}</a></td>
                        <td><a href="{{ route('fees.analytics.pdf', ['period' => $period, 'class' => $row['id']]) }}" target="_blank">Class PDF</a></td>
                    </tr>
                @empty
                    <tr><td colspan="10" class="text-center text-muted py-4">No classes were found for this filter.</td></tr>
                @endforelse
                </tbody>
                <tfoot><tr>
                    <th>Selected total</th><th class="text-end">{{ number_format($totals['active_students']) }}</th><th class="text-end">{{ number_format($totals['students_without_fee']) }}</th>
                    <th class="text-end">{{ $F::number($totals['total_fee']) }}</th><th class="text-end">{{ $F::number($totals['received_total']) }}</th>
                    <th class="text-end">{{ $F::number($totals['remaining_fee']) }}</th><th class="text-end">{{ $F::number($totals['month_collected']) }}</th>
                    <th class="text-end">{{ $F::number($totals['period_voucher_balance']) }}</th><th class="text-end">{{ number_format($totals['students_unpaid_this_month']) }}</th><th></th>
                </tr></tfoot>
            </table></div>
        </div></div>

        <div class="card" id="unpaid-students"><div class="card-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                <div><h5 class="mb-1">Students who did not pay in {{ $periodLabel }}</h5><small class="text-muted">Only verified payments dated within the selected month count as paid.</small></div>
                <span class="badge bg-danger">{{ number_format($unpaidStudents->total()) }} students</span>
            </div>
            <div class="table-responsive"><table class="table table-hover">
                <thead><tr><th>Student / Roll No.</th><th>Class / Section</th><th>Phone</th><th class="text-end">Finalized fee</th><th class="text-end">Voucher billed</th><th class="text-end">Voucher balance</th><th>Voucher status</th><th>Action</th></tr></thead>
                <tbody>
                @forelse ($unpaidStudents as $student)
                    @php
                        $voucherCount = (int) ($student->period_voucher_count ?? 0);
                        $voucherBalance = (float) ($student->period_voucher_balance ?? 0);
                        $voucherStatus = $voucherCount === 0 ? 'No voucher' : ($voucherBalance <= 0.001 ? 'Paid' : 'Unpaid / partial');
                    @endphp
                    <tr>
                        <td><strong>{{ $student->full_name }}</strong><div class="small text-muted">{{ $student->roll_number }}</div></td>
                        <td>{{ $student->schoolClass?->name ?? '—' }} / {{ $student->section?->name ?? '—' }}</td>
                        <td>{{ $student->phone ?: '—' }}</td>
                        <td class="text-end">{{ $student->finalized_fee === null ? 'Not set' : $F::number($student->finalized_fee) }}</td>
                        <td class="text-end">{{ $F::number($student->period_voucher_total ?? 0) }}</td>
                        <td class="text-end text-danger">{{ $F::number($voucherBalance) }}</td>
                        <td><span class="badge bg-{{ $voucherStatus === 'Paid' ? 'success' : ($voucherStatus === 'No voucher' ? 'secondary' : 'warning') }}">{{ $voucherStatus }}</span></td>
                        <td class="text-nowrap"><a href="{{ route('fees.accounts.show', $student) }}">Account book</a> @if (($student->finalized_fee ?? 0) > 0) <span class="text-muted">|</span> <a href="{{ route('fees.vouchers.create', ['student' => $student->id, 'type' => 'monthly', 'period' => $period]) }}">Create voucher</a>@endif</td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center text-muted py-4">All active students in this filter have at least one verified payment during {{ $periodLabel }}.</td></tr>
                @endforelse
                </tbody>
            </table></div>
            {{ $unpaidStudents->links('pagination::bootstrap-5') }}
        </div></div>
    </div>
</div>
@endsection
