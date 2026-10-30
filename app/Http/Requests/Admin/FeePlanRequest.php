<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class FeePlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'total_fee'                  => ['required', 'numeric', 'min:1', 'max:10000000', 'decimal:0,2'],
            'discount'                   => ['nullable', 'numeric', 'min:0', 'max:10000000', 'decimal:0,2'],
            'notes'                      => ['nullable', 'string', 'max:255'],
            'installments'               => ['nullable', 'array', 'max:60'],
            'installments.*.amount'      => ['nullable', 'numeric', 'min:0', 'max:10000000', 'decimal:0,2'],
            'installments.*.due_date'    => ['nullable', 'required_with:installments.*.amount', 'date_format:Y-m-d'],
        ];
    }

    public function messages(): array
    {
        return [
            'total_fee.required'                    => 'Enter the total fee of the course.',
            'installments.*.due_date.required_with' => 'Every installment needs a due date.',
            'installments.*.due_date.date_format'   => 'Use a valid due date.',
        ];
    }
}
