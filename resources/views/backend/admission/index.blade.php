@extends('backend.layouts.layout')
@section('title', 'Admissions - King TAS College')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Admission Applications</h4>
                <h6>Review, verify and process student applications.</h6>
            </div>
            <div class="page-btn">
                <a href="{{ route('admission.export', ['status' => $status]) }}" class="btn btn-added">
                    <img src="{{ asset('backend/assets/img/icons/excel.svg') }}" alt="" class="me-1"> Export CSV
                </a>
            </div>
        </div>

        {{-- Status cards: click one to filter the list --}}
        <div class="row">
            <div class="col-6 col-md-4 col-xl-2 mb-3">
                <a href="{{ route('admission.index') }}" class="card h-100 mb-0 text-center text-decoration-none {{ ! $status ? 'border-dark' : '' }}">
                    <div class="card-body py-3">
                        <h3 class="mb-0">{{ $counts->sum() }}</h3>
                        <small class="text-muted">All</small>
                    </div>
                </a>
            </div>
            @foreach (\App\Models\Admission::STATUSES as $key => $label)
                <div class="col-6 col-md-4 col-xl-2 mb-3">
                    <a href="{{ route('admission.index', ['status' => $key]) }}"
                       class="card h-100 mb-0 text-center text-decoration-none {{ $status === $key ? 'border-' . \App\Models\Admission::STATUS_COLORS[$key] : '' }}">
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
                <div class="table-responsive">
                    <table class="table datanew">
                        <thead>
                            <tr>
                                <th>Applicant</th>
                                <th>Program</th>
                                <th>Phone</th>
                                <th>Marks %</th>
                                <th>Docs verified</th>
                                <th>Status</th>
                                <th>Submitted</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($admissions as $item)
                            @php
                                $docs = $item->documents()->where('required', true);
                                $verified = $docs->filter(fn ($d) => $item->isDocumentVerified($d['key']))->count();
                            @endphp
                            <tr>
                                <td>
                                    <a href="{{ route('admission.show', $item) }}" class="d-flex align-items-center text-decoration-none">
                                        <img src="{{ route('admission.document', [$item, 'photo']) }}" alt=""
                                             class="rounded-circle me-2" style="width:38px;height:38px;object-fit:cover;">
                                        <span>
                                            <strong>{{ $item->full_name }}</strong><br>
                                        </span>
                                    </a>
                                </td>
                                <td>{{ $item->program }}</td>
                                <td>{{ $item->phone }}</td>
                                <td>{{ $item->percentage !== null ? rtrim(rtrim($item->percentage, '0'), '.') . '%' : '—' }}</td>
                                <td data-order="{{ $verified }}">
                                    <span class="badge rounded-pill bg-{{ $verified === $docs->count() ? 'success' : 'light text-dark' }}">
                                        {{ $verified }}/{{ $docs->count() }}
                                    </span>
                                </td>
                                <td><span class="badge rounded-pill bg-{{ $item->status_color }}">{{ $item->status_label }}</span></td>
                                <td data-order="{{ $item->created_at->timestamp }}">{{ $item->created_at->format('d M Y') }}</td>
                                <td class="text-nowrap">
                                    <a href="{{ route('admission.show', $item) }}" class="me-3" title="Open"><img src="{{ asset('backend/assets/img/icons/eye.svg') }}" alt="Open"></a>
                                    <!-- <form action="{{ route('admission.destroy', $item) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-link p-0" title="Delete"
                                                onclick="return confirm('Delete this application and all its documents? This cannot be undone.');">
                                            <img src="{{ asset('backend/assets/img/icons/delete.svg') }}" alt="Delete">
                                        </button>
                                    </form> -->
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
