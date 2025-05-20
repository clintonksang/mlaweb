<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('loan_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories');
            $table->string('name');
            $table->decimal('minimum_amount', 28, 8)->default(0);
            $table->decimal('maximum_amount', 28, 8)->default(0);
            $table->decimal('per_installment', 5, 2)->default(0);
            $table->integer('installment_interval')->default(0)->comment('In days');
            $table->integer('total_installment')->default(0);
            $table->decimal('installment_amount', 5, 2)->default(0);
            $table->decimal('late_fee', 28, 8)->default(0);
            $table->integer('interval_day')->default(0)->comment('Late fee charges day');
            $table->decimal('fixed_late_fee', 28, 8)->default(0);
            $table->decimal('percent_late_fee', 5, 2)->default(0);
            $table->string('instruction')->nullable();
            $table->boolean('status')->default(1)->comment('0=disable, 1=enable');
            $table->integer('delay_value')->default(0)->comment('Delay in days before late fee applies');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_plans');
    }
};
