<?php

namespace App\Http\Requests\Admin;

use App\Models\Expense;
use App\Models\ExpensePayment;
use App\Support\FeeHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreExpensePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        /** @var Expense $expense */
        $expense = $this->route('expense');

        return [
            'payment_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:' . $expense->expense_date->toDateString(), 'before_or_equal:' . FeeHelper::today()->toDateString()],
            'amount'       => ['required', 'numeric', 'min:1', 'max:100000000', 'decimal:0,2'],
            'method'       => ['required', Rule::in(array_keys(ExpensePayment::METHODS))],
            'reference_no' => ['nullable', 'string', 'max:60'],
            'remarks'      => ['nullable', 'string', 'max:255'],
            'submit_token' => ['required', 'string', 'max:40'],
        ];
    }

    public function messages(): array
    {
        return [
            'payment_date.after_or_equal'  => 'The payment date cannot be before the bill date.',
            'payment_date.before_or_equal' => 'The payment date cannot be in the future.',
        ];
    }
}
