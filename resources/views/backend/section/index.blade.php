@extends('backend.layouts.layout')
@section('title', 'Sections - King TAS College')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Sections</h4>
                <h6>Manage the sections of each class.</h6>
            </div>
            <div class="page-btn">
                <a href="{{ route('section.create', $classId ? ['class' => $classId] : []) }}" class="btn btn-added">
                    <img src="{{ asset('backend/assets/img/icons/plus.svg') }}" alt="" class="me-1"> Add Section
                </a>
            </div>
        </div>

        {{-- Filter by class --}}
        <div class="card">
            <div class="card-body">
                <form action="{{ route('section.index') }}" method="GET" class="row align-items-end">
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="form-group mb-0">
                            <label>Filter by class</label>
                            <select name="class" class="form-select" onchange="this.form.submit()">
                                <option value="">All classes</option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}" @selected($classId === $class->id)>{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table datanew">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Class</th>
                                <th>Section</th>
                                <th>Room</th>
                                <th>Class Teacher</th>
                                <th>Capacity</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($sections as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->schoolClass->name }}</td>
                                <td><strong>{{ $item->name }}</strong></td>
                                <td>{{ $item->room ?: '—' }}</td>
                                <td>{{ $item->class_teacher ?: '—' }}</td>
                                <td>{{ $item->capacity ?: '—' }}</td>
                                <td>
                                    <span class="badge rounded-pill bg-{{ $item->is_active ? 'success' : 'secondary' }}">
                                        {{ $item->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="text-nowrap">
                                    <a href="{{ route('section.edit', $item) }}" class="me-3" title="Edit">
                                        <img src="{{ asset('backend/assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                    <form action="{{ route('section.destroy', $item) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-link p-0" title="Delete"
                                                onclick="return confirm('Delete this section? This cannot be undone.');">
                                            <img src="{{ asset('backend/assets/img/icons/delete.svg') }}" alt="Delete">
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