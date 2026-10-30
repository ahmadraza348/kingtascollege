@extends('backend.layouts.layout')
@section('title', 'Admin Dashboard - King TAS College')
@section('content')
@php
    $money = fn ($value) => 'Rs. ' . number_format((float) $value, 0);
    $attendanceLabels = [
        'present' => 'Present', 'late' => 'Late', 'absent' => 'Absent',
        'excused' => 'Excused', 'half_day' => 'Half day',
    ];
    $attendanceColors = [
        'present' => 'success', 'late' => 'warning', 'absent' => 'danger',
        'excused' => 'info', 'half_day' => 'primary',
    ];
@endphp
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Dashboard</h4>
                <h6>College overview · {{ now()->format('l, d M Y') }}</h6>
            </div>
            <div class="page-btn d-flex flex-wrap gap-2">
                <a href="{{ route('student.create') }}" class="btn btn-added">+ Add Student</a>
                <a href="{{ route('fees.vouchers.create') }}" class="btn btn-outline-primary">Create Voucher</a>
            </div>
        </div>

        {{-- Key operational indicators --}}
        <div class="row">
            <div class="col-6 col-md-6 col-xl-3 mb-3">
                <a href="{{ route('student.index') }}" class="card h-100 mb-0 text-decoration-none">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div><small class="text-muted">Total students</small><h3 class="mt-2 mb-1">{{ number_format($stats['students_total']) }}</h3><small class="text-muted">{{ number_format($stats['students_new_month']) }} joined this month</small></div>
                            <span class="badge bg-light-primary text-primary"><i class="fas fa-user-graduate"></i></span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-6 col-xl-3 mb-3">
                <a href="{{ route('student.index', ['status' => 'active']) }}" class="card h-100 mb-0 text-decoration-none">
                    <div class="card-body">
                        <small class="text-muted">Active students</small>
                        <h3 class="mt-2 mb-1 text-success">{{ number_format($stats['students_active']) }}</h3>
                        <small class="text-muted">Currently enrolled and active</small>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-6 col-xl-3 mb-3">
                <a href="{{ route('admission.index', ['status' => 'pending']) }}" class="card h-100 mb-0 text-decoration-none">
                    <div class="card-body">
                        <small class="text-muted">Pending applications</small>
                        <h3 class="mt-2 mb-1 text-warning">{{ number_format($stats['pending_admissions']) }}</h3>
                        <small class="text-muted">Awaiting review or documents</small>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-6 col-xl-3 mb-3">
                <a href="{{ route('fees.vouchers') }}" class="card h-100 mb-0 text-decoration-none">
                    <div class="card-body">
                        <small class="text-muted">Outstanding fees</small>
                        <h3 class="mt-2 mb-1 text-danger">{{ $money($stats['fee_outstanding']) }}</h3>
                        <small class="text-muted">Balance on all open vouchers</small>
                    </div>
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-6 col-lg-3 mb-3">
                <div class="card h-100 mb-0"><div class="card-body">
                    <small class="text-muted">Fees collected this month</small>
                    <h4 class="mt-2 mb-0 text-success">{{ $money($stats['fee_collected_month']) }}</h4>
                </div></div>
            </div>
            <div class="col-6 col-lg-3 mb-3">
                <a href="{{ route('fees.vouchers') }}" class="card h-100 mb-0 text-decoration-none"><div class="card-body">
                    <small class="text-muted">Overdue vouchers</small>
                    <h4 class="mt-2 mb-0 {{ $stats['overdue_vouchers'] ? 'text-danger' : 'text-success' }}">{{ number_format($stats['overdue_vouchers']) }}</h4>
                    <small class="text-muted">Unpaid balance past due date</small>
                </div></a>
            </div>
            <div class="col-6 col-lg-3 mb-3">
                <a href="{{ route('attendance.dashboard') }}" class="card h-100 mb-0 text-decoration-none"><div class="card-body">
                    <small class="text-muted">Today's attendance rate</small>
                    <h4 class="mt-2 mb-0">{{ $stats['attendance_rate'] === null ? 'Not marked' : $stats['attendance_rate'] . '%' }}</h4>
                    <small class="text-muted">{{ number_format($stats['attendance_marked']) }} student records marked</small>
                </div></a>
            </div>
            <div class="col-6 col-lg-3 mb-3">
                <a href="{{ route('admission.index') }}" class="card h-100 mb-0 text-decoration-none"><div class="card-body">
                    <small class="text-muted">Total applications</small>
                    <h4 class="mt-2 mb-0">{{ number_format($admissionCounts->sum()) }}</h4>
                    <small class="text-muted">All application statuses</small>
                </div></a>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-7 col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Recent admissions</h5>
                        <a href="{{ route('admission.index') }}">View all</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead><tr><th>Applicant</th><th>Program</th><th>Status</th><th>Received</th></tr></thead>
                                <tbody>
                                @forelse ($recentAdmissions as $item)
                                    <tr>
                                        <td><a href="{{ route('admission.show', $item) }}"><strong>{{ $item->full_name }}</strong></a><small class="d-block text-muted">{{ $item->form_number }}</small></td>
                                        <td>{{ $item->program }}</td>
                                        <td><span class="badge rounded-pill bg-{{ $item->status_color }}">{{ $item->status_label }}</span></td>
                                        <td class="text-nowrap">{{ $item->created_at->format('d M Y') }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center text-muted py-4">No applications have been received yet.</td></tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-5 col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Today's attendance</h5>
                        <a href="{{ route('attendance.mark') }}">Mark attendance</a>
                    </div>
                    <div class="card-body">
                        @if ($stats['attendance_marked'] === 0)
                            <p class="text-muted mb-0">Attendance has not been marked today.</p>
                        @else
                            @foreach ($attendanceLabels as $key => $label)
                                @php $count = (int) ($attendanceCounts[$key] ?? 0); @endphp
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1"><span>{{ $label }}</span><strong>{{ $count }}</strong></div>
                                    <div class="progress" style="height:7px"><div class="progress-bar bg-{{ $attendanceColors[$key] }}" role="progressbar" style="width: {{ $stats['attendance_marked'] ? ($count / $stats['attendance_marked']) * 100 : 0 }}%"></div></div>
                                </div>
                            @endforeach
                            <small class="text-muted">Rate counts Present, Late, and Half day as attended.</small>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-7 col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Recently added students</h5>
                        <a href="{{ route('student.index') }}">View all</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead><tr><th>Student</th><th>Roll No.</th><th>Programs</th><th>Status</th></tr></thead>
                                <tbody>
                                @forelse ($recentStudents as $student)
                                    <tr>
                                        <td><a href="{{ route('student.show', $student) }}"><strong>{{ $student->full_name }}</strong></a></td>
                                        <td>{{ $student->roll_number }}</td>
                                        <td>{{ implode(', ', $student->program_names) ?: '—' }}</td>
                                        <td><span class="badge rounded-pill bg-{{ $student->status_color }}">{{ $student->status_label }}</span></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center text-muted py-4">No students have been added yet.</td></tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-5 col-12">
                <div class="card">
                    <div class="card-header"><h5 class="card-title mb-0">Active students by program</h5></div>
                    <div class="card-body">
                        @forelse ($programStats as $program)
                            <div class="mb-3">
                                <div class="d-flex justify-content-between gap-2 mb-1"><span>{{ $program->program }}</span><strong>{{ $program->students_count }}</strong></div>
                                <div class="progress" style="height:7px"><div class="progress-bar bg-primary" role="progressbar" style="width: {{ $programStats->max('students_count') ? ($program->students_count / $programStats->max('students_count')) * 100 : 0 }}%"></div></div>
                            </div>
                        @empty
                            <p class="text-muted mb-0">Program statistics will appear after students are assigned to programs.</p>
                        @endforelse
                    </div>
                </div>
              
            </div>
        </div>
    </div>
</div>
@endsection
