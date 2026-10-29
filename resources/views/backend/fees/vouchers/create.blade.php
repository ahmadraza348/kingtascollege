@extends('backend.layouts.layout')
@section('title', 'New Fee Voucher - King TAS College')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header"><div class="page-title"><h4>New Fee Voucher</h4><h6>For one student. To bill a whole class use "Generate monthly vouchers".</h6></div></div>

        <form action="{{ route('fees.vouchers.store') }}" method="POST">
            @csrf
            <div class="card"><div class="card-body"><div class="row">
                @if ($student)
                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                    <div class="col-12 mb-3"><strong>{{ $student->full_name }}</strong> — {{ $student->roll_number }} — {{ $student->schoolClass->name }} / {{ $student->section->name }}
                        <a href="{{ route('fees.vouchers.create') }}" class="ms-2 small">Change student</a></div>
                @else
                    <div class="col-lg-3 col-md-6"><div class="form-group"><label>Class</label>
                        <select id="vClass" class="form-select" data-sections="#vSection"><option value="">— Select —</option>
                            @foreach ($classes as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach</select></div></div>
                    <div class="col-lg-3 col-md-6"><div class="form-group"><label>Section</label>
                        <select id="vSection" class="form-select"><option value="">— Select —</option></select></div></div>
                    <div class="col-lg-6"><div class="form-group"><label>Student <span class="text-danger">*</span></label>
                        <select name="student_id" id="vStudent" class="form-select @error('student_id') is-invalid @enderror" required><option value="">— Select student —</option></select>
                        @error('student_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror</div></div>
                @endif

                <div class="col-lg-3 col-md-6"><div class="form-group"><label>Voucher for <span class="text-danger">*</span></label>
                    <select name="type" id="vType" class="form-select @error('type') is-invalid @enderror">
                        @foreach (\App\Models\FeeVoucher::TYPES as $k => $l)<option value="{{ $k }}" @selected(old('type', $type) === $k)>{{ $l }}</option>@endforeach</select></div></div>
                <div class="col-lg-3 col-md-6"><div class="form-group"><label>Billing month <span class="text-danger">*</span></label>
                    <input type="month" name="period" value="{{ old('period', $period) }}" required class="form-control @error('period') is-invalid @enderror">
                    @error('period')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror</div></div>
                <div class="col-lg-3 col-md-6"><div class="form-group"><label>Issue date <span class="text-danger">*</span></label>
                    <input type="date" name="issue_date" value="{{ old('issue_date', $issue) }}" required class="form-control @error('issue_date') is-invalid @enderror">
                    @error('issue_date')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror</div></div>
                <div class="col-lg-3 col-md-6"><div class="form-group"><label>Due date <span class="text-danger">*</span></label>
                    <input type="date" name="due_date" value="{{ old('due_date', $due) }}" required class="form-control @error('due_date') is-invalid @enderror">
                    @error('due_date')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror</div></div>

                <div class="col-lg-6 manual-fields"><div class="form-group"><label>Description</label>
                    <input type="text" name="description" value="{{ old('description') }}" maxlength="150" class="form-control @error('description') is-invalid @enderror" placeholder="e.g. Dues of 2025 from the old register">
                    @error('description')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror</div></div>
                <div class="col-lg-3 manual-fields"><div class="form-group"><label>Amount (Rs.)</label>
                    <input type="number" step="0.01" min="1" name="amount" value="{{ old('amount') }}" class="form-control @error('amount') is-invalid @enderror">
                    @error('amount')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror</div></div>

                <div class="col-12 monthly-only"><label class="d-block mb-0"><input type="checkbox" name="include_absent_fine" value="1" checked> Include absent fine (only if an absent fine is set in Settings)</label></div>
            </div></div></div>

            <div class="alert alert-info">Monthly Tuition Fee uses the student-specific override when one is set; otherwise it uses the class/session fee structure. Other fee heads still use the class structure. Previously created vouchers do not change. Previous unpaid vouchers are shown as <strong>arrears</strong> on the printed voucher automatically — do not add them here.</div>
            <button type="submit" class="btn btn-submit me-2">Create voucher</button>
            <a href="{{ route('fees.vouchers') }}" class="btn btn-cancel">Cancel</a>
        </form>
    </div>
</div>
@include('backend.student._class_section_js')
<script>
    (function () {
        var type = document.getElementById('vType');
        function toggle() {
            var manual = ['opening', 'other'].indexOf(type.value) !== -1;
            document.querySelectorAll('.manual-fields').forEach(function (el) { el.style.display = manual ? '' : 'none'; });
            document.querySelectorAll('.monthly-only').forEach(function (el) { el.style.display = type.value === 'monthly' ? '' : 'none'; });
        }
        type.addEventListener('change', toggle); toggle();

        var section = document.getElementById('vSection'), student = document.getElementById('vStudent'), cls = document.getElementById('vClass');
        if (!section) return;
        var tpl = @json(route('fees.students-by-section', '__ID__'));
        function reset() { student.innerHTML = '<option value="">— Select student —</option>'; }
        cls.addEventListener('change', reset);
        section.addEventListener('change', function () {
            reset(); if (!this.value) return;
            fetch(tpl.replace('__ID__', this.value), { headers: { 'Accept': 'application/json' } }).then(function (r) { return r.json(); })
                .then(function (list) { list.forEach(function (s) { student.add(new Option(s.roll_number + ' — ' + s.full_name, s.id)); }); });
        });
    })();
</script>
@endsection