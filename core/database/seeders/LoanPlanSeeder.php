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
                'category_id'         => $categoryId,
                'name'                => $plan['name'],
                'minimum_amount'      => $plan['minimum_amount'],
                'maximum_amount'      => $plan['maximum_amount'],
                'per_installment'     => $plan['per_installment'],
                'installment_interval'=> $plan['installment_interval'],
                'total_installment'   => $plan['total_installment'],
                'installment_amount'  => $plan['installment_amount'],
                'late_fee'            => $plan['late_fee'] ?? 0,
                'interval_day'        => $plan['interval_day'] ?? 0,
                'fixed_late_fee'      => $plan['fixed_late_fee'] ?? 0,
                'percent_late_fee'    => $plan['percent_late_fee'] ?? 0,
                'instruction'         => $plan['instruction'] ?? null,
                'status'              => $plan['status'] ?? 1,
                'created_at'          => now(),
                'updated_at'          => now(),
            ];
        }

        if (!empty($loanPlans)) {
            DB::table('loan_plans')->insert($loanPlans);
        }
    }
}
