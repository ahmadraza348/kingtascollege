@extends('backend.layouts.layout')
@section('title', 'Expense - King TAS College')
@section('content')
@php
    $F = \App\Support\FeeHelper::class;
    $tz = config('fees.timezone');
    $isOpen = in_array($expense->status, \App\Models\Expense::OPEN, true);
@endphp
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title"><h4>{{ $expense->title }}</h4><h6>{{ $expense->expense_number }}</h6></div>
            <div class="page-btn">
                @if ($expense->status !== 'cancelled')<a href="{{ route('expenses.edit', $expense) }}" class="btn btn-added me-2">Edit</a>@endif
                <a href="{{ route('expenses.index') }}" class="btn btn-cancel">Back</a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-5">
                <div class="card"><div class="card-body">
                    <span class="badge rounded-pill bg-{{ $expense->status_color }} mb-2">{{ $expense->status_label }}</span>
                    @if ($expense->is_overdue)<span class="badge rounded-pill bg-danger mb-2">Overdue</span>@endif

                    <div class="row g-2 mb-3">
                        <div class="col-4"><div class="border rounded p-2"><small class="text-muted">Amount</small><div><strong>{{ $F::money($expense->amount) }}</strong></div></div></div>
                        <div class="col-4"><div class="border rounded p-2"><small class="text-muted">Paid</small><div class="text-success"><strong>{{ $F::money($expense->paid_amount) }}</strong></div></div></div>
                        <div class="col-4"><div class="border rounded p-2"><small class="text-muted">Balance</small><div class="{{ $expense->balance > 0 ? 'text-danger' : '' }}"><strong>{{ $F::money($expense->balance) }}</strong></div></div></div>
                    </div>

                    <div>Category: <strong>{{ $expense->category?->name }}</strong></div>
                    @if ($expense->payee)<div>Paid to: <strong>{{ $expense->payee }}</strong></div>@endif
                    <div>Bill date: <strong>{{ $expense->expense_date->format('d M Y') }}</strong></div>
                    <div>Due date: <strong>{{ $expense->due_date ? $expense->due_date->format('d M Y') : '—' }}</strong></div>
                    @if ($expense->reference_no)<div>Bill / invoice no.: <strong>{{ $expense->reference_no }}</strong></div>@endif
                    @if ($expense->description)<div class="mt-2">{{ $expense->description }}</div>@endif
                    @if ($expense->attachment_path)<div class="mt-2">Attachment: <a href="{{ route('expenses.attachment', $expense) }}" target="_blank">{{ $expense->attachment_name ?: 'View file' }}</a></div>@endif
                    <div class="text-muted small mt-2">Entered by {{ $expense->creator?->full_name ?: '—' }} on {{ $expense->created_at->timezone($tz)->format('d M Y, h:i A') }}</div>
                    @if ($expense->status === 'cancelled')<div class="text-danger mt-2">Cancelled: {{ $expense->status_reason }}</div>@endif
                </div></div>

                @if ($isOpen)
                <div class="card"><div class="card-body">
                    <h5 class="mb-3">Record a payment</h5>
                    <form action="{{ route('expenses.payments.store', $expense) }}" method="POST" id="payForm">
                        @csrf
                        <input type="hidden" name="submit_token" value="{{ $token }}">
                        <div class="form-group"><label>Amount (Rs.) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="1" max="{{ $expense->balance }}" name="amount" required value="{{ old('amount', $expense->balance) }}" class="form-control @error('amount') is-invalid @enderror">
                            <small class="text-muted">Balance due: {{ $F::money($expense->balance) }}</small>
                            @error('amount')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror</div>
                        <div class="form-group"><label>Payment date <span class="text-danger">*</span></label>
                            <input type="date" name="payment_date" required min="{{ $expense->expense_date->toDateString() }}" max="{{ $today }}" value="{{ old('payment_date', $today) }}" class="form-control @error('payment_date') is-invalid @enderror">
                            @error('payment_date')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror</div>
                        <div class="form-group"><label>Paid by <span class="text-danger">*</span></label>
                            <select name="method" class="form-select @error('method') is-invalid @enderror">
                                @foreach (\App\Models\ExpensePayment::METHODS as $k => $l)<option value="{{ $k }}" @selected(old('method', 'cash') === $k)>{{ $l }}</option>@endforeach</select>
                            @error('method')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror</div>
                        <div class="form-group"><label>Cheque / transaction no.</label>
                            <input type="text" name="reference_no" maxlength="60" value="{{ old('reference_no') }}" class="form-control"></div>
                        <div class="form-group"><label>Remarks</label>
                            <input type="text" name="remarks" maxlength="255" value="{{ old('remarks') }}" class="form-control"></div>
                        <button class="btn btn-submit">Save payment</button>
                    </form>
                    <script>
                        document.getElementById('payForm').addEventListener('submit', function () {
                            var b = this.querySelector('button'); setTimeout(function () { b.disabled = true; }, 0);
                        });
                    </script>
                </div></div>
                @endif

                @if ($expense->status !== 'cancelled' && $expense->payments->where('status', 'active')->isEmpty())
                <div class="card"><div class="card-body">
                    <details><summary class="text-danger" style="cursor:pointer">Cancel this expense (entered by mistake)</summary>
                        <form action="{{ route('expenses.cancel', $expense) }}" method="POST" class="mt-2" onsubmit="return confirm('Cancel this expense?');">@csrf
                            <input type="text" name="reason" class="form-control mb-2" required maxlength="255" placeholder="Reason">
                            @error('reason')<div class="text-danger small mb-2">{{ $message }}</div>@enderror
                            <button class="btn btn-sm btn-danger">Cancel expense</button></form></details>
                </div></div>
                @endif
            </div>

            <div class="col-lg-7">
                <div class="card"><div class="card-body">
                    <h5 class="mb-3">Payments made</h5>
                    <div class="table-responsive"><table class="table table-sm mb-0">
                        <thead><tr><th>Date</th><th>Method</th><th>Reference</th><th>Status</th><th class="text-end">Amount</th></tr></thead>
                        <tbody>
                        @forelse ($expense->payments as $p)
                            <tr class="{{ $p->status === 'cancelled' ? 'text-muted' : '' }}">
                                <td>{{ $p->payment_date->format('d M Y') }}<div class="small text-muted">by {{ $p->creator?->full_name ?: '—' }}</div></td>
                                <td>{{ $p->method_label }}</td>
                                <td>{{ $p->reference_no ?: '—' }}@if ($p->remarks)<div class="small text-muted">{{ $p->remarks }}</div>@endif</td>
                                <td>
                                    @if ($p->status === 'active')<span class="badge bg-success">Paid</span>
                                    @else<span class="badge bg-secondary">Cancelled</span><div class="small">{{ $p->cancel_reason }}</div>@endif
                                </td>
                                <td class="text-end {{ $p->status === 'cancelled' ? 'text-decoration-line-through' : '' }}">{{ $F::money($p->amount) }}</td>
                            </tr>
                            @if ($p->status === 'active')
                            <tr><td colspan="5" class="border-0 pt-0 pb-2 text-end">
                                <details><summary class="small text-danger d-inline-block" style="cursor:pointer">Cancel this payment</summary>
                                    <form action="{{ route('expenses.payments.cancel', $p) }}" method="POST" class="mt-1 d-flex justify-content-end gap-2" onsubmit="return confirm('Cancel this payment? The amount becomes due again.');">@csrf
                                        <input type="text" name="reason" required maxlength="255" class="form-control form-control-sm w-50" placeholder="Reason (e.g. bounced cheque)">
                                        <button class="btn btn-sm btn-danger">Cancel payment</button></form></details>
                            </td></tr>
                            @endif
                        @empty
                            <tr><td colspan="5" class="text-center text-muted">No payments recorded yet.</td></tr>
                        @endforelse
                        </tbody>
                    </table></div>
                </div></div>
            </div>
        </div>
    </div>
</div>
@endsection
