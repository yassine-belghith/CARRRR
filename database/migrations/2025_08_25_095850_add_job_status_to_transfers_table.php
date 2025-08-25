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
        Schema::table('transfers', function (Blueprint $table) {
            $table->enum('job_status', ['pending', 'started', 'completed'])->default('pending')->after('driver_confirmation_status');
            $table->timestamp('job_started_at')->nullable()->after('job_status');
            $table->timestamp('job_completed_at')->nullable()->after('job_started_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transfers', function (Blueprint $table) {
            $table->dropColumn(['job_status', 'job_started_at', 'job_completed_at']);
        });
    }
};
