<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BulkVoucherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'school_class_id'     => ['required', 'exists:school_classes,id'],
            'section_id'          => ['nullable', Rule::exists('sections', 'id')->where('school_class_id', $this->input('school_class_id'))],
            'period'              => ['required', 'date_format:Y-m'],
            'issue_date'          => ['required', 'date_format:Y-m-d'],
            'due_date'            => ['required', 'date_format:Y-m-d', 'after_or_equal:issue_date'],
            'include_absent_fine' => ['nullable', 'boolean'],
        ];
    }
}