@extends('backend.layouts.layout')
@section('title', $student->full_name . ' - King TAS College')
@section('content')
@php
$dash = fn ($v) => filled($v) ? e($v) : '<span class="text-muted">—</span>';
$cards = [
'Personal information' => [
'Full name' => $student->full_name,
'Father name' => $student->father_name,
'Gender' => $student->gender,
'Date of birth' => $student->date_of_birth ? $student->date_of_birth->format('d M Y') . ' (' . $student->age . ' yrs)' : null,
'CNIC / B-Form' => $student->cnic,
'Blood group' => $student->blood_group,
],
'Contact & guardian' => [
'Phone' => $student->phone,
'WhatsApp' => $student->whatsapp,
'Email' => $student->email,
'Guardian name' => $student->guardian_name,
'Guardian phone' => $student->guardian_phone,
],
'Address' => [
'Street' => $student->street,
'City' => $student->city,
'District' => $student->district,
'Province' => $student->province,
],
'Previous education' => [
'Qualification' => $student->qualification,
'Institution' => $student->institution,
'Marks' => $student->obtained_marks !== null ? rtrim(rtrim($student->obtained_marks, '0'), '.') . ' / ' . rtrim(rtrim((string) $student->total_marks, '0'), '.') : null,
'Percentage' => $student->percentage !== null ? rtrim(rtrim($student->percentage, '0'), '.') . '%' : null,
],
];
@endphp
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>{{ $student->full_name }}</h4>
                <h6>Student profile</h6>
            </div>
            <div class="page-btn">
                <a href="{{ route('student.edit', $student) }}" class="btn btn-added me-2">Edit</a>
                <a href="{{ route('student.index') }}" class="btn btn-cancel">Back to list</a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body text-center">
                        <img src="{{ $student->photo_url }}" alt="Photo" class="rounded mb-3" style="width:120px;height:145px;object-fit:cover;">
                        <h5 class="mb-1">{{ $student->full_name }}</h5>
                        <p class="text-muted mb-2">{{ $student->program ?: '—' }}</p>
                        <span class="badge rounded-pill bg-{{ $student->status_color }} mb-2">{{ $student->status_label }}</span>
                        <div>Roll No: <strong>{{ $student->roll_number }}</strong></div>
                        <div>{{ $student->schoolClass->name }} / Section {{ $student->section->name }}</div>
                        <div class="text-muted">Session {{ $student->session }}</div>

                        <div class="d-flex flex-wrap justify-content-center gap-2 mt-3">
                            <a href="tel:{{ $student->phone }}" class="btn btn-sm btn-outline-primary">Call</a>
                            <a href="{{ $student->whatsapp_link }}" target="_blank" class="btn btn-sm btn-outline-success">WhatsApp</a>
                            @if ($student->email)
                            <a href="mailto:{{ $student->email }}" class="btn btn-sm btn-outline-secondary">Email</a>
                            @endif
                        </div>
                    </div>
                </div>
                

                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-3">Online admission</h5>
                        @if ($student->admission)
                        <p class="mb-2">Application <strong>{{ $student->admission_form_number }}</strong></p>
                        <a href="{{ route('admission.show', $student->admission) }}" class="btn btn-sm btn-outline-primary">Open application</a>
                        @else
                        <p class="text-muted mb-0">Added manually — no online admission linked.</p>
                        @endif
                        <hr>
                        <small class="text-muted d-block">Admission date</small>
                        {{ $student->admission_date?->format('d M Y') ?? '—' }}
                    </div>

                    @php
                    $att = app(\App\Services\Admin\AttendanceService::class);
                    $now = $att->today();
                    $mine = \App\Models\AttendanceSummary::where('student_id', $student->id)->where('year', $now->year)->where('month', $now->month)
                    ->selectRaw('SUM(present) present, SUM(absent) absent, SUM(late) late, SUM(excused) excused, SUM(half_day) half_day')->first();
                    $c = ['present' => (int) $mine?->present, 'absent' => (int) $mine?->absent, 'late' => (int) $mine?->late,
                    'excused' => (int) $mine?->excused, 'half_day' => (int) $mine?->half_day];
                    $p = $att->percent($c);
                    @endphp
                    <div class="card">
                        <div class="card-body">
                            <h5 class="mb-3">Attendance — {{ $now->format('F') }}</h5>
                            <h3 class="{{ $p !== null && $p < config('attendance.threshold') ? 'text-danger' : 'text-success' }}">{{ $p === null ? '—' : rtrim(rtrim(number_format($p, 1), '0'), '.') . '%' }}</h3>
                            <small class="text-muted">Present {{ $c['present'] }} · Absent {{ $c['absent'] }} · Late {{ $c['late'] }} · Excused {{ $c['excused'] }} · Half day {{ $c['half_day'] }}</small>
                            <div class="mt-2"><a href="{{ route('attendance.report', ['class' => $student->school_class_id, 'section' => $student->section_id]) }}">Full report</a></div>
                        </div>
                    </div>
                </div>

                                @php $feeDue = (float) \App\Models\FeeVoucher::where('student_id', $student->id)->where('status', '!=', 'cancelled')->sum('balance'); @endphp
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-3">Fees</h5>
                        <h3 class="{{ $feeDue > 0 ? 'text-danger' : 'text-success' }}">{{ \App\Support\FeeHelper::money($feeDue) }}</h3>
                        <small class="text-muted">remaining balance</small>
                        <div class="mt-2">
                            <a href="{{ route('fees.accounts.show', $student) }}">Fee account</a> ·
                            <a href="{{ route('fees.vouchers.create', ['student' => $student->id, 'type' => 'admission']) }}">Admission fee voucher</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                @foreach ($cards as $title => $rows)
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-3">{{ $title }}</h5>
                        <div class="row">
                            @foreach ($rows as $label => $value)
                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">{{ $label }}</small>
                                {!! $dash($value) !!}
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach

                @if ($student->notes)
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-2">Notes</h5>
                        <p class="mb-0">{!! nl2br(e($student->notes)) !!}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection