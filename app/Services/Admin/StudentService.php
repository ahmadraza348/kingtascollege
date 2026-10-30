<?php

namespace App\Services\Admin;

use App\Models\Admission;
use App\Models\SchoolClass;
use App\Models\Student;
use DomainException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StudentService
{
    /** Photos live in /public like the gallery (fast, cacheable). Names are random UUIDs. */
    public const PHOTO_FOLDER = 'uploads/students';

    private ?string $session = null;

    public function __construct(private AdmissionManagementService $admissions)
    {
    }

    /* ------------------------------------------------------------------
     |  Cleaning: used by the form AND the Excel import, so both behave the same
     * ------------------------------------------------------------------ */

    public function normalize(array $data): array
    {
        foreach ($data as $key => $value) {
            if (is_string($value)) {
                $value = trim(preg_replace('/\s+/', ' ', $value));
                $data[$key] = $value === '' ? null : $value;
            }
        }

        foreach (['phone', 'whatsapp', 'guardian_phone'] as $key) {
            $data[$key] = $this->normalizePhone($data[$key] ?? null);
        }

        $data['cnic'] = $this->normalizeCnic($data['cnic'] ?? null);

        if (! empty($data['gender'])) {
            $data['gender'] = $this->normalizeGender($data['gender']);
        }

        if (! empty($data['status'])) {
            $status = strtolower(str_replace([' ', '/'], '_', trim($data['status'])));
            $data['status'] = in_array($status, ['left', 'dropped', 'left__dropped'], true) ? 'left' : $status;
        }

        if (! empty($data['blood_group'])) {
            $data['blood_group'] = strtoupper(str_replace(' ', '', $data['blood_group']));
        }

        if (! empty($data['admission_form_number'])) {
            $data['admission_form_number'] = strtoupper($data['admission_form_number']);
        }

        // Accept both the new multi-select field and the legacy single `program` value
        // used by older Excel imports and admission records.
        $programs = $data['programs'] ?? [];
        if (! is_array($programs)) {
            $programs = [];
        }
        if (! $programs && filled($data['program'] ?? null)) {
            $programs = [$data['program']];
        }
        if (! $programs && ! empty($data['school_class_id'])) {
            $classProgram = SchoolClass::whereKey($data['school_class_id'])->value('program');
            if ($classProgram) {
                $programs = [$classProgram];
            }
        }
        $data['programs'] = collect($programs)
            ->filter(fn ($program) => is_string($program) && trim($program) !== '')
            ->map(fn ($program) => trim($program))
            ->unique()
            ->values()
            ->all();
        $data['program'] = $data['programs'][0] ?? null;

        // Work out the percentage when only the marks were given.
        if (empty($data['percentage']) && is_numeric($data['obtained_marks'] ?? null) && is_numeric($data['total_marks'] ?? null) && (float) $data['total_marks'] > 0) {
            $data['percentage'] = round(((float) $data['obtained_marks'] / (float) $data['total_marks']) * 100, 2);
        }

        return $data;
    }

    public function normalizePhone(?string $phone): ?string
    {
        if ($phone === null || $phone === '') {
            return null;
        }

        $digits = preg_replace('/\D/', '', $phone);

        if (str_starts_with($digits, '92') && strlen($digits) === 12) {
            $digits = '0' . substr($digits, 2);
        } elseif (strlen($digits) === 10 && str_starts_with($digits, '3')) {
            $digits = '0' . $digits; // Excel dropped the leading zero
        }

        return strlen($digits) === 11 && str_starts_with($digits, '03')
            ? substr($digits, 0, 4) . '-' . substr($digits, 4)
            : $phone;
    }

    public function normalizeCnic(?string $cnic): ?string
    {
        if ($cnic === null || $cnic === '') {
            return null;
        }

        $digits = preg_replace('/\D/', '', $cnic);

        return strlen($digits) === 13
            ? substr($digits, 0, 5) . '-' . substr($digits, 5, 7) . '-' . substr($digits, 12)
            : $cnic;
    }

    public function normalizeGender(?string $gender): ?string
    {
        return match (strtolower(trim((string) $gender))) {
            'm', 'male'                                      => 'Male',
            'f', 'female'                                    => 'Female',
            'o', 'other', 'prefer not to say', 'transgender' => 'Other',
            default                                          => $gender,
        };
    }

    /** Values the form/import may leave empty. */
    public function withDefaults(array $data): array
    {
        $data['status'] ??= 'active';
        $data['session'] ??= $this->defaultSession();
        $data['admission_date'] ??= now()->format('Y-m-d');

        return $data;
    }

    public function defaultSession(): string
    {
        return $this->session ??= Student::withTrashed()->latest('id')->value('session')
            ?? Admission::latest('id')->value('session')
            ?? now()->year . '–' . substr((string) (now()->year + 1), 2);
    }

    /* ------------------------------------------------------------------
     |  Validation
     * ------------------------------------------------------------------ */

    public function rules(array $input, ?Student $student = null): array
    {
        $phone = ['regex:/^03\d{2}-\d{7}$/'];

        $rules = [
            'full_name'       => ['required', 'string', 'min:3', 'max:120'],
            'father_name'     => ['required', 'string', 'min:3', 'max:120'],
            'gender'          => ['required', Rule::in(Student::GENDERS)],
            'date_of_birth'   => ['required', 'date_format:Y-m-d', 'before:today'],
            'cnic'            => ['nullable', 'regex:/^\d{5}-\d{7}-\d$/', Rule::unique('students', 'cnic')->whereNull('deleted_at')->ignore($student?->id)],
            'blood_group'     => ['nullable', Rule::in(Student::BLOOD_GROUPS)],
            'phone'           => ['required', ...$phone],
            'whatsapp'        => ['nullable', ...$phone],
            'guardian_name'   => ['nullable', 'string', 'max:120'],
            'guardian_phone'  => ['nullable', ...$phone],
            'email'           => ['nullable', 'email:rfc', 'max:150'],
            'street'          => ['nullable', 'string', 'max:200'],
            'city'            => ['nullable', 'string', 'max:100'],
            'district'        => ['nullable', 'string', 'max:100'],
            'province'        => ['nullable', Rule::in(Student::PROVINCES)],
            'qualification'   => ['nullable', 'string', 'max:100'],
            'institution'     => ['nullable', 'string', 'max:150'],
            'obtained_marks'  => ['nullable', 'numeric', 'min:0'],
            'total_marks'     => ['nullable', 'numeric', 'min:0'],
            'percentage'      => ['nullable', 'numeric', 'between:0,100'],
            'school_class_id' => ['required', Rule::exists('school_classes', 'id')],
            'section_id'      => ['required', Rule::exists('sections', 'id')->where('school_class_id', $input['school_class_id'] ?? 0)],
            'programs'        => ['nullable', 'array', 'max:12'],
            'programs.*'      => ['required', 'string', 'max:100', 'distinct'],
            'session'         => ['required', 'string', 'max:20'],
            'monthly_tuition_fee' => ['nullable', 'numeric', 'min:0', 'max:10000000', 'decimal:0,2'],
            'admission_date'  => ['nullable', 'date_format:Y-m-d'],
            'status'          => ['required', Rule::in(array_keys(Student::STATUSES))],
            'roll_number'     => ['nullable', 'string', 'max:30', Rule::unique('students', 'roll_number')->ignore($student?->id)],
            'notes'           => ['nullable', 'string', 'max:1000'],
            'photo'           => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];

        // The admission link can only be set when the student is created.
        if (! $student) {
            $rules['admission_form_number'] = ['nullable', 'string', 'max:30', function ($attribute, $value, $fail) {
                [, $error] = $this->resolveAdmission($value);

                if ($error) {
                    $fail($error);
                }
            }];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'date_of_birth.date_format'  => 'Date of birth must be a valid date (for example 25-12-2005).',
            'admission_date.date_format' => 'Admission date must be a valid date (for example 25-12-2026).',
            'phone.regex'                => 'Phone must look like 0300-1234567.',
            'whatsapp.regex'             => 'WhatsApp must look like 0300-1234567.',
            'guardian_phone.regex'       => 'Guardian phone must look like 0300-1234567.',
            'cnic.regex'                 => 'CNIC / B-Form must have 13 digits (for example 35202-1234567-1).',
            'cnic.unique'                => 'A student with this CNIC / B-Form already exists.',
            'roll_number.unique'         => 'This roll number is already used.',
            'section_id.exists'          => 'The selected section does not belong to the selected class.',
            'programs.array'             => 'Select programs using the program list.',
            'programs.*.distinct'        => 'A program can only be selected once.',
            'gender.in'                  => 'Gender must be Male, Female or Other.',
        ];
    }

    public function attributes(): array
    {
        return [
            'school_class_id'       => 'class',
            'section_id'            => 'section',
            'programs'              => 'programs',
            'monthly_tuition_fee'   => 'monthly tuition fee override',
            'cnic'                  => 'CNIC / B-Form',
            'admission_form_number' => 'admission form number',
        ];
    }

    /* ------------------------------------------------------------------
     |  Online admission link
     * ------------------------------------------------------------------ */

    /** @return array{0: ?Admission, 1: ?string}  [application, error message] */
    public function resolveAdmission(?string $formNumber): array
    {
        if (blank($formNumber)) {
            return [null, null];
        }

        $admission = Admission::findByFormNumber($formNumber);

        if (! $admission) {
            return [null, 'No admission application was found for form number ' . strtoupper(trim($formNumber)) . '.'];
        }

        if (! in_array($admission->status, ['approved', 'enrolled'], true)) {
            return [$admission, 'Application ' . $admission->form_number . ' is "' . $admission->status_label . '". Only approved or enrolled applications can be added as students.'];
        }

        $linked = Student::withTrashed()->where('admission_id', $admission->id)->first();

        if ($linked) {
            return [$admission, $linked->trashed()
                ? 'This application belongs to a deleted student (' . $linked->roll_number . '). Restore that student instead.'
                : 'This application is already linked to student ' . $linked->roll_number . ' (' . $linked->full_name . ').'];
        }

        return [$admission, null];
    }

    /** Student fields taken from an application. */
    public function fromAdmission(Admission $a): array
    {
        return [
            'full_name'      => $a->full_name,
            'father_name'    => $a->father_name,
            'gender'         => $this->normalizeGender($a->gender),
            'date_of_birth'  => $a->date_of_birth?->format('Y-m-d'),
            'cnic'           => $this->normalizeCnic($a->cnic),
            'phone'          => $this->normalizePhone($a->phone),
            'whatsapp'       => $this->normalizePhone($a->whatsapp),
            'email'          => $a->email,
            'qualification'  => $a->qualification,
            'institution'    => $a->institution,
            'obtained_marks' => $a->obtained_marks,
            'total_marks'    => $a->total_marks,
            'percentage'     => $a->percentage,
            'program'        => $a->program,
            'programs'       => filled($a->program) ? [$a->program] : [],
            'session'        => $a->session,
            'street'         => $a->street,
            'city'           => $a->city,
            'district'       => $a->district,
            'province'       => $a->province,
            'roll_number'    => $a->roll_number,
        ];
    }

    /* ------------------------------------------------------------------
     |  Create / update
     * ------------------------------------------------------------------ */

    /** @throws DomainException */
    public function create(array $data, ?UploadedFile $photo = null): Student
    {
        [$admission, $error] = $this->resolveAdmission($data['admission_form_number'] ?? null);

        if ($error) {
            throw new DomainException($error);
        }

        return DB::transaction(function () use ($data, $photo, $admission) {
            $data = $this->withDefaults($data);

            if ($admission) {
                // Approved -> Enrolled (writes the history entry and gives the application a roll number).
                if ($admission->status === 'approved') {
                    $this->admissions->changeStatus($admission, 'enrolled', 'Student record created.', auth('admin')->id());
                    $admission->refresh();
                }

                $data['admission_id']          = $admission->id;
                $data['admission_form_number'] = $admission->form_number;
            } else {
                $data['admission_id']          = null;
                $data['admission_form_number'] = null;
            }

            $roll = $data['roll_number'] ?? $admission?->roll_number;
            if (blank($roll) || Student::withTrashed()->where('roll_number', $roll)->exists()) {
                $roll = $this->nextRollNumber();
            }
            $data['roll_number'] = $roll;

            $programs = $data['programs'] ?? [];
            if (! $programs && filled($data['program'] ?? null)) {
                $programs = [$data['program']];
            }
            if (! $programs) {
                $classProgram = SchoolClass::whereKey($data['school_class_id'])->value('program');
                if ($classProgram) {
                    $programs = [$classProgram];
                }
            }
            $programs = collect($programs)->filter()->map(fn ($program) => trim((string) $program))->unique()->values()->all();
            $data['program'] = $programs[0] ?? null;
            unset($data['programs']);

            $data['photo_path'] = $this->storePhoto($photo, $admission);

            $student = Student::create(Arr::only($data, (new Student)->getFillable()));
            $this->syncPrograms($student, $programs);

            return $student;
        });
    }

    public function update(Student $student, array $data, ?UploadedFile $photo = null): Student
    {
        unset($data['admission_form_number'], $data['admission_id']); // never changes after creation

        if (blank($data['roll_number'] ?? null)) {
            unset($data['roll_number']);
        }

        $oldPhoto = $student->photo_path;
        $programs = $data['programs'] ?? [];
        if (! $programs && filled($data['program'] ?? null)) {
            $programs = [$data['program']];
        }
        $programs = collect($programs)->filter()->map(fn ($program) => trim((string) $program))->unique()->values()->all();
        $data['program'] = $programs[0] ?? null;
        unset($data['programs']);

        if ($photo) {
            $data['photo_path'] = $this->storePhoto($photo);
        }

        DB::transaction(function () use ($student, $data, $programs) {
            $student->update(Arr::only($data, $student->getFillable()));
            $this->syncPrograms($student, $programs);
        });

        if ($photo && $oldPhoto) {
            File::delete(public_path($oldPhoto));
        }

        return $student->refresh();
    }

    /** Replace the student's linked program list while preserving a single legacy primary value. */
    private function syncPrograms(Student $student, array $programs): void
    {
        $student->programEnrollments()->delete();

        if ($programs) {
            $student->programEnrollments()->createMany(array_map(
                fn ($program) => ['program' => $program],
                $programs
            ));
        }
    }

    /**
     * Next free roll number, e.g. KT-26-0043.
     * Looks at students AND admissions, so both always share one sequence.
     */
    public function nextRollNumber(): string
    {
        $prefix = 'KT-' . now()->format('y') . '-';

        $max = Student::withTrashed()->where('roll_number', 'like', $prefix . '%')->pluck('roll_number')
            ->merge(Admission::where('roll_number', 'like', $prefix . '%')->pluck('roll_number'))
            ->map(fn ($roll) => (int) substr($roll, strlen($prefix)))
            ->max() ?? 0;

        return $prefix . str_pad((string) ($max + 1), 4, '0', STR_PAD_LEFT);
    }

    private function storePhoto(?UploadedFile $photo, ?Admission $admission = null): ?string
    {
        $folder = public_path(self::PHOTO_FOLDER);
        File::ensureDirectoryExists($folder);

        if ($photo) {
            $name = Str::uuid() . '.' . $photo->extension();
            $photo->move($folder, $name);

            return self::PHOTO_FOLDER . '/' . $name;
        }

        // No upload: reuse the photo from the online admission form.
        if ($admission && $admission->personal_picture_path && Storage::disk('local')->exists($admission->personal_picture_path)) {
            $name = Str::uuid() . '.' . pathinfo($admission->personal_picture_path, PATHINFO_EXTENSION);
            File::put($folder . '/' . $name, Storage::disk('local')->get($admission->personal_picture_path));

            return self::PHOTO_FOLDER . '/' . $name;
        }

        return null;
    }
}