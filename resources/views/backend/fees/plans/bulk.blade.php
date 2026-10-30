@extends('backend.layouts.layout')
@section('title', 'Fee Plans for a Class - King TAS College')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header"><div class="page-title"><h4>Fee plans for a class</h4><h6>Give every active student of a class the same total fee and installment schedule. Students who already have a plan are skipped.</h6></div></div>

        <div class="card"><div class="card-body">
            <form action="{{ route('fees.plans.bulk') }}" method="GET" class="row align-items-end">
                <div class="col-lg-4 col-md-6"><div class="form-group"><label>Class</label>
                    <select name="class" class="form-select" onchange="this.form.section.value='';this.form.submit()"><option value="">— Select —</option>
                        @foreach ($classes as $c)<option value="{{ $c->id }}" @selected($classId === $c->id)>{{ $c->name }}</option>@endforeach</select></div></div>
                <div class="col-lg-4 col-md-6"><div class="form-group"><label>Section</label>
                    <select name="section" id="bSection" class="form-select" onchange="this.form.submit()"><option value="">All sections</option>
                        @foreach ($sections as $s)<option value="{{ $s->id }}" @selected($sectionId === $s->id)>{{ $s->name }}</option>@endforeach</select></div></div>
            </form>
        </div></div>

        @if ($eligible)
            <div class="alert alert-info">{{ $eligible['total'] }} active student(s) selected: <strong>{{ $eligible['total'] - $eligible['with'] }}</strong> will get a plan, {{ $eligible['with'] }} already have one and will be skipped.</div>

            @if ($eligible['total'] - $eligible['with'] > 0)
            <form action="{{ route('fees.plans.bulk.store') }}" method="POST" onsubmit="return confirm('Create fee plans for {{ $eligible['total'] - $eligible['with'] }} student(s)?');">
                @csrf
                <input type="hidden" name="school_class_id" value="{{ $classId }}">
                <input type="hidden" name="section_id" value="{{ $sectionId }}">
                <div class="card"><div class="card-body"><div class="row">
                    <div class="col-lg-3 col-md-6"><div class="form-group"><label>Total course fee (Rs.) <span class="text-danger">*</span></label><input type="number" step="0.01" min="1" name="total_fee" value="{{ old('total_fee') }}" required class="form-control @error('total_fee') is-invalid @enderror">@error('total_fee')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror</div></div>
                    <div class="col-lg-3 col-md-6"><div class="form-group"><label>Discount (Rs.)</label><input type="number" step="0.01" min="0" name="discount" value="{{ old('discount', 0) }}" class="form-control"></div></div>
                    <div class="col-lg-3 col-md-6"><div class="form-group"><label>Number of installments <span class="text-danger">*</span></label><input type="number" min="1" max="60" name="count" value="{{ old('count', 4) }}" required class="form-control"></div></div>
                    <div class="col-lg-3 col-md-6"><div class="form-group"><label>Every</label><select name="interval" class="form-select">@foreach ([1 => '1 month', 2 => '2 months', 3 => '3 months', 6 => '6 months'] as $k => $l)<option value="{{ $k }}" @selected((int) old('interval', 1) === $k)>{{ $l }}</option>@endforeach</select></div></div>
                    <div class="col-lg-3 col-md-6"><div class="form-group"><label>First due date <span class="text-danger">*</span></label><input type="date" name="first_due" value="{{ old('first_due', $today) }}" required class="form-control"></div></div>
                    <div class="col-lg-6"><div class="form-group"><label>Note</label><input type="text" name="notes" value="{{ old('notes') }}" maxlength="255" class="form-control"></div></div>
                </div></div></div>
                <div class="alert alert-secondary">The total is split equally (any remainder goes to the first installment). You can still change any single student's plan later from their account book, for example for a scholarship.</div>
                <button class="btn btn-submit me-2">Create fee plans</button>
                <a href="{{ route('fees.accounts') }}" class="btn btn-cancel">Cancel</a>
            </form>
            @endif
        @endif
    </div>
</div>
@endsection
