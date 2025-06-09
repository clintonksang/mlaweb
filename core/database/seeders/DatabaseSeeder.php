<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\AgentRequestTypeSeeder;
use Database\Seeders\FormsTableSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\LoanPlanSeeder;
use Database\Seeders\LanguageSeeder;
use Database\Seeders\GeneralSettingsSeeder;
use Database\Seeders\AdminSeeder;
use Database\Seeders\UserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        $this->call([
            AdminSeeder::class,
            AgentRequestTypeSeeder::class,
            FormsTableSeeder::class,
            CategorySeeder::class,
            LoanPlanSeeder::class,
            LanguageSeeder::class,
            GeneralSettingsSeeder::class,
            UserSeeder::class,
        ]);
    }
} 