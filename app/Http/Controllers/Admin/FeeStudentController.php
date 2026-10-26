<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeeVoucher;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Student;
use App\Services\Admin\FeeReportService;
use App\Support\FeeHelper;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\View\View;

/** "Student fee accounts": one line per student, and the full statement of each. */
class FeeStudentController extends Controller
{
    public function index(Request $request): View
    {
        $search  = trim((string) $request->query('q'));
        $balance = $request->query('balance');
        $status  = $request->query('student_status', 'active');
        $classId = $request->integer('class') ?: null;

        $live = fn ($q) => $q->where('status', '!=', 'cancelled');

        $students = Student::query()
            ->with(['schoolClass:id,name', 'section:id,name'])
            ->withSum(['feeVouchers as billed' => $live], 'total_amount')
            ->withSum(['feeVouchers as paid' => $live], 'paid_amount')
            ->withSum(['feeVouchers as due' => $live], 'balance')
            ->withExists(['feeVouchers as has_overdue_voucher' => fn ($q) => $q->overdue()])
            ->when($search !== '', fn ($q) => $q->where(fn ($w) => $w->where('full_name', 'like', "%$search%")->orWhere('roll_number', 'like', "%$search%")->orWhere('cnic', 'like', "%$search%")))
            ->when($classId, fn ($q) => $q->where('school_class_id', $classId))
            ->when($request->integer('section'), fn ($q, $s) => $q->where('section_id', $s))
            ->when(isset(Student::STATUSES[$status]), fn ($q) => $q->where('status', $status))
            ->when($balance === 'due', fn ($q) => $q->whereHas('feeVouchers', fn ($v) => $v->open()))
            ->when($balance === 'overdue', fn ($q) => $q->whereHas('feeVouchers', fn ($v) => $v->overdue()))
            ->when($balance === 'clear', fn ($q) => $q->whereDoesntHave('feeVouchers', fn ($v) => $v->open()))
            ->orderBy('school_class_id')->orderBy('section_id')->orderBy('roll_number')
            ->paginate(config('fees.per_page'))->withQueryString();

        return view('backend.fees.students.index', [
            'students' => $students,
            'classes'  => SchoolClass::orderBy('sort_order')->orderBy('name')->get(),
            'sections' => $classId ? Section::where('school_class_id', $classId)->orderBy('name')->get() : collect(),
            'filters'  => $request->query(),
        ]);
    }

    public function show(Student $student, FeeReportService $reports): View
    {
        $student->load(['schoolClass', 'section']);

        return view('backend.fees.students.show', [
            'student'     => $student,
            'statement'   => $reports->statement($student),
            'vouchers'    => FeeVoucher::where('student_id', $student->id)->latest('period')->latest('id')->get(),
        ]);
    }

    public function statementPdf(Student $student, FeeReportService $reports)
    {
        $student->load(['schoolClass', 'section']);

        return Pdf::loadView('backend.fees.pdf.statement', [
            'student'    => $student,
            'statement'  => $reports->statement($student),
            'letterhead' => FeeHelper::letterhead(),
        ])->setPaper('a4', 'portrait')->stream('fee-statement-' . $student->roll_number . '.pdf');
    }

}
