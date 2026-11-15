<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ArrayExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ReasonRequest;
use App\Http\Requests\Admin\StoreExpenseRequest;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Services\Admin\ExpenseService;
use App\Support\FeeHelper;
use DomainException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class ExpenseController extends Controller
{
    public function __construct(private ExpenseService $expenses)
    {
    }

    public function index(Request $request): View
    {
        $query = $this->filtered($request);

        // Totals of everything that matches the filters (not only the current page).
        $totals = (clone $query)->setEagerLoads([])->notCancelled()->selectRaw('COALESCE(SUM(amount),0) AS amount, COALESCE(SUM(paid_amount),0) AS paid')->first();

        return view('backend.expenses.index', [
            'expenses'   => (clone $query)->latest('expense_date')->latest('id')->paginate(config('fees.per_page'))->withQueryString(),
            'categories' => ExpenseCategory::orderBy('sort_order')->orderBy('name')->get(['id', 'name']),
            'counts'     => Expense::selectRaw('status, COUNT(*) AS total')->groupBy('status')->pluck('total', 'status'),
            'overdueCount' => Expense::overdue()->count(),
            'totals'     => [
                'amount'  => round((float) $totals->amount, 2),
                'paid'    => round((float) $totals->paid, 2),
                'balance' => round((float) $totals->amount - (float) $totals->paid, 2),
            ],
            'filters'    => $request->query(),
        ]);
    }

    public function export(Request $request)
    {
        $rows = $this->filtered($request)->latest('expense_date')->latest('id')->get()->map(fn (Expense $e) => [
            $e->expense_number,
            $e->expense_date->format('d-m-Y'),
            $e->category?->name,
            $e->title,
            $e->payee,
            $e->reference_no,
            $e->due_date?->format('d-m-Y'),
            (float) $e->amount,
            (float) $e->paid_amount,
            $e->balance,
            $e->status_label,
        ])->all();

        return Excel::download(new ArrayExport(
            ['Expense No', 'Bill Date', 'Category', 'Title', 'Payee', 'Bill / Invoice No', 'Due Date', 'Amount', 'Paid', 'Balance Due', 'Status'],
            $rows
        ), 'expenses-' . FeeHelper::today()->format('Y-m-d') . '.xlsx');
    }

    public function create(Request $request): View
    {
        return $this->form(null);
    }

    public function store(StoreExpenseRequest $request): RedirectResponse
    {
        try {
            $expense = $this->expenses->create($request->validated(), $request->file('attachment'));
        } catch (DomainException $e) {
            toastr()->error($e->getMessage());

            return back()->withInput();
        }

        toastr()->success('Expense ' . $expense->expense_number . ' saved.');

        return redirect()->route('expenses.show', $expense);
    }

    public function show(Expense $expense): View
    {
        $expense->load(['category', 'creator', 'payments.creator']);

        return view('backend.expenses.show', [
            'expense' => $expense,
            'token'   => (string) Str::uuid(),
            'today'   => FeeHelper::today()->toDateString(),
        ]);
    }

    public function edit(Expense $expense): View|RedirectResponse
    {
        if ($expense->status === 'cancelled') {
            toastr()->error('A cancelled expense cannot be edited.');

            return redirect()->route('expenses.show', $expense);
        }

        return $this->form($expense);
    }

    public function update(StoreExpenseRequest $request, Expense $expense): RedirectResponse
    {
        try {
            $this->expenses->update($expense, $request->validated(), $request->file('attachment'), $request->boolean('remove_attachment'));
        } catch (DomainException $e) {
            toastr()->error($e->getMessage());

            return back()->withInput();
        }

        toastr()->success('Expense updated.');

        return redirect()->route('expenses.show', $expense);
    }

    public function cancel(ReasonRequest $request, Expense $expense): RedirectResponse
    {
        try {
            $this->expenses->cancelExpense($expense, $request->validated('reason'));
        } catch (DomainException $e) {
            toastr()->error($e->getMessage());

            return back();
        }

        toastr()->success('Expense cancelled.');

        return redirect()->route('expenses.show', $expense);
    }

    /** The bill / receipt photo, only for logged-in admins. */
    public function attachment(Expense $expense)
    {
        abort_unless($expense->attachment_path && Storage::disk($this->expenses->disk())->exists($expense->attachment_path), 404);

        return Storage::disk($this->expenses->disk())->response($expense->attachment_path, $expense->attachment_name);
    }

    private function form(?Expense $expense): View
    {
        return view('backend.expenses.form', [
            'expense'    => $expense,
            'categories' => ExpenseCategory::where(fn ($q) => $q->where('is_active', true)->when($expense, fn ($w) => $w->orWhere('id', $expense->expense_category_id)))
                ->orderBy('sort_order')->orderBy('name')->get(['id', 'name']),
            'payees'     => Expense::whereNotNull('payee')->distinct()->orderBy('payee')->limit(200)->pluck('payee'),
            'token'      => (string) Str::uuid(),
            'today'      => FeeHelper::today()->toDateString(),
        ]);
    }

    private function filtered(Request $request): Builder
    {
        $status = (string) $request->query('status');
        $search = trim((string) $request->query('q'));

        return Expense::with('category:id,name')
            ->when(isset(Expense::STATUSES[$status]), fn ($q) => $q->where('status', $status))
            ->when($status === 'due', fn ($q) => $q->open())
            ->when($status === 'overdue', fn ($q) => $q->overdue())
            ->when($request->filled('category'), fn ($q) => $q->where('expense_category_id', $request->integer('category')))
            ->when($request->filled('from'), fn ($q) => $q->whereDate('expense_date', '>=', $request->query('from')))
            ->when($request->filled('to'), fn ($q) => $q->whereDate('expense_date', '<=', $request->query('to')))
            ->when($search !== '', fn ($q) => $q->where(fn ($w) => $w
                ->where('title', 'like', "%$search%")
                ->orWhere('payee', 'like', "%$search%")
                ->orWhere('expense_number', 'like', "%$search%")
                ->orWhere('reference_no', 'like', "%$search%")));
    }
}
