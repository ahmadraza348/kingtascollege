@extends('backend.layouts.layout')
@section('title', 'Check Import - King TAS College')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Check before importing</h4>
                <h6>Nothing has been saved yet.</h6>
            </div>
            <div class="page-btn">
                <a href="{{ route('student.import') }}" class="btn btn-cancel">Upload a different file</a>
            </div>
        </div>

        <div class="row">
            <div class="col-4 mb-3"><div class="card h-100 mb-0 text-center"><div class="card-body py-3"><h3 class="mb-0">{{ $total }}</h3><small class="text-muted">Rows found</small></div></div></div>
            <div class="col-4 mb-3"><div class="card h-100 mb-0 text-center"><div class="card-body py-3"><h3 class="mb-0 text-success">{{ $valid }}</h3><small class="text-muted">Ready to import</small></div></div></div>
            <div class="col-4 mb-3"><div class="card h-100 mb-0 text-center"><div class="card-body py-3"><h3 class="mb-0 text-danger">{{ $total - $valid }}</h3><small class="text-muted">Have errors</small></div></div></div>
        </div>

        <div class="card">
            <div class="card-body">
                @if ($valid > 0)
                    <form action="{{ route('student.import.commit') }}" method="POST" class="d-flex align-items-center flex-wrap">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <button type="submit" class="btn btn-submit me-3">Import {{ $valid }} {{ str('student')->plural($valid) }}</button>
                        @if ($total - $valid > 0)
                            <span class="text-muted">Rows with errors are skipped. Fix them in the sheet and upload that file again.</span>
                        @endif
                    </form>
                @else
                    <div class="alert alert-danger mb-0">No row can be imported. Fix the errors below in your sheet and upload it again.</div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr><th>Row</th><th>Student</th><th>Roll No</th><th>Class / Section</th><th>Programs</th><th>Phone</th><th>Result</th></tr>
                        </thead>
                        <tbody>
                        @foreach ($built as $row)
                            <tr class="{{ $row['ok'] ? '' : 'table-danger' }}">
                                <td>{{ $row['line'] }}</td>
                                <td>
                                    <strong>{{ $row['data']['full_name'] ?? '—' }}</strong>
                                    @if (! empty($row['data']['admission_form_number']))
                                        <br><small class="text-muted">{{ $row['data']['admission_form_number'] }}</small>
                                    @endif
                                </td>
                                <td>{{ $row['data']['roll_number'] ?? 'Auto' }}</td>
                                <td>{{ $row['class'] ?? '—' }} / {{ $row['section'] ?? '—' }}</td>
                                <td>{{ implode(', ', $row['data']['programs'] ?? []) ?: '—' }}</td>
                                <td>{{ $row['data']['phone'] ?? '—' }}</td>
                                <td>
                                    @if ($row['ok'])
                                        <span class="badge rounded-pill bg-success">Ready</span>
                                    @else
                                        @foreach ($row['errors'] as $error) <div class="text-danger small">{{ $error }}</div> @endforeach
                                    @endif
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