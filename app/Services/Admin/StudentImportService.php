<?php

namespace App\Services\Admin;

use App\Imports\StudentsSheet;
use App\Models\SchoolClass;
use DomainException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Throwable;

class StudentImportService
{
    public const MAX_ROWS = 500;

    /** Column order of the downloadable template. */
    public const HEADINGS = [
        'Admission Form No', 'Roll No', 'Full Name', 'Father Name', 'Gender', 'Date of Birth', 'CNIC', 'Phone',
        'WhatsApp', 'Email', 'Guardian Name', 'Guardian Phone', 'Blood Group', 'Class', 'Section', 'Program',
        'Session', 'Admission Date', 'Qualification', 'Institution', 'Street', 'City', 'District', 'Province',
        'Status', 'Notes',
    ];

    /** Columns kept as text so Excel never strips leading zeros or reformats dates. */
    public const TEXT_COLUMNS = ['A', 'B', 'F', 'G', 'H', 'I', 'L', 'R'];

    /** heading in the sheet (lower-case, underscores) => student field */
    private const ALIASES = [
        'admission_form_no' => 'admission_form_number', 'admission_form_number' => 'admission_form_number',
        'form_no' => 'admission_form_number', 'form_number' => 'admission_form_number',
        'roll_no' => 'roll_number', 'roll_number' => 'roll_number',
        'full_name' => 'full_name', 'name' => 'full_name', 'student_name' => 'full_name',
        'father_name' => 'father_name', 'father' => 'father_name',
        'gender' => 'gender',
        'date_of_birth' => 'date_of_birth', 'dob' => 'date_of_birth',
        'cnic' => 'cnic', 'b_form' => 'cnic', 'cnic_b_form' => 'cnic',
        'phone' => 'phone', 'mobile' => 'phone',
        'whatsapp' => 'whatsapp', 'email' => 'email',
        'guardian_name' => 'guardian_name', 'guardian_phone' => 'guardian_phone',
        'blood_group' => 'blood_group',
        'class' => 'class_name', 'section' => 'section_name',
        'program' => 'program', 'session' => 'session',
        'admission_date' => 'admission_date',
        'qualification' => 'qualification', 'institution' => 'institution',
        'street' => 'street', 'address' => 'street', 'city' => 'city', 'district' => 'district', 'province' => 'province',
        'status' => 'status', 'notes' => 'notes',
    ];

    private const DATE_FIELDS = ['date_of_birth', 'admission_date'];

    public function __construct(private StudentService $students)
    {
    }

    /**
     * Read the file into plain rows. Nothing is saved here.
     *
     * @return array<int, array{line:int,row:array}>
     * @throws DomainException
     */
    public function parse(UploadedFile $file): array
    {
        $sheet = Excel::toCollection(new StudentsSheet, $file)->first();

        if (! $sheet || $sheet->isEmpty()) {
            throw new DomainException('The file has no rows. Fill in the template and try again.');
        }

        $rows = [];

        foreach ($sheet as $index => $cells) {
            $row = [];

            foreach ($cells as $heading => $value) {
                $field = self::ALIASES[$heading] ?? null;

                if (! $field || $value === null || $value === '') {
                    continue;
                }

                $row[$field] = in_array($field, self::DATE_FIELDS, true)
                    ? $this->toDate($value)
                    : trim((string) $value);
            }

            if ($row) {
                $rows[] = ['line' => $index + 2, 'row' => $row]; // +2: heading is line 1
            }
        }

        if (! $rows) {
            throw new DomainException('No student rows were found in the file.');
        }

        if (count($rows) > self::MAX_ROWS) {
            throw new DomainException('A file can contain up to ' . self::MAX_ROWS . ' students. Please split it into smaller files.');
        }

        $known = collect($rows)->flatMap(fn ($r) => array_keys($r['row']))->unique();
        if (! $known->contains('full_name') && ! $known->contains('admission_form_number')) {
            throw new DomainException('The expected columns were not found. Download the template and keep its column headings.');
        }

        return $rows;
    }

    /**
     * Turn the parsed rows into validated student data. Used for the preview AND again on import,
     * so what you confirmed is always re-checked against the current database.
     *
     * @return array<int, array{line:int,data:array,errors:array,ok:bool,class:?string,section:?string}>
     */
    public function build(array $parsed, ?int $defaultClassId, ?int $defaultSectionId): array
    {
        $classes = SchoolClass::with('sections')->get();
        $byName  = [];
        foreach ($classes as $class) {
            $byName[mb_strtolower($class->name)] = $class;
            if ($class->code) {
                $byName[mb_strtolower($class->code)] = $class;
            }
        }

        $seen  = ['roll_number' => [], 'cnic' => [], 'admission_form_number' => []];
        $built = [];

        foreach ($parsed as $item) {
            $row    = $item['row'];
            $errors = [];

            // 1. Fill what we can from the online admission (the sheet always wins).
            $fromAdmission = [];
            if (! empty($row['admission_form_number'])) {
                [$admission, $error] = $this->students->resolveAdmission($row['admission_form_number']);
                if ($admission && ! $error) {
                    $fromAdmission = $this->students->fromAdmission($admission);
                }
            }

            $data = array_filter(array_merge($fromAdmission, $row), fn ($v) => $v !== null && $v !== '');
            $data = $this->students->withDefaults($this->students->normalize($data));

            // 2. Class and section by name (or the defaults chosen on the upload page).
            $class   = $defaultClassId ? $classes->firstWhere('id', $defaultClassId) : null;
            $section = $defaultSectionId ? $class?->sections->firstWhere('id', $defaultSectionId) : null;
            $placementError = false;

            if (! empty($row['class_name'])) {
                $class   = $byName[mb_strtolower($row['class_name'])] ?? null;
                $section = null;

                if (! $class) {
                    $errors[] = 'Class "' . $row['class_name'] . '" does not exist.';
                    $placementError = true;
                }
            }

            if ($class && ! empty($row['section_name'])) {
                $section = $class->sections->first(fn ($s) => mb_strtolower($s->name) === mb_strtolower($row['section_name']));

                if (! $section) {
                    $errors[] = 'Section "' . $row['section_name'] . '" does not exist in class "' . $class->name . '".';
                    $placementError = true;
                }
            }

            unset($data['class_name'], $data['section_name']);
            $data['school_class_id'] = $class?->id;
            $data['section_id']      = $section?->id;

            // 3. Same rules as the manual form.
            $validator = Validator::make($data, $this->students->rules($data), $this->students->messages(), $this->students->attributes());

            foreach ($validator->errors()->messages() as $field => $messages) {
                if ($placementError && in_array($field, ['school_class_id', 'section_id'], true)) {
                    continue;
                }
                array_push($errors, ...$messages);
            }

            // 4. Repeated inside the file.
            foreach (['roll_number' => 'Roll number', 'cnic' => 'CNIC', 'admission_form_number' => 'Admission form number'] as $field => $label) {
                if (empty($data[$field])) {
                    continue;
                }

                $key = strtoupper($data[$field]);

                if (isset($seen[$field][$key])) {
                    $errors[] = $label . ' is repeated in this file (also on row ' . $seen[$field][$key] . ').';
                } else {
                    $seen[$field][$key] = $item['line'];
                }
            }

            $errors = array_values(array_unique($errors));

            $built[] = [
                'line'    => $item['line'],
                'data'    => $data,
                'errors'  => $errors,
                'ok'      => $errors === [],
                'class'   => $class?->name,
                'section' => $section?->name,
            ];
        }

        return $built;
    }

    /** Save every row that passed. A failing row never stops the others. */
    public function commit(array $built): array
    {
        $created = 0;
        $failed  = [];

        foreach ($built as $row) {
            if (! $row['ok']) {
                continue;
            }

            try {
                $this->students->create($row['data']);
                $created++;
            } catch (Throwable $e) {
                report($e);
                $failed[] = 'Row ' . $row['line'] . ': ' . ($e instanceof DomainException ? $e->getMessage() : 'could not be saved.');
            }
        }

        return ['created' => $created, 'failed' => $failed];
    }

    /** Excel date cell, text date, or DateTime -> Y-m-d. Unreadable text is returned as-is so validation reports it. */
    private function toDate(mixed $value): ?string
    {
        if ($value instanceof \DateTimeInterface) {
            return $value->format('Y-m-d');
        }

        if (is_numeric($value) && $value > 1000 && $value < 100000) {
            return ExcelDate::excelToDateTimeObject((float) $value)->format('Y-m-d');
        }

        $text = trim((string) $value);

        foreach (['d-m-Y', 'd/m/Y', 'Y-m-d', 'd.m.Y', 'j-n-Y', 'j/n/Y', 'd-M-Y', 'd M Y'] as $format) {
            $date = \DateTime::createFromFormat('!' . $format, $text);

            if ($date && $date->format($format) === $text) {
                return $date->format('Y-m-d');
            }
        }

        return $text;
    }
}