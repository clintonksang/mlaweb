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
        Schema::create('admin_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->nullable()->constrained('admins')->onDelete('cascade'); // Assuming admin_id can be nullable if notification is system-wide
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade'); // User related to notification, if any
            $table->string('title');
            $table->text('body')->nullable();
            $table->string('type')->nullable()->comment('e.g., new_user, new_deposit, support_ticket');
            $table->string('click_url')->nullable()->comment('Link to the relevant page in admin panel');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_notifications');
    }
};
