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
            'amount'              => ['required', 'numeric', 'min:1', 'max:10000000', 'decimal:0,2'],
            'description'         => ['nullable', 'string', 'max:150'],
        ];
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