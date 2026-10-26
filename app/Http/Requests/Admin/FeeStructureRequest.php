<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class FeeStructureRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'            => ['nullable', 'string', 'max:150'],
            'school_class_id' => ['required', 'exists:school_classes,id'],
            'session'         => [
                'required', 'string', 'max:20',
                Rule::unique('fee_structures')
                    ->where('school_class_id', $this->input('school_class_id'))
                    ->ignore($this->route('structure')),
            ],
            'is_active'       => ['nullable', 'boolean'],
            'items'           => ['required', 'array'],
            'items.*'         => ['nullable', 'numeric', 'min:0', 'max:10000000', 'decimal:0,2'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $v) {
            $filled = collect($this->input('items', []))->filter(fn ($amount) => (float) $amount > 0);

            if ($filled->isEmpty()) {
                $v->errors()->add('items', 'Enter at least one fee amount.');
            }
        });
    }

    public function messages(): array
    {
        return [
            'session.unique' => 'This class already has a fee structure for this session. Edit that one instead.',
        ];
    }
}