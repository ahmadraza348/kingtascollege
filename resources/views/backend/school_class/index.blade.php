@extends('backend.layouts.layout')
@section('title', 'Classes - King TAS College')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Classes</h4>
                <h6>Manage the classes of the college.</h6>
            </div>
            <div class="page-btn">
                <a href="{{ route('school-class.create') }}" class="btn btn-added">
                    <img src="{{ asset('backend/assets/img/icons/plus.svg') }}" alt="" class="me-1"> Add Class
                </a>
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
                                <th>Code</th>
                                <th>Program</th>
                                <th>Sections</th>
                                <th>Order</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($classes as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><strong>{{ $item->name }}</strong></td>
                                <td>{{ $item->code ?: '—' }}</td>
                                <td>{{ $item->program ?: '—' }}</td>
                                <td>
                                    <a href="{{ route('section.index', ['class' => $item->id]) }}">
                                        {{ $item->sections_count }}
                                    </a>
                                </td>
                                <td>{{ $item->sort_order }}</td>
                                <td>
                                    <span class="badge rounded-pill bg-{{ $item->is_active ? 'success' : 'secondary' }}">
                                        {{ $item->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="text-nowrap">
                                    <a href="{{ route('school-class.edit', $item) }}" class="me-3" title="Edit">
                                        <img src="{{ asset('backend/assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                    <form action="{{ route('school-class.destroy', $item) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-link p-0" title="Delete"
                                                onclick="return confirm('Delete this class? This cannot be undone.');">
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