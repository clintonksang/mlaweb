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
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // User who created the ticket
            $table->string('ticket_number')->unique();
            $table->string('subject');
            $table->text('message');
            $table->tinyInteger('status')->default(0)->comment('0: Open, 1: Answered, 2: User Reply, 3: Closed, 4: Pending');
            $table->tinyInteger('priority')->default(1)->comment('1: Low, 2: Medium, 3: High');
            $table->string('attachment')->nullable();
            $table->timestamp('last_reply')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('support_tickets');
    }
}; 