<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            if (!Schema::hasColumn('rentals', 'needs_driver')) {
                $table->boolean('needs_driver')->default(false);
            }
            if (!Schema::hasColumn('rentals', 'driver_license_path')) {
                $table->string('driver_license_path')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            if (Schema::hasColumn('rentals', 'needs_driver')) {
                $table->dropColumn('needs_driver');
            }
            if (Schema::hasColumn('rentals', 'driver_license_path')) {
                $table->dropColumn('driver_license_path');
            }
        });
    }
};
