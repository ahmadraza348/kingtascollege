<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFeeSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'college_name'        => ['required', 'string', 'max:150'],
            'college_address'     => ['nullable', 'string', 'max:255'],
            'college_phone'       => ['nullable', 'string', 'max:100'],
            'college_email'       => ['nullable', 'email', 'max:150'],
            'bank_name'           => ['nullable', 'string', 'max:100'],
            'bank_branch'         => ['nullable', 'string', 'max:100'],
            'account_title'       => ['nullable', 'string', 'max:100'],
            'account_number'      => ['nullable', 'string', 'max:60'],
            'due_day'             => ['required', 'integer', 'between:1,28'],
            'late_fee_enabled'    => ['required', 'boolean'],
            'late_fee_per_day'    => ['required', 'numeric', 'min:0', 'max:100000'],
            'absent_fine_per_day' => ['required', 'numeric', 'min:0', 'max:100000'],
            'readmission_fee'     => ['required', 'numeric', 'min:0', 'max:10000000'],
            'voucher_notes'       => ['nullable', 'string', 'max:1000'],
        ];
    }
}
