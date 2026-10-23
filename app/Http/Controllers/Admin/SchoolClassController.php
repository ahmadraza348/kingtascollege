<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SchoolClassController extends Controller
{
    private function rules(?SchoolClass $schoolClass = null): array
    {
        return [
            'name'        => ['required', 'string', 'max:100', Rule::unique('school_classes', 'name')->ignore($schoolClass?->id)],
            'code'        => ['nullable', 'string', 'max:30', Rule::unique('school_classes', 'code')->ignore($schoolClass?->id)],
            'program'     => ['nullable', 'string', Rule::in(SchoolClass::PROGRAMS)],
            'description' => ['nullable', 'string', 'max:500'],
            'sort_order'  => ['nullable', 'integer', 'min:0', 'max:65535'],
            'is_active'   => ['required', 'boolean'],
        ];
    }

    public function index(): View
    {
        $classes = SchoolClass::withCount('sections')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('backend.school_class.index', compact('classes'));
    }

    public function create(): View
    {
        $schoolClass = new SchoolClass(['is_active' => true, 'sort_order' => 0]);

        return view('backend.school_class.create', compact('schoolClass'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate($this->rules());
        $data['sort_order'] = $data['sort_order'] ?? 0;

        SchoolClass::create($data);

        toastr()->success('Class added successfully.');

        return redirect()->route('school-class.index');
    }

    public function edit(SchoolClass $schoolClass): View
    {
        return view('backend.school_class.edit', compact('schoolClass'));
    }

    public function update(Request $request, SchoolClass $schoolClass): RedirectResponse
    {
        $data = $request->validate($this->rules($schoolClass));
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $schoolClass->update($data);

        toastr()->success('Class updated successfully.');

        return redirect()->route('school-class.index');
    }

    public function destroy(SchoolClass $schoolClass): RedirectResponse
    {
        if ($schoolClass->students()->withTrashed()->exists()) {
            toastr()->error('This class has students. Move or remove them first.');

            return redirect()->route('school-class.index');
        }

        $schoolClass->delete();

        toastr()->success('Class deleted.');

        return redirect()->route('school-class.index');
    }
}
