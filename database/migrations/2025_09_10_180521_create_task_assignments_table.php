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
        Schema::create('task_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained('tasks')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('assigned_at')->useCurrent();
            $table->timestamp('due_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->unique(['task_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_assignments');
    }
};
