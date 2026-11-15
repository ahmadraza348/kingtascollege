@extends('backend.layouts.layout')
@section('title', 'Expenses - King TAS College')
@section('content')
@php
    $F = \App\Support\FeeHelper::class;
    $current = $filters['status'] ?? '';
    $tab = fn ($key, $label, $count, $color) => '<a href="' . route('expenses.index', $key === '' ? [] : ['status' => $key]) . '" class="btn btn-sm me-1 mb-1 ' . ($current === $key ? "btn-$color" : "btn-outline-$color") . '">' . $label . ($count !== null ? " ($count)" : '') . '</a>';
    $openCount = ($counts['unpaid'] ?? 0) + ($counts['partial'] ?? 0);
@endphp
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title"><h4>Expenses &amp; Dues</h4><h6>Every bill the school has to pay or has paid.</h6></div>
            <div class="page-btn">
                <a href="{{ route('expenses.export', request()->query()) }}" class="btn btn-cancel me-2">Export to Excel</a>
                <a href="{{ route('expenses.create') }}" class="btn btn-added">Add Expense</a>
            </div>
        </div>

        <div class="mb-3">
            {!! $tab('', 'All', null, 'primary') !!}
            {!! $tab('due', 'Dues payable', $openCount, 'danger') !!}
            {!! $tab('overdue', 'Overdue', $overdueCount, 'danger') !!}
            {!! $tab('unpaid', 'Unpaid', $counts['unpaid'] ?? 0, 'danger') !!}
            {!! $tab('partial', 'Partly paid', $counts['partial'] ?? 0, 'warning') !!}
            {!! $tab('paid', 'Paid', $counts['paid'] ?? 0, 'success') !!}
            {!! $tab('cancelled', 'Cancelled', $counts['cancelled'] ?? 0, 'secondary') !!}
        </div>

        <div class="card"><div class="card-body">
            <form action="{{ route('expenses.index') }}" method="GET" class="row align-items-end">
                @if ($current !== '')<input type="hidden" name="status" value="{{ $current }}">@endif
                <div class="col-lg-3 col-md-6"><div class="form-group"><label>Search</label><input type="text" name="q" value="{{ $filters['q'] ?? '' }}" class="form-control" placeholder="Title, payee, bill no"></div></div>
                <div class="col-lg-3 col-md-6"><div class="form-group"><label>Category</label><select name="category" class="form-select"><option value="">All</option>
                    @foreach ($categories as $c)<option value="{{ $c->id }}" @selected((int) ($filters['category'] ?? 0) === $c->id)>{{ $c->name }}</option>@endforeach</select></div></div>
                <div class="col-lg-2 col-md-6"><div class="form-group"><label>From</label><input type="date" name="from" value="{{ $filters['from'] ?? '' }}" class="form-control"></div></div>
                <div class="col-lg-2 col-md-6"><div class="form-group"><label>To</label><input type="date" name="to" value="{{ $filters['to'] ?? '' }}" class="form-control"></div></div>
                <div class="col-lg-2 col-12"><div class="form-group"><button class="btn btn-submit me-1">Filter</button><a href="{{ route('expenses.index') }}" class="btn btn-cancel">Reset</a></div></div>
            </form>
        </div></div>

        <div class="row">
            <div class="col-md-4 mb-3"><div class="card mb-0"><div class="card-body py-2"><small class="text-muted">Total billed (matching)</small><h5 class="mb-0">{{ $F::money($totals['amount']) }}</h5></div></div></div>
            <div class="col-md-4 mb-3"><div class="card mb-0"><div class="card-body py-2"><small class="text-muted">Paid</small><h5 class="mb-0 text-success">{{ $F::money($totals['paid']) }}</h5></div></div></div>
            <div class="col-md-4 mb-3"><div class="card mb-0"><div class="card-body py-2"><small class="text-muted">Still to pay</small><h5 class="mb-0 text-danger">{{ $F::money($totals['balance']) }}</h5></div></div></div>
        </div>

        <div class="card"><div class="card-body">
            <div class="table-responsive"><table class="table">
                <thead><tr><th>Date</th><th>Expense</th><th>Category</th><th>Due date</th><th>Status</th><th class="text-end">Amount</th><th class="text-end">Balance</th><th></th></tr></thead>
                <tbody>
                @forelse ($expenses as $e)
                    <tr>
                        <td>{{ $e->expense_date->format('d M Y') }}</td>
                        <td><a href="{{ route('expenses.show', $e) }}">{{ $e->title }}</a>
                            <div class="small text-muted">{{ $e->expense_number }}@if ($e->payee) · {{ $e->payee }}@endif</div></td>
                        <td>{{ $e->category?->name }}</td>
                        <td>{{ $e->due_date ? $e->due_date->format('d M Y') : '—' }} @if ($e->is_overdue)<span class="badge bg-danger">Overdue</span>@endif</td>
                        <td><span class="badge rounded-pill bg-{{ $e->status_color }}">{{ $e->status_label }}</span></td>
                        <td class="text-end">{{ $F::money($e->amount) }}</td>
                        <td class="text-end {{ $e->balance > 0 ? 'text-danger' : '' }}">{{ $e->balance > 0 ? $F::money($e->balance) : '—' }}</td>
                        <td><a href="{{ route('expenses.show', $e) }}">{{ in_array($e->status, \App\Models\Expense::OPEN, true) ? 'Pay' : 'Open' }}</a></td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center text-muted py-4">No expenses found.</td></tr>
                @endforelse
                </tbody>
            </table></div>
            {{ $expenses->links('pagination::bootstrap-5') }}
        </div></div>
    </div>
</div>
@endsection
