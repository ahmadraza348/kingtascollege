@extends('backend.layouts.layout')
@section('title', 'Add Student - King TAS College')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Add Student</h4>
                <h6>Add one student, or import many from Excel.</h6>
            </div>
            <div class="page-btn">
                <a href="{{ route('student.import') }}" class="btn btn-added me-2">Import from Excel</a>
                <a href="{{ route('student.index') }}" class="btn btn-cancel">Back to list</a>
            </div>
        </div>

        <form action="{{ route('student.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('backend.student._form')
            <button type="submit" class="btn btn-submit me-2">Save Student</button>
            <a href="{{ route('student.index') }}" class="btn btn-cancel">Cancel</a>
        </form>
    </div>
</div>
@endsection