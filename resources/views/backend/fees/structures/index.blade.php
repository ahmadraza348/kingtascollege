@extends('backend.layouts.layout')
@section('title', 'Class-wise Fee Amounts - King TAS College')
@section('content')
@php $F = \App\Support\FeeHelper::class; @endphp
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title"><h4>Class-wise Fee Amounts</h4><h6>Set the fee amounts students in each class pay for a session.</h6></div>
            <div class="page-btn"><a href="{{ route('fees.structures.create') }}" class="btn btn-added">Set class fees</a></div>
        </div>
        <div class="card"><div class="card-body"><div class="table-responsive">
            <table class="table">
                <thead><tr><th>Class</th><th>Session</th><th>Name</th><th class="text-end">Total fee amounts</th><th>Status</th><th>Action</th></tr></thead>
                <tbody>
                @forelse ($structures as $s)
                    <tr>
                        <td><strong>{{ $s->schoolClass->name }}</strong></td>
                        <td>{{ $s->session }}</td>
                        <td>{{ $s->name }}</td>
                        <td class="text-end">{{ $F::money($s->total) }}</td>
                        <td><span class="badge rounded-pill bg-{{ $s->is_active ? 'success' : 'secondary' }}">{{ $s->is_active ? 'Active' : 'Inactive' }}</span></td>
                        <td class="text-nowrap">
                            <a href="{{ route('fees.structures.edit', $s) }}" class="me-3">Edit</a>
                            <form action="{{ route('fees.structures.destroy', $s) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-link p-0 text-danger" onclick="return confirm('Delete this fee structure? Existing vouchers are not affected.');">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">No class fees have been set yet. Add the fee amounts for each class before creating vouchers.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div></div></div>
    </div>
</div>
@endsection