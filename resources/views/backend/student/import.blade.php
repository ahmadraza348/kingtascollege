@extends('backend.layouts.layout')
@section('title', 'Import Students - King TAS College')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Import Students from Excel</h4>
                <h6>Upload a sheet, check the preview, then import.</h6>
            </div>
            <div class="page-btn">
                <a href="{{ route('student.index') }}" class="btn btn-cancel">Back to list</a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-3">1. Download the template</h5>
                        <a href="{{ route('student.import.template') }}" class="btn btn-added mb-4">
                            <img src="{{ asset('backend/assets/img/icons/download.svg') }}" alt="" class="me-1"> students-import-template.xlsx
                        </a>

                        <h5 class="mb-3">2. Upload the filled sheet</h5>
                        <form action="{{ route('student.import.preview') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Excel or CSV file <span class="text-danger">*</span></label>
                                <input type="file" name="file" accept=".xlsx,.xls,.csv" required
                                       class="form-control @error('file') is-invalid @enderror">
                                @error('file') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Default class (optional)</label>
                                        <select name="default_class_id" class="form-select" data-sections="#defaultSection">
                                            <option value="">— Use the Class column —</option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}" @selected((int) old('default_class_id') === $class->id)>{{ $class->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Default section (optional)</label>
                                        <select name="default_section_id" id="defaultSection" class="form-select @error('default_section_id') is-invalid @enderror">
                                            <option value="">— Use the Section column —</option>
                                        </select>
                                        @error('default_section_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <small class="text-muted d-block mb-3">
                                The default is used for every row that has no Class / Section in the sheet.
                                Handy when you upload one section at a time.
                            </small>

                            <button type="submit" class="btn btn-submit">Upload &amp; check</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-3">How the sheet works</h5>
                        <ul class="mb-0 ps-3">
                            <li>Keep the column headings of the template. Delete the columns you do not need.</li>
                            <li><strong>Admission Form No</strong> (e.g. KTC-2026-00042): the student's details and photo are taken from the online admission. Anything you type in the sheet wins.</li>
                            <li>Without a form number, these are required: <strong>Full Name, Father Name, Gender, Date of Birth, Phone</strong>.</li>
                            <li><strong>Class</strong> and <strong>Section</strong> must match the names you created (or use the defaults on the left).</li>
                            <li><strong>Programs</strong>: enter one program or separate multiple programs with a pipe, for example <code>BSN Generic | Post RN</code>.</li>
                            <li><strong>Roll No</strong> can stay empty: it is generated automatically.</li>
                            <li>Dates: <code>25-12-2005</code>. Gender: Male / Female / Other. Status: Active, Inactive, Graduated, Left (empty = Active).</li>
                            <li>Up to {{ \App\Services\Admin\StudentImportService::MAX_ROWS }} students per file.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('backend.student._class_section_js')
@endsection