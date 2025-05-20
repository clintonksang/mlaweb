<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agent_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agent_id');
            $table->unsignedBigInteger('type_id');
            $table->decimal('amount', 12, 2);
            $table->string('description')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->timestamps();

            $table->foreign('type_id')->references('id')->on('agent_request_types')->onDelete('cascade');
            // You may want to add foreign keys for agent_id and admin_id if those tables exist
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agent_requests');
    }
}; 