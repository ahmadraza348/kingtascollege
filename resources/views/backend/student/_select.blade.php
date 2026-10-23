@php
    $col      = $col ?? 'col-lg-3 col-md-6 col-12';
    $required = $required ?? false;
    $current  = (string) old($name, $student->{$name});
@endphp
<div class="{{ $col }}">
    <div class="form-group">
        <label>{{ $label }} @if ($required)<span class="text-danger">*</span>@endif</label>
        <select name="{{ $name }}" id="f_{{ $name }}" {!! $attrs ?? '' !!} @required($required)
                class="form-select @error($name) is-invalid @enderror">
            <option value="">{{ $placeholder ?? '— Select —' }}</option>
            @foreach ($options as $value => $text)
                <option value="{{ $value }}" @selected($current === (string) $value)>{{ $text }}</option>
            @endforeach
        </select>
        @error($name) <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>
</div>