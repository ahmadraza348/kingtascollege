@extends('backend.layouts.layout')
@section('title', 'Mark Attendance - King TAS College')
@section('content')
@include('backend.attendance._styles')
@php
    $STATUSES = \App\Models\AttendanceLog::STATUSES;
    $LETTERS  = \App\Models\AttendanceLog::LETTERS;
@endphp
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Attendance</h4>
                <h6>Mark and update attendance week by week.</h6>
            </div>
            <div class="page-btn">
                <a href="{{ route('attendance.dashboard') }}" class="btn btn-added me-2">Dashboard</a>
                <a href="{{ route('attendance.report') }}" class="btn btn-added">Reports</a>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">@foreach ($errors->all() as $error)<div>{{ $error }}</div>@endforeach</div>
        @endif

        {{-- Class / section / week: any change loads the students immediately --}}
        <div class="card">
            <div class="card-body">
                <form id="filterForm" action="{{ route('attendance.mark') }}" method="GET" class="row align-items-end">
                    <div class="col-lg-2 col-md-6 col-12">
                        <div class="form-group mb-lg-0">
                            <label>Class</label>
                            <select name="class" id="selClass" class="form-select">
                                <option value="">— Select class —</option>
                                @foreach ($classes as $c)
                                    <option value="{{ $c->id }}" @selected($class?->id === $c->id)>{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-12">
                        <div class="form-group mb-lg-0">
                            <label>Section</label>
                            <select name="section" id="selSection" class="form-select" @disabled(! $class)>
                                @if ($class)
                                    @foreach ($class->sections as $s)
                                        <option value="{{ $s->id }}" @selected($section?->id === $s->id)>{{ $s->name }}</option>
                                    @endforeach
                                @else
                                    <option value="">—</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-12">
                        <div class="form-group mb-lg-0">
                            <label>Week of</label>
                            <input type="date" name="date" id="selDate" value="{{ $date }}" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12 ">
                        <noscript><button class="btn btn-submit">Load</button></noscript>
                        @if ($section)
                            <a href="{{ route('attendance.mark', ['class' => $class->id, 'section' => $section->id, 'date' => $prevWeek]) }}" class="btn btn-cancel me-1">‹ Prev</a>
                            <a href="{{ route('attendance.mark', ['class' => $class->id, 'section' => $section->id, 'date' => $thisWeek]) }}" class="btn btn-cancel me-1">This week</a>
                            <a href="{{ route('attendance.mark', ['class' => $class->id, 'section' => $section->id, 'date' => $nextWeek]) }}" class="btn btn-cancel">Next ›</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        @if (! $class)
            <div class="card"><div class="card-body text-center text-muted py-5">Select a class to load its students.</div></div>
        @elseif (! $section)
            <div class="alert alert-warning">
                This class has no active section yet. <a href="{{ route('section.create', ['class' => $class->id]) }}">Add a section</a> first.
            </div>
        @else
            @php
                $days     = $week['days'];
                $students = $week['students'];
                $logs     = $week['logs'];
                $sessions = $week['sessions'];
            @endphp

            <form id="attForm" action="{{ route('attendance.save') }}" method="POST">
                @csrf
                <input type="hidden" name="section_id" value="{{ $section->id }}">
                <input type="hidden" name="week" value="{{ $date }}">

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                            <div>
                                <h5 class="mb-1">{{ $class->name }} — Section {{ $section->name }}</h5>
                                <span class="text-muted">Week: {{ $weekLabel }} · {{ $students->count() }} student(s)</span>
                            </div>
                            <button type="submit" class="btn btn-submit mt-2 mt-md-0">Save attendance</button>
                        </div>

                        <div class="att-legend small mb-3">
                            @foreach ($STATUSES as $key => $label)
                                <span class="me-3"><span class="att-chip sm" data-status="{{ $key }}">{{ $LETTERS[$key] }}</span> {{ $label }}</span>
                            @endforeach
                            <!-- <span class="text-muted d-block d-md-inline ms-md-2">
                                Everyone starts as Present. Changing a status ticks that day for saving; untouched saved days are left as they are.
                            </span> -->
                        </div>

                        @if ($students->isEmpty())
                            <div class="alert alert-info mb-0">There are no active students in this section.
                                <a href="{{ route('student.create', ['class' => $class->id, 'section' => $section->id]) }}">Add a student</a>.</div>
                        @else
                        <div class="table-responsive">
                            <table class="table att-table">
                                <thead>
                                    <tr>
                                        <th class="student-col">Student</th>
                                        @foreach ($days as $day)
                                            @php $session = $sessions[$day['date']] ?? null; @endphp
                                            <th class="day {{ $day['today'] ? 'is-today' : '' }}">
                                                <div class="fw-bold">{{ $day['dow'] }}</div>
                                                <div class="small mb-1">{{ $day['day'] }}</div>

                                                @if ($day['editable'])
                                                    <label class="small d-block mb-1">
                                                        <input type="checkbox" class="day-save" name="save_days[]" value="{{ $day['date'] }}"
                                                               @checked($day['today'] && ! $session)> Save this day
                                                    </label>
                                                    <a href="#" class="small all-present" data-date="{{ $day['date'] }}">All present</a>
                                                    <div class="small mt-1 {{ $session ? 'text-success' : 'text-muted' }}">{{ $session ? 'Saved' : 'Not taken' }}</div>
                                                    @if ($session)
                                                        <div class="small text-muted" style="line-height:1.2">
                                                             {{ $session->updated_at->timezone($tz)->format('d M, h:i A') }}
                                                        </div>
                                                    @endif
                                                    <div class="day-counts mt-1" data-date="{{ $day['date'] }}"></div>
                                                @else
                                                    <span class="badge bg-secondary">{{ $day['reason'] }}</span>
                                                @endif
                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($students as $student)
                                    <tr>
                                        <td class="student-col">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $student->photo_url }}" alt="" class="rounded-circle me-2" style="width:30px;height:30px;object-fit:cover;">
                                                <div>
                                                    <strong>{{ $student->full_name }}</strong>
                                                    @if ($student->status !== 'active' || $student->trashed())
                                                        <span class="badge bg-secondary">{{ $student->trashed() ? 'Deleted' : ucfirst($student->status) }}</span>
                                                    @endif
                                                    <div class="small text-muted">{{ $student->roll_number }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        @foreach ($days as $day)
                                            @php $current = $logs[$student->id][$day['date']] ?? null; @endphp
                                            <td class="text-center">
                                                @if ($day['editable'])
                                                    @php $value = $current ?? 'present'; @endphp
                                                    <select name="status[{{ $day['date'] }}][{{ $student->id }}]" class="att-select"
                                                            data-date="{{ $day['date'] }}" data-status="{{ $value }}" data-original="{{ $value }}">
                                                        @foreach ($STATUSES as $key => $label)
                                                            <option value="{{ $key }}" @selected($value === $key)>{{ $label }}</option>
                                                        @endforeach
                                                    </select>
                                                @elseif ($current)
                                                    <span class="att-chip" data-status="{{ $current }}" title="{{ $STATUSES[$current] }}">{{ $LETTERS[$current] }}</span>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-submit">Save attendance</button>
                        </div>
                        @endif
                    </div>
                </div>
            </form>
        @endif
    </div>
</div>

<script>
    (function () {
        // ---- Filters: any change reloads the page with the new selection (section falls back to the class's first one).
        var form = document.getElementById('filterForm');
        var selClass = document.getElementById('selClass');
        var selSection = document.getElementById('selSection');
        selClass.addEventListener('change', function () { selSection.value = ''; selSection.disabled = true; form.submit(); });
        selSection.addEventListener('change', function () { form.submit(); });
        document.getElementById('selDate').addEventListener('change', function () { if (this.value) form.submit(); });

        // ---- Weekly grid
        var att = document.getElementById('attForm');
        if (!att) return;

        var letters = @json($LETTERS);
        var names   = @json($STATUSES);
        var hasChanges = false;

        function dayBox(date) { return att.querySelector('.day-save[value="' + date + '"]'); }

        function recount(date) {
            var box = att.querySelector('.day-counts[data-date="' + date + '"]');
            if (!box) return;
            var counts = {};
            att.querySelectorAll('.att-select[data-date="' + date + '"]').forEach(function (s) { counts[s.value] = (counts[s.value] || 0) + 1; });
            box.innerHTML = Object.keys(letters).filter(function (k) { return counts[k]; }).map(function (k) {
                return '<span class="att-chip sm" data-status="' + k + '" title="' + names[k] + '">' + letters[k] + ' ' + counts[k] + '</span>';
            }).join(' ');
        }

        function onChange(select) {
            select.dataset.status = select.value;
            var changed = select.value !== select.dataset.original;
            select.classList.toggle('changed', changed);
            if (changed) { var box = dayBox(select.dataset.date); if (box) box.checked = true; hasChanges = true; }
            recount(select.dataset.date);
        }

        att.querySelectorAll('.att-select').forEach(function (s) { s.addEventListener('change', function () { onChange(s); }); });

        att.querySelectorAll('.day-counts').forEach(function (el) { recount(el.dataset.date); });

        att.querySelectorAll('.all-present').forEach(function (link) {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                var date = link.dataset.date;
                att.querySelectorAll('.att-select[data-date="' + date + '"]').forEach(function (s) { s.value = 'present'; onChange(s); });
                var box = dayBox(date); if (box) box.checked = true;
            });
        });

        // ---- Confirm before saving
        att.addEventListener('submit', function (e) {
            e.preventDefault();
            var days = Array.prototype.slice.call(att.querySelectorAll('.day-save:checked'));

            if (!days.length) {
                var msg = 'Nothing to save yet. Change a status, or tick "Save this day".';
                window.Swal ? Swal.fire({ icon: 'info', title: 'Nothing to save', text: msg }) : alert(msg);
                return;
            }

            var totals = { absent: 0, late: 0, excused: 0, half_day: 0 };
            days.forEach(function (box) {
                att.querySelectorAll('.att-select[data-date="' + box.value + '"]').forEach(function (s) {
                    if (totals[s.value] !== undefined) totals[s.value]++;
                });
            });

            var html = '<b>' + days.length + ' day(s)</b> will be saved.<br>Absent: ' + totals.absent + ' · Late: ' + totals.late +
                       ' · Excused: ' + totals.excused + ' · Half day: ' + totals.half_day;

            var go = function () { hasChanges = false; att.submit(); };

            if (window.Swal) {
                Swal.fire({ title: 'Save attendance?', html: html, icon: 'question', showCancelButton: true, confirmButtonText: 'Yes, save' })
                    .then(function (r) { if (r.isConfirmed) go(); });
            } else if (confirm('Save attendance for ' + days.length + ' day(s)?')) { go(); }
        });

        window.addEventListener('beforeunload', function (e) { if (hasChanges) { e.preventDefault(); e.returnValue = ''; } });
    })();
</script>
@endsection