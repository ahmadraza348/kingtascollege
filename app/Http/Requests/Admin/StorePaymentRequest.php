<?php

namespace App\Http\Requests\Admin;

use App\Models\FeePayment;
use App\Support\FeeHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_id'           => ['required', Rule::exists('students', 'id')->whereNull('deleted_at')],
            'payment_date'         => ['required', 'date_format:Y-m-d', 'before_or_equal:' . FeeHelper::today()->toDateString()],
            'method'               => ['required', Rule::in(array_keys(FeePayment::METHODS))],
            'amount'               => ['required', 'numeric', 'min:1', 'max:10000000', 'decimal:0,2'],
            'bank_name'            => ['nullable', 'required_if:method,bank_deposit', 'string', 'max:100'],
            'branch'               => ['nullable', 'string', 'max:100'],
            'reference_no'         => ['nullable', 'required_if:method,bank_deposit', 'string', 'max:60'],
            'preferred_voucher_id' => ['nullable', Rule::exists('fee_vouchers', 'id')->where('student_id', $this->input('student_id'))],
            'remarks'              => ['nullable', 'string', 'max:255'],
            'submit_token'         => ['required', 'string', 'max:40'],
        ];
    }

    public function messages(): array
    {
        return [
            'payment_date.before_or_equal' => 'The payment date cannot be in the future.',
            'bank_name.required_if'        => 'Enter the bank name.',
            'reference_no.required_if'     => 'Enter the deposit slip / transaction / cheque number.',
        ];
    }
}
