@extends('backend.layouts.layout')
@section('title', 'Add Section - King TAS College')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Add Section</h4>
                <h6>Create a new section inside a class.</h6>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('section.store') }}" method="POST">
                    @csrf
                    @include('backend.section._form')
                    <button type="submit" class="btn btn-submit me-2">Save</button>
                    <a href="{{ route('section.index') }}" class="btn btn-cancel">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection