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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('plan_id')->constrained('loan_plans');
            $table->string('loan_number')->unique();
            $table->decimal('amount', 28, 8)->default(0);
            $table->decimal('per_installment', 28, 8)->default(0);
            $table->integer('installment_interval')->default(0);
            $table->integer('delay_value')->default(0);
            $table->decimal('charge_per_installment', 28, 8)->default(0);
            $table->decimal('delay_charge', 28, 8)->default(0);
            $table->integer('given_installment')->default(0);
            $table->integer('total_installment')->default(0);
            $table->timestamp('application_date')->nullable();
            $table->timestamp('approved_date')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0=pending, 1=running, 2=paid, 3=rejected');
            $table->text('admin_feedback')->nullable();
            $table->text('application_form')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
