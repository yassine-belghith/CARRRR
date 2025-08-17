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
            // Drop foreign keys first
            $table->dropForeign(['pickup_location_id']);
            $table->dropForeign(['dropoff_location_id']);

            // Change columns to be nullable
            $table->unsignedBigInteger('pickup_location_id')->nullable()->change();
            $table->unsignedBigInteger('dropoff_location_id')->nullable()->change();

            // Re-add foreign keys with onDelete('set null')
            $table->foreign('pickup_location_id')
                  ->references('id')->on('destinations')
                  ->onDelete('set null');

            $table->foreign('dropoff_location_id')
                  ->references('id')->on('destinations')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transfers', function (Blueprint $table) {
            // Drop the modified foreign keys
            $table->dropForeign(['pickup_location_id']);
            $table->dropForeign(['dropoff_location_id']);

            // Revert columns to not be nullable
            $table->unsignedBigInteger('pickup_location_id')->nullable(false)->change();
            $table->unsignedBigInteger('dropoff_location_id')->nullable(false)->change();

            // Re-add original foreign keys
            $table->foreign('pickup_location_id')
                  ->references('id')->on('destinations');

            $table->foreign('dropoff_location_id')
                  ->references('id')->on('destinations');
        });
    }
};
