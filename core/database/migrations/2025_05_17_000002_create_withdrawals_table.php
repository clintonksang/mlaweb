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
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('method_id')->comment('FK to withdraw_methods table'); // Assuming a withdraw_methods table
            $table->string('trx')->unique();
            $table->string('currency', 10);
            $table->decimal('amount', 28, 8)->default(0);
            $table->decimal('charge', 28, 8)->default(0);
            $table->decimal('rate', 28, 8)->default(0);
            $table->decimal('final_amount', 28, 8)->default(0)->comment('Amount after charge and conversion');
            $table->text('withdraw_information')->nullable()->comment('User provided details for withdrawal as JSON');
            $table->text('admin_feedback')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0:pending, 1:approved/successful, 2:rejected, 3:initiated');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawals');
    }
}; 