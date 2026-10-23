@extends('backend.layouts.layout')
@section('title', 'Edit Class - King TAS College')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Edit Class</h4>
                <h6>Update class details.</h6>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('school-class.update', $schoolClass) }}" method="POST">
                    @csrf @method('PUT')
                    @include('backend.school_class._form')
                    <button type="submit" class="btn btn-submit me-2">Update</button>
                    <a href="{{ route('school-class.index') }}" class="btn btn-cancel">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection