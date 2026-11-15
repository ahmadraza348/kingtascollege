<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExpenseCategoryRequest extends FormRequest
{
    /** Errors from renaming a row are kept apart from the "add new category" box. */
    protected function prepareForValidation(): void
    {
        $this->errorBag = $this->route('category') ? 'update' : 'default';
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'      => ['required', 'string', 'max:100', Rule::unique('expense_categories', 'name')->ignore($this->route('category'))],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return ['name.unique' => 'A category with this name already exists.'];
    }
}
