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
        Schema::create('lists', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('parent_list_id')->nullable()->constrained('lists');
            $table->enum('schedule_type', ['once', 'daily', 'weekly', 'monthly', 'custom'])->default('once');
            $table->json('schedule_config')->nullable(); // For storing days of week, dates, intervals
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->datetime('due_date')->nullable();
            $table->json('tags')->nullable();
            $table->string('category')->nullable();
            $table->boolean('requires_signature')->default(false);
            $table->boolean('is_template')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lists');
    }
};
