@extends('backend.layouts.layout')
@section('title', 'Fee Settings - King TAS College')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Fee Settings</h4>
                <h6>Update the college and bank details shown on each fee voucher.</h6>
            </div>
        </div>

        <form action="{{ route('fees.settings.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card"><div class="card-body">
                <h5 class="mb-3">College details</h5>
                <div class="row">
                    <div class="col-lg-6"><div class="form-group">
                        <label>College name *</label>
                        <input type="text" name="college_name" required maxlength="150" value="{{ old('college_name', $v['college_name']) }}" class="form-control @error('college_name') is-invalid @enderror">
                        @error('college_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div></div>
                    <div class="col-lg-6"><div class="form-group">
                        <label>Address</label>
                        <input type="text" name="college_address" maxlength="255" value="{{ old('college_address', $v['college_address']) }}" class="form-control @error('college_address') is-invalid @enderror">
                        @error('college_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div></div>
                    <div class="col-lg-6"><div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="college_phone" maxlength="100" value="{{ old('college_phone', $v['college_phone']) }}" class="form-control @error('college_phone') is-invalid @enderror">
                        @error('college_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div></div>
                    <div class="col-lg-6"><div class="form-group">
                        <label>Email</label>
                        <input type="email" name="college_email" maxlength="150" value="{{ old('college_email', $v['college_email']) }}" class="form-control @error('college_email') is-invalid @enderror">
                        @error('college_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div></div>
                </div>
            </div></div>

            <div class="card"><div class="card-body">
                <h5 class="mb-3">Bank account</h5>
                <div class="row">
                    @foreach ([['bank_name', 'Bank name'], ['bank_branch', 'Branch'], ['account_title', 'Account title'], ['account_number', 'Account number']] as [$name, $label])
                        <div class="col-lg-6"><div class="form-group">
                            <label>{{ $label }}</label>
                            <input type="text" name="{{ $name }}" maxlength="100" value="{{ old($name, $v[$name]) }}" class="form-control @error($name) is-invalid @enderror">
                            @error($name)<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div></div>
                    @endforeach
                </div>
            </div></div>

            <div class="card"><div class="card-body">
                <h5 class="mb-3">Simple fee rules</h5>
                <div class="row">
                    <div class="col-lg-4 col-md-6"><div class="form-group">
                        <label>Fee due day of each month *</label>
                        <input type="number" name="due_day" min="1" max="28" required value="{{ old('due_day', $v['due_day']) }}" class="form-control @error('due_day') is-invalid @enderror">
                        <small class="text-muted">Used as the default due date for monthly vouchers.</small>
                        @error('due_day')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div></div>
                    <div class="col-lg-4 col-md-6"><div class="form-group">
                        <label>Late fine per day (Rs.) *</label>
                        <input type="number" name="late_fee_per_day" min="0" step="0.01" required value="{{ old('late_fee_per_day', $v['late_fee_per_day']) }}" class="form-control @error('late_fee_per_day') is-invalid @enderror">
                        @error('late_fee_per_day')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div></div>
                    <div class="col-lg-4 col-md-6"><div class="form-group">
                        <label>Apply late fine?</label>
                        <select name="late_fee_enabled" class="form-select @error('late_fee_enabled') is-invalid @enderror">
                            <option value="1" @selected(old('late_fee_enabled', $v['late_fee_enabled']) == '1')>Yes</option>
                            <option value="0" @selected(old('late_fee_enabled', $v['late_fee_enabled']) == '0')>No</option>
                        </select>
                        @error('late_fee_enabled')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div></div>
                    <div class="col-lg-4 col-md-6"><div class="form-group">
                        <label>Absent fine per day (Rs.) *</label>
                        <input type="number" name="absent_fine_per_day" min="0" step="0.01" required value="{{ old('absent_fine_per_day', $v['absent_fine_per_day']) }}" class="form-control @error('absent_fine_per_day') is-invalid @enderror">
                        <small class="text-muted">Set to 0 if absent fines are not used.</small>
                        @error('absent_fine_per_day')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div></div>
                    <div class="col-lg-4 col-md-6"><div class="form-group">
                        <label>Readmission fee (Rs.) *</label>
                        <input type="number" name="readmission_fee" min="0" step="0.01" required value="{{ old('readmission_fee', $v['readmission_fee']) }}" class="form-control @error('readmission_fee') is-invalid @enderror">
                        @error('readmission_fee')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div></div>
                </div>
            </div></div>

            <div class="card"><div class="card-body">
                <h5 class="mb-3">Voucher terms and notes</h5>
                <textarea name="voucher_notes" rows="8" maxlength="1000" class="form-control @error('voucher_notes') is-invalid @enderror">{{ old('voucher_notes', $v['voucher_notes']) }}</textarea>
                <small class="text-muted">Keep one note per line. The default text matches the supplied voucher template.</small>
                @error('voucher_notes')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div></div>

            @if ($errors->any())<div class="alert alert-danger">Please correct the highlighted fields.</div>@endif
            <button type="submit" class="btn btn-submit">Save settings</button>
        </form>
    </div>
</div>
@endsection
