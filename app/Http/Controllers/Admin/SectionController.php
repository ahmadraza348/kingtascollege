<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Section;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class SectionController extends Controller
{
    private function rules(Request $request, ?Section $section = null): array
    {
        return [
            'school_class_id' => ['required', 'integer', Rule::exists('school_classes', 'id')],
            'name'            => [
                'required', 'string', 'max:50',
                Rule::unique('sections', 'name')
                    ->where('school_class_id', $request->input('school_class_id'))
                    ->ignore($section?->id),
            ],
            'room'            => ['nullable', 'string', 'max:50'],
            'class_teacher'   => ['nullable', 'string', 'max:100'],
            'capacity'        => ['nullable', 'integer', 'min:1', 'max:1000'],
            'is_active'       => ['required', 'boolean'],
        ];
    }

    private function messages(): array
    {
        return [
            'school_class_id.required' => 'Please select a class.',
            'name.unique'              => 'This section already exists in the selected class.',
        ];
    }

    public function index(Request $request): View
    {
        $classId = $request->integer('class') ?: null;

        $sections = Section::with('schoolClass')
            ->when($classId, fn ($q) => $q->where('school_class_id', $classId))
            ->orderBy('school_class_id')
            ->orderBy('name')
            ->get();

        $classes = SchoolClass::orderBy('sort_order')->orderBy('name')->get();

        return view('backend.section.index', compact('sections', 'classes', 'classId'));
    }

    public function create(Request $request): View
    {
        $section = new Section([
            'is_active'       => true,
            'school_class_id' => $request->integer('class') ?: null,
        ]);
        $classes = SchoolClass::active()->orderBy('sort_order')->orderBy('name')->get();

        return view('backend.section.create', compact('section', 'classes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate($this->rules($request), $this->messages());

        Section::create($data);

        toastr()->success('Section added successfully.');

        return redirect()->route('section.index', ['class' => $data['school_class_id']]);
    }

    public function edit(Section $section): View
    {
        $classes = SchoolClass::orderBy('sort_order')->orderBy('name')->get();

        return view('backend.section.edit', compact('section', 'classes'));
    }

    public function update(Request $request, Section $section): RedirectResponse
    {
        $data = $request->validate($this->rules($request, $section), $this->messages());

        $section->update($data);

        toastr()->success('Section updated successfully.');

        return redirect()->route('section.index', ['class' => $data['school_class_id']]);
    }

    public function destroy(Section $section): RedirectResponse
    {
        if ($section->students()->withTrashed()->exists()) {
            toastr()->error('This section has students. Move or remove them first.');

            return redirect()->route('section.index', ['class' => $section->school_class_id]);
        }

        $classId = $section->school_class_id;
        $section->delete();

        toastr()->success('Section deleted.');

        return redirect()->route('section.index', ['class' => $classId]);
    }

       /** AJAX: active sections of a class, for dependent dropdowns. */
    public function byClass(SchoolClass $schoolClass): JsonResponse
    {
        return response()->json(
            $schoolClass->sections()->active()->orderBy('name')->get(['id', 'name'])
        );
    }
}