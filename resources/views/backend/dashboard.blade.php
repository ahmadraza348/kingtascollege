@extends('backend.layouts.layout')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title"><h4>Dashboard</h4><h6>Admissions overview</h6></div>
        </div>

        <div class="row">
            <div class="col-6 col-md-4 col-xl-2 mb-3">
                <a href="{{ route('admission.index') }}" class="card h-100 mb-0 text-center text-decoration-none">
                    <div class="card-body py-3"><h3 class="mb-0">{{ $counts->sum() }}</h3><small class="text-muted">All applications</small></div>
                </a>
            </div>
            @foreach (\App\Models\Admission::STATUSES as $key => $label)
                <div class="col-6 col-md-4 col-xl-2 mb-3">
                    <a href="{{ route('admission.index', ['status' => $key]) }}" class="card h-100 mb-0 text-center text-decoration-none">
                        <div class="card-body py-3">
                            <h3 class="mb-0 text-{{ \App\Models\Admission::STATUS_COLORS[$key] }}">{{ $counts[$key] ?? 0 }}</h3>
                            <small class="text-muted">{{ $label }}</small>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Latest applications</h5>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead><tr><th>Form No</th><th>Name</th><th>Program</th><th>Status</th><th>Submitted</th></tr></thead>
                        <tbody>
                        @forelse ($recentAdmissions as $item)
                            <tr>
                                <td><a href="{{ route('admission.show', $item) }}">{{ $item->form_number }}</a></td>
                                <td>{{ $item->full_name }}</td>
                                <td>{{ $item->program }}</td>
                                <td><span class="badge rounded-pill bg-{{ $item->status_color }}">{{ $item->status_label }}</span></td>
                                <td>{{ $item->created_at->format('d M Y, h:i A') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted">No applications yet.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
