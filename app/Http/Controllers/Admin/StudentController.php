<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Student;
use App\Services\Admin\StudentService;
use DomainException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function __construct(private StudentService $service)
    {
    }

    public function index(Request $request): View
    {
        $classId   = $request->integer('class') ?: null;
        $sectionId = $request->integer('section') ?: null;
        $status    = $request->query('status');
        $trashed   = $request->boolean('trashed');

        $students = Student::query()
            ->with(['schoolClass:id,name', 'section:id,name'])
            ->when($trashed, fn ($q) => $q->onlyTrashed())
            ->when($classId, fn ($q) => $q->where('school_class_id', $classId))
            ->when($sectionId, fn ($q) => $q->where('section_id', $sectionId))
            ->when(is_string($status) && array_key_exists($status, Student::STATUSES), fn ($q) => $q->where('status', $status))
            ->orderBy('school_class_id')->orderBy('section_id')->orderBy('full_name')
            ->get();

        $counts   = Student::selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status');
        $classes  = SchoolClass::orderBy('sort_order')->orderBy('name')->get();
        $sections = $classId ? Section::where('school_class_id', $classId)->orderBy('name')->get() : collect();

        return view('backend.student.index', compact('students', 'counts', 'classes', 'sections', 'classId', 'sectionId', 'status', 'trashed'));
    }

    public function create(Request $request): View
    {
        $student = new Student([
            'status'          => 'active',
            'session'         => $this->service->defaultSession(),
            'admission_date'  => now(),
            'school_class_id' => $request->integer('class') ?: null,
            'section_id'      => $request->integer('section') ?: null,
        ]);

        return view('backend.student.create', $this->formData($student) + [
            'formNumber' => $request->query('form_number'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->merge($this->service->normalize($request->except('photo')));

        $data = $request->validate(
            $this->service->rules($request->all()),
            $this->service->messages(),
            $this->service->attributes()
        );

        try {
            $student = $this->service->create($data, $request->file('photo'));
        } catch (DomainException $e) {
            toastr()->error($e->getMessage());

            return back()->withInput();
        }

        toastr()->success('Student added. Roll number: ' . $student->roll_number);

        return redirect()->route('student.show', $student);
    }

    public function show(Student $student): View
    {
        $student->load(['schoolClass', 'section', 'admission']);

        return view('backend.student.show', compact('student'));
    }

    public function edit(Student $student): View
    {
        return view('backend.student.edit', $this->formData($student));
    }

    public function update(Request $request, Student $student): RedirectResponse
    {
        $request->merge($this->service->normalize($request->except('photo')));

        $data = $request->validate(
            $this->service->rules($request->all(), $student),
            $this->service->messages(),
            $this->service->attributes()
        );

        $this->service->update($student, $data, $request->file('photo'));

        toastr()->success('Student updated.');

        return redirect()->route('student.show', $student);
    }

    /** Soft delete: the record (and later its attendance history) can be restored. */
    public function destroy(Student $student): RedirectResponse
    {
        $student->delete();

        toastr()->success('Student deleted. You can restore it from the "Deleted" list.');

        return redirect()->route('student.index');
    }

    public function restore(int $id): RedirectResponse
    {
        $student = Student::onlyTrashed()->findOrFail($id);
        $student->restore();

        toastr()->success('Student restored.');

        return redirect()->route('student.index');
    }

    /** Move several students to another class/section, or change their status. */
    public function bulk(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'ids'             => ['required', 'array', 'min:1'],
            'ids.*'           => ['integer'],
            'action'          => ['required', Rule::in(['move', 'status'])],
            'school_class_id' => ['required_if:action,move', 'nullable', 'exists:school_classes,id'],
            'section_id'      => ['required_if:action,move', 'nullable', Rule::exists('sections', 'id')->where('school_class_id', $request->input('school_class_id'))],
            'status'          => ['required_if:action,status', 'nullable', Rule::in(array_keys(Student::STATUSES))],
        ], [
            'ids.required'          => 'Select at least one student.',
            'school_class_id.required_if' => 'Choose the class to move the students to.',
            'section_id.required_if'      => 'Choose the section to move the students to.',
            'section_id.exists'           => 'The selected section does not belong to the selected class.',
            'status.required_if'          => 'Choose the new status.',
        ]);

        $query = Student::whereIn('id', $data['ids']);

        $count = $data['action'] === 'move'
            ? $query->update(['school_class_id' => $data['school_class_id'], 'section_id' => $data['section_id']])
            : $query->update(['status' => $data['status']]);

        toastr()->success($count . ' ' . str('student')->plural($count) . ' updated.');

        return back();
    }

    /** AJAX: details of an online admission, used by the "Fetch details" button. */
    public function admissionLookup(Request $request): JsonResponse
    {
        [$admission, $error] = $this->service->resolveAdmission((string) $request->query('form_number'));

        if (! $admission) {
            return response()->json(['ok' => false, 'message' => $error ?? 'Enter an admission form number.'], 404);
        }

        return response()->json([
            'ok'            => $error === null,
            'message'       => $error,
            'form_number'   => $admission->form_number,
            'status'        => $admission->status_label,
            'admission_url' => route('admission.show', $admission),
            'photo_url'     => route('admission.document', [$admission, 'photo']),
            'data'          => $error === null ? $this->service->fromAdmission($admission) : [],
        ]);
    }

    private function formData(Student $student): array
    {
        $classId = old('school_class_id', $student->school_class_id);

        return [
            'student'  => $student,
            // Active classes, plus the student's current class even if it was deactivated later.
            'classes'  => SchoolClass::where(fn ($q) => $q->where('is_active', true)->orWhere('id', $student->school_class_id))
                ->orderBy('sort_order')->orderBy('name')->get(),
            'sections' => $classId ? Section::where('school_class_id', $classId)->orderBy('name')->get() : collect(),
        ];
    }
}