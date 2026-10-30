@extends('backend.layouts.layout')
@section('title', ($plan ? 'Change Fee Plan' : 'Set Up Fee Plan') . ' - ' . $student->full_name)
@section('content')
@php
    $F = \App\Support\FeeHelper::class;
    $initialRows = old('installments', $rows);
@endphp
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>{{ $plan ? 'Change fee plan' : 'Set up fee plan' }} — {{ $student->full_name }}</h4>
                <h6>Roll No {{ $student->roll_number }} · {{ $student->schoolClass->name }} / {{ $student->section->name }}@if ($student->session) · Session {{ $student->session }}@endif</h6>
            </div>
        </div>

        <form action="{{ $plan ? route('fees.plans.update', $student) : route('fees.plans.store', $student) }}" method="POST" id="planForm">
            @csrf
            @if ($plan) @method('PUT') @endif

            <div class="card"><div class="card-body"><div class="row">
                <div class="col-lg-3 col-md-6"><div class="form-group"><label>Total course fee (Rs.) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" min="1" name="total_fee" id="totalFee" value="{{ old('total_fee', $plan?->total_fee) }}" required class="form-control @error('total_fee') is-invalid @enderror">
                    @error('total_fee')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror</div></div>
                <div class="col-lg-3 col-md-6"><div class="form-group"><label>Discount / scholarship (Rs.)</label>
                    <input type="number" step="0.01" min="0" name="discount" id="discount" value="{{ old('discount', $plan ? (float) $plan->discount : 0) }}" class="form-control @error('discount') is-invalid @enderror">
                    @error('discount')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror</div></div>
                <div class="col-lg-3 col-md-6"><div class="form-group"><label>Total payable (Rs.)</label>
                    <input type="text" id="netFee" class="form-control" readonly></div></div>
                <div class="col-lg-3 col-md-6"><div class="form-group"><label>Note</label>
                    <input type="text" name="notes" value="{{ old('notes', $plan?->notes) }}" maxlength="255" class="form-control" placeholder="Optional"></div></div>
            </div></div></div>

            @if ($locked->isNotEmpty())
                <div class="card"><div class="card-body">
                    <h5 class="mb-1">Installments that already have payments</h5>
                    <p class="text-muted small">These stay as they are. Only the unpaid installments below can be changed.</p>
                    <table class="table table-sm mb-0">
                        @foreach ($locked as $v)
                            <tr><td>Installment {{ $v->installment_no }}</td><td>Due {{ $v->due_date->format('d M Y') }}</td>
                                <td class="text-end">{{ $F::number(app(\App\Services\Admin\FeePlanService::class)->baseAmount($v)) }}</td>
                                <td><span class="badge rounded-pill bg-{{ $v->status_color }}">{{ $v->status_label }}</span></td></tr>
                        @endforeach
                    </table>
                </div></div>
            @endif

            <div class="card"><div class="card-body">
                <h5 class="mb-3">{{ $locked->isNotEmpty() ? 'Remaining installments' : 'Installments' }}</h5>

                <div class="row align-items-end mb-3 p-3 rounded" style="background:#f8f9fa">
                    <div class="col-lg-3 col-md-4"><div class="form-group mb-0"><label>Split into</label>
                        <input type="number" min="1" max="60" id="count" value="4" class="form-control"></div></div>
                    <div class="col-lg-3 col-md-4"><div class="form-group mb-0"><label>First due date</label>
                        <input type="date" id="firstDue" value="{{ $today }}" class="form-control"></div></div>
                    <div class="col-lg-3 col-md-4"><div class="form-group mb-0"><label>Every</label>
                        <select id="interval" class="form-select"><option value="1">1 month</option><option value="2">2 months</option><option value="3">3 months</option><option value="6">6 months</option></select></div></div>
                    <div class="col-lg-3 mt-2 mt-lg-0"><button type="button" id="generate" class="btn btn-added w-100">Create equal installments</button></div>
                </div>

                <div class="table-responsive"><table class="table" id="rowsTable">
                    <thead><tr><th style="width:60px">#</th><th>Amount (Rs.)</th><th>Due date</th><th style="width:60px"></th></tr></thead>
                    <tbody></tbody>
                </table></div>
                @error('installments.*.amount')<div class="text-danger small">{{ $message }}</div>@enderror
                @error('installments.*.due_date')<div class="text-danger small">{{ $message }}</div>@enderror

                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <button type="button" id="addRow" class="btn btn-sm btn-added">+ Add installment</button>
                    <div id="sumBox" class="fw-bold"></div>
                </div>
            </div></div>

            <div class="alert alert-info">Each installment becomes a fee voucher with its own due date. Students can pay any installment in cash or by bank deposit; the account book shows what is paid and what remains.@if ($plan) Changing the plan replaces only the unpaid installments.@endif</div>

            <button type="submit" id="saveBtn" class="btn btn-submit me-2">{{ $plan ? 'Save changes' : 'Save fee plan' }}</button>
            <a href="{{ route('fees.accounts.show', $student) }}" class="btn btn-cancel">Cancel</a>
        </form>
    </div>
</div>
<script>
(function () {
    var lockedSum = {{ json_encode((float) $lockedSum) }};
    var initial = @json(array_values($initialRows));
    var tbody = document.querySelector('#rowsTable tbody');
    var total = document.getElementById('totalFee'), disc = document.getElementById('discount'), net = document.getElementById('netFee');
    var sumBox = document.getElementById('sumBox'), saveBtn = document.getElementById('saveBtn');

    function paisa(v) { return Math.round((parseFloat(v) || 0) * 100); }
    function money(p) { return 'Rs. ' + (p / 100).toLocaleString('en-US', { minimumFractionDigits: p % 100 ? 2 : 0 }); }
    function target() { return paisa(total.value) - paisa(disc.value) - paisa(lockedSum); }

    function renumber() { Array.prototype.forEach.call(tbody.rows, function (tr, i) { tr.cells[0].textContent = i + 1; }); }

    function addRow(amount, due) {
        var tr = tbody.insertRow();
        tr.insertCell().textContent = '';
        var i = tbody.rows.length - 1;
        tr.insertCell().innerHTML = '<input type="number" step="0.01" min="0" class="form-control amt" name="installments[' + i + '][amount]">';
        tr.insertCell().innerHTML = '<input type="date" class="form-control due" name="installments[' + i + '][due_date]">';
        tr.insertCell().innerHTML = '<button type="button" class="btn btn-sm btn-danger rm">×</button>';
        tr.querySelector('.amt').value = amount == null ? '' : amount;
        tr.querySelector('.due').value = due || '';
        renumber(); refresh();
    }

    function reindex() {
        Array.prototype.forEach.call(tbody.rows, function (tr, i) {
            tr.querySelector('.amt').name = 'installments[' + i + '][amount]';
            tr.querySelector('.due').name = 'installments[' + i + '][due_date]';
        });
    }

    function refresh() {
        var netP = paisa(total.value) - paisa(disc.value);
        net.value = netP > 0 ? (netP / 100).toFixed(2) : '';
        var sum = 0;
        tbody.querySelectorAll('.amt').forEach(function (a) { sum += paisa(a.value); });
        var diff = target() - sum;
        if (!tbody.rows.length) { sumBox.textContent = ''; saveBtn.disabled = false; return; }
        if (diff === 0) { sumBox.className = 'fw-bold text-success'; sumBox.textContent = 'Installments total ' + money(sum) + ' ✓'; saveBtn.disabled = false; }
        else { sumBox.className = 'fw-bold text-danger'; sumBox.textContent = 'Installments total ' + money(sum) + ' — ' + (diff > 0 ? money(diff) + ' still to assign' : money(-diff) + ' too much'); saveBtn.disabled = true; }
    }

    function addMonths(dateStr, m) {
        var p = dateStr.split('-'), y = +p[0], mo = +p[1] - 1 + m, d = +p[2];
        var last = new Date(y, mo + 1, 0); // last day of the target month
        var dt = new Date(last.getFullYear(), last.getMonth(), Math.min(d, last.getDate()));
        return dt.getFullYear() + '-' + String(dt.getMonth() + 1).padStart(2, '0') + '-' + String(dt.getDate()).padStart(2, '0');
    }

    document.getElementById('generate').addEventListener('click', function () {
        var t = target(), n = Math.max(1, Math.min(60, parseInt(document.getElementById('count').value) || 1));
        var first = document.getElementById('firstDue').value, step = parseInt(document.getElementById('interval').value);
        if (t <= 0) { alert('Enter the total fee first.'); return; }
        if (!first) { alert('Choose the first due date.'); return; }
        tbody.innerHTML = '';
        var base = Math.floor(t / n), rest = t - base * n;
        for (var i = 0; i < n; i++) addRow(((base + (i === 0 ? rest : 0)) / 100).toFixed(2), addMonths(first, i * step));
    });
    document.getElementById('addRow').addEventListener('click', function () { addRow('', ''); });
    tbody.addEventListener('click', function (e) {
        if (e.target.classList.contains('rm')) { e.target.closest('tr').remove(); renumber(); reindex(); refresh(); }
    });
    tbody.addEventListener('input', refresh);
    [total, disc].forEach(function (el) { el.addEventListener('input', refresh); });

    initial.forEach(function (r) { addRow(r.amount, r.due_date); });
    refresh();
})();
</script>
@endsection
