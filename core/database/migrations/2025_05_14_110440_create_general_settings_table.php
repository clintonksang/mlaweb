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
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->nullable();
            $table->string('cur_text')->nullable();
            $table->string('cur_sym')->nullable();
            $table->string('email_from')->nullable();
            $table->string('email_from_name')->nullable();
            $table->text('email_template')->nullable();
            $table->text('sms_from')->nullable();
            $table->text('sms_template')->nullable();
            $table->text('mail_config')->nullable();
            $table->text('sms_config')->nullable();
            $table->text('global_shortcodes')->nullable();
            $table->text('firebase_config')->nullable();
            $table->text('socialite_credentials')->nullable();
            $table->string('active_template')->nullable();
            $table->string('base_color')->nullable();
            $table->integer('paginate_number')->default(20);
            $table->integer('currency_format')->default(1);
            $table->boolean('maintenance_mode')->default(false);
            $table->boolean('kv')->default(false);
            $table->boolean('ev')->default(false);
            $table->boolean('en')->default(false);
            $table->boolean('sv')->default(false);
            $table->boolean('sn')->default(false);
            $table->boolean('pn')->default(false);
            $table->boolean('force_ssl')->default(false);
            $table->boolean('secure_password')->default(false);
            $table->boolean('registration')->default(true);
            $table->boolean('agree')->default(false);
            $table->boolean('multi_language')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_settings');
    }
};
