@extends('backend.layouts.layout')
@section('title', 'Expenses & Dues - King TAS College')
@section('content')
@php $F = \App\Support\FeeHelper::class; @endphp
<div class="page-wrapper"><div class="content">
    <div class="page-header">
        <div class="page-title"><h4>Expenses &amp; Dues Payable</h4><h6>What the school spends and what it still has to pay.</h6></div>
        <div class="page-btn">
            <a href="{{ route('expenses.categories') }}" class="btn btn-cancel me-2">Categories</a>
            <a href="{{ route('expenses.index') }}" class="btn btn-cancel me-2">All Expenses</a>
            <a href="{{ route('expenses.create') }}" class="btn btn-added">Add Expense</a>
        </div>
    </div>

    {{-- Month switcher --}}
    <div class="d-flex align-items-center mb-3">
        <a href="{{ route('expenses.dashboard', ['month' => $stats['prev_month']]) }}" class="btn btn-sm btn-outline-primary">&laquo; Previous</a>
        <h5 class="mb-0 mx-3">{{ $stats['month_label'] }}</h5>
        @if ($stats['next_month'])
            <a href="{{ route('expenses.dashboard', ['month' => $stats['next_month']]) }}" class="btn btn-sm btn-outline-primary">Next &raquo;</a>
        @endif
    </div>

    @if ($stats['overdue_count'] > 0)
        <div class="alert alert-danger">{{ $stats['overdue_count'] }} bill(s) are past their due date, {{ $F::money($stats['overdue']) }} in total.
            <a href="{{ route('expenses.index', ['status' => 'overdue']) }}">View overdue bills</a></div>
    @endif

    <div class="row">
        <div class="col-xl-3 col-md-6 mb-3"><div class="card mb-0"><div class="card-body"><small class="text-muted">Expenses billed this month</small><h3 class="mt-1 mb-0">{{ $F::money($stats['billed']) }}</h3><small class="text-muted">By bill date</small></div></div></div>
        <div class="col-xl-3 col-md-6 mb-3"><div class="card mb-0"><div class="card-body"><small class="text-muted">Paid out this month</small><h3 class="mt-1 mb-0 text-danger">{{ $F::money($stats['paid_out']) }}</h3><small class="text-muted">Money that left the school</small></div></div></div>
        <div class="col-xl-3 col-md-6 mb-3"><div class="card mb-0"><div class="card-body"><small class="text-muted">Fees collected this month</small><h3 class="mt-1 mb-0 text-success">{{ $F::money($stats['collected']) }}</h3><small class="text-muted">From the fee module</small></div></div></div>
        <div class="col-xl-3 col-md-6 mb-3"><div class="card mb-0"><div class="card-body"><small class="text-muted">Fees collected − paid out</small><h3 class="mt-1 mb-0 {{ $stats['net'] < 0 ? 'text-danger' : 'text-success' }}">{{ $stats['net'] < 0 ? '−' : '' }}{{ $F::money(abs($stats['net'])) }}</h3><small class="text-muted">{{ $stats['net'] < 0 ? 'Spent more than collected' : 'Left after expenses' }}</small></div></div></div>
    </div>

    <div class="row">
        <div class="col-xl-6 col-md-6 mb-3"><div class="card mb-0"><div class="card-body"><small class="text-muted">Total dues payable (all months)</small><h3 class="mt-1 mb-0 text-danger">{{ $F::money($stats['payable']) }}</h3><a href="{{ route('expenses.index', ['status' => 'due']) }}" class="small">{{ $stats['open_count'] }} bill(s) still to pay</a></div></div></div>
        <div class="col-xl-6 col-md-6 mb-3"><div class="card mb-0"><div class="card-body"><small class="text-muted">Overdue dues</small><h3 class="mt-1 mb-0 text-danger">{{ $F::money($stats['overdue']) }}</h3><a href="{{ route('expenses.index', ['status' => 'overdue']) }}" class="small">{{ $stats['overdue_count'] }} bill(s) overdue</a></div></div></div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card"><div class="card-body">
                <h5 class="mb-3">Dues to pay next</h5>
                <div class="table-responsive"><table class="table table-sm mb-0">
                    <thead><tr><th>Due</th><th>Bill</th><th class="text-end">Balance</th></tr></thead>
                    <tbody>
                    @forelse ($stats['upcoming'] as $e)
                        <tr>
                            <td>{{ $e->due_date ? $e->due_date->format('d M Y') : 'No date' }} @if ($e->is_overdue)<span class="badge bg-danger">Overdue</span>@endif</td>
                            <td><a href="{{ route('expenses.show', $e) }}">{{ $e->title }}</a><div class="small text-muted">{{ $e->payee ?: $e->category?->name }}</div></td>
                            <td class="text-end text-danger"><strong>{{ $F::money($e->balance) }}</strong></td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center text-muted">Nothing is due. All bills are paid.</td></tr>
                    @endforelse
                    </tbody>
                </table></div>
            </div></div>
        </div>

        <div class="col-lg-6">
            <div class="card"><div class="card-body">
                <h5 class="mb-3">{{ $stats['month_label'] }} by category</h5>
                @forelse ($stats['categories'] as $c)
                    <div class="mb-2">
                        <div class="d-flex justify-content-between"><span>{{ $c['name'] }} <small class="text-muted">({{ $c['bills'] }})</small></span><strong>{{ $F::money($c['total']) }}</strong></div>
                        <div class="progress" style="height:6px"><div class="progress-bar" style="width: {{ $c['percent'] }}%"></div></div>
                    </div>
                @empty
                    <p class="text-muted mb-0">No expenses entered for this month.</p>
                @endforelse
            </div></div>
        </div>
    </div>

    <div class="card"><div class="card-body">
        <h5 class="mb-3">Last 6 months</h5>
        <div class="table-responsive"><table class="table table-sm mb-0">
            <thead><tr><th>Month</th><th class="text-end">Billed</th><th class="text-end">Paid out</th><th class="text-end">Fees collected</th><th class="text-end">Collected − paid out</th></tr></thead>
            <tbody>
            @foreach ($stats['trend'] as $t)
                @php $diff = $t['collected'] - $t['paid_out']; @endphp
                <tr>
                    <td>{{ $t['label'] }}</td>
                    <td class="text-end">{{ $F::money($t['billed']) }}</td>
                    <td class="text-end">{{ $F::money($t['paid_out']) }}</td>
                    <td class="text-end">{{ $F::money($t['collected']) }}</td>
                    <td class="text-end {{ $diff < 0 ? 'text-danger' : 'text-success' }}">{{ $diff < 0 ? '−' : '' }}{{ $F::money(abs($diff)) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table></div>
    </div></div>

    <div class="card"><div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3"><h5 class="mb-0">Recent expenses</h5><a href="{{ route('expenses.index') }}">View all</a></div>
        <div class="table-responsive"><table class="table table-sm mb-0">
            <thead><tr><th>Date</th><th>Bill</th><th>Category</th><th>Status</th><th class="text-end">Amount</th></tr></thead>
            <tbody>
            @forelse ($stats['recent'] as $e)
                <tr>
                    <td>{{ $e->expense_date->format('d M Y') }}</td>
                    <td><a href="{{ route('expenses.show', $e) }}">{{ $e->title }}</a><div class="small text-muted">{{ $e->payee }}</div></td>
                    <td>{{ $e->category?->name }}</td>
                    <td><span class="badge rounded-pill bg-{{ $e->status_color }}">{{ $e->status_label }}</span></td>
                    <td class="text-end">{{ $F::money($e->amount) }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted">No expenses yet. <a href="{{ route('expenses.create') }}">Add the first one</a>.</td></tr>
            @endforelse
            </tbody>
        </table></div>
    </div></div>
</div></div>
@endsection
