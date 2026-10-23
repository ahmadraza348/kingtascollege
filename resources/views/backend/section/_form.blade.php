<div class="row">
    <div class="col-lg-6 col-12">
        <div class="form-group">
            <label>Class <span class="text-danger">*</span></label>
            <select name="school_class_id" class="form-select @error('school_class_id') is-invalid @enderror" required>
                <option value="">— Select class —</option>
                @foreach ($classes as $class)
                    <option value="{{ $class->id }}" @selected((int) old('school_class_id', $section->school_class_id) === $class->id)>
                        {{ $class->name }}{{ $class->is_active ? '' : ' (inactive)' }}
                    </option>
                @endforeach
            </select>
            @error('school_class_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="col-lg-6 col-12">
        <div class="form-group">
            <label>Section Name <span class="text-danger">*</span></label>
            <input type="text" name="name" maxlength="50" class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $section->name) }}" placeholder="e.g. A" required>
            @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="col-lg-6 col-12">
        <div class="form-group">
            <label>Class Teacher</label>
            <input type="text" name="class_teacher" maxlength="100" class="form-control @error('class_teacher') is-invalid @enderror"
                   value="{{ old('class_teacher', $section->class_teacher) }}">
            @error('class_teacher') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="col-lg-2 col-6">
        <div class="form-group">
            <label>Room</label>
            <input type="text" name="room" maxlength="50" class="form-control @error('room') is-invalid @enderror"
                   value="{{ old('room', $section->room) }}">
            @error('room') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="col-lg-2 col-6">
        <div class="form-group">
            <label>Capacity</label>
            <input type="number" name="capacity" min="1" max="1000" class="form-control @error('capacity') is-invalid @enderror"
                   value="{{ old('capacity', $section->capacity) }}">
            @error('capacity') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="col-lg-2 col-12">
        <div class="form-group">
            <label>Status <span class="text-danger">*</span></label>
            <select name="is_active" class="form-select @error('is_active') is-invalid @enderror">
                <option value="1" @selected((string) old('is_active', (int) $section->is_active) === '1')>Active</option>
                <option value="0" @selected((string) old('is_active', (int) $section->is_active) === '0')>Inactive</option>
            </select>
            @error('is_active') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
    </div>
</div>