<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ReasonRequest;
use App\Http\Requests\Admin\StoreExpensePaymentRequest;
use App\Models\Expense;
use App\Models\ExpensePayment;
use App\Services\Admin\ExpenseService;
use DomainException;
use Illuminate\Http\RedirectResponse;

class ExpensePaymentController extends Controller
{
    public function __construct(private ExpenseService $expenses)
    {
    }

    public function store(StoreExpensePaymentRequest $request, Expense $expense): RedirectResponse
    {
        try {
            $payment = $this->expenses->addPayment($expense, $request->validated());
        } catch (DomainException $e) {
            toastr()->error($e->getMessage());

            return back()->withInput();
        }

        toastr()->success('Payment of ' . fee_money($payment->amount) . ' recorded.');

        return redirect()->route('expenses.show', $expense);
    }

    public function cancel(ReasonRequest $request, ExpensePayment $payment): RedirectResponse
    {
        try {
            $this->expenses->cancelPayment($payment, $request->validated('reason'));
        } catch (DomainException $e) {
            toastr()->error($e->getMessage());

            return back();
        }

        toastr()->success('Payment cancelled. The amount is due again.');

        return redirect()->route('expenses.show', $payment->expense_id);
    }
}
