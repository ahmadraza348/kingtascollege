<?php

namespace App\Http\Requests\Admin;

use App\Models\Admission;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAdmissionStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // the adminauth middleware already protects the route
    }

    public function rules(): array
    {
        return [
            'status'  => ['required', Rule::in(array_keys(Admission::STATUSES))],
            // The student needs to know why, so a reason is mandatory for these two.
            'remarks' => ['nullable', 'required_if:status,rejected,documents_required', 'string', 'max:1000'],
            'notify'  => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'remarks.required_if' => 'Please write the reason / missing documents. The student will see it.',
        ];
    }
}
