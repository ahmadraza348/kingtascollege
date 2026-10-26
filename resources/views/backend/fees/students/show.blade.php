@extends('backend.layouts.layout')
@section('title', 'Student Fee Status - ' . $student->full_name)
@section('content')
@php $F = \App\Support\FeeHelper::class; @endphp
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title"><h4>{{ $student->full_name }}</h4><h6>{{ $student->roll_number }} · {{ $student->schoolClass->name }} / {{ $student->section->name }}</h6></div>
            <div class="page-btn">
                <a href="{{ route('fees.payments.create', ['student' => $student->id]) }}" class="btn btn-submit me-2">Receive payment</a>
                <a href="{{ route('fees.vouchers.create', ['student' => $student->id]) }}" class="btn btn-added me-2">New voucher</a>
                <a href="{{ route('fees.accounts.statement', $student) }}" target="_blank" class="btn btn-added me-2">Statement (PDF)</a>
                <a href="{{ route('student.show', $student) }}" class="btn btn-cancel">Student profile</a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3"><div class="card mb-0 text-center"><div class="card-body py-3"><h4 class="mb-0">{{ $F::money($statement['debit']) }}</h4><small class="text-muted">Total charged</small></div></div></div>
            <div class="col-md-4 mb-3"><div class="card mb-0 text-center"><div class="card-body py-3"><h4 class="mb-0 text-success">{{ $F::money($statement['credit']) }}</h4><small class="text-muted">Paid / discounts</small></div></div></div>
            <div class="col-md-4 mb-3"><div class="card mb-0 text-center"><div class="card-body py-3"><h4 class="mb-0 {{ $statement['balance'] > 0 ? 'text-danger' : 'text-success' }}">{{ $F::money($statement['balance']) }}</h4><small class="text-muted">Remaining balance</small></div></div></div>
        </div>

        @if ($statement['pending']->isNotEmpty())
            <div class="alert alert-warning">{{ $statement['pending']->count() }} bank deposit(s) are waiting for verification and are not counted yet:
                @foreach ($statement['pending'] as $p)<a href="{{ route('fees.payments.show', $p) }}">{{ $F::money($p->amount) }}</a>{{ ! $loop->last ? ',' : '' }}@endforeach</div>
        @endif

        <div class="row">
            <div class="col-lg-12">
                <div class="card"><div class="card-body">
                    <h5 class="mb-3">Statement</h5>
                    <div class="table-responsive"><table class="table table-sm">
                        <thead><tr><th>Date</th><th>Details</th><th class="text-end">Charged</th><th class="text-end">Paid / Less</th><th class="text-end">Balance</th></tr></thead>
                        <tbody>
                        @forelse ($statement['rows'] as $r)
                            <tr><td class="text-nowrap">{{ date('d M Y', strtotime($r['date'])) }}</td><td>{{ $r['text'] }}</td>
                                <td class="text-end">{{ $r['debit'] ? $F::number($r['debit']) : '' }}</td>
                                <td class="text-end text-success">{{ $r['credit'] ? $F::number($r['credit']) : '' }}</td>
                                <td class="text-end"><strong>{{ $F::number($r['balance']) }}</strong></td></tr>
                        @empty<tr><td colspan="5" class="text-center text-muted">No fee history yet.</td></tr>@endforelse
                        </tbody>
                    </table></div>
                </div></div>

                <div class="card"><div class="card-body">
                    <h5 class="mb-3">Fee vouchers and status</h5>
                    <div class="table-responsive"><table class="table table-sm">
                        <thead><tr><th>Voucher</th><th>Month</th><th>Due</th><th class="text-end">Total</th><th class="text-end">Balance</th><th>Status</th></tr></thead>
                        <tbody>
                        @foreach ($vouchers as $v)
                            <tr><td><a href="{{ route('fees.vouchers.show', $v) }}">{{ $v->voucher_number }}</a></td><td>{{ $v->period_label }}</td><td>{{ $v->due_date->format('d M Y') }}</td>
                                <td class="text-end">{{ $F::number($v->total_amount) }}</td><td class="text-end">{{ $F::number($v->balance) }}</td>
                                <td><span class="badge rounded-pill bg-{{ $v->status_color }}">{{ $v->status_label }}</span></td></tr>
                        @endforeach
                        </tbody>
                    </table></div>
                </div></div>
            </div>

        </div>
    </div>
</div>
@endsection
