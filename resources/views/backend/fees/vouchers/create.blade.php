@extends('backend.layouts.layout')
@section('title', 'Create Student Fee Voucher - King TAS College')
@section('content')
@php $F = \App\Support\FeeHelper::class; @endphp
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Create Student Fee Voucher</h4>
                <h6>Create a voucher for one student using that student's finalized fee.</h6>
            </div>
        </div>

        <form action="{{ route('fees.vouchers.store') }}" method="POST">
            @csrf
            <div class="card"><div class="card-body"><div class="row">
                @if ($student)
                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                    <div class="col-12 mb-3">
                        <strong>{{ $student->full_name }}</strong> — {{ $student->roll_number }} — {{ $student->schoolClass?->name ?? '—' }} / {{ $student->section?->name ?? '—' }}
                        <a href="{{ route('fees.vouchers.create') }}" class="ms-2 small">Change student</a>
                    </div>
                    <div class="col-md-4 mb-3"><div class="border rounded p-3 h-100"><small class="text-muted">Finalized total fee</small><h5 class="mb-0">{{ $student->finalized_fee !== null ? $F::money($finalizedFee) : 'Not set' }}</h5></div></div>
                    <div class="col-md-4 mb-3"><div class="border rounded p-3 h-100"><small class="text-muted">Received so far</small><h5 class="mb-0 text-success">{{ $F::money($receivedFee) }}</h5></div></div>
                    <div class="col-md-4 mb-3"><div class="border rounded p-3 h-100"><small class="text-muted">Remaining student balance</small><h5 class="mb-0 text-danger">{{ $student->finalized_fee !== null ? $F::money($studentBalance) : '—' }}</h5></div></div>
                    @if ($student->finalized_fee === null)
                        <div class="col-12"><div class="alert alert-warning mb-3">Set the student's finalized total fee in the Student record before creating a voucher. <a href="{{ route('student.edit', $student) }}">Edit student fee</a>.</div></div>
                    @elseif ($remainingToBill <= 0)
                        <div class="col-12"><div class="alert alert-info mb-3">The full finalized fee has already been billed. Update the student's finalized fee only if the agreed total has changed.</div></div>
                    @else
                        <div class="col-12"><div class="alert alert-light border py-2 mb-3">Amount still available to bill: <strong>{{ $F::money($remainingToBill) }}</strong></div></div>
                    @endif
                @else
                    <div class="col-lg-3 col-md-6"><div class="form-group"><label>Class</label>
                        <select id="vClass" class="form-select" data-sections="#vSection"><option value="">— Select —</option>
                            @foreach ($classes as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach</select></div></div>
                    <div class="col-lg-3 col-md-6"><div class="form-group"><label>Section</label>
                        <select id="vSection" class="form-select"><option value="">— Select —</option></select></div></div>
                    <div class="col-lg-6"><div class="form-group"><label>Student <span class="text-danger">*</span></label>
                        <select name="student_id" id="vStudent" class="form-select @error('student_id') is-invalid @enderror" required><option value="">— Select student —</option></select>
                        @error('student_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror</div></div>
                    <div class="col-12 d-none" id="vFeeSummary">
                        <div class="row g-2 mb-3">
                            <div class="col-md-4"><div class="border rounded p-3 h-100"><small class="text-muted">Finalized total fee</small><h5 class="mb-0" id="vFinalizedFee">—</h5></div></div>
                            <div class="col-md-4"><div class="border rounded p-3 h-100"><small class="text-muted">Received so far</small><h5 class="mb-0 text-success" id="vReceivedFee">—</h5></div></div>
                            <div class="col-md-4"><div class="border rounded p-3 h-100"><small class="text-muted">Remaining student balance</small><h5 class="mb-0 text-danger" id="vRemainingBalance">—</h5></div></div>
                        </div>
                        <div class="alert alert-light border py-2 mb-3" id="vFeeMessage"></div>
                    </div>
                @endif

                <div class="col-lg-3 col-md-6"><div class="form-group"><label>Voucher type <span class="text-danger">*</span></label>
                    <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                        @foreach (\App\Models\FeeVoucher::manualTypes() as $k => $l)<option value="{{ $k }}" @selected(old('type', $type) === $k)>{{ $l }}</option>@endforeach
                    </select>@error('type')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror</div></div>
                <div class="col-lg-3 col-md-6"><div class="form-group"><label>Billing month <span class="text-danger">*</span></label>
                    <input type="month" name="period" value="{{ old('period', $period) }}" required class="form-control @error('period') is-invalid @enderror">
                    @error('period')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror</div></div>
                <div class="col-lg-3 col-md-6"><div class="form-group"><label>Issue date <span class="text-danger">*</span></label>
                    <input type="date" name="issue_date" value="{{ old('issue_date', $issue) }}" required class="form-control @error('issue_date') is-invalid @enderror">
                    @error('issue_date')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror</div></div>
                <div class="col-lg-3 col-md-6"><div class="form-group"><label>Due date <span class="text-danger">*</span></label>
                    <input type="date" name="due_date" value="{{ old('due_date', $due) }}" required class="form-control @error('due_date') is-invalid @enderror">
                    @error('due_date')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror</div></div>

                <div class="col-lg-4 col-md-6"><div class="form-group"><label>Voucher amount (PKR) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" min="1" max="{{ $student ? $remainingToBill : 10000000 }}" name="amount" id="vAmount" value="{{ old('amount') }}" required class="form-control @error('amount') is-invalid @enderror" placeholder="Enter amount">
                    @error('amount')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div></div>
                <div class="col-lg-8 col-md-6"><div class="form-group"><label>Description</label>
                    <input type="text" name="description" value="{{ old('description') }}" maxlength="150" class="form-control @error('description') is-invalid @enderror" placeholder="e.g. Monthly tuition fee, admission fee, examination fee">
                    @error('description')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div></div>
            </div></div></div>

            <button type="submit" id="vCreateButton" class="btn btn-submit me-2" @if (! $student || $student->finalized_fee === null || (float) $student->finalized_fee <= 0 || $remainingToBill <= 0) disabled @endif>Create voucher</button>
            <a href="{{ route('fees.vouchers') }}" class="btn btn-cancel">Cancel</a>
        </form>
    </div>
</div>
@include('backend.student._class_section_js')
<script>
    (function () {
        var section = document.getElementById('vSection');
        var studentSelect = document.getElementById('vStudent');
        var cls = document.getElementById('vClass');
        if (!section || !studentSelect || !cls) return;

        var urlTemplate = @json(route('fees.students-by-section', '__ID__'));
        var studentData = {};
        var summary = document.getElementById('vFeeSummary');
        var createButton = document.getElementById('vCreateButton');
        var amountInput = document.getElementById('vAmount');

        function money(value) {
            return 'PKR ' + Number(value || 0).toLocaleString('en-PK', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }

        function resetSummary() {
            if (summary) summary.classList.add('d-none');
            if (createButton) createButton.disabled = true;
            if (amountInput) amountInput.max = 10000000;
        }

        function showStudentFee(item) {
            if (!item) {
                resetSummary();
                return;
            }

            summary.classList.remove('d-none');
            document.getElementById('vFinalizedFee').textContent = item.finalized_fee === null ? 'Not set' : money(item.finalized_fee);
            document.getElementById('vReceivedFee').textContent = money(item.received_fee);
            document.getElementById('vRemainingBalance').textContent = item.remaining_balance === null ? '—' : money(item.remaining_balance);

            var message = document.getElementById('vFeeMessage');
            if (item.finalized_fee === null || item.finalized_fee <= 0) {
                message.textContent = 'This student has no finalized total fee. Set it in the Student record before creating a voucher.';
                message.className = 'alert alert-warning py-2 mb-3';
                createButton.disabled = true;
                amountInput.max = 0;
            } else if (item.remaining_to_bill <= 0) {
                message.textContent = 'The full finalized fee has already been billed. Update the Student record only when the agreed fee changes.';
                message.className = 'alert alert-info py-2 mb-3';
                createButton.disabled = true;
                amountInput.max = 0;
            } else {
                message.textContent = 'Amount still available to bill: ' + money(item.remaining_to_bill);
                message.className = 'alert alert-light border py-2 mb-3';
                createButton.disabled = false;
                amountInput.max = item.remaining_to_bill;
            }
        }

        function resetStudents() {
            studentSelect.innerHTML = '<option value="">— Select student —</option>';
            studentData = {};
            resetSummary();
        }

        cls.addEventListener('change', resetStudents);
        studentSelect.addEventListener('change', function () {
            showStudentFee(studentData[this.value] || null);
        });
        section.addEventListener('change', function () {
            resetStudents();
            if (!this.value) return;

            fetch(urlTemplate.replace('__ID__', this.value), { headers: { 'Accept': 'application/json' } })
                .then(function (response) {
                    if (!response.ok) throw new Error('Unable to load students.');
                    return response.json();
                })
                .then(function (list) {
                    list.forEach(function (item) {
                        studentData[item.id] = item;
                        studentSelect.add(new Option(item.roll_number + ' — ' + item.full_name, item.id));
                    });
                })
                .catch(function () {
                    resetStudents();
                    alert('Could not load students for this section. Please try again.');
                });
        });
    })();
</script>
@endsection
