@php
    $classOptions   = $classes->pluck('name', 'id');
    $sectionOptions = $sections->pluck('name', 'id');
    $genders        = array_combine(\App\Models\Student::GENDERS, \App\Models\Student::GENDERS);
    $bloodGroups    = array_combine(\App\Models\Student::BLOOD_GROUPS, \App\Models\Student::BLOOD_GROUPS);
    $provinces      = array_combine(\App\Models\Student::PROVINCES, \App\Models\Student::PROVINCES);
@endphp

{{-- Online admission link --}}
<div class="card">
    <div class="card-body">
        <h5 class="mb-3">Online admission</h5>

        @if ($student->exists)
            @if ($student->admission_id)
                <p class="mb-0">Linked to application
                    <a href="{{ route('admission.show', $student->admission_id) }}">{{ $student->admission_form_number }}</a>.</p>
            @else
                <p class="text-muted mb-0">Added manually — not linked to an online admission.</p>
            @endif
        @else
            <div class="row align-items-end">
                <div class="col-lg-5 col-md-8 col-12">
                    <div class="form-group mb-0">
                        <label>Admission Form No</label>
                        <div class="input-group">
                            <input type="text" name="admission_form_number" id="f_admission_form_number" autocomplete="off"
                                   class="form-control @error('admission_form_number') is-invalid @enderror"
                                   value="{{ old('admission_form_number', $formNumber ?? '') }}" placeholder="KTC-2026-00042">
                            <button type="button" id="fetchAdmission" class="btn btn-primary">Fetch details</button>
                        </div>
                        @error('admission_form_number') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-lg-7 col-12 mt-2 mt-lg-0"><div id="admissionResult"></div></div>
            </div>
          
        @endif
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h5 class="mb-3">Personal information</h5>
        <div class="row">
            @include('backend.student._field', ['name' => 'full_name', 'label' => 'Full Name', 'required' => true, 'col' => 'col-lg-6 col-12', 'max' => 120])
            @include('backend.student._field', ['name' => 'father_name', 'label' => 'Father Name', 'required' => true, 'col' => 'col-lg-6 col-12', 'max' => 120])
            @include('backend.student._select', ['name' => 'gender', 'label' => 'Gender', 'required' => true, 'options' => $genders])
            @include('backend.student._field', ['name' => 'date_of_birth', 'label' => 'Date of Birth', 'type' => 'date', 'required' => true])
            @include('backend.student._field', ['name' => 'cnic', 'label' => 'CNIC / B-Form', 'placeholder' => '35202-1234567-1', 'max' => 25])
            @include('backend.student._select', ['name' => 'blood_group', 'label' => 'Blood Group', 'options' => $bloodGroups])
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h5 class="mb-3">Contact &amp; guardian</h5>
        <div class="row">
            @include('backend.student._field', ['name' => 'phone', 'label' => 'Phone', 'type' => 'tel', 'required' => true, 'placeholder' => '0300-1234567', 'max' => 30])
            @include('backend.student._field', ['name' => 'whatsapp', 'label' => 'WhatsApp', 'type' => 'tel', 'placeholder' => '0300-1234567', 'max' => 30])
            @include('backend.student._field', ['name' => 'email', 'label' => 'Email', 'type' => 'email'])
            @include('backend.student._field', ['name' => 'guardian_name', 'label' => 'Guardian Name', 'max' => 120])
            @include('backend.student._field', ['name' => 'guardian_phone', 'label' => 'Guardian Phone', 'type' => 'tel', 'placeholder' => '0300-1234567', 'max' => 30])
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h5 class="mb-3">Address</h5>
        <div class="row">
            @include('backend.student._field', ['name' => 'street', 'label' => 'Street / Address', 'col' => 'col-lg-6 col-12', 'max' => 200])
            @include('backend.student._field', ['name' => 'city', 'label' => 'City', 'col' => 'col-lg-2 col-md-4 col-12', 'max' => 100])
            @include('backend.student._field', ['name' => 'district', 'label' => 'District', 'col' => 'col-lg-2 col-md-4 col-12', 'max' => 100])
            @include('backend.student._select', ['name' => 'province', 'label' => 'Province', 'col' => 'col-lg-2 col-md-4 col-12', 'options' => $provinces])
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h5 class="mb-3">Previous education</h5>
        <div class="row">
            @include('backend.student._field', ['name' => 'qualification', 'label' => 'Qualification', 'col' => 'col-lg-4 col-md-6 col-12', 'max' => 100])
            @include('backend.student._field', ['name' => 'institution', 'label' => 'Institution', 'col' => 'col-lg-4 col-md-6 col-12'])
            @include('backend.student._field', ['name' => 'obtained_marks', 'label' => 'Marks Obtained', 'type' => 'number', 'col' => 'col-lg-2 col-md-6 col-6', 'attrs' => 'step="0.01" min="0"'])
            @include('backend.student._field', ['name' => 'total_marks', 'label' => 'Total Marks', 'type' => 'number', 'col' => 'col-lg-2 col-md-6 col-6', 'attrs' => 'step="0.01" min="0"'])
            @include('backend.student._field', ['name' => 'percentage', 'label' => 'Percentage', 'type' => 'number', 'col' => 'col-lg-2 col-md-6 col-6', 'attrs' => 'step="0.01" min="0" max="100"'])
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h5 class="mb-3">College placement</h5>
        <div class="row">
            @include('backend.student._select', ['name' => 'school_class_id', 'label' => 'Class', 'required' => true, 'options' => $classOptions, 'attrs' => 'data-sections="#f_section_id"'])
            @include('backend.student._select', ['name' => 'section_id', 'label' => 'Section', 'required' => true, 'options' => $sectionOptions])
            <div class="col-lg-6 col-md-12 col-12">
                <div class="form-group">
                    <label for="f_programs">Programs</label>
                    <select name="programs[]" id="f_programs" class="form-control select2 @error('programs') is-invalid @enderror" multiple="multiple" data-placeholder="Select one or more programs">
                        @foreach ($programOptions as $program)
                            <option value="{{ $program }}" @selected(in_array($program, (array) $selectedPrograms, true))>{{ $program }}</option>
                        @endforeach
                    </select>
                    @error('programs') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    @foreach ($errors->get('programs.*') as $programErrors)
                        @foreach ($programErrors as $message)
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @endforeach
                    @endforeach
                </div>
            </div>
            @include('backend.student._field', ['name' => 'session', 'label' => 'Session', 'required' => true, 'max' => 20])
            @include('backend.student._field', ['name' => 'admission_date', 'label' => 'Admission Date', 'type' => 'date'])
            @include('backend.student._field', ['name' => 'roll_number', 'label' => 'Roll Number', 'placeholder' => 'Auto-generated if empty', 'max' => 30])
            @include('backend.student._select', ['name' => 'status', 'label' => 'Status', 'required' => true, 'options' => \App\Models\Student::STATUSES, 'placeholder' => '— Select —'])
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h5 class="mb-3">Fee assignment</h5>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-12">
                <div class="form-group">
                    <label for="f_monthly_tuition_fee">Monthly Tuition Fee Override (PKR)</label>
                    <input type="number" name="monthly_tuition_fee" id="f_monthly_tuition_fee"
                           value="{{ old('monthly_tuition_fee', $student->monthly_tuition_fee) }}"
                           min="0" max="10000000" step="0.01" placeholder="Use class/session default"
                           class="form-control @error('monthly_tuition_fee') is-invalid @enderror">
                    @error('monthly_tuition_fee') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h5 class="mb-3">Photo &amp; notes</h5>
        <div class="row">
            <div class="col-lg-4 col-12">
                <div class="form-group">
                    <label>Photo</label>
                    <input type="file" name="photo" accept=".jpg,.jpeg,.png,.webp" class="form-control @error('photo') is-invalid @enderror">
                    <small class="text-muted">JPG, PNG or WEBP, up to 2 MB.
                        @unless ($student->exists) If you skip this, the admission photo is used. @endunless</small>
                    @error('photo') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
                @if ($student->photo_path)
                    <img src="{{ $student->photo_url }}" alt="" class="rounded" style="width:90px;height:110px;object-fit:cover;">
                @endif
            </div>
            @include('backend.student._field', ['name' => 'notes', 'label' => 'Notes', 'type' => 'textarea', 'col' => 'col-lg-8 col-12'])
        </div>
    </div>
</div>

@include('backend.student._class_section_js')

@unless ($student->exists)
<script>
    // "Fetch details": loads the online admission and fills the form.
    (function () {
        var button = document.getElementById('fetchAdmission');
        if (!button) return;
        var input  = document.getElementById('f_admission_form_number');
        var result = document.getElementById('admissionResult');
        var url    = @json(route('student.admission-lookup'));

        function esc(text) { var d = document.createElement('div'); d.textContent = text; return d.innerHTML; }
        function show(type, html) { result.innerHTML = '<div class="alert alert-' + type + ' py-2 mb-0">' + html + '</div>'; }

        function fetchAdmission() {
            var number = input.value.trim();
            if (!number) { show('warning', 'Enter a form number first.'); return; }

            button.disabled = true; button.textContent = 'Fetching…';

            fetch(url + '?form_number=' + encodeURIComponent(number), { headers: { 'Accept': 'application/json' } })
                .then(function (r) { return r.json(); })
                .then(function (res) {
                    if (!res.ok) { show('danger', esc(res.message || 'Application not found.')); return; }

                    Object.keys(res.data).forEach(function (key) {
                        var field = document.getElementById('f_' + key);
                        if (!field || res.data[key] === null) return;

                        if (field.multiple && Array.isArray(res.data[key])) {
                            Array.from(field.options).forEach(function (option) {
                                option.selected = res.data[key].includes(option.value);
                            });
                            if (window.jQuery && jQuery.fn.select2) jQuery(field).trigger('change');
                        } else if (!Array.isArray(res.data[key])) {
                            field.value = res.data[key];
                        }
                    });
                    input.value = res.form_number;

                    show('success',
                        '<img src="' + res.photo_url + '" alt="" style="width:34px;height:42px;object-fit:cover;border-radius:4px;margin-right:8px;">' +
                        'Loaded from <a href="' + res.admission_url + '" target="_blank">' + esc(res.form_number) + '</a> (' + esc(res.status) +
                        '). Now choose the class and section.');
                })
                .catch(function () { show('danger', 'Could not fetch the application. Please try again.'); })
                .finally(function () { button.disabled = false; button.textContent = 'Fetch details'; });
        }

        button.addEventListener('click', fetchAdmission);
        input.addEventListener('keydown', function (e) { if (e.key === 'Enter') { e.preventDefault(); fetchAdmission(); } });

        @if (! empty($formNumber) && ! $errors->any())
            fetchAdmission(); // arrived from the admission page ("Add as student")
        @endif
    })();
</script>
@endunless