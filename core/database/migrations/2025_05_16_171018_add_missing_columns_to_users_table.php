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
        Schema::table('users', function (Blueprint $table) {
            $table->string('firstname')->after('name')->nullable();
            $table->string('lastname')->after('firstname')->nullable();
            $table->string('username')->after('lastname')->unique()->nullable();
            $table->string('mobile')->nullable();
            $table->string('dial_code')->nullable();
            $table->string('address')->nullable();
            $table->tinyInteger('ev')->default(0)->comment('email verification');
            $table->tinyInteger('sv')->default(0)->comment('sms verification');
            $table->tinyInteger('kv')->default(0)->comment('kyc verification');
            $table->tinyInteger('ts')->default(0)->comment('two-factor auth status');
            $table->tinyInteger('tv')->default(1)->comment('two-factor auth verification');
            $table->string('ver_code')->nullable()->comment('verification code');
            $table->timestamp('ver_code_send_at')->nullable();
            $table->decimal('balance', 28, 8)->default(0);
            $table->text('kyc_data')->nullable();
            $table->integer('ref_by')->default(0);
            $table->tinyInteger('status')->default(1)->comment('0: banned, 1: active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('firstname');
            $table->dropColumn('lastname');
            $table->dropColumn('username');
            $table->dropColumn('mobile');
            $table->dropColumn('dial_code');
            $table->dropColumn('address');
            $table->dropColumn('ev');
            $table->dropColumn('sv');
            $table->dropColumn('kv');
            $table->dropColumn('ts');
            $table->dropColumn('tv');
            $table->dropColumn('ver_code');
            $table->dropColumn('ver_code_send_at');
            $table->dropColumn('balance');
            $table->dropColumn('kyc_data');
            $table->dropColumn('ref_by');
            $table->dropColumn('status');
        });
    }
};
