<?php

return [
    // Personal Loans
    [
        'category' => 'Personal Loans',
        'name' => 'Quick Cash Loan',
        'title' => 'Emergency Quick Cash',
        'minimum_amount' => 1000,
        'maximum_amount' => 50000,
        'per_installment' => 15.00, // 15% per installment
        'installment_interval' => 30, // 30 days
        'total_installment' => 1,
        'delay_value' => 7, // 7 days grace period
        'fixed_charge' => 500, // Fixed late fee
        'percent_charge' => 5.00, // 5% late fee
        'application_fixed_charge' => 200,
        'application_percent_charge' => 2.0,
        'is_featured' => 1,
        'instruction' => 'Quick emergency loan with 15% interest payable in a single installment within 30 days',
        'status' => 1,
    ],
    [
        'category' => 'Personal Loans',
        'name' => 'Personal Installment Loan',
        'title' => '3-Month Personal Loan',
        'minimum_amount' => 5000,
        'maximum_amount' => 200000,
        'per_installment' => 8.00, // 8% per installment
        'installment_interval' => 30, // 30 days
        'total_installment' => 3,
        'delay_value' => 5, // 5 days grace period
        'fixed_charge' => 1000, // Fixed late fee
        'percent_charge' => 3.00, // 3% late fee
        'application_fixed_charge' => 500,
        'application_percent_charge' => 1.5,
        'is_featured' => 1,
        'instruction' => 'Flexible personal loan with 8% monthly interest, payable over 3 months',
        'status' => 1,
    ],

    // Business Loans
    [
        'category' => 'Business Loans',
        'name' => 'Small Business Starter',
        'title' => 'SME Quick Start Loan',
        'minimum_amount' => 10000,
        'maximum_amount' => 500000,
        'per_installment' => 12.00, // 12% per installment
        'installment_interval' => 30, // 30 days
        'total_installment' => 6,
        'delay_value' => 10, // 10 days grace period
        'fixed_charge' => 2000, // Fixed late fee
        'percent_charge' => 4.00, // 4% late fee
        'application_fixed_charge' => 1000,
        'application_percent_charge' => 2.5,
        'is_featured' => 1,
        'instruction' => 'Business loan for small enterprises with 12% monthly interest over 6 months',
        'status' => 1,
    ],
    [
        'category' => 'Business Loans',
        'name' => 'Business Growth Loan',
        'title' => 'Scale Your Business',
        'minimum_amount' => 50000,
        'maximum_amount' => 2000000,
        'per_installment' => 10.00, // 10% per installment
        'installment_interval' => 30, // 30 days
        'total_installment' => 12,
        'delay_value' => 15, // 15 days grace period
        'fixed_charge' => 5000, // Fixed late fee
        'percent_charge' => 2.5, // 2.5% late fee
        'application_fixed_charge' => 2500,
        'application_percent_charge' => 1.0,
        'is_featured' => 1,
        'instruction' => 'Long-term business growth loan with competitive 10% monthly rates over 12 months',
        'status' => 1,
    ],

    // Agricultural Loans
    [
        'category' => 'Agricultural Loans',
        'name' => 'Seasonal Farming Loan',
        'title' => 'Crop Season Finance',
        'minimum_amount' => 5000,
        'maximum_amount' => 300000,
        'per_installment' => 6.00, // 6% per installment
        'installment_interval' => 90, // 90 days (quarterly)
        'total_installment' => 2,
        'delay_value' => 30, // 30 days grace period for farmers
        'fixed_charge' => 1500, // Fixed late fee
        'percent_charge' => 2.00, // 2% late fee
        'application_fixed_charge' => 300,
        'application_percent_charge' => 1.0,
        'is_featured' => 1,
        'instruction' => 'Agricultural loan for crop farming with 6% quarterly interest, suitable for seasonal farming cycles',
        'status' => 1,
    ],
    [
        'category' => 'Agricultural Loans',
        'name' => 'Livestock Investment Loan',
        'title' => 'Livestock & Dairy Finance',
        'minimum_amount' => 20000,
        'maximum_amount' => 800000,
        'per_installment' => 7.50, // 7.5% per installment
        'installment_interval' => 60, // 60 days
        'total_installment' => 6,
        'delay_value' => 20, // 20 days grace period
        'fixed_charge' => 2500, // Fixed late fee
        'percent_charge' => 3.00, // 3% late fee
        'application_fixed_charge' => 800,
        'application_percent_charge' => 1.2,
        'is_featured' => 0,
        'instruction' => 'Investment loan for livestock and dairy farming with flexible 7.5% bi-monthly payments',
        'status' => 1,
    ],

    // Education Loans
    [
        'category' => 'Education Loans',
        'name' => 'School Fees Loan',
        'title' => 'Education Fee Finance',
        'minimum_amount' => 3000,
        'maximum_amount' => 150000,
        'per_installment' => 5.00, // 5% per installment
        'installment_interval' => 30, // 30 days
        'total_installment' => 10,
        'delay_value' => 14, // 14 days grace period
        'fixed_charge' => 800, // Fixed late fee
        'percent_charge' => 2.00, // 2% late fee
        'application_fixed_charge' => 150,
        'application_percent_charge' => 0.5,
        'is_featured' => 1,
        'instruction' => 'Affordable education loan with 5% monthly interest to support school fees and educational expenses',
        'status' => 1,
    ],
    [
        'category' => 'Education Loans',
        'name' => 'Higher Education Loan',
        'title' => 'University & College Finance',
        'minimum_amount' => 25000,
        'maximum_amount' => 500000,
        'per_installment' => 4.00, // 4% per installment
        'installment_interval' => 90, // 90 days (quarterly)
        'total_installment' => 8,
        'delay_value' => 21, // 21 days grace period
        'fixed_charge' => 1200, // Fixed late fee
        'percent_charge' => 1.50, // 1.5% late fee
        'application_fixed_charge' => 1000,
        'application_percent_charge' => 0.8,
        'is_featured' => 0,
        'instruction' => 'Long-term education financing for higher education with low 4% quarterly interest rates',
        'status' => 1,
    ],
]; 