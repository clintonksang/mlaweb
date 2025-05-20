<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert English as the default language
        DB::table('languages')->insert([
            'name' => 'English',
            'code' => 'en',
            'icon' => '🇺🇸',
            'is_default' => 1,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Add another language as non-default
        DB::table('languages')->insert([
            'name' => 'French',
            'code' => 'fr',
            'icon' => '🇫🇷',
            'is_default' => 0,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
