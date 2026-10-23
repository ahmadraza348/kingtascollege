@php
    $type     = $type ?? 'text';
    $col      = $col ?? 'col-lg-3 col-md-6 col-12';
    $required = $required ?? false;
    $raw      = $student->{$name};
    $value    = old($name, $raw instanceof \Carbon\CarbonInterface ? $raw->format('Y-m-d') : $raw);
@endphp
<div class="{{ $col }}">
    <div class="form-group">
        <label>{{ $label }} @if ($required)<span class="text-danger">*</span>@endif</label>
        @if ($type === 'textarea')
            <textarea name="{{ $name }}" id="f_{{ $name }}" rows="3" maxlength="{{ $max ?? 1000 }}"
                      class="form-control @error($name) is-invalid @enderror">{{ $value }}</textarea>
        @else
            <input type="{{ $type }}" name="{{ $name }}" id="f_{{ $name }}" value="{{ $value }}"
                   maxlength="{{ $max ?? 150 }}" placeholder="{{ $placeholder ?? '' }}"
                   @if (! empty($list)) list="{{ $list }}" @endif
                   {!! $attrs ?? '' !!} @required($required)
                   class="form-control @error($name) is-invalid @enderror">
        @endif
        @error($name) <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>
</div>