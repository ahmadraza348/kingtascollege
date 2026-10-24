@extends('backend.layouts.layout')
@section('title', 'Students - King TAS College')
@section('content')
@php $keep = array_filter(['class' => $classId, 'section' => $sectionId]); @endphp
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Students</h4>
                <h6>Manage enrolled students.</h6>
            </div>
            <div class="page-btn">
                <a href="{{ route('student.import') }}" class="btn btn-added me-2">
                    <img src="{{ asset('backend/assets/img/icons/excel.svg') }}" alt="" class="me-1"> Import from Excel
                </a>
                <a href="{{ route('student.create') }}" class="btn btn-added">
                    <img src="{{ asset('backend/assets/img/icons/plus.svg') }}" alt="" class="me-1"> Add Student
                </a>
            </div>
        </div>

        @if (session('import_skipped'))
            <div class="alert alert-warning">
                <strong>{{ count(session('import_skipped')) }} row(s) were not imported:</strong>
                <ul class="mb-0 mt-1">
                    @foreach (session('import_skipped') as $line) <li>{{ $line }}</li> @endforeach
                </ul>
            </div>
        @endif

        {{-- Status cards --}}
        <div class="row">
            <div class="col-6 col-md-2 mb-3">
                <a href="{{ route('student.index', $keep) }}" class="card h-100 mb-0 text-center text-decoration-none {{ ! $status && ! $trashed ? 'border-dark' : '' }}">
                    <div class="card-body py-3">
                        <h3 class="mb-0">{{ $counts->sum() }}</h3><small class="text-muted">All</small>
                    </div>
                </a>
            </div>
            @foreach (\App\Models\Student::STATUSES as $key => $label)
                <div class="col-6 col-md-2 mb-3">
                    <a href="{{ route('student.index', $keep + ['status' => $key]) }}"
                       class="card h-100 mb-0 text-center text-decoration-none {{ $status === $key ? 'border-' . \App\Models\Student::STATUS_COLORS[$key] : '' }}">
                        <div class="card-body py-3">
                            <h3 class="mb-0 text-{{ \App\Models\Student::STATUS_COLORS[$key] }}">{{ $counts[$key] ?? 0 }}</h3>
                            <small class="text-muted">{{ $label }}</small>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        {{-- Filters --}}
        <div class="card">
            <div class="card-body">
                <form action="{{ route('student.index') }}" method="GET" class="row align-items-end">
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="form-group mb-lg-0">
                            <label>Class</label>
                            <select name="class" id="filterClass" class="form-select" data-sections="#filterSection">
                                <option value="">All classes</option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}" @selected($classId === $class->id)>{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="form-group mb-lg-0">
                            <label>Section</label>
                            <select name="section" id="filterSection" class="form-select">
                                <option value="">All sections</option>
                                @foreach ($sections as $section)
                                    <option value="{{ $section->id }}" @selected($sectionId === $section->id)>{{ $section->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="form-group mb-lg-0">
                            <label>Show</label>
                            <select name="trashed" class="form-select">
                                <option value="0">Current students</option>
                                <option value="1" @selected($trashed)>Deleted students</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12 page-btn">
                        @if ($status) <input type="hidden" name="status" value="{{ $status }}"> @endif
                        <button type="submit" class="btn btn-submit me-2">Filter</button>
                        <a href="{{ route('student.index') }}" class="btn btn-cancel">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Bulk actions: appear once students are ticked --}}
        <div id="bulkBar" class="card d-none border-primary">
            <div class="card-body">
                <form id="bulkForm" action="{{ route('student.bulk') }}" method="POST" class="row align-items-end">
                    @csrf
                    <div class="col-lg-2 col-12 mb-2 mb-lg-0"><strong><span id="bulkCount">0</span> selected</strong></div>
                    <div class="col-lg-2 col-md-6 col-12">
                        <label>Action</label>
                        <select name="action" id="bulkAction" class="form-select">
                            <option value="move">Move to class / section</option>
                            <option value="status">Change status</option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-6 col-12 bulk-move">
                        <label>Class</label>
                        <select name="school_class_id" id="bulkClass" class="form-select" data-sections="#bulkSection">
                            <option value="">— Select —</option>
                            @foreach ($classes as $class) <option value="{{ $class->id }}">{{ $class->name }}</option> @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-6 col-12 bulk-move">
                        <label>Section</label>
                        <select name="section_id" id="bulkSection" class="form-select"><option value="">— Select —</option></select>
                    </div>
                    <div class="col-lg-2 col-md-6 col-12 bulk-status d-none">
                        <label>Status</label>
                        <select name="status" class="form-select">
                            @foreach (\App\Models\Student::STATUSES as $key => $label) <option value="{{ $key }}">{{ $label }}</option> @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2 col-12 mt-2 mt-lg-0">
                        <button type="submit" class="btn btn-submit">Apply</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table datanew" id="studentsTable">
                        <thead>
                            <tr>
                                <th data-orderable="false" style="width:30px;">
                                    @unless ($trashed) <input type="checkbox" id="checkAll"> @endunless
                                </th>
                                <th>Student</th>
                                <th>Roll No</th>
                                <th>Class / Section</th>
                                <th>Father</th>
                                <th>Phone</th>
                                <!-- <th>Admission</th> -->
                                <th>Status</th>
                                <th data-orderable="false">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($students as $item)
                            <tr>
                                <td>@unless ($trashed) <input type="checkbox" class="row-check" value="{{ $item->id }}"> @endunless</td>
                                <td>
                                    <a href="{{ $trashed ? '#' : route('student.show', $item) }}" class="d-flex align-items-center text-decoration-none">
                                        <img src="{{ $item->photo_url }}" alt="" class="rounded-circle me-2" style="width:38px;height:38px;object-fit:cover;">
                                        <strong>{{ $item->full_name }}</strong>
                                    </a>
                                </td>
                                <td>{{ $item->roll_number }}</td>
                                <td>{{ $item->schoolClass->name }} / {{ $item->section->name }}</td>
                                <td>{{ $item->father_name }}</td>
                                <td>{{ $item->phone }}</td>
                                <!-- <td>
                                    @if ($item->admission_id)
                                        <a href="{{ route('admission.show', $item->admission_id) }}">{{ $item->admission_form_number }}</a>
                                    @else — @endif
                                </td> -->
                                <td><span class="badge rounded-pill bg-{{ $item->status_color }}">{{ $item->status_label }}</span></td>
                                <td class="text-nowrap">
                                    @if ($trashed)
                                        <form action="{{ route('student.restore', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-primary">Restore</button>
                                        </form>
                                    @else
                                        <a href="{{ route('student.show', $item) }}" class="me-2" title="View"><img src="{{ asset('backend/assets/img/icons/eye.svg') }}" alt="View"></a>
                                        <a href="{{ route('student.edit', $item) }}" class="me-2" title="Edit"><img src="{{ asset('backend/assets/img/icons/edit.svg') }}" alt="Edit"></a>
                                        <form action="{{ route('student.destroy', $item) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-link p-0" title="Delete"
                                                    onclick="return confirm('Delete this student? You can restore them later from the Deleted list.');">
                                                <img src="{{ asset('backend/assets/img/icons/delete.svg') }}" alt="Delete">
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('backend.student._class_section_js')

<script>
    // Runs on window "load": the layout loads jQuery again and starts the DataTable at the bottom of the page.
    window.addEventListener('load', function () {
        var $ = window.jQuery;
        var tableEl = $('#studentsTable');
        if (!$.fn.DataTable || !$.fn.DataTable.isDataTable(tableEl)) return;

        var dt    = tableEl.DataTable();
        var bar   = document.getElementById('bulkBar');
        var count = document.getElementById('bulkCount');

        // dt.$() searches every page of the table, not only the visible one.
        function ticked() { return dt.$('.row-check:checked'); }
        function refresh() { var n = ticked().length; count.textContent = n; bar.classList.toggle('d-none', n === 0); }

        $('#checkAll').on('change', function () {
            dt.$('.row-check', { search: 'applied' }).prop('checked', this.checked);
            refresh();
        });
        tableEl.on('change', '.row-check', refresh);

        document.getElementById('bulkAction').addEventListener('change', function () {
            var move = this.value === 'move';
            document.querySelectorAll('.bulk-move').forEach(function (el) { el.classList.toggle('d-none', !move); });
            document.querySelectorAll('.bulk-status').forEach(function (el) { el.classList.toggle('d-none', move); });
        });

        document.getElementById('bulkForm').addEventListener('submit', function (e) {
            var boxes = ticked();
            if (!boxes.length) { e.preventDefault(); return; }
            var form = this;
            form.querySelectorAll('input[name="ids[]"]').forEach(function (i) { i.remove(); });
            boxes.each(function () {
                var hidden = document.createElement('input');
                hidden.type = 'hidden'; hidden.name = 'ids[]'; hidden.value = this.value;
                form.appendChild(hidden);
            });
        });
    });
</script>
@endsection