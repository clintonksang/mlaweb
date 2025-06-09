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
        Schema::table('loan_plans', function (Blueprint $table) {
            $table->string('title')->nullable()->after('name');
            $table->decimal('fixed_charge', 28, 8)->default(0)->after('delay_value');
            $table->decimal('percent_charge', 5, 2)->default(0)->after('fixed_charge');
            $table->boolean('is_featured')->default(0)->after('percent_charge');
            $table->decimal('application_fixed_charge', 28, 8)->default(0)->after('is_featured');
            $table->decimal('application_percent_charge', 5, 2)->default(0)->after('application_fixed_charge');
            $table->unsignedBigInteger('form_id')->default(0)->after('application_percent_charge');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loan_plans', function (Blueprint $table) {
            $table->dropColumn([
                'title',
                'fixed_charge',
                'percent_charge',
                'is_featured',
                'application_fixed_charge',
                'application_percent_charge',
                'form_id'
            ]);
        });
    }
};
