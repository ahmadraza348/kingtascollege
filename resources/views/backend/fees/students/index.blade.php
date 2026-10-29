@extends('backend.layouts.layout')
@section('title', 'Student Fee Accounts - King TAS College')
@section('content')
@php $F = \App\Support\FeeHelper::class; @endphp
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title"><h4>Student Fee Status</h4><h6>See each student's billed amount, paid amount, remaining balance and vouchers.</h6></div>
            <div class="page-btn"><a href="{{ route('fees.vouchers.bulk') }}" class="btn btn-added">Generate monthly vouchers</a></div>
        </div>

        <div class="card"><div class="card-body">
            <form action="{{ route('fees.accounts') }}" method="GET" class="row align-items-end">
                <div class="col-lg-3 col-md-6"><div class="form-group"><label>Search student</label><input type="text" name="q" value="{{ $filters['q'] ?? '' }}" class="form-control" placeholder="Name, roll no or CNIC"></div></div>
                <div class="col-lg-2 col-md-6"><div class="form-group"><label>Class</label>
                    <select name="class" class="form-select" data-sections="#aSection"><option value="">All classes</option>
                        @foreach ($classes as $c)<option value="{{ $c->id }}" @selected((int) ($filters['class'] ?? 0) === $c->id)>{{ $c->name }}</option>@endforeach</select></div></div>
                <div class="col-lg-2 col-md-6"><div class="form-group"><label>Section</label>
                    <select name="section" id="aSection" class="form-select"><option value="">All sections</option>
                        @foreach ($sections as $s)<option value="{{ $s->id }}" @selected((int) ($filters['section'] ?? 0) === $s->id)>{{ $s->name }}</option>@endforeach</select></div></div>
                <div class="col-lg-2 col-md-6"><div class="form-group"><label>Fee status</label>
                    <select name="balance" class="form-select"><option value="">All statuses</option>
                        <option value="due" @selected(($filters['balance'] ?? '') === 'due')>Due</option>
                        <option value="overdue" @selected(($filters['balance'] ?? '') === 'overdue')>Overdue</option>
                        <option value="clear" @selected(($filters['balance'] ?? '') === 'clear')>Paid / no dues</option></select></div></div>
                <div class="col-lg-2 col-md-6"><div class="form-group"><label>Student status</label>
                    <select name="student_status" class="form-select"><option value="all" @selected(($filters['student_status'] ?? 'active') === 'all')>All students</option>
                        @foreach (\App\Models\Student::STATUSES as $k => $l)<option value="{{ $k }}" @selected(($filters['student_status'] ?? 'active') === $k)>{{ $l }}</option>@endforeach</select></div></div>
                <div class="col-lg-1 col-12"><div class="form-group"><button class="btn btn-submit">Filter</button></div></div>
            </form>
        </div></div>

        <div class="card"><div class="card-body">
            <div class="table-responsive"><table class="table">
                <thead><tr><th>Student</th><th>Class / Section</th><th>Monthly tuition</th><th>Fee status</th><th class="text-end">Total fees</th><th class="text-end">Paid</th><th class="text-end">Balance</th><th>Actions</th></tr></thead>
                <tbody>
                @forelse ($students as $s)
                    @php
                        $billed = (float) ($s->billed ?? 0);
                        $paid = (float) ($s->paid ?? 0);
                        $due = (float) ($s->due ?? 0);
                        $feeStatus = $s->has_overdue_voucher ? 'Overdue' : ($due > 0 ? 'Due' : ($billed > 0 ? 'Paid' : 'Not billed'));
                        $badge = $feeStatus === 'Overdue' ? 'danger' : ($feeStatus === 'Due' ? 'warning' : ($feeStatus === 'Paid' ? 'success' : 'secondary'));
                    @endphp
                    <tr>
                        <td><a href="{{ route('fees.accounts.show', $s) }}"><strong>{{ $s->full_name }}</strong></a><div class="small text-muted">Roll No: {{ $s->roll_number }}</div></td>
                        <td>{{ $s->schoolClass?->name ?? '—' }} / {{ $s->section?->name ?? '—' }}</td>
                        <td class="text-nowrap">
                            @if ($s->monthly_tuition_fee !== null)
                                <strong>{{ $F::money($s->monthly_tuition_fee) }}</strong><div class="small text-muted">Student-specific</div>
                            @else
                                <span class="text-muted">Class default</span>
                            @endif
                        </td>
                        <td><span class="badge rounded-pill bg-{{ $badge }}">{{ $feeStatus }}</span></td>
                        <td class="text-end">{{ $F::number($billed) }}</td>
                        <td class="text-end text-success">{{ $F::number($paid) }}</td>
                        <td class="text-end"><strong class="{{ $due > 0 ? 'text-danger' : 'text-success' }}">{{ $F::number($due) }}</strong></td>
                        <td class="text-nowrap">
                            <a href="{{ route('fees.accounts.show', $s) }}" class="me-2">View fees</a>
                            <a href="{{ route('student.edit', $s) }}" class="me-2">Edit fee</a>
                            <a href="{{ route('fees.vouchers.create', ['student' => $s->id, 'type' => 'monthly']) }}" class="me-2">Voucher</a>
                            @if ($due > 0)<a href="{{ route('fees.payments.create', ['student' => $s->id]) }}" class="text-success">Receive payment</a>@endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center text-muted py-4">No students found. Try changing the search or filters.</td></tr>
                @endforelse
                </tbody>
            </table></div>
            {{ $students->links('pagination::bootstrap-5') }}
        </div></div>
    </div>
</div>
@include('backend.student._class_section_js')
@endsection
