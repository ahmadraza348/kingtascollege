@extends('backend.layouts.layout')
@section('title', 'Attendance Dashboard - King TAS College')
@section('content')
@php
    $pct = fn ($v) => $v === null ? '—' : rtrim(rtrim(number_format($v, 1), '0'), '.') . '%';
    $keep = array_filter(['class' => $classId, 'section' => $sectionId]);
    $presets = ['this_week' => 'This week', 'last_week' => 'Last week', 'this_month' => 'This month', 'last_month' => 'Last month'];
@endphp
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Attendance Dashboard</h4>
                <h6>{{ \Carbon\Carbon::parse($from)->format('d M Y') }} – {{ \Carbon\Carbon::parse($to)->format('d M Y') }}</h6>
            </div>
            <div class="page-btn">
                <a href="{{ route('attendance.mark') }}" class="btn btn-added me-2">Mark attendance</a>
                <a href="{{ route('attendance.report') }}" class="btn btn-added">Reports</a>
            </div>
        </div>

        {{-- Filters --}}
        <div class="card">
            <div class="card-body">
                <form action="{{ route('attendance.dashboard') }}" method="GET" class="row align-items-end">
                    <div class="col-lg-2 col-md-6 col-12">
                        <div class="form-group mb-lg-0"><label>Class</label>
                            <select name="class" class="form-select" data-sections="#dSection">
                                <option value="">All classes</option>
                                @foreach ($classes as $c) <option value="{{ $c->id }}" @selected($classId === $c->id)>{{ $c->name }}</option> @endforeach
                            </select></div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-12">
                        <div class="form-group   mb-lg-0"><label>Section</label>
                            <select name="section" id="dSection" class="form-select">
                                <option value="">All sections</option>
                                @foreach ($sections as $s) <option value="{{ $s->id }}" @selected($sectionId === $s->id)>{{ $s->name }}</option> @endforeach
                            </select></div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-6">
                        <div class="form-group mb-lg-0"><label>From</label><input type="date" name="from" value="{{ $from }}" class="form-control"></div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-6">
                        <div class="form-group mb-lg-0"><label>To</label><input type="date" name="to" value="{{ $to }}" class="form-control"></div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-6">
                                            <button type="submit" class="btn btn-submit my-2">Apply</button>

                    </div>
                    <div class="col-lg-6 col-12 mt-2 ">
                        <div class="d-flex gap-2">
                            @foreach ($presets as $key => $label)
                            <a href="{{ route('attendance.dashboard', $keep + ['period' => $key]) }}" class="btn btn-sm btn-outline-secondary mb-1">{{ $label }}</a>
                            @endforeach
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- KPI cards --}}
        <div class="row">
            <div class="col-xl-2 col-md-4 col-6 mb-3">
                <div class="card h-100 mb-0"><div class="card-body">
                    <small class="text-muted">Today's attendance</small>
                    @if ($todayOff)
                        <h5 class="mt-2 mb-0 text-muted">No school<br><small>{{ $todayOff }}</small></h5>
                    @else
                        <h3 class="mt-1 mb-0 {{ $todayRate !== null && $todayRate < $threshold ? 'text-danger' : 'text-success' }}">{{ $pct($todayRate) }}</h3>
                        <small class="text-muted">{{ $sectionsTaken }} of {{ $sectionsTotal }} sections taken</small>
                    @endif
                </div></div>
            </div>
            <div class="col-xl-2 col-md-4 col-6 mb-3">
                <div class="card h-100 mb-0"><div class="card-body">
                    <small class="text-muted">Present (period)</small>
                    <h3 class="mt-1 mb-0 text-success">{{ number_format($period['present']) }}</h3>
                    <small class="text-muted">Rate {{ $pct($periodRate) }}</small>
                </div></div>
            </div>
            <div class="col-xl-2 col-md-4 col-6 mb-3">
                <div class="card h-100 mb-0"><div class="card-body">
                    <small class="text-muted">Absent (period)</small>
                    <h3 class="mt-1 mb-0 text-danger">{{ number_format($period['absent']) }}</h3>
                </div></div>
            </div>
            <div class="col-xl-2 col-md-4 col-6 mb-3">
                <div class="card h-100 mb-0"><div class="card-body">
                    <small class="text-muted">Late (period)</small>
                    <h3 class="mt-1 mb-0" style="color:#ff9f43">{{ number_format($period['late']) }}</h3>
                </div></div>
            </div>
            <div class="col-xl-2 col-md-4 col-6 mb-3">
                <div class="card h-100 mb-0"><div class="card-body">
                    <small class="text-muted">Excused / Half day</small>
                    <h3 class="mt-1 mb-0" style="color:#00cfe8">{{ number_format($period['excused']) }} <small class="text-muted">/ {{ number_format($period['half_day']) }}</small></h3>
                </div></div>
            </div>
            <div class="col-xl-2 col-md-4 col-6 mb-3">
                <div class="card h-100 mb-0 {{ $alerts ? 'border-danger' : '' }}"><div class="card-body">
                    <small class="text-muted">Below {{ $threshold }}%</small>
                    <h3 class="mt-1 mb-0 {{ $alerts ? 'text-danger' : 'text-success' }}">{{ $alerts }}</h3>
                    <small class="text-muted">students need attention</small>
                </div></div>
            </div>
        </div>

        {{-- Charts --}}
        <div class="row">
            <div class="col-lg-6 mb-3">
                <div class="card h-100 mb-0"><div class="card-body">
                    <h5 class="mb-3">This week, day by day</h5>
                    <div id="weeklyTrendChart"></div>
                </div></div>
            </div>
            <div class="col-lg-6 mb-3">
                <div class="card h-100 mb-0"><div class="card-body">
                    <h5 class="mb-3">Last 6 months {{ $classId || $sectionId ? 'by section' : 'by class' }}</h5>
                    <div id="monthlyCompareChart"></div>
                </div></div>
            </div>
        </div>

        {{-- Watchlist --}}
        <div class="card">
            <div class="card-body">
                <h5 class="mb-3">Low attendance watchlist <small class="text-muted">(below {{ $threshold }}% in the selected period)</small></h5>
                @if ($watchlist->isEmpty())
                    <p class="text-success mb-0">No active student is below {{ $threshold }}% in this period.</p>
                @else
                    <div class="table-responsive">
                        <table class="table">
                            <thead><tr>
                                <th>Student</th><th>Class / Section</th><th class="text-center">Present</th><th class="text-center">Absent</th>
                                <th class="text-center">Late</th><th class="text-center">Excused</th><th class="text-center">Half</th>
                                <th class="text-center">Marked</th><th class="text-center">Attendance</th><th>Contact</th>
                            </tr></thead>
                            <tbody>
                            @foreach ($watchlist as $row)
                                @php $s = $row['student']; $c = $row['counts']; @endphp
                                <tr>
                                    <td><a href="{{ route('student.show', $s) }}"><strong>{{ $s->full_name }}</strong></a><div class="small text-muted">{{ $s->roll_number }}</div></td>
                                    <td>{{ $s->schoolClass->name }} / {{ $s->section->name }}</td>
                                    <td class="text-center">{{ $c['present'] }}</td>
                                    <td class="text-center text-danger"><strong>{{ $c['absent'] }}</strong></td>
                                    <td class="text-center">{{ $c['late'] }}</td>
                                    <td class="text-center">{{ $c['excused'] }}</td>
                                    <td class="text-center">{{ $c['half_day'] }}</td>
                                    <td class="text-center">{{ $row['marked'] }}</td>
                                    <td class="text-center"><span class="badge rounded-pill bg-danger">{{ $pct($row['percent']) }}</span></td>
                                    <td class="text-nowrap">
                                        <a href="tel:{{ $s->phone }}" class="btn btn-sm btn-outline-primary">Call</a>
                                        <a href="{{ $s->whatsapp_link }}" target="_blank" class="btn btn-sm btn-outline-success">WhatsApp</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if ($alerts > 10)
                        <small class="text-muted">Showing the 10 lowest of {{ $alerts }}. Use <a href="{{ route('attendance.report', ['from' => $from, 'to' => $to] + $keep) }}">Reports</a> for the full list.</small>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>

@include('backend.student._class_section_js')

<script>
    // The layout loads ApexCharts at the bottom, so draw the charts once the page is fully loaded.
    window.addEventListener('load', function () {
        if (typeof ApexCharts === 'undefined') return;

        var fmt = function (v) { return (v === null || v === undefined) ? '' : v + '%'; };
        var weekly = @json($weekly);
        var monthly = @json($monthly);

        new ApexCharts(document.querySelector('#weeklyTrendChart'), {
            chart: { type: 'bar', height: 300, toolbar: { show: false } },
            series: [{ name: 'Attendance %', data: weekly.rates }],
            xaxis: { categories: weekly.labels },
            yaxis: { min: 0, max: 100, labels: { formatter: function (v) { return v + '%'; } } },
            dataLabels: { enabled: true, formatter: fmt },
            plotOptions: { bar: { borderRadius: 4, columnWidth: '45%' } },
            colors: ['#28c76f'],
            tooltip: { y: { formatter: fmt } },
            noData: { text: 'No attendance taken this week yet' }
        }).render();

        new ApexCharts(document.querySelector('#monthlyCompareChart'), {
            chart: { type: 'bar', height: 300, toolbar: { show: false } },
            series: monthly.series,
            xaxis: { categories: monthly.labels },
            yaxis: { min: 0, max: 100, labels: { formatter: function (v) { return v + '%'; } } },
            dataLabels: { enabled: false },
            plotOptions: { bar: { borderRadius: 3, columnWidth: '70%' } },
            tooltip: { y: { formatter: fmt } },
            legend: { position: 'bottom' },
            noData: { text: 'No attendance data yet' }
        }).render();
    });
</script>
@endsection