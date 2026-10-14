<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class ContactFormRequest extends FormRequest
{
    /**
     * Anyone visiting the website may send a query.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name'    => ['required', 'string', 'min:3', 'max:120'],
            'phone'   => ['required', 'string', 'max:30', 'regex:/^(0\d{3}-?\d{7}|\+92\d{10})$/'],
            'email'   => ['required', 'email:rfc', 'max:150'],
            'subject' => ['required', 'string', 'min:3', 'max:150'],
            'program' => ['nullable', 'string', 'max:100'],
            'message' => ['required', 'string', 'min:10', 'max:1000'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'phone.regex' => 'Enter a valid Pakistani phone number, for example 0302-8098542.',
        ];
    }
}
