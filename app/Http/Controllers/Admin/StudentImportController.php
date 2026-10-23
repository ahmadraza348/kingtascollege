<?php

namespace App\Http\Controllers\Admin;

use App\Exports\StudentsTemplateExport;
use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Services\Admin\StudentImportService;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Throwable;

class StudentImportController extends Controller
{
    private const TMP = 'imports/students';

    public function __construct(private StudentImportService $importer)
    {
    }

    public function create(): View
    {
        $classes = SchoolClass::active()->orderBy('sort_order')->orderBy('name')->get();

        return view('backend.student.import', compact('classes'));
    }

    public function template(): BinaryFileResponse
    {
        return Excel::download(new StudentsTemplateExport, 'students-import-template.xlsx');
    }

    /** Step 1: read the file and show what would happen. Nothing is saved yet. */
    public function preview(Request $request): View|RedirectResponse
    {
        $request->validate([
            'file'               => ['required', 'file', 'mimes:xlsx,xls,csv,txt', 'max:5120'],
            'default_class_id'   => ['nullable', 'exists:school_classes,id'],
            'default_section_id' => ['nullable', Rule::exists('sections', 'id')->where('school_class_id', $request->input('default_class_id'))],
        ], [
            'file.required'              => 'Please choose an Excel or CSV file.',
            'file.mimes'                 => 'The file must be .xlsx, .xls or .csv.',
            'default_section_id.exists'  => 'The selected section does not belong to the selected class.',
        ]);

        set_time_limit(120);

        try {
            $parsed = $this->importer->parse($request->file('file'));
        } catch (DomainException $e) {
            toastr()->error($e->getMessage());

            return back()->withInput();
        } catch (Throwable $e) {
            report($e);
            toastr()->error('The file could not be read. Make sure it is a valid .xlsx or .csv file.');

            return back()->withInput();
        }

        $classId   = $request->integer('default_class_id') ?: null;
        $sectionId = $request->integer('default_section_id') ?: null;

        // Keep the parsed rows until the user confirms (old temp files are cleaned up here).
        $this->cleanOldFiles();
        $token = (string) Str::uuid();
        Storage::disk('local')->put(self::TMP . "/{$token}.json", json_encode([
            'class' => $classId, 'section' => $sectionId, 'rows' => $parsed,
        ]));

        $built = $this->importer->build($parsed, $classId, $sectionId);

        return view('backend.student.import_preview', [
            'built'   => $built,
            'token'   => $token,
            'total'   => count($built),
            'valid'   => collect($built)->where('ok', true)->count(),
        ]);
    }

    /** Step 2: import the valid rows (everything is re-validated first). */
    public function commit(Request $request): RedirectResponse
    {
        $request->validate(['token' => ['required', 'uuid']]);

        $path = self::TMP . '/' . $request->input('token') . '.json';

        if (! Storage::disk('local')->exists($path)) {
            toastr()->error('This import has expired. Please upload the file again.');

            return redirect()->route('student.import');
        }

        set_time_limit(300);

        $payload = json_decode(Storage::disk('local')->get($path), true);
        $built   = $this->importer->build($payload['rows'], $payload['class'], $payload['section']);
        $result  = $this->importer->commit($built);

        Storage::disk('local')->delete($path);

        $skipped = collect($built)->where('ok', false)
            ->map(fn ($r) => 'Row ' . $r['line'] . ': ' . implode(' ', $r['errors']))
            ->merge($result['failed'])
            ->values()->all();

        toastr()->success($result['created'] . ' ' . str('student')->plural($result['created']) . ' imported.');

        return redirect()->route('student.index')->with('import_skipped', $skipped);
    }

    private function cleanOldFiles(): void
    {
        $disk = Storage::disk('local');

        foreach ($disk->files(self::TMP) as $file) {
            if ($disk->lastModified($file) < now()->subDay()->timestamp) {
                $disk->delete($file);
            }
        }
    }
}