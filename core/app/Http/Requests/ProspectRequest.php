<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProspectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $prospectId = $this->route('uuid') ? 
            \App\Models\Prospect::where('uuid', $this->route('uuid'))->first()?->id : 
            null;

        return [
            'name' => 'required|string|max:255',
            'primary_phone' => [
                'required',
                'string',
                'max:20',
                Rule::unique('prospects', 'primary_phone')->ignore($prospectId)
            ],
            'email_official' => 'nullable|email|max:255',
            'email_personal' => 'nullable|email|max:255',
            'id_passport' => [
                'required',
                'string',
                'max:50',
                Rule::unique('prospects', 'id_passport')->ignore($prospectId)
            ],
            'kra_pin' => 'nullable|string|max:20',
            'gender' => 'nullable|in:Male,Female,Other',
            'marital_status' => 'nullable|in:Single,Married,Divorced,Widowed',
            'dob' => 'nullable|date|before:today',
            'education' => 'nullable|string|max:255',
            'postal_address' => 'nullable|string|max:500',
            'bank_name' => 'nullable|string|max:255',
            'bank_branch' => 'nullable|string|max:255',
            'account_title' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:50',
            'county' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'sub_location' => 'nullable|string|max:255',
            'building_name' => 'nullable|string|max:255',
            'house_no' => 'nullable|string|max:50',
            'residence_ownership' => 'nullable|string|max:255',
            'residence_landmark' => 'nullable|string|max:500',
            'nok_name' => 'nullable|string|max:255',
            'nok_relationship' => 'nullable|string|max:255',
            'nok_id' => 'nullable|string|max:50',
            'nok_phone' => 'nullable|string|max:20',
            'nok_address' => 'nullable|string|max:500',
            'referee1_name' => 'nullable|string|max:255',
            'referee1_phone' => 'nullable|string|max:20',
            'referee1_relationship' => 'nullable|string|max:255',
            'referee2_name' => 'nullable|string|max:255',
            'referee2_phone' => 'nullable|string|max:20',
            'referee2_relationship' => 'nullable|string|max:255',
            'source' => 'nullable|string|max:255',
            'applicant_signature' => 'nullable|string|max:255',
            'terms_signature' => 'nullable|string|max:255',
            'id_passport_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120', // 5MB max
            'kra_pin_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120', // 5MB max
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Name is required',
            'primary_phone.required' => 'Primary phone number is required',
            'primary_phone.unique' => 'This phone number is already registered',
            'primary_phone.max' => 'Phone number must not exceed 20 characters',
            'email_official.email' => 'Please provide a valid official email address',
            'email_personal.email' => 'Please provide a valid personal email address',
            'id_passport.required' => 'ID/Passport number is required',
            'id_passport.unique' => 'This ID/Passport number is already registered',
            'dob.before' => 'Date of birth must be before today',
            'gender.in' => 'Gender must be Male, Female, or Other',
            'marital_status.in' => 'Marital status must be Single, Married, Divorced, or Widowed',
            'id_passport_file.file' => 'ID/Passport file must be a valid file',
            'id_passport_file.mimes' => 'ID/Passport file must be jpg, jpeg, png, or pdf format',
            'id_passport_file.max' => 'ID/Passport file size must not exceed 5MB',
            'kra_pin_file.file' => 'KRA PIN file must be a valid file',
            'kra_pin_file.mimes' => 'KRA PIN file must be jpg, jpeg, png, or pdf format',
            'kra_pin_file.max' => 'KRA PIN file size must not exceed 5MB',
        ];
    }
}
