<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdmissionFormRequest extends FormRequest
{
    /**
     * Public applicants may submit an admission application.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            // Personal information
            'fullName' => ['required', 'string', 'min:3', 'max:120'],
            'fatherName' => ['required', 'string', 'min:3', 'max:120'],
            'dob' => ['required', 'date', 'before:today'],
            'gender' => ['required', 'string', Rule::in(['Female', 'Male', 'Prefer not to say'])],
            'cnic' => ['required', 'string', 'max:20', 'regex:/^\d{5}-?\d{7}-?\d$/'],
            'phone' => ['required', 'string', 'max:30', 'regex:/^(0\d{3}-?\d{7}|\+92\d{10})$/'],
            'whatsapp' => ['nullable', 'string', 'max:30', 'regex:/^(0\d{3}-?\d{7}|\+92\d{10})$/'],
            'email' => ['nullable', 'email', 'max:150'],

            // Academic information
            'qualification' => ['required', 'string', Rule::in([
                'Matric',
                'F.Sc / Intermediate',
                'Diploma',
                'Bachelor',
                'Other',
            ])],
            'institution' => ['required', 'string', 'max:150'],
            'obtained' => ['nullable', 'numeric', 'min:0'],
            'total' => ['nullable', 'numeric', 'min:0'],
            'percentage' => ['nullable', 'numeric', 'between:0,100'],

            // Program information. Keep this allow-list aligned with the Blade options.
            'program' => ['required', 'string', Rule::in([
                'BSN Generic',
                'Post RN',
                'LHV (Lady Health Visitor)',
                'CMW (Community Midwife)',
                'CNA (Certified Nursing Assistant)',
                'Anesthesia Technician',
                'Radiography Technology + F.Sc',
                'Medical Lab Technology + F.Sc',
                'Dental Technician',
                'Operation Theater Technology + F.Sc',
                'Dispenser + F.Sc',
                'B-Category Pharmacy Technician',
            ])],
            'session' => ['required', Rule::in(['2026–27'])],
            'notes' => ['nullable', 'string', 'max:600'],

            // Address
            'street' => ['required', 'string', 'max:200'],
            'city' => ['required', 'string', 'max:100'],
            'district' => ['nullable', 'string', 'max:100'],
            'province' => ['nullable', 'string', Rule::in([
                'Punjab',
                'Sindh',
                'Khyber Pakhtunkhwa',
                'Balochistan',
                'Islamabad Capital Territory',
                'Other',
            ])],

            // Required individual documents (max values are in kilobytes)
            'cnic_front' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'cnic_back' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'domicile_document' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'degree_documents' => ['required', 'array', 'min:1', 'max:10'],
            'degree_documents.*' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'personal_picture' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'other_documents' => ['nullable', 'array', 'max:10'],
            'other_documents.*' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],

            // Declaration
            'agreeTerms' => ['accepted'],
        ];
    }

    /**
     * Human-friendly labels for validation errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'fullName' => 'full name',
            'fatherName' => "father's name",
            'dob' => 'date of birth',
            'cnic' => 'CNIC / B-Form number',
            'phone' => 'phone number',
            'whatsapp' => 'WhatsApp number',
            'qualification' => 'previous qualification',
            'institution' => 'institution',
            'obtained' => 'marks obtained',
            'total' => 'total marks',
            'program' => 'preferred program',
            'street' => 'postal address',
            'city' => 'city',
            'cnic_front' => 'CNIC / B-Form front side',
            'cnic_back' => 'CNIC / B-Form back side',
            'domicile_document' => 'domicile certificate',
            'degree_documents' => 'educational certificates / degree documents',
            'degree_documents.*' => 'educational document',
            'personal_picture' => 'personal photograph',
            'other_documents.*' => 'additional supporting document',
            'agreeTerms' => 'terms and conditions acceptance',
        ];
    }

    /**
     * Custom messages for common upload validation failures.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'dob.before' => 'Date of birth must be before today.',
            'cnic.regex' => 'Enter a valid CNIC / B-Form number, for example 33302-1234567-1.',
            'phone.regex' => 'Enter a valid Pakistani phone number, for example 0300-1234567.',
            'whatsapp.regex' => 'Enter a valid Pakistani WhatsApp number, for example 0300-1234567.',
            'degree_documents.required' => 'Upload at least one educational certificate or degree document.',
            'degree_documents.min' => 'Upload at least one educational certificate or degree document.',
            'degree_documents.max' => 'You may upload a maximum of 10 educational documents.',
            'degree_documents.*.mimes' => 'Educational documents must be PDF, JPG, JPEG or PNG files.',
            'degree_documents.*.max' => 'Each educational document must be 5 MB or smaller.',
            'other_documents.max' => 'You may upload a maximum of 10 additional documents.',
            'other_documents.*.mimes' => 'Additional documents must be PDF, JPG, JPEG or PNG files.',
            'other_documents.*.max' => 'Each additional document must be 5 MB or smaller.',
            'cnic_front.max' => 'The CNIC / B-Form front file must be 5 MB or smaller.',
            'cnic_back.max' => 'The CNIC / B-Form back file must be 5 MB or smaller.',
            'domicile_document.max' => 'The domicile certificate must be 5 MB or smaller.',
            'personal_picture.max' => 'The personal photograph must be 2 MB or smaller.',
            'agreeTerms.accepted' => 'Please accept the terms and conditions before submitting.',
        ];
    }
}
