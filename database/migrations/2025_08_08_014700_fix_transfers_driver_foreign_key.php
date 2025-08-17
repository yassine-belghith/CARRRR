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
            // Drop the existing foreign key constraint
            $table->dropForeign(['driver_id']);
            
            // Add the correct foreign key constraint referencing users table
            $table->foreign('driver_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transfers', function (Blueprint $table) {
            // Drop the correct foreign key constraint
            $table->dropForeign(['driver_id']);
            
            // Re-add the incorrect foreign key constraint referencing drivers table
            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('set null');
        });
    }
};
