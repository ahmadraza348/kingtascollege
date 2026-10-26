@extends('backend.layouts.layout')
@section('title', ($structure->exists ? 'Edit' : 'Set') . ' Class Fees - King TAS College')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header"><div class="page-title"><h4>{{ $structure->exists ? 'Edit' : 'Set' }} Class Fees</h4>
            <h6>Choose a class and session, then enter the fees students in that class should pay.</h6></div></div>

        <form action="{{ $structure->exists ? route('fees.structures.update', $structure) : route('fees.structures.store') }}" method="POST">
            @csrf @if ($structure->exists) @method('PUT') @endif

            <div class="card"><div class="card-body"><div class="row">
                <div class="col-lg-4"><div class="form-group"><label>Class <span class="text-danger">*</span></label>
                    <select name="school_class_id" class="form-select @error('school_class_id') is-invalid @enderror" required>
                        <option value="">— Select class —</option>
                        @foreach ($classes as $c)<option value="{{ $c->id }}" @selected((int) old('school_class_id', $structure->school_class_id) === $c->id)>{{ $c->name }}</option>@endforeach
                    </select>@error('school_class_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror</div></div>
                <div class="col-lg-3"><div class="form-group"><label>Session <span class="text-danger">*</span></label>
                    <input type="text" name="session" value="{{ old('session', $structure->session) }}" required maxlength="20" class="form-control @error('session') is-invalid @enderror">
                    <small class="text-muted">Use the same session value saved on the students.</small>
                    @error('session')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror</div></div>
                <div class="col-lg-3"><div class="form-group"><label>Name (optional)</label>
                    <input type="text" name="name" value="{{ old('name', $structure->name) }}" maxlength="150" class="form-control"></div></div>
                <div class="col-lg-2"><div class="form-group"><label>Status</label>
                    <select name="is_active" class="form-select"><option value="1" @selected(old('is_active', $structure->is_active ?? true))>Active</option><option value="0" @selected(! old('is_active', $structure->is_active ?? true))>Inactive</option></select></div></div>
            </div></div></div>

            <div class="card"><div class="card-body">
                <h5 class="mb-3">Fee amounts (Rs.)</h5>
                @error('items')<div class="alert alert-danger">{{ $message }}</div>@enderror
                <div class="row">
                @foreach ($heads as $head)
                    <div class="col-lg-3 col-md-6"><div class="form-group">
                        <label>{{ $head->name }} <small class="text-muted">({{ \App\Models\FeeHead::FREQUENCIES[$head->frequency] }})</small></label>
                        <input type="number" step="0.01" min="0" name="items[{{ $head->id }}]" value="{{ old('items.' . $head->id, $amounts[$head->id] ?? '') }}" class="form-control @error('items.' . $head->id) is-invalid @enderror">
                        @error('items.' . $head->id)<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div></div>
                @endforeach
                </div>
                <small class="text-muted">Late fine, absent fine, and readmission fee are set in Fee Settings.</small>
            </div></div>

            <button type="submit" class="btn btn-submit me-2">Save</button>
            <a href="{{ route('fees.structures.index') }}" class="btn btn-cancel">Cancel</a>
        </form>
    </div>
</div>
@endsection