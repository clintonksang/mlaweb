<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LoanPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $loanPlansConfig = config('loan_plans', []);

        $loanPlans = [];

        foreach ($loanPlansConfig as $plan) {
            // Resolve category ID by name (fall back to null)
            $categoryId = DB::table('categories')->where('name', $plan['category'])->value('id');
            if (!$categoryId) {
                // Skip if category not found
                continue;
            }

            $loanPlans[] = [
                'category_id'                => $categoryId,
                'name'                       => $plan['name'],
                'title'                      => $plan['title'] ?? $plan['name'],
                'minimum_amount'             => $plan['minimum_amount'],
                'maximum_amount'             => $plan['maximum_amount'],
                'per_installment'            => $plan['per_installment'],
                'installment_interval'       => $plan['installment_interval'],
                'total_installment'          => $plan['total_installment'],
                'delay_value'                => $plan['delay_value'] ?? 7,
                'fixed_charge'               => $plan['fixed_charge'] ?? 0,
                'percent_charge'             => $plan['percent_charge'] ?? 0,
                'is_featured'                => $plan['is_featured'] ?? 0,
                'application_fixed_charge'   => $plan['application_fixed_charge'] ?? 0,
                'application_percent_charge' => $plan['application_percent_charge'] ?? 0,
                'instruction'                => $plan['instruction'] ?? null,
                'status'                     => $plan['status'] ?? 1,
                'form_id'                    => 0, // Default to 0, can be updated later
                'created_at'                 => now(),
                'updated_at'                 => now(),
            ];
        }

        if (!empty($loanPlans)) {
            DB::table('loan_plans')->insert($loanPlans);
        }
    }
}
