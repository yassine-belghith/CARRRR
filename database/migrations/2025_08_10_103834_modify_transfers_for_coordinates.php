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
            // Add new coordinate columns after the 'id' column
            $table->decimal('pickup_latitude', 10, 7)->after('id');
            $table->decimal('pickup_longitude', 10, 7)->after('pickup_latitude');
            $table->decimal('dropoff_latitude', 10, 7)->after('pickup_longitude');
            $table->decimal('dropoff_longitude', 10, 7)->after('dropoff_latitude');

            // Drop the old foreign key columns
            $table->dropForeign(['pickup_location_id']);
            $table->dropForeign(['dropoff_location_id']);
            $table->dropColumn(['pickup_location_id', 'dropoff_location_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transfers', function (Blueprint $table) {
            // Add the old columns back
            $table->foreignId('pickup_location_id')->constrained('destinations');
            $table->foreignId('dropoff_location_id')->constrained('destinations');

            // Drop the new coordinate columns
            $table->dropColumn(['pickup_latitude', 'pickup_longitude', 'dropoff_latitude', 'dropoff_longitude']);
        });
    }
};
