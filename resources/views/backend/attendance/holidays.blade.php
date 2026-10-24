@extends('backend.layouts.layout')
@section('title', 'Holidays - King TAS College')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>School Holidays</h4>
                <h6>Holidays cannot be marked and never count against students. Weekends are handled automatically.</h6>
            </div>
            <div class="page-btn">
                <a href="{{ route('attendance.mark') }}" class="btn btn-cancel">Back to attendance</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('attendance.holidays.store') }}" method="POST" class="row align-items-end">
                    @csrf
                    <div class="col-lg-4 col-12">
                        <div class="form-group mb-lg-0">
                            <label>Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" maxlength="150" value="{{ old('title') }}" required
                                   class="form-control @error('title') is-invalid @enderror" placeholder="e.g. Eid ul Fitr">
                            @error('title') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="form-group mb-lg-0">
                            <label>From <span class="text-danger">*</span></label>
                            <input type="date" name="from" value="{{ old('from') }}" required class="form-control @error('from') is-invalid @enderror">
                            @error('from') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="form-group mb-lg-0">
                            <label>To (leave empty for one day)</label>
                            <input type="date" name="to" value="{{ old('to') }}" class="form-control @error('to') is-invalid @enderror">
                            @error('to') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-lg-2 col-12 mt-2 mt-lg-0"><button type="submit" class="btn btn-submit">Add holiday</button></div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table datanew">
                        <thead><tr><th>Date</th><th>Day</th><th>Holiday</th><th>Action</th></tr></thead>
                        <tbody>
                        @foreach ($holidays as $holiday)
                            @php $d = \Carbon\Carbon::parse($holiday->date); @endphp
                            <tr>
                                <td data-order="{{ $holiday->date }}">{{ $d->format('d M Y') }}</td>
                                <td>{{ $d->format('l') }}</td>
                                <td>{{ $holiday->title }}</td>
                                <td>
                                    <form action="{{ route('attendance.holidays.destroy', $holiday) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-link p-0" title="Remove"
                                                onclick="return confirm('Remove this holiday? Attendance already marked on this day will count again.');">
                                            <img src="{{ asset('backend/assets/img/icons/delete.svg') }}" alt="Remove">
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
@endsection