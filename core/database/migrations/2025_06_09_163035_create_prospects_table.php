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
        Schema::create('prospects', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            
            // Personal Information
            $table->string('name');
            $table->string('primary_phone');
            $table->string('email_official')->nullable();
            $table->string('email_personal')->nullable();
            $table->string('id_passport');
            $table->string('kra_pin')->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable();
            $table->enum('marital_status', ['Single', 'Married', 'Divorced', 'Widowed'])->nullable();
            $table->date('dob')->nullable();
            $table->string('education')->nullable();
            
            // Contact Information
            $table->string('postal_address')->nullable();
            
            // Bank Information
            $table->string('bank_name')->nullable();
            $table->string('bank_branch')->nullable();
            $table->string('account_title')->nullable();
            $table->string('account_number')->nullable();
            
            // Address Information
            $table->string('county')->nullable();
            $table->string('district')->nullable();
            $table->string('location')->nullable();
            $table->string('sub_location')->nullable();
            $table->string('building_name')->nullable();
            $table->string('house_no')->nullable();
            $table->string('residence_ownership')->nullable();
            $table->string('residence_landmark')->nullable();
            
            // Next of Kin
            $table->string('nok_name')->nullable();
            $table->string('nok_relationship')->nullable();
            $table->string('nok_id')->nullable();
            $table->string('nok_phone')->nullable();
            $table->text('nok_address')->nullable();
            
            // Referees
            $table->string('referee1_name')->nullable();
            $table->string('referee1_phone')->nullable();
            $table->string('referee1_relationship')->nullable();
            $table->string('referee2_name')->nullable();
            $table->string('referee2_phone')->nullable();
            $table->string('referee2_relationship')->nullable();
            
            // Additional Fields
            $table->string('source')->nullable();
            $table->string('applicant_signature')->nullable();
            $table->string('terms_signature')->nullable();
            
            // File Paths
            $table->string('id_passport_file_path')->nullable();
            $table->string('kra_pin_file_path')->nullable();
            
            // Status
            $table->boolean('kyc_status')->default(false);
            $table->enum('status', ['active', 'inactive', 'pending'])->default('pending');
            
            $table->timestamps();
            
            // Indexes
            $table->index(['name', 'primary_phone']);
            $table->index('status');
            $table->index('kyc_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prospects');
    }
};
