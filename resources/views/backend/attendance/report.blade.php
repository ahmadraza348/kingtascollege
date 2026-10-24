@extends('backend.layouts.layout')
@section('title', 'Attendance Reports - King TAS College')
@section('content')
@include('backend.attendance._styles')
@php
    $pct = fn ($v) => $v === null ? '—' : rtrim(rtrim(number_format($v, 1), '0'), '.') . '%';
    $LETTERS = \App\Models\AttendanceLog::LETTERS;
    $keep = array_filter(['class' => $filters['class_id'], 'section' => $filters['section_id'], 'status' => $filters['status'] ?? 'all']);
    $presets = ['this_week' => 'This week', 'last_week' => 'Last week', 'this_month' => 'This month', 'last_month' => 'Last month'];
@endphp
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Attendance Reports</h4>
                <h6>{{ \Carbon\Carbon::parse($report['from'])->format('d M Y') }} – {{ \Carbon\Carbon::parse($report['to'])->format('d M Y') }}</h6>
            </div>
            <div class="page-btn">
                <a href="{{ route('attendance.report.pdf', $query) }}" class="btn btn-added me-2"><img src="{{ asset('backend/assets/img/icons/pdf.svg') }}" alt="" class="me-1"> PDF</a>
                <a href="{{ route('attendance.report.export', ['format' => 'xlsx'] + $query) }}" class="btn btn-added me-2"><img src="{{ asset('backend/assets/img/icons/excel.svg') }}" alt="" class="me-1"> Excel</a>
                <a href="{{ route('attendance.report.export', ['format' => 'csv'] + $query) }}" class="btn btn-added">CSV</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('attendance.report') }}" method="GET" class="row align-items-end">
                    <div class="col-lg-2 col-md-6 col-12">
                        <div class="form-group mb-lg-0"><label>Class</label>
                            <select name="class" class="form-select" data-sections="#rSection">
                                <option value="">All classes</option>
                                @foreach ($classes as $c) <option value="{{ $c->id }}" @selected($filters['class_id'] === $c->id)>{{ $c->name }}</option> @endforeach
                            </select></div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-12">
                        <div class="form-group mb-lg-0"><label>Section</label>
                            <select name="section" id="rSection" class="form-select">
                                <option value="">All sections</option>
                                @foreach ($sections as $s) <option value="{{ $s->id }}" @selected($filters['section_id'] === $s->id)>{{ $s->name }}</option> @endforeach
                            </select></div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-12">
                        <div class="form-group mb-lg-0"><label>Students</label>
                            <select name="status" class="form-select">
                                <option value="all" @selected(! $filters['status'])>All statuses</option>
                                @foreach (\App\Models\Student::STATUSES as $key => $label)
                                    <option value="{{ $key }}" @selected($filters['status'] === $key)>{{ $label }}</option>
                                @endforeach
                            </select></div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-6">
                        <div class="form-group mb-lg-0"><label>From</label><input type="date" name="from" value="{{ $filters['from'] }}" class="form-control"></div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-6">
                        <div class="form-group mb-lg-0"><label>To</label><input type="date" name="to" value="{{ $filters['to'] }}" class="form-control"></div>
                    </div>
                    <div class="col-lg-2 col-12 mt-2 mt-lg-0"><button type="submit" class="btn btn-submit">Show report</button></div>
                </form>
                <div class="mt-3">
                    <span class="text-muted me-2">Quick range:</span>
                    @foreach ($presets as $key => $label)
                        <a href="{{ route('attendance.report', $keep + ['period' => $key]) }}" class="btn btn-sm btn-outline-secondary mb-1">{{ $label }}</a>
                    @endforeach
                    <small class="text-muted ms-2">Ranges are limited to 93 days.</small>
                </div>
            </div>
        </div>

        {{-- Totals --}}
        <div class="row">
            @php $t = $report['totals']; @endphp
            <div class="col-6 col-md-3 col-xl mb-3"><div class="card h-100 mb-0 text-center"><div class="card-body py-3"><h3 class="mb-0">{{ $pct($report['percent']) }}</h3><small class="text-muted">Overall attendance</small></div></div></div>
            <div class="col-6 col-md-3 col-xl mb-3"><div class="card h-100 mb-0 text-center"><div class="card-body py-3"><h3 class="mb-0 text-success">{{ $t['present'] }}</h3><small class="text-muted">Present</small></div></div></div>
            <div class="col-6 col-md-3 col-xl mb-3"><div class="card h-100 mb-0 text-center"><div class="card-body py-3"><h3 class="mb-0 text-danger">{{ $t['absent'] }}</h3><small class="text-muted">Absent</small></div></div></div>
            <div class="col-6 col-md-3 col-xl mb-3"><div class="card h-100 mb-0 text-center"><div class="card-body py-3"><h3 class="mb-0" style="color:#ff9f43">{{ $t['late'] }}</h3><small class="text-muted">Late</small></div></div></div>
            <div class="col-6 col-md-3 col-xl mb-3"><div class="card h-100 mb-0 text-center"><div class="card-body py-3"><h3 class="mb-0" style="color:#00cfe8">{{ $t['excused'] }}</h3><small class="text-muted">Excused</small></div></div></div>
            <div class="col-6 col-md-3 col-xl mb-3"><div class="card h-100 mb-0 text-center"><div class="card-body py-3"><h3 class="mb-0" style="color:#7367f0">{{ $t['half_day'] }}</h3><small class="text-muted">Half day</small></div></div></div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="att-legend small mb-3">
                    @foreach (\App\Models\AttendanceLog::STATUSES as $key => $label)
                        <span class="me-3"><span class="att-chip sm" data-status="{{ $key }}">{{ $LETTERS[$key] }}</span> {{ $label }}</span>
                    @endforeach
                    <span class="text-muted">· Blank = not marked · Red % = below {{ $report['threshold'] }}% · Weekends and holidays are left out</span>
                </div>

                @if ($report['holidays'])
                    <div class="small text-muted mb-2">Holidays in this range:
                        @foreach ($report['holidays'] as $date => $title) {{ \Carbon\Carbon::parse($date)->format('d M') }} ({{ $title }})@if (! $loop->last), @endif @endforeach
                    </div>
                @endif

                @unless ($report['show_grid'])
                    <div class="alert alert-info py-2">The day-by-day grid is shown for ranges of up to 31 school days. Totals are shown for this longer range.</div>
                @endunless

                <div class="table-responsive">
                    <table class="table table-bordered table-sm att-table align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="student-col">Student</th>
                                <th>Class</th>
                                @if ($report['show_grid'])
                                    @foreach ($report['dates'] as $d)
                                        <th class="text-center" style="min-width:30px;font-weight:600">{{ $d['day'] }}<br><small class="text-muted">{{ substr($d['dow'], 0, 2) }}</small></th>
                                    @endforeach
                                @endif
                                <th class="text-center">P</th><th class="text-center">A</th><th class="text-center">L</th>
                                <th class="text-center">E</th><th class="text-center">H</th>
                                <th class="text-center">Days</th><th class="text-center">%</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($report['rows'] as $row)
                            @php $s = $row['student']; $c = $row['counts']; @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="student-col">
                                    <a href="{{ $s->trashed() ? '#' : route('student.show', $s) }}"><strong>{{ $s->full_name }}</strong></a>
                                    @if ($s->status !== 'active')<span class="badge bg-secondary">{{ ucfirst($s->status) }}</span>@endif
                                    <div class="small text-muted">{{ $s->roll_number }}</div>
                                </td>
                                <td class="text-nowrap">{{ $s->schoolClass?->name }} / {{ $s->section?->name }}</td>
                                @if ($report['show_grid'])
                                    @foreach ($report['dates'] as $d)
                                        @php $st = $row['cells'][$d['date']] ?? null; @endphp
                                        <td class="text-center p-1">@if ($st)<span class="att-chip sm" data-status="{{ $st }}">{{ $LETTERS[$st] }}</span>@endif</td>
                                    @endforeach
                                @endif
                                <td class="text-center">{{ $c['present'] }}</td>
                                <td class="text-center">{{ $c['absent'] }}</td>
                                <td class="text-center">{{ $c['late'] }}</td>
                                <td class="text-center">{{ $c['excused'] }}</td>
                                <td class="text-center">{{ $c['half_day'] }}</td>
                                <td class="text-center">{{ $row['marked'] }}</td>
                                <td class="text-center">
                                    <span class="badge rounded-pill bg-{{ $row['percent'] === null ? 'secondary' : ($row['low'] ? 'danger' : ($row['percent'] < 90 ? 'warning' : 'success')) }}">{{ $pct($row['percent']) }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="30" class="text-center text-muted py-4">No students match these filters.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@include('backend.student._class_section_js')
@endsection