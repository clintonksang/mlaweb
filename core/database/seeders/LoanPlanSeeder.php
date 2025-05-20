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
        // Get category IDs
        $personalLoanId = DB::table('categories')->where('name', 'Personal Loans')->value('id');
        $businessLoanId = DB::table('categories')->where('name', 'Business Loans')->value('id');
        $agricultureLoanId = DB::table('categories')->where('name', 'Agricultural Loans')->value('id');
        $educationLoanId = DB::table('categories')->where('name', 'Education Loans')->value('id');

        // Add sample loan plans
        $loanPlans = [
            // Personal Loans
            [
                'category_id' => $personalLoanId,
                'name' => 'Quick Cash',
                'minimum_amount' => 1000,
                'maximum_amount' => 50000,
                'per_installment' => 10.00,
                'installment_interval' => 30,
                'total_installment' => 3,
                'installment_amount' => 33.33,
                'late_fee' => 500,
                'interval_day' => 1,
                'fixed_late_fee' => 500,
                'percent_late_fee' => 1.00,
                'instruction' => 'Quick cash for emergencies with fast approval',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'category_id' => $personalLoanId,
                'name' => 'Personal Financing',
                'minimum_amount' => 10000,
                'maximum_amount' => 200000,
                'per_installment' => 8.50,
                'installment_interval' => 30,
                'total_installment' => 12,
                'installment_amount' => 8.33,
                'late_fee' => 1000,
                'interval_day' => 3,
                'fixed_late_fee' => 1000,
                'percent_late_fee' => 2.00,
                'instruction' => 'Longer term personal financing for larger needs',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            
            // Business Loans
            [
                'category_id' => $businessLoanId,
                'name' => 'SME Startup',
                'minimum_amount' => 50000,
                'maximum_amount' => 500000,
                'per_installment' => 7.00,
                'installment_interval' => 30,
                'total_installment' => 24,
                'installment_amount' => 4.17,
                'late_fee' => 2000,
                'interval_day' => 5,
                'fixed_late_fee' => 2000,
                'percent_late_fee' => 3.00,
                'instruction' => 'Financing for small business startups',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            
            // Agricultural Loans
            [
                'category_id' => $agricultureLoanId,
                'name' => 'Seasonal Farming',
                'minimum_amount' => 20000,
                'maximum_amount' => 200000,
                'per_installment' => 5.00,
                'installment_interval' => 90,
                'total_installment' => 4,
                'installment_amount' => 25.00,
                'late_fee' => 1000,
                'interval_day' => 7,
                'fixed_late_fee' => 1000,
                'percent_late_fee' => 1.50,
                'instruction' => 'Financing for seasonal farming activities with longer payment intervals',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            
            // Education Loans
            [
                'category_id' => $educationLoanId,
                'name' => 'Student Financing',
                'minimum_amount' => 10000,
                'maximum_amount' => 300000,
                'per_installment' => 4.00,
                'installment_interval' => 30,
                'total_installment' => 36,
                'installment_amount' => 2.78,
                'late_fee' => 500,
                'interval_day' => 10,
                'fixed_late_fee' => 500,
                'percent_late_fee' => 1.00,
                'instruction' => 'Low-interest financing for education expenses with flexible repayment',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        DB::table('loan_plans')->insert($loanPlans);
    }
}
