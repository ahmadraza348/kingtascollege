@extends('backend.layouts.layout')
@section('title', 'Fee Vouchers - King TAS College')
@section('content')
@php $F = \App\Support\FeeHelper::class; $print = array_filter(request()->only(['q', 'class', 'section', 'period', 'status', 'type'])); @endphp
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title"><h4>Fee Vouchers</h4><h6>Search, filter and print vouchers.</h6></div>
            <div class="page-btn">
                <a href="{{ route('fees.vouchers.bulk') }}" class="btn btn-added me-2">Generate monthly vouchers</a>
                <a href="{{ route('fees.vouchers.create') }}" class="btn btn-added">New voucher</a>
            </div>
        </div>

        @if (session('bulk_skipped'))
            <div class="alert alert-warning"><strong>{{ count(session('bulk_skipped')) }} student(s) were skipped:</strong>
                <ul class="mb-0">@foreach (session('bulk_skipped') as $line)<li>{{ $line }}</li>@endforeach</ul></div>
        @endif

        <div class="card"><div class="card-body">
            <form action="{{ route('fees.vouchers') }}" method="GET" class="row align-items-end">
                <div class="col-lg-3 col-md-6"><div class="form-group"><label>Search</label>
                    <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" class="form-control" placeholder="Voucher no, name or roll no"></div></div>
                <div class="col-lg-2 col-md-6"><div class="form-group"><label>Class</label>
                    <select name="class" class="form-select" data-sections="#fSection"><option value="">All</option>
                        @foreach ($classes as $c)<option value="{{ $c->id }}" @selected((int) ($filters['class'] ?? 0) === $c->id)>{{ $c->name }}</option>@endforeach</select></div></div>
                <div class="col-lg-2 col-md-6"><div class="form-group"><label>Section</label>
                    <select name="section" id="fSection" class="form-select"><option value="">All</option>
                        @foreach ($sections as $s)<option value="{{ $s->id }}" @selected((int) ($filters['section'] ?? 0) === $s->id)>{{ $s->name }}</option>@endforeach</select></div></div>
                <div class="col-lg-2 col-md-6"><div class="form-group"><label>Month</label>
                    <input type="month" name="period" value="{{ $filters['period'] ?? '' }}" class="form-control"></div></div>
                <div class="col-lg-2 col-md-6"><div class="form-group"><label>Status</label>
                    <select name="status" class="form-select"><option value="">All</option>
                        <option value="overdue" @selected(($filters['status'] ?? '') === 'overdue')>Overdue</option>
                        @foreach (\App\Models\FeeVoucher::STATUSES as $k => $l)<option value="{{ $k }}" @selected(($filters['status'] ?? '') === $k)>{{ $l }}</option>@endforeach</select></div></div>
                <div class="col-lg-1 col-12"><div class="form-group"><button class="btn btn-submit">Filter</button></div></div>
            </form>
        </div></div>

        <div class="row">
            <div class="col-md-3 col-6 mb-3"><div class="card mb-0 text-center"><div class="card-body py-3"><h4 class="mb-0">{{ $summary->vouchers }}</h4><small class="text-muted">Vouchers</small></div></div></div>
            <div class="col-md-3 col-6 mb-3"><div class="card mb-0 text-center"><div class="card-body py-3"><h4 class="mb-0">{{ $F::money($summary->billed) }}</h4><small class="text-muted">Billed</small></div></div></div>
            <div class="col-md-3 col-6 mb-3"><div class="card mb-0 text-center"><div class="card-body py-3"><h4 class="mb-0 text-success">{{ $F::money($summary->paid) }}</h4><small class="text-muted">Collected</small></div></div></div>
            <div class="col-md-3 col-6 mb-3"><div class="card mb-0 text-center"><div class="card-body py-3"><h4 class="mb-0 text-danger">{{ $F::money($summary->balance) }}</h4><small class="text-muted">Outstanding</small></div></div></div>
        </div>

        <div class="card"><div class="card-body">
            <div class="d-flex flex-wrap justify-content-between mb-3">
                <div>
                    <a href="{{ route('fees.vouchers.print-many', $print) }}" target="_blank" class="btn btn-sm btn-outline-primary me-1">Print all these vouchers (PDF)</a>
                </div>
                <small class="text-muted align-self-center">Page {{ $vouchers->currentPage() }} of {{ $vouchers->lastPage() }} · {{ $vouchers->total() }} voucher(s)</small>
            </div>

            <div class="table-responsive"><table class="table">
                <thead><tr><th>Voucher</th><th>Student</th><th>Class / Section</th><th>Month</th><th>Due</th><th class="text-end">Total</th><th class="text-end">Balance</th><th>Status</th><th>Actions</th></tr></thead>
                <tbody>
                @forelse ($vouchers as $v)
                    <tr>
                        <td><a href="{{ route('fees.vouchers.show', $v) }}"><strong>{{ $v->voucher_number }}</strong></a><div class="small text-muted">{{ $v->type_label }}</div></td>
                        <td>{{ $v->student->full_name }}<div class="small text-muted">{{ $v->roll_number }}</div></td>
                        <td>{{ $v->schoolClass->name }} / {{ $v->section->name }}</td>
                        <td>{{ $v->period_label }}</td>
                        <td>{{ $v->due_date->format('d M Y') }} @if ($v->is_overdue)<span class="badge bg-danger">Overdue</span>@endif</td>
                        <td class="text-end">{{ $F::number($v->total_amount) }}</td>
                        <td class="text-end"><strong>{{ $F::number($v->balance) }}</strong></td>
                        <td><span class="badge rounded-pill bg-{{ $v->status_color }}">{{ $v->status_label }}</span></td>
                        <td class="text-nowrap">
                            <a href="{{ route('fees.vouchers.show', $v) }}" class="me-2">View</a>
                            @if ($v->status !== 'cancelled')<a href="{{ route('fees.vouchers.pdf', $v) }}" target="_blank" class="me-2">PDF</a>@endif
                            @if (in_array($v->status, ['unpaid', 'partial']))<a href="{{ route('fees.payments.create', ['student' => $v->student_id, 'voucher' => $v->id]) }}" class="text-success">Receive</a>@endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="text-center text-muted py-4">No vouchers found.</td></tr>
                @endforelse
                </tbody>
            </table></div>
            {{ $vouchers->links('pagination::bootstrap-5') }}
        </div></div>
    </div>
</div>
@include('backend.student._class_section_js')
@endsection
