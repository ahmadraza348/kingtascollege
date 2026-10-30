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
            'amount'              => ['nullable', 'required_if:type,opening,other', 'numeric', 'min:1', 'max:10000000', 'decimal:0,2'],
            'description'         => ['nullable', 'required_if:type,opening,other', 'string', 'max:150'],
            'include_absent_fine' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'student_id.required'       => 'Please select a student.',
            'amount.required_if'        => 'Enter the amount for this type of voucher.',
            'description.required_if'   => 'Enter a short description for this charge.',
            'due_date.after_or_equal'   => 'The due date cannot be before the issue date.',
        ];
    }
}