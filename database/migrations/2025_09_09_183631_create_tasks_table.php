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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('list_id')->constrained('lists')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('instructions')->nullable();
            $table->enum('required_proof_type', ['none', 'photo', 'video', 'text', 'file', 'any'])->default('none');
            $table->boolean('is_required')->default(true);
            $table->integer('order_index')->default(0);
            $table->json('attachments')->nullable(); // For instruction files, images, videos
            $table->json('validation_rules')->nullable(); // Custom validation rules
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
