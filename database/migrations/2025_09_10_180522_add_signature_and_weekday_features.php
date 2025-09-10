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
        // Add signature requirement to tasks
        Schema::table('tasks', function (Blueprint $table) {
            $table->boolean('requires_signature')->default(false)->after('validation_rules');
        });
        
        // Add weekday column to task lists for daily sub-lists
        Schema::table('lists', function (Blueprint $table) {
            $table->enum('weekday', ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'])->nullable()->after('parent_list_id');
        });
        
        // Add rejection fields to submission_tasks
        Schema::table('submission_tasks', function (Blueprint $table) {
            $table->text('rejection_reason')->nullable()->after('manager_comment');
            $table->timestamp('rejected_at')->nullable()->after('reviewed_at');
            $table->boolean('redo_requested')->default(false)->after('rejection_reason');
        });
        
        // Add signature to submissions
        Schema::table('submissions', function (Blueprint $table) {
            $table->text('digital_signature')->nullable()->after('employee_signature');
            $table->timestamp('signature_date')->nullable()->after('digital_signature');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('requires_signature');
        });
        
        Schema::table('lists', function (Blueprint $table) {
            $table->dropColumn('weekday');
        });
        
        Schema::table('submission_tasks', function (Blueprint $table) {
            $table->dropColumn(['rejection_reason', 'rejected_at', 'redo_requested']);
        });
        
        Schema::table('submissions', function (Blueprint $table) {
            $table->dropColumn(['digital_signature', 'signature_date']);
        });
    }
};
