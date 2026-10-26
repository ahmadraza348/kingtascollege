@extends('backend.layouts.layout')
@section('title', 'Receive Payment - King TAS College')
@section('content')
@php $F = \App\Support\FeeHelper::class; @endphp
<div class="page-wrapper">
    <div class="content">
        <div class="page-header"><div class="page-title"><h4>Receive Payment</h4><h6>Record cash received or a bank deposit after checking the deposit slip.</h6></div></div>

        @if (! $student)
            <div class="card"><div class="card-body">
                <form action="{{ route('fees.payments.create') }}" method="GET" class="row align-items-end">
                    <div class="col-lg-6"><div class="form-group"><label>Find the student</label>
                        <input type="text" name="q" value="{{ $search }}" autofocus class="form-control" placeholder="Name, roll number or CNIC"></div></div>
                    <div class="col-lg-2"><div class="form-group"><button class="btn btn-submit">Search</button></div></div>
                </form>
                @if ($matches !== null)
                    <div class="table-responsive"><table class="table">
                        @forelse ($matches as $m)
                            <tr><td>{{ $m->full_name }}</td><td>{{ $m->roll_number }}</td><td>{{ $m->schoolClass->name }} / {{ $m->section->name }}</td>
                                <td><a href="{{ route('fees.payments.create', ['student' => $m->id]) }}" class="btn btn-sm btn-submit">Select</a></td></tr>
                        @empty<tr><td class="text-muted">No student found.</td></tr>@endforelse
                    </table></div>
                @endif
            </div></div>
        @else
            <div class="card"><div class="card-body">
                <div class="d-flex justify-content-between flex-wrap">
                    <div><h5 class="mb-0">{{ $student->full_name }}</h5>
                        <span class="text-muted">{{ $student->roll_number }} · {{ $student->schoolClass->name }} / {{ $student->section->name }}</span></div>
                    <a href="{{ route('fees.payments.create') }}" class="small align-self-center">Change student</a>
                </div>

                @if ($open->isEmpty())
                    <div class="alert alert-success mt-3 mb-0">This student has no unpaid vouchers.</div>
                @else
                    <div class="table-responsive mt-3"><table class="table table-sm">
                        <thead><tr><th>Voucher</th><th>Month</th><th>Due</th><th class="text-end">Balance</th><th class="text-end">Late fee if paid today</th></tr></thead>
                        <tbody>
                        @foreach ($open as $v)
                            <tr><td><a href="{{ route('fees.vouchers.show', $v) }}">{{ $v->voucher_number }}</a></td><td>{{ $v->period_label }}</td>
                                <td>{{ $v->due_date->format('d M Y') }} @if ($v->is_overdue)<span class="badge bg-danger">Overdue</span>@endif</td>
                                <td class="text-end">{{ $F::number($v->balance) }}</td>
                                <td class="text-end">{{ $v->late_extra > 0 ? '+' . $F::number($v->late_extra) : '—' }}</td></tr>
                        @endforeach
                        </tbody>
                        <tfoot><tr><th colspan="3" class="text-end">Total to clear everything today</th><th colspan="2" class="text-end text-danger">{{ $F::money($dueToday) }}</th></tr></tfoot>
                    </table></div>
                    <small class="text-muted">Late fees are added automatically for the payment date when the payment is confirmed. A payment is applied to the oldest voucher first.</small>
                @endif
            </div></div>

            @if ($open->isNotEmpty())
            <form action="{{ route('fees.payments.store') }}" method="POST">
                @csrf
                <input type="hidden" name="student_id" value="{{ $student->id }}">
                <input type="hidden" name="submit_token" value="{{ $token }}">
                <div class="card"><div class="card-body"><div class="row">
                    <div class="col-lg-3 col-md-6"><div class="form-group"><label>Payment method <span class="text-danger">*</span></label>
                        <select name="method" id="pMethod" class="form-select @error('method') is-invalid @enderror">
                            @foreach (\App\Models\FeePayment::METHODS as $k => $l)<option value="{{ $k }}" @selected(old('method', 'cash') === $k)>{{ $l }}</option>@endforeach</select>
                        @error('method')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror</div></div>
                    <div class="col-lg-3 col-md-6"><div class="form-group"><label>Amount received (Rs.) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="1" name="amount" value="{{ old('amount', $dueToday) }}" required class="form-control @error('amount') is-invalid @enderror">
                        @error('amount')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror</div></div>
                    <div class="col-lg-3 col-md-6"><div class="form-group"><label>Payment date <span class="text-danger">*</span></label>
                        <input type="date" name="payment_date" value="{{ old('payment_date', $today) }}" max="{{ $today }}" required class="form-control @error('payment_date') is-invalid @enderror">
                        @error('payment_date')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror</div></div>
                    <div class="col-lg-3 col-md-6"><div class="form-group"><label>Pay this voucher first</label>
                        <select name="preferred_voucher_id" class="form-select"><option value="">Oldest dues first (recommended)</option>
                            @foreach ($open as $v)<option value="{{ $v->id }}" @selected((int) old('preferred_voucher_id', $voucherId) === $v->id)>{{ $v->voucher_number }} ({{ $v->period_label }})</option>@endforeach</select></div></div>

                    <div class="col-lg-3 col-md-6 bank-fields"><div class="form-group"><label>Bank name <span class="text-danger">*</span></label>
                        <input type="text" name="bank_name" value="{{ old('bank_name') }}" maxlength="100" class="form-control @error('bank_name') is-invalid @enderror">
                        @error('bank_name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror</div></div>
                    <div class="col-lg-3 col-md-6 bank-fields"><div class="form-group"><label>Branch</label><input type="text" name="branch" value="{{ old('branch') }}" maxlength="100" class="form-control"></div></div>
                    <div class="col-lg-3 col-md-6 bank-fields"><div class="form-group"><label>Deposit slip number <span class="text-danger">*</span></label>
                        <input type="text" name="reference_no" value="{{ old('reference_no') }}" maxlength="60" class="form-control @error('reference_no') is-invalid @enderror">
                        @error('reference_no')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror</div></div>

                    <div class="col-12"><div class="form-group"><label>Remarks</label><input type="text" name="remarks" value="{{ old('remarks') }}" maxlength="255" class="form-control"></div></div>
                </div></div></div>
                <button type="submit" class="btn btn-submit me-2" onclick="this.form.requestSubmit ? null : null;">Save payment</button>
                <a href="{{ route('fees.payments') }}" class="btn btn-cancel">Cancel</a>
            </form>
            <script>
                (function () {
                    var method = document.getElementById('pMethod');
                    function toggle() { document.querySelectorAll('.bank-fields').forEach(function (el) { el.style.display = method.value === 'cash' ? 'none' : ''; }); }
                    method.addEventListener('change', toggle); toggle();
                    // Disable the button after the first click so a double click cannot save twice.
                    document.querySelector('form[action="{{ route('fees.payments.store') }}"]').addEventListener('submit', function () {
                        this.querySelector('button[type=submit]').disabled = true;
                    });
                })();
            </script>
            @endif
        @endif
    </div>
</div>
@endsection
