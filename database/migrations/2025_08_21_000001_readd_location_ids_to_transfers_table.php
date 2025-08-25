<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add columns if missing
        Schema::table('transfers', function (Blueprint $table) {
            if (!Schema::hasColumn('transfers', 'pickup_location_id')) {
                $table->unsignedBigInteger('pickup_location_id')->nullable()->after('car_id');
            }
            if (!Schema::hasColumn('transfers', 'dropoff_location_id')) {
                $table->unsignedBigInteger('dropoff_location_id')->nullable()->after('pickup_location_id');
            }
        });

        // Add foreign keys (guarded against double-add by names implicit)
        Schema::table('transfers', function (Blueprint $table) {
            if (Schema::hasColumn('transfers', 'pickup_location_id')) {
                $table->foreign('pickup_location_id')
                      ->references('id')->on('destinations')
                      ->onDelete('set null');
            }
            if (Schema::hasColumn('transfers', 'dropoff_location_id')) {
                $table->foreign('dropoff_location_id')
                      ->references('id')->on('destinations')
                      ->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('transfers', function (Blueprint $table) {
            if (Schema::hasColumn('transfers', 'pickup_location_id')) {
                $table->dropForeign(['pickup_location_id']);
            }
            if (Schema::hasColumn('transfers', 'dropoff_location_id')) {
                $table->dropForeign(['dropoff_location_id']);
            }
        });

        Schema::table('transfers', function (Blueprint $table) {
            if (Schema::hasColumn('transfers', 'pickup_location_id')) {
                $table->dropColumn('pickup_location_id');
            }
            if (Schema::hasColumn('transfers', 'dropoff_location_id')) {
                $table->dropColumn('dropoff_location_id');
            }
        });
    }
};


