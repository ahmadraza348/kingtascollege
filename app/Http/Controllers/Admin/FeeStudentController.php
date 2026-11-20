<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Student;
use App\Services\Admin\FeeAccountBookService;
use App\Services\Admin\FeeReportService;
use App\Services\Admin\FeeBalanceService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\View\View;

/** Student fee accounts: finalized fee, verified receipts and individual vouchers. */
class FeeStudentController extends Controller
{
    public function index(Request $request, FeeBalanceService $balances): View
    {
        $search  = trim((string) $request->query('q'));
        $balance = $request->query('balance');
        $status  = $request->query('student_status', 'active');
        $classId = $request->integer('class') ?: null;

        $students = Student::query()
            ->leftJoinSub($balances->studentBaseCollectionQuery(), 'base_collection', fn ($join) => $join->on('base_collection.student_id', '=', 'students.id'))
            ->select('students.*')
            ->addSelect('base_collection.base_received as base_received')
            ->with(['schoolClass:id,name', 'section:id,name'])
            ->withSum(['feePayments as received' => fn ($query) => $query->where('status', 'verified')], 'amount')
            ->withExists(['feeVouchers as has_overdue_voucher' => fn ($query) => $query->overdue()])
            ->when($search !== '', fn ($query) => $query->where(fn ($where) => $where
                ->where('full_name', 'like', "%$search%")
                ->orWhere('roll_number', 'like', "%$search%")
                ->orWhere('cnic', 'like', "%$search%")))
            ->when($classId, fn ($query) => $query->where('school_class_id', $classId))
            ->when($request->integer('section'), fn ($query, $section) => $query->where('section_id', $section))
            ->when(isset(Student::STATUSES[$status]), fn ($query) => $query->where('status', $status))
            ->when($balance === 'due', fn ($query) => $query->whereNotNull('students.finalized_fee')->whereRaw('COALESCE(students.finalized_fee, 0) > COALESCE(base_collection.base_received, 0)'))
            ->when($balance === 'overdue', fn ($query) => $query->whereHas('feeVouchers', fn ($voucherQuery) => $voucherQuery->overdue()))
            ->when($balance === 'clear', fn ($query) => $query->whereNotNull('students.finalized_fee')->whereRaw('COALESCE(students.finalized_fee, 0) <= COALESCE(base_collection.base_received, 0)'))
            ->orderBy('school_class_id')->orderBy('section_id')->orderBy('roll_number')
            ->paginate(config('fees.per_page'))->withQueryString();

        return view('backend.fees.students.index', [
            'students' => $students,
            'classes'  => SchoolClass::orderBy('sort_order')->orderBy('name')->get(),
            'sections' => $classId ? Section::where('school_class_id', $classId)->orderBy('name')->get() : collect(),
            'filters'  => $request->query(),
        ]);
    }

    public function show(Student $student, FeeAccountBookService $books, FeeReportService $reports): View
    {
        $student->load(['schoolClass', 'section']);

        return view('backend.fees.students.show', [
            'student'   => $student,
            'book'      => $books->build($student),
            'statement' => $reports->statement($student),
        ]);
    }

    public function statementPdf(Student $student, FeeReportService $reports, FeeAccountBookService $books)
    {
        $student->load(['schoolClass', 'section']);

        return Pdf::loadView('backend.fees.pdf.statement', [
            'student'    => $student,
            'book'       => $books->build($student),
            'statement'  => $reports->statement($student),
            'letterhead' => \App\Support\FeeHelper::letterhead(),
        ])->setPaper('a4', 'portrait')->stream('fee-statement-' . $student->roll_number . '.pdf');
    }
}
