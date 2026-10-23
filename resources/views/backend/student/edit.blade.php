@extends('backend.layouts.layout')
@section('title', 'Edit Student - King TAS College')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Edit Student</h4>
                <h6>{{ $student->full_name }} — {{ $student->roll_number }}</h6>
            </div>
            <div class="page-btn">
                <a href="{{ route('student.show', $student) }}" class="btn btn-cancel">Back to profile</a>
            </div>
        </div>

        <form action="{{ route('student.update', $student) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            @include('backend.student._form')
            <button type="submit" class="btn btn-submit me-2">Update Student</button>
            <a href="{{ route('student.show', $student) }}" class="btn btn-cancel">Cancel</a>
        </form>
    </div>
</div>
@endsection