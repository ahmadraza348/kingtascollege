<?php

namespace App\Http\Requests\Admin;

use App\Models\Expense;
use App\Models\ExpensePayment;
use App\Support\FeeHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/** Used for both adding and editing an expense. */
class StoreExpenseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        /** @var Expense|null $current */
        $current = $this->route('expense');
        $creating = $current === null;
        $today = FeeHelper::today()->toDateString();

        $rules = [
            // A category switched off later can still stay on bills that already use it.
            'expense_category_id' => ['required', Rule::exists('expense_categories', 'id')->where(
                fn ($q) => $q->where(fn ($w) => $w->where('is_active', true)
                    ->when($current, fn ($x) => $x->orWhere('id', $current->expense_category_id)))
            )],
            'title'        => ['required', 'string', 'max:150'],
            'payee'        => ['nullable', 'string', 'max:150'],
            'reference_no' => ['nullable', 'string', 'max:60'],
            'expense_date' => ['required', 'date_format:Y-m-d', 'before_or_equal:' . $today],
            'due_date'     => ['nullable', 'date_format:Y-m-d', 'after_or_equal:expense_date'],
            'amount'       => ['required', 'numeric', 'min:1', 'max:100000000', 'decimal:0,2'],
            'description'  => ['nullable', 'string', 'max:1000'],
            'attachment'   => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:4096'],
        ];

        if ($creating) {
            $rules += [
                'payment_option'    => ['required', Rule::in(['paid', 'unpaid', 'partial'])],
                'paid_amount'       => ['nullable', 'required_if:payment_option,partial', 'numeric', 'min:1', 'lt:amount', 'decimal:0,2'],
                'payment_date'      => ['nullable', 'required_if:payment_option,paid,partial', 'date_format:Y-m-d', 'after_or_equal:expense_date', 'before_or_equal:' . $today],
                'payment_method'    => ['nullable', 'required_if:payment_option,paid,partial', Rule::in(array_keys(ExpensePayment::METHODS))],
                'payment_reference' => ['nullable', 'string', 'max:60'],
                'submit_token'      => ['required', 'string', 'max:40'],
            ];
        } else {
            $rules['remove_attachment'] = ['nullable', 'boolean'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'expense_date.before_or_equal'  => 'The bill date cannot be in the future.',
            'due_date.after_or_equal'       => 'The due date cannot be before the bill date.',
            'paid_amount.lt'                => 'For a part payment the amount paid must be less than the full amount. Choose "Paid in full" instead.',
            'paid_amount.required_if'       => 'Enter how much has been paid so far.',
            'payment_date.required_if'      => 'Enter the date the payment was made.',
            'payment_date.after_or_equal'   => 'The payment date cannot be before the bill date.',
            'payment_method.required_if'    => 'Choose how it was paid.',
            'attachment.mimes'              => 'Attach a PDF, JPG or PNG file.',
            'attachment.max'                => 'The attachment must be 4 MB or smaller.',
        ];
    }
}
