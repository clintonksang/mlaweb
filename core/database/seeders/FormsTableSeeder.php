<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update or insert KYC form
        DB::table('forms')->updateOrInsert(
            ['act' => 'kyc'],
            [
                'name' => 'KYC Form',
                'form_data' => json_encode([
                    'text_input_field' => [
                        'name' => 'First Name',
                        'label' => 'first_name',
                        'is_required' => 'required',
                        'instruction' => 'Enter your legal first name.',
                        'extensions' => '',
                        'options' => [],
                        'type' => 'text',
                        'selectedValue' => ''
                    ],
                    'textarea_input_field' => [
                        'name' => 'Full Address',
                        'label' => 'full_address',
                        'is_required' => 'required',
                        'instruction' => 'Enter your complete residential address.',
                        'extensions' => '',
                        'options' => [],
                        'type' => 'textarea',
                        'selectedValue' => ''
                    ],
                    'dropdown_select_field' => [
                        'name' => 'Country of Residence',
                        'label' => 'country_of_residence',
                        'is_required' => 'required',
                        'instruction' => 'Select your country.',
                        'extensions' => '',
                        'options' => ['USA', 'Canada', 'UK', 'Australia', 'Kenya'],
                        'type' => 'select',
                        'selectedValue' => ''
                    ],
                    'checkbox_field' => [
                        'name' => 'Terms and Conditions',
                        'label' => 'terms_and_conditions',
                        'is_required' => 'required',
                        'instruction' => 'Please read and accept the terms.',
                        'extensions' => '',
                        'options' => ['I agree to the terms and conditions'],
                        'type' => 'checkbox',
                        'selectedValue' => ''
                    ],
                    'radio_button_field' => [
                        'name' => 'Gender',
                        'label' => 'gender',
                        'is_required' => 'optional',
                        'instruction' => 'Select your gender.',
                        'extensions' => '',
                        'options' => ['Male', 'Female', 'Other', 'Prefer not to say'],
                        'type' => 'radio',
                        'selectedValue' => ''
                    ],
                    'file_upload_field' => [
                        'name' => 'National ID (Front)',
                        'label' => 'national_id_front',
                        'is_required' => 'required',
                        'instruction' => 'Upload a clear image of the front of your National ID.',
                        'extensions' => 'jpg,jpeg,png,pdf',
                        'options' => [],
                        'type' => 'file',
                        'selectedValue' => ''
                    ]
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        );
    }
}
