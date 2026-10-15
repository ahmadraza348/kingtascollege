@extends('backend.layouts.layout')
@section('title', 'Contact Message - Pound Store')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Contact Message</h4>
                <h6>Submitted on {{ $message->created_at->format('d M Y, h:i A') }}</h6>
            </div>
            <div class="page-btn"><a href="{{ route('contact-message.index') }}" class="btn btn-cancel">Back to list</a></div>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered mb-4">
                    <tbody>
                        <tr><th style="width: 220px;">Name</th><td>{{ $message->name }}</td></tr>
                        <tr><th> Phone</th><td>{{ $message->phone }}</td></tr>
                        <tr><th> Email</th><td>{{ $message->email }}</td></tr>
                        <tr><th>Subject</th><td>{{ $message->subject ?: '—' }}</td></tr>
                        <tr><th>Message</th><td>{!! nl2br(e($message->message)) !!}</td></tr>
                    </tbody>
                </table>

                <form action="{{ route('contact-message.destroy', $message) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Delete this message?');">Delete message</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
