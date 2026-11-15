@extends('backend.layouts.layout')
@section('title', 'Student Fee Accounts - King TAS College')
@section('content')
@php $F = \App\Support\FeeHelper::class; @endphp
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Student Fee Accounts</h4>
                <h6>Finalized fee, received payments and remaining balance for each student.</h6>
            </div>
            <div class="page-btn">
                <a href="{{ route('fees.vouchers.create') }}" class="btn btn-added">Create student voucher</a>
            </div>
        </div>

        <div class="card"><div class="card-body">
            <form action="{{ route('fees.accounts') }}" method="GET" class="row align-items-end">
                <div class="col-lg-3 col-md-6"><div class="form-group"><label>Search student</label><input type="text" name="q" value="{{ $filters['q'] ?? '' }}" class="form-control" placeholder="Name, roll no or CNIC"></div></div>
                <div class="col-lg-2 col-md-6"><div class="form-group"><label>Class</label>
                    <select name="class" class="form-select" data-sections="#aSection"><option value="">All classes</option>
                        @foreach ($classes as $class)<option value="{{ $class->id }}" @selected((int) ($filters['class'] ?? 0) === $class->id)>{{ $class->name }}</option>@endforeach</select></div></div>
                <div class="col-lg-2 col-md-6"><div class="form-group"><label>Section</label>
                    <select name="section" id="aSection" class="form-select"><option value="">All sections</option>
                        @foreach ($sections as $section)<option value="{{ $section->id }}" @selected((int) ($filters['section'] ?? 0) === $section->id)>{{ $section->name }}</option>@endforeach</select></div></div>
                <div class="col-lg-2 col-md-6"><div class="form-group"><label>Fee status</label>
                    <select name="balance" class="form-select"><option value="">All statuses</option>
                        <option value="due" @selected(($filters['balance'] ?? '') === 'due')>Balance due</option>
                        <option value="overdue" @selected(($filters['balance'] ?? '') === 'overdue')>Voucher overdue</option>
                        <option value="clear" @selected(($filters['balance'] ?? '') === 'clear')>Fee cleared</option></select></div></div>
                <div class="col-lg-2 col-md-6"><div class="form-group"><label>Student status</label>
                    <select name="student_status" class="form-select"><option value="all" @selected(($filters['student_status'] ?? 'active') === 'all')>All students</option>
                        @foreach (\App\Models\Student::STATUSES as $key => $label)<option value="{{ $key }}" @selected(($filters['student_status'] ?? 'active') === $key)>{{ $label }}</option>@endforeach</select></div></div>
                <div class="col-lg-1 col-12"><div class="form-group"><button class="btn btn-submit">Filter</button></div></div>
            </form>
        </div></div>

        <div class="card"><div class="card-body">
            <div class="table-responsive"><table class="table">
                <thead><tr><th>Student</th><th>Class / Section</th><th>Fee status</th><th class="text-end">Finalized fee</th><th class="text-end">Received</th><th class="text-end">Remaining</th><th>Actions</th></tr></thead>
                <tbody>
                @forelse ($students as $student)
                    @php
                        $finalized = $student->finalized_fee === null ? null : (float) $student->finalized_fee;
                        $received = (float) ($student->received ?? 0);
                        $remaining = $finalized === null ? null : max(0, round($finalized - $received, 2));
                        $feeStatus = $finalized === null ? 'Fee not set' : ($student->has_overdue_voucher ? 'Voucher overdue' : ($remaining > 0 ? 'Balance due' : 'Fee cleared'));
                        $badge = $feeStatus === 'Voucher overdue' ? 'danger' : ($feeStatus === 'Balance due' ? 'warning' : ($feeStatus === 'Fee cleared' ? 'success' : 'secondary'));
                    @endphp
                    <tr>
                        <td><a href="{{ route('fees.accounts.show', $student) }}"><strong>{{ $student->full_name }}</strong></a><div class="small text-muted">Roll No: {{ $student->roll_number }}</div></td>
                        <td>{{ $student->schoolClass?->name ?? '—' }} / {{ $student->section?->name ?? '—' }}</td>
                        <td><span class="badge rounded-pill bg-{{ $badge }}">{{ $feeStatus }}</span></td>
                        <td class="text-end">{{ $finalized === null ? '—' : $F::number($finalized) }}</td>
                        <td class="text-end text-success">{{ $F::number($received) }}</td>
                        <td class="text-end"><strong class="{{ ($remaining ?? 0) > 0 ? 'text-danger' : 'text-success' }}">{{ $remaining === null ? '—' : $F::number($remaining) }}</strong></td>
                        <td class="text-nowrap">
                            <a href="{{ route('fees.accounts.show', $student) }}" class="me-2">Account book</a>
                            <a href="{{ route('student.edit', $student) }}" class="me-2">Edit fee</a>
                            @if (($remaining ?? 0) > 0)<a href="{{ route('fees.vouchers.create', ['student' => $student->id]) }}">Create voucher</a>@endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">No students found. Try changing the search or filters.</td></tr>
                @endforelse
                </tbody>
            </table></div>
            {{ $students->links('pagination::bootstrap-5') }}
        </div></div>
    </div>
</div>
@include('backend.student._class_section_js')
@endsection
