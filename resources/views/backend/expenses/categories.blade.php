@extends('backend.layouts.layout')
@section('title', 'Expense Categories - King TAS College')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title"><h4>Expense Categories</h4><h6>The headings your expenses are grouped under.</h6></div>
            <div class="page-btn"><a href="{{ route('expenses.dashboard') }}" class="btn btn-cancel">Back</a></div>
        </div>

        <div class="card"><div class="card-body">
            <form action="{{ route('expenses.categories.store') }}" method="POST" class="row align-items-end">
                @csrf
                <div class="col-lg-5 col-md-8"><div class="form-group">
                    <label>New category</label>
                    <input type="text" name="name" required maxlength="100" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="e.g. Library Books">
                    @error('name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div></div>
                <div class="col-lg-2 col-md-4"><div class="form-group"><button class="btn btn-submit">Add category</button></div></div>
            </form>
        </div></div>

        <div class="card"><div class="card-body">
            <div class="table-responsive"><table class="table">
                <thead><tr><th>Name</th><th>Expenses</th><th>Active</th><th></th></tr></thead>
                <tbody>
                @foreach ($categories as $c)
                    <tr>
                        <td colspan="3">
                            <form action="{{ route('expenses.categories.update', $c) }}" method="POST" class="row g-2 align-items-center">
                                @csrf @method('PUT')
                                <input type="hidden" name="_row" value="{{ $c->id }}">
                                @php $rowError = (int) old('_row') === $c->id ? $errors->update->first('name') : null; @endphp
                                <div class="col-md-6"><input type="text" name="name" required maxlength="100" value="{{ $rowError ? old('name') : $c->name }}" class="form-control form-control-sm @if ($rowError) is-invalid @endif">
                                    @if ($rowError)<div class="invalid-feedback d-block">{{ $rowError }}</div>@endif</div>
                                <div class="col-md-2">{{ $c->expenses_count }}</div>
                                <div class="col-md-2"><label class="mb-0"><input type="checkbox" name="is_active" value="1" @checked($c->is_active)> Active</label></div>
                                <div class="col-md-2"><button class="btn btn-sm btn-submit">Save</button></div>
                            </form>
                        </td>
                        <td class="text-end">
                            @if ($c->expenses_count === 0)
                                <form action="{{ route('expenses.categories.destroy', $c) }}" method="POST" onsubmit="return confirm('Delete this category?');">@csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Delete</button></form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table></div>
            <small class="text-muted">A category that already has expenses cannot be deleted. Untick "Active" to hide it from new expenses.</small>
        </div></div>
    </div>
</div>
@endsection
