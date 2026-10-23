@extends('backend.layouts.layout')
@section('title', 'Edit Section - King TAS College')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Edit Section</h4>
                <h6>Update section details.</h6>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('section.update', $section) }}" method="POST">
                    @csrf @method('PUT')
                    @include('backend.section._form')
                    <button type="submit" class="btn btn-submit me-2">Update</button>
                    <a href="{{ route('section.index', ['class' => $section->school_class_id]) }}" class="btn btn-cancel">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection