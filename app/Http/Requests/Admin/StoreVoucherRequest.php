<?php

namespace App\Http\Requests\Admin;

use App\Models\FeeVoucher;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreVoucherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_id'          => ['required', Rule::exists('students', 'id')->whereNull('deleted_at')],
            'type'                => ['required', Rule::in(array_keys(FeeVoucher::manualTypes()))],
            'period'              => ['required', 'date_format:Y-m'],
            'issue_date'          => ['required', 'date_format:Y-m-d'],
            'due_date'            => ['required', 'date_format:Y-m-d', 'after_or_equal:issue_date'],
            'amount'              => ['required', 'numeric', 'min:0', 'max:10000000', 'decimal:0,2'],
            'description'         => ['nullable', 'string', 'max:150'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if ($this->input('type') !== 'monthly' && (float) $this->input('amount', 0) <= 0) {
                $validator->errors()->add('amount', 'Enter an amount greater than zero for this voucher type.');
            }
        });
    }

    public function messages(): array
    {
        return [
            'student_id.required'       => 'Please select a student.',
            'amount.required'           => 'Enter the amount for this voucher.',
            'due_date.after_or_equal'   => 'The due date cannot be before the issue date.',
        ];
    }
}