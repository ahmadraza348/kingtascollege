@extends('backend.layouts.layout')
@section('title', 'Add Class - King TAS College')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Add Class</h4>
                <h6>Create a new class.</h6>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('school-class.store') }}" method="POST">
                    @csrf
                    @include('backend.school_class._form')
                    <button type="submit" class="btn btn-submit me-2">Save</button>
                    <a href="{{ route('school-class.index') }}" class="btn btn-cancel">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection