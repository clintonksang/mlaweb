<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgentRequestTypeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('agent_request_types')->insert([
            [
                'name' => 'Fare',
                'description' => 'Transportation fare',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Food',
                'description' => 'Food allowance',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
} 