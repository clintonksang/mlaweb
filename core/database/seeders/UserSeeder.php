<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            [ 'email' => 'test@mla.com' ],
            [
                'name'       => 'Test User',
                'firstname'  => 'Test',
                'lastname'   => 'User',
                'username'   => 'testuser',
                'password'   => Hash::make('password'), // change in production
                'ev'         => 1, // email verified
                'sv'         => 1, // sms verified
                'status'     => 1, // active
                'user_type'  => 'User',
            ]
        );
    }
} 