<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/** Used wherever the admin must explain an action: reject a payment, cancel a payment, cancel a voucher. */
class ReasonRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return ['reason' => ['required', 'string', 'min:3', 'max:255']];
    }

    public function messages(): array
    {
        return ['reason.required' => 'Please write the reason. It is kept in the history.'];
    }
}