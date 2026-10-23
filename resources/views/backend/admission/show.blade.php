@extends('backend.layouts.layout')
@section('title', 'Application ' . $admission->form_number . ' - King TAS College')
@section('content')
@php
$docs = $admission->documents();
$required = $docs->where('required', true);
$verifiedCount = $required->filter(fn ($d) => $admission->isDocumentVerified($d['key']))->count();
$money = fn ($v) => $v !== null ? rtrim(rtrim(number_format((float) $v, 2, '.', ''), '0'), '.') : '—';
@endphp
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Application {{ $admission->form_number }}</h4>
                <h6>Submitted on {{ $admission->created_at->format('d M Y, h:i A') }}</h6>
            </div>
            <div class="page-btn">
                @if (in_array($admission->status, ['approved', 'enrolled'], true))
                @if ($admission->student)
                <a href="{{ route('student.show', $admission->student) }}" class="btn btn-added me-2">View student</a>
                @else
                <a href="{{ route('student.create', ['form_number' => $admission->form_number]) }}" class="btn btn-added me-2">Add as student</a>
                @endif
                @endif
                <a href="{{ route('admission.pdf', $admission) }}" target="_blank" class="btn btn-added me-2">Print form (PDF)</a>

                <a href="{{ route('admission.index') }}" class="btn btn-cancel">Back to list</a>
            </div>
        </div>

        @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)<div>{{ $error }}</div>@endforeach
        </div>
        @endif

        @if ($duplicates->isNotEmpty())
        <div class="alert alert-warning">
            <strong>Duplicate CNIC:</strong> this CNIC has applied before —
            @foreach ($duplicates as $dup)
            <a href="{{ route('admission.show', $dup) }}">{{ $dup->form_number }} ({{ $dup->program }}, {{ $dup->status_label }})</a>{{ ! $loop->last ? ',' : '' }}
            @endforeach
        </div>
        @endif

        <div class="row">
            {{-- LEFT: profile + status + notes + history --}}
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body text-center">
                        <img src="{{ route('admission.document', [$admission, 'photo']) }}" alt="Photo"
                            class="rounded mb-3" style="width:120px;height:145px;object-fit:cover;">
                        <h5 class="mb-1">{{ $admission->full_name }}</h5>
                        <p class="text-muted mb-2">{{ $admission->program }}</p>
                        <span class="badge rounded-pill bg-{{ $admission->status_color }} mb-2">{{ $admission->status_label }}</span>
                        @if ($admission->roll_number)
                        <div>Roll No: <strong>{{ $admission->roll_number }}</strong></div>
                        @endif

                        <div class="d-flex flex-wrap justify-content-center gap-2 mt-3">
                            <a href="tel:{{ $admission->phone }}" class="btn btn-sm btn-outline-primary">Call</a>
                            <a href="{{ $admission->whatsapp_link }}" target="_blank" class="btn btn-sm btn-outline-success">WhatsApp</a>
                            @if ($admission->email)
                            <a href="mailto:{{ $admission->email }}" class="btn btn-sm btn-outline-secondary">Email</a>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Change status --}}
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Process application</h5>
                        <form action="{{ route('admission.status', $admission) }}" method="POST">
                            @csrf @method('PATCH')
                            <div class="form-group mb-3">
                                <label>New status</label>
                                <select name="status" class="form-select">
                                    @foreach (\App\Models\Admission::STATUSES as $key => $label)
                                    <option value="{{ $key }}" @selected(old('status', $admission->status) === $key)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label>Remarks <small class="text-muted">(required for Rejected / Documents Required)</small></label>
                                <textarea name="remarks" rows="3" class="form-control" maxlength="1000">{{ old('remarks') }}</textarea>
                            </div>
                            @if ($admission->email)
                            <div class="form-check mb-3">
                                <input type="checkbox" name="notify" value="1" id="notify" class="form-check-input" checked>
                                <label for="notify" class="form-check-label">Email the student about this change</label>
                            </div>
                            @endif
                            <button type="submit" class="btn btn-submit w-100">Update status</button>
                            <small class="text-muted d-block mt-2">
                                Approving needs all required documents verified ({{ $verifiedCount }}/{{ $required->count() }} now).
                                Only approved applications can be enrolled; a roll number is created on enrolment.
                            </small>
                        </form>
                    </div>
                </div>

                {{-- Internal notes (never shown to the student) --}}
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Internal notes</h5>
                        <form action="{{ route('admission.notes', $admission) }}" method="POST">
                            @csrf @method('PATCH')
                            <textarea name="internal_notes" rows="3" class="form-control mb-2" maxlength="2000"
                                placeholder="Phone call details, fee promises, etc.">{{ old('internal_notes', $admission->internal_notes) }}</textarea>
                            <button type="submit" class="btn btn-sm btn-primary">Save notes</button>
                        </form>
                    </div>
                </div>

                {{-- History --}}
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Status history</h5>
                        @forelse ($admission->logs as $log)
                        <div class="border-bottom pb-2 mb-2">
                            <div>
                                @if ($log->from_status)
                                {{ \App\Models\Admission::STATUSES[$log->from_status] ?? $log->from_status }} →
                                @endif
                                <strong>{{ \App\Models\Admission::STATUSES[$log->to_status] ?? $log->to_status }}</strong>
                            </div>
                            @if ($log->remarks)<div class="small">{{ $log->remarks }}</div>@endif
                            <small class="text-muted">
                                {{ $log->created_at->format('d M Y, h:i A') }}
                                @if ($log->admin) · {{ $log->admin->first_name }} {{ $log->admin->last_name }} @endif
                            </small>
                        </div>
                        @empty
                        <p class="text-muted mb-0">No changes yet. Application is waiting for review.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- RIGHT: details + documents --}}
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Personal information</h5>
                        <table class="table table-bordered mb-0">
                            <tr>
                                <th style="width:22%">Full name</th>
                                <td>{{ $admission->full_name }}</td>
                                <th style="width:22%">Father's name</th>
                                <td>{{ $admission->father_name }}</td>
                            </tr>
                            <tr>
                                <th>Date of birth</th>
                                <td>{{ $admission->date_of_birth->format('d M Y') }} ({{ $admission->date_of_birth->age }} yrs)</td>
                                <th>Gender</th>
                                <td>{{ $admission->gender }}</td>
                            </tr>
                            <tr>
                                <th>CNIC / B-Form</th>
                                <td>{{ $admission->cnic }}</td>
                                <th>Phone</th>
                                <td>{{ $admission->phone }}</td>
                            </tr>
                            <tr>
                                <th>WhatsApp</th>
                                <td>{{ $admission->whatsapp ?: '—' }}</td>
                                <th>Email</th>
                                <td>{{ $admission->email ?: '—' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Academic &amp; program</h5>
                        <table class="table table-bordered mb-0">
                            <tr>
                                <th style="width:22%">Qualification</th>
                                <td>{{ $admission->qualification }}</td>
                                <th style="width:22%">Institution</th>
                                <td>{{ $admission->institution }}</td>
                            </tr>
                            <tr>
                                <th>Marks</th>
                                <td>{{ $money($admission->obtained_marks) }} / {{ $money($admission->total_marks) }}</td>
                                <th>Percentage</th>
                                <td>{{ $admission->percentage !== null ? $money($admission->percentage) . '%' : '—' }}</td>
                            </tr>
                            <tr>
                                <th>Program</th>
                                <td>{{ $admission->program }}</td>
                                <th>Session</th>
                                <td>{{ $admission->session }}</td>
                            </tr>
                            <tr>
                                <th>Applicant notes</th>
                                <td colspan="3">{!! $admission->notes ? nl2br(e($admission->notes)) : '—' !!}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Address</h5>
                        <table class="table table-bordered mb-0">
                            <tr>
                                <th style="width:22%">Postal address</th>
                                <td colspan="3">{{ $admission->street }}</td>
                            </tr>
                            <tr>
                                <th>City</th>
                                <td>{{ $admission->city }}</td>
                                <th style="width:22%">District</th>
                                <td>{{ $admission->district ?: '—' }}</td>
                            </tr>
                            <tr>
                                <th>Province</th>
                                <td colspan="3">{{ $admission->province ?: '—' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">Documents</h5>
                            <span class="badge rounded-pill bg-{{ $verifiedCount === $required->count() ? 'success' : 'warning' }}">
                                {{ $verifiedCount }} of {{ $required->count() }} required verified
                            </span>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Document</th>
                                        <th>Verified</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($docs as $doc)
                                    <tr>
                                        <td>{{ $doc['label'] }} @unless ($doc['required'])<small class="text-muted">(optional)</small>@endunless</td>
                                        <td>
                                            @if ($admission->isDocumentVerified($doc['key']))
                                            <span class="badge rounded-pill bg-success">Verified</span>
                                            @else
                                            <span class="badge rounded-pill bg-light text-dark">Not checked</span>
                                            @endif
                                        </td>
                                        <td class="text-end text-nowrap">
                                            <a href="{{ route('admission.document', [$admission, $doc['key']]) }}" target="_blank" class="btn btn-sm btn-outline-primary">View</a>
                                            <a href="{{ route('admission.document', [$admission, $doc['key'], 'download' => 1]) }}" class="btn btn-sm btn-outline-secondary">Download</a>
                                            <form action="{{ route('admission.document.verify', [$admission, $doc['key']]) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm {{ $admission->isDocumentVerified($doc['key']) ? 'btn-outline-danger' : 'btn-success' }}">
                                                    {{ $admission->isDocumentVerified($doc['key']) ? 'Unverify' : 'Verify' }}
                                                </button>
                                            </form>
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
    </div>
</div>
@endsection