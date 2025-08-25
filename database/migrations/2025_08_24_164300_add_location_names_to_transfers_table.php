<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transfers', function (Blueprint $table) {
            $table->string('pickup_location_name')->nullable()->after('pickup_longitude');
            $table->string('dropoff_location_name')->nullable()->after('dropoff_longitude');
        });
    }

    public function down(): void
    {
        Schema::table('transfers', function (Blueprint $table) {
            $table->dropColumn(['pickup_location_name', 'dropoff_location_name']);
        });
    }
};
