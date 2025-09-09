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
        Schema::create('submission_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained('submissions')->onDelete('cascade');
            $table->foreignId('task_id')->constrained('tasks');
            $table->text('proof_text')->nullable();
            $table->json('proof_files')->nullable(); // Array of file paths
            $table->enum('status', ['pending', 'completed', 'approved', 'rejected'])->default('pending');
            $table->text('manager_comment')->nullable();
            $table->datetime('completed_at')->nullable();
            $table->datetime('reviewed_at')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submission_tasks');
    }
};
