<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateAdmissionNotesRequest;
use App\Http\Requests\Admin\UpdateAdmissionStatusRequest;
use App\Models\Admission;
use App\Services\Admin\AdmissionManagementService;
use App\Services\Frontend\AdmissionNotificationService;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdmissionController extends Controller
{
    public function __construct(private AdmissionManagementService $service)
    {
    }

    /**
     * List applications. Search, sorting and paging are done by the theme's DataTable,
     * so we simply send all rows (optionally narrowed by the status cards).
     */
    public function index(Request $request): View
    {
        $status = $request->query('status');

        $admissions = Admission::query()
            ->when(array_key_exists($status, Admission::STATUSES), fn ($q) => $q->where('status', $status))
            ->latest()
            ->get();

        // One query for all the numbers shown in the cards.
        $counts = Admission::selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status');

        return view('backend.admission.index', compact('admissions', 'counts', 'status'));
    }

    public function show(Admission $admission): View
    {
        $admission->load('logs.admin');

        // Same CNIC applied more than once? Warn the admin.
        $duplicates = Admission::where('cnic', $admission->cnic)->where('id', '!=', $admission->id)->get();

        return view('backend.admission.show', compact('admission', 'duplicates'));
    }

    public function updateStatus(UpdateAdmissionStatusRequest $request, Admission $admission): RedirectResponse
    {
        $data = $request->validated();

        try {
            $this->service->changeStatus($admission, $data['status'], $data['remarks'] ?? null, auth('admin')->id());
        } catch (DomainException $e) {
            toastr()->error($e->getMessage());

            return back()->withInput();
        }

        if ($request->boolean('notify')) {
            $this->service->notifyStudent($admission, $data['remarks'] ?? null);
        }

        toastr()->success('Status changed to ' . $admission->status_label . '.');

        return back();
    }

    public function updateNotes(UpdateAdmissionNotesRequest $request, Admission $admission): RedirectResponse
    {
        $admission->update(['internal_notes' => $request->validated()['internal_notes'] ?? null]);

        toastr()->success('Internal notes saved.');

        return back();
    }

    /** Tick / untick a document as verified. */
    public function toggleDocument(Admission $admission, string $key): RedirectResponse
    {
        $verified = $this->service->toggleDocument($admission, $key);

        toastr()->success($verified ? 'Document marked as verified.' : 'Verification removed.');

        return back();
    }

    /** Stream a private file to the admin (inline preview, or ?download=1). */
    public function document(Request $request, Admission $admission, string $key)
    {
        // The path always comes from the database, never from the URL.
        $doc = $admission->documents()->firstWhere('key', $key);
        abort_unless($doc && Storage::disk('local')->exists($doc['path']), 404);

        if ($request->boolean('download')) {
            $name = $admission->form_number . '-' . $doc['key'] . '.' . pathinfo($doc['path'], PATHINFO_EXTENSION);

            return Storage::disk('local')->download($doc['path'], $name);
        }

        return Storage::disk('local')->response($doc['path']);
    }

    /** Download the printable admission form (office copy). */
    public function pdf(Admission $admission, AdmissionNotificationService $pdfMaker)
    {
        $bytes = $pdfMaker->makePdf($admission, 'Office Copy');

        return response($bytes, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="Admission-Form-' . $admission->form_number . '.pdf"',
        ]);
    }

    /** Export applications to CSV (opens in Excel). Respects the status card filter. */
    public function export(Request $request): StreamedResponse
    {
        $status = $request->query('status');

        $rows = Admission::query()
            ->when(array_key_exists($status, Admission::STATUSES), fn ($q) => $q->where('status', $status))
            ->latest();

        return response()->streamDownload(function () use ($rows) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF"); // UTF-8 BOM so Excel shows characters correctly
            fputcsv($out, $this->service->csvHeaders());

            foreach ($rows->cursor() as $admission) {
                fputcsv($out, $this->service->csvRow($admission));
            }

            fclose($out);
        }, 'admissions-' . now()->format('Y-m-d') . '.csv', ['Content-Type' => 'text/csv']);
    }

    public function destroy(Admission $admission): RedirectResponse
    {
        $this->service->delete($admission);

        toastr()->success('Application deleted.');

        return redirect()->route('admission.index');
    }
}
