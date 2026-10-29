@extends('backend.layouts.layout')
@section('title', 'Generate Monthly Vouchers - King TAS College')
@section('content')
@php $F = \App\Support\FeeHelper::class; @endphp
<div class="page-wrapper">
    <div class="content">
        <div class="page-header"><div class="page-title"><h4>Generate Monthly Vouchers</h4><h6>Step 1: choose class and month. Step 2: check the list. Step 3: generate.</h6></div></div>

        <div class="card"><div class="card-body">
            <form action="{{ route('fees.vouchers.bulk') }}" method="GET" class="row align-items-end">
                <div class="col-lg-3 col-md-6"><div class="form-group"><label>Class</label>
                    <select name="class" class="form-select" data-sections="#bSection" required><option value="">— Select —</option>
                        @foreach ($classes as $c)<option value="{{ $c->id }}" @selected($classId === $c->id)>{{ $c->name }}</option>@endforeach</select></div></div>
                <div class="col-lg-2 col-md-6"><div class="form-group"><label>Section</label>
                    <select name="section" id="bSection" class="form-select"><option value="">All sections</option>
                        @foreach ($sections as $s)<option value="{{ $s->id }}" @selected($sectionId === $s->id)>{{ $s->name }}</option>@endforeach</select></div></div>
                <div class="col-lg-2 col-md-6"><div class="form-group"><label>Billing month</label><input type="month" name="period" value="{{ $period }}" required class="form-control"></div></div>
                <div class="col-lg-2 col-md-6"><div class="form-group"><label>Issue date</label><input type="date" name="issue_date" value="{{ $issue }}" class="form-control"></div></div>
                <div class="col-lg-2 col-md-6"><div class="form-group"><label>Due date</label><input type="date" name="due_date" value="{{ $due }}" class="form-control"></div></div>
                <div class="col-lg-1 col-12"><div class="form-group"><button class="btn btn-submit">Check</button></div></div>
            </form>
        </div></div>

        @if ($preview)
            @php $ready = $preview->where('state', 'ready'); @endphp
            <div class="card"><div class="card-body">
                <div class="row text-center mb-3">
                    <div class="col-4"><h3 class="mb-0 text-success">{{ $ready->count() }}</h3><small class="text-muted">Will be created</small></div>
                    <div class="col-4"><h3 class="mb-0">{{ $preview->where('state', 'exists')->count() }}</h3><small class="text-muted">Already have a voucher</small></div>
                    <div class="col-4"><h3 class="mb-0 text-danger">{{ $preview->where('state', 'blocked')->count() }}</h3><small class="text-muted">Cannot be created</small></div>
                </div>

                <div class="table-responsive"><table class="table table-sm">
                    <thead><tr><th>Roll No</th><th>Student</th><th>Section</th><th>Tuition setting</th><th class="text-end">Voucher total</th><th>Result</th></tr></thead>
                    <tbody>
                    @foreach ($preview as $row)
                        <tr>
                            <td>{{ $row['student']->roll_number }}</td><td>{{ $row['student']->full_name }}</td><td>{{ $row['student']->section->name }}</td>
                            <td class="text-nowrap">
                                @if ($row['student']->monthly_tuition_fee !== null)
                                    {{ $F::money($row['student']->monthly_tuition_fee) }} <span class="small text-muted">(custom)</span>
                                @else
                                    <span class="text-muted">Class default</span>
                                @endif
                            </td>
                            <td class="text-end">{{ $F::number($row['amount']) }}</td>
                            <td>@if ($row['state'] === 'ready')<span class="badge bg-success">Ready</span>
                                @elseif ($row['state'] === 'exists')<span class="badge bg-secondary">{{ $row['note'] }}</span>
                                @else<span class="text-danger small">{{ $row['note'] }}</span>@endif</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table></div>

                @if ($ready->isNotEmpty())
                    <form action="{{ route('fees.vouchers.bulk.store') }}" method="POST" class="mt-3" onsubmit="return confirm('Create {{ $ready->count() }} voucher(s)?');">
                        @csrf
                        <input type="hidden" name="school_class_id" value="{{ $classId }}">
                        <input type="hidden" name="section_id" value="{{ $sectionId }}">
                        <input type="hidden" name="period" value="{{ $period }}">
                        <input type="hidden" name="issue_date" value="{{ $issue }}">
                        <input type="hidden" name="due_date" value="{{ $due }}">
                        <label class="d-block mb-3"><input type="checkbox" name="include_absent_fine" value="1" checked> Include absent fine (only if set in Settings)</label>
                        <button class="btn btn-submit">Generate {{ $ready->count() }} voucher(s)</button>
                    </form>
                @endif
            </div></div>
        @endif
    </div>
</div>
@include('backend.student._class_section_js')
@endsection