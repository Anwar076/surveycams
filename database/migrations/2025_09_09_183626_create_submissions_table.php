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
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('list_id')->constrained('lists');
            $table->datetime('started_at')->nullable();
            $table->datetime('completed_at')->nullable();
            $table->enum('status', ['in_progress', 'completed', 'reviewed', 'rejected'])->default('in_progress');
            $table->text('employee_signature')->nullable();
            $table->text('manager_signature')->nullable();
            $table->text('notes')->nullable();
            $table->json('metadata')->nullable(); // For storing additional data like location, device info
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
