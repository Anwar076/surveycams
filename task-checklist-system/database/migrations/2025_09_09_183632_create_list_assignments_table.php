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
        Schema::create('list_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('list_id')->constrained('lists');
            $table->foreignId('user_id')->nullable()->constrained('users'); // Individual assignment
            $table->string('department')->nullable(); // Department assignment
            $table->string('role')->nullable(); // Role-based assignment
            $table->date('assigned_date');
            $table->date('due_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Ensure at least one assignment type is specified
            $table->index(['list_id', 'user_id']);
            $table->index(['list_id', 'department']);
            $table->index(['assigned_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_assignments');
    }
};
