@extends('backend.layouts.layout')
@section('title', ($expense ? 'Edit Expense' : 'Add Expense') . ' - King TAS College')
@section('content')
@php
    $editing = (bool) $expense;
    $option = old('payment_option', 'unpaid');
@endphp
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>{{ $editing ? 'Edit Expense' : 'Add Expense' }}</h4>
                <h6>{{ $editing ? $expense->expense_number : 'Enter a bill. If it is not paid yet it is added to your dues.' }}</h6>
            </div>
        </div>

        <form action="{{ $editing ? route('expenses.update', $expense) : route('expenses.store') }}" method="POST" enctype="multipart/form-data" id="expenseForm">
            @csrf
            @if ($editing) @method('PUT') @else <input type="hidden" name="submit_token" value="{{ $token }}"> @endif

            <div class="card"><div class="card-body">
                <h5 class="mb-3">Bill details</h5>
                <div class="row">
                    <div class="col-lg-4 col-md-6"><div class="form-group">
                        <label>Category <span class="text-danger">*</span></label>
                        <select name="expense_category_id" required class="form-select @error('expense_category_id') is-invalid @enderror">
                            <option value="">Select category</option>
                            @foreach ($categories as $c)<option value="{{ $c->id }}" @selected((int) old('expense_category_id', $expense->expense_category_id ?? 0) === $c->id)>{{ $c->name }}</option>@endforeach
                        </select>
                        @error('expense_category_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        <a href="{{ route('expenses.categories') }}" class="small">Manage categories</a>
                    </div></div>

                    <div class="col-lg-4 col-md-6"><div class="form-group">
                        <label>Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" required maxlength="150" value="{{ old('title', $expense->title ?? '') }}" class="form-control @error('title') is-invalid @enderror" placeholder="e.g. October electricity bill">
                        @error('title')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div></div>

                    <div class="col-lg-4 col-md-6"><div class="form-group">
                        <label>Paid to (payee)</label>
                        <input type="text" name="payee" list="payeeList" maxlength="150" value="{{ old('payee', $expense->payee ?? '') }}" class="form-control @error('payee') is-invalid @enderror" placeholder="Vendor, landlord, staff member ...">
                        <datalist id="payeeList">@foreach ($payees as $p)<option value="{{ $p }}">@endforeach</datalist>
                        @error('payee')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div></div>

                    <div class="col-lg-3 col-md-6"><div class="form-group">
                        <label>Amount (Rs.) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="1" name="amount" id="amount" required value="{{ old('amount', $expense->amount ?? '') }}" class="form-control @error('amount') is-invalid @enderror">
                        @error('amount')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div></div>

                    <div class="col-lg-3 col-md-6"><div class="form-group">
                        <label>Bill date <span class="text-danger">*</span></label>
                        <input type="date" name="expense_date" id="expenseDate" required max="{{ $today }}" value="{{ old('expense_date', $editing ? $expense->expense_date->toDateString() : $today) }}" class="form-control @error('expense_date') is-invalid @enderror">
                        @error('expense_date')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div></div>

                    <div class="col-lg-3 col-md-6" id="dueDateBox"><div class="form-group">
                        <label>Due date</label>
                        <input type="date" name="due_date" value="{{ old('due_date', $editing ? $expense->due_date?->toDateString() : '') }}" class="form-control @error('due_date') is-invalid @enderror">
                        @error('due_date')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        <small class="text-muted">Last day to pay. Used to show overdue bills.</small>
                    </div></div>

                    <div class="col-lg-3 col-md-6"><div class="form-group">
                        <label>Bill / invoice no.</label>
                        <input type="text" name="reference_no" maxlength="60" value="{{ old('reference_no', $expense->reference_no ?? '') }}" class="form-control @error('reference_no') is-invalid @enderror">
                        @error('reference_no')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div></div>

                    <div class="col-lg-8"><div class="form-group">
                        <label>Notes</label>
                        <textarea name="description" rows="2" maxlength="1000" class="form-control @error('description') is-invalid @enderror">{{ old('description', $expense->description ?? '') }}</textarea>
                        @error('description')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div></div>

                    <div class="col-lg-4"><div class="form-group">
                        <label>Bill / receipt photo (PDF, JPG, PNG · max 4 MB)</label>
                        <input type="file" name="attachment" accept=".pdf,.jpg,.jpeg,.png" class="form-control @error('attachment') is-invalid @enderror">
                        @error('attachment')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        @if ($editing && $expense->attachment_path)
                            <div class="small mt-1">Current: <a href="{{ route('expenses.attachment', $expense) }}" target="_blank">{{ $expense->attachment_name }}</a>
                                <label class="ms-2"><input type="checkbox" name="remove_attachment" value="1"> remove</label></div>
                        @endif
                    </div></div>
                </div>
            </div></div>

            @unless ($editing)
            <div class="card"><div class="card-body">
                <h5 class="mb-3">Payment</h5>
                <div class="mb-3">
                    <label class="me-4"><input type="radio" name="payment_option" value="unpaid" @checked($option === 'unpaid')> Not paid yet <small class="text-muted">(adds to dues)</small></label>
                    <label class="me-4"><input type="radio" name="payment_option" value="paid" @checked($option === 'paid')> Paid in full</label>
                    <label><input type="radio" name="payment_option" value="partial" @checked($option === 'partial')> Paid partly</label>
                    @error('payment_option')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>

                <div class="row pay-fields">
                    <div class="col-lg-3 col-md-6 partial-field"><div class="form-group">
                        <label>Amount paid so far (Rs.) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="1" name="paid_amount" value="{{ old('paid_amount') }}" class="form-control @error('paid_amount') is-invalid @enderror">
                        @error('paid_amount')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div></div>
                    <div class="col-lg-3 col-md-6"><div class="form-group">
                        <label>Payment date <span class="text-danger">*</span></label>
                        <input type="date" name="payment_date" max="{{ $today }}" value="{{ old('payment_date', $today) }}" class="form-control @error('payment_date') is-invalid @enderror">
                        @error('payment_date')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div></div>
                    <div class="col-lg-3 col-md-6"><div class="form-group">
                        <label>Paid by <span class="text-danger">*</span></label>
                        <select name="payment_method" class="form-select @error('payment_method') is-invalid @enderror">
                            @foreach (\App\Models\ExpensePayment::METHODS as $k => $l)<option value="{{ $k }}" @selected(old('payment_method', 'cash') === $k)>{{ $l }}</option>@endforeach
                        </select>
                        @error('payment_method')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div></div>
                    <div class="col-lg-3 col-md-6"><div class="form-group">
                        <label>Cheque / transaction no.</label>
                        <input type="text" name="payment_reference" maxlength="60" value="{{ old('payment_reference') }}" class="form-control @error('payment_reference') is-invalid @enderror">
                    </div></div>
                </div>
            </div></div>
            @endunless

            <button type="submit" class="btn btn-submit me-2">{{ $editing ? 'Save changes' : 'Save expense' }}</button>
            <a href="{{ $editing ? route('expenses.show', $expense) : route('expenses.index') }}" class="btn btn-cancel">Cancel</a>
        </form>
    </div>
</div>

<script>
    (function () {
        var form = document.getElementById('expenseForm');

        @unless ($editing)
        function sync() {
            var opt = form.querySelector('input[name=payment_option]:checked').value;
            form.querySelector('.pay-fields').style.display = opt === 'unpaid' ? 'none' : '';
            form.querySelectorAll('.partial-field').forEach(function (el) { el.style.display = opt === 'partial' ? '' : 'none'; });
            document.getElementById('dueDateBox').style.display = opt === 'paid' ? 'none' : '';
        }
        form.querySelectorAll('input[name=payment_option]').forEach(function (r) { r.addEventListener('change', sync); });
        sync();
        @endunless

        // Disable the button after the first click so a double click cannot save twice.
        form.addEventListener('submit', function () {
            var btn = form.querySelector('button[type=submit]');
            setTimeout(function () { btn.disabled = true; }, 0);
        });
    })();
</script>
@endsection
