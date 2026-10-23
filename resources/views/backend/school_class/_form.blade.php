<div class="row">
    <div class="col-lg-6 col-12">
        <div class="form-group">
            <label>Class Name <span class="text-danger">*</span></label>
            <input type="text" name="name" maxlength="100" class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $schoolClass->name) }}" placeholder="e.g. BSN Generic - Year 1" required>
            @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="col-lg-6 col-12">
        <div class="form-group">
            <label>Code</label>
            <input type="text" name="code" maxlength="30" class="form-control @error('code') is-invalid @enderror"
                   value="{{ old('code', $schoolClass->code) }}" placeholder="e.g. BSN-1">
            @error('code') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="col-lg-6 col-12">
        <div class="form-group">
            <label>Program</label>
            <select name="program" class="form-select @error('program') is-invalid @enderror">
                <option value="">— None —</option>
                @foreach (\App\Models\SchoolClass::PROGRAMS as $program)
                    <option value="{{ $program }}" @selected(old('program', $schoolClass->program) === $program)>{{ $program }}</option>
                @endforeach
            </select>
            @error('program') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="form-group">
            <label>Display Order</label>
            <input type="number" name="sort_order" min="0" max="65535" class="form-control @error('sort_order') is-invalid @enderror"
                   value="{{ old('sort_order', $schoolClass->sort_order ?? 0) }}">
            @error('sort_order') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="form-group">
            <label>Status <span class="text-danger">*</span></label>
            <select name="is_active" class="form-select @error('is_active') is-invalid @enderror">
                <option value="1" @selected((string) old('is_active', (int) $schoolClass->is_active) === '1')>Active</option>
                <option value="0" @selected((string) old('is_active', (int) $schoolClass->is_active) === '0')>Inactive</option>
            </select>
            @error('is_active') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="col-12">
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="3" maxlength="500" class="form-control @error('description') is-invalid @enderror">{{ old('description', $schoolClass->description) }}</textarea>
            @error('description') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
    </div>
</div>