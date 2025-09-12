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
        Schema::table('submission_tasks', function (Blueprint $table) {
            $table->text('digital_signature')->nullable()->after('proof_files');
            $table->timestamp('signature_date')->nullable()->after('digital_signature');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('submission_tasks', function (Blueprint $table) {
            $table->dropColumn(['digital_signature', 'signature_date']);
        });
    }
};

