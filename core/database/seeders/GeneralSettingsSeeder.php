<?php

namespace Database\Seeders;

use App\Models\GeneralSetting;
use Illuminate\Database\Seeder;

class GeneralSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $general = new GeneralSetting();
        $general->site_name = 'Mkulima Loan App';
        $general->cur_text = 'KES';
        $general->cur_sym = 'Ksh';
        $general->email_from = 'info@mkulima.com';
        $general->email_from_name = 'Mkulima Loan App';
        $general->active_template = 'basic';
        $general->base_color = '1e90ff';
        $general->mail_config = [
            'name' => 'php'
        ];
        $general->sms_config = [
            'name' => 'custom',
            'custom' => [
                'method' => 'get',
                'url' => 'https://api.example.com/sms',
            ]
        ];
        $general->firebase_config = [
            'apiKey' => '',
            'authDomain' => '',
            'projectId' => '',
            'storageBucket' => '',
            'messagingSenderId' => '',
            'appId' => '',
            'measurementId' => '',
            'serverKey' => '',
        ];
        $general->socialite_credentials = [
            'google' => [
                'client_id' => '',
                'client_secret' => '',
                'status' => 0
            ],
            'facebook' => [
                'client_id' => '',
                'client_secret' => '',
                'status' => 0
            ],
        ];
        $general->save();
    }
} 