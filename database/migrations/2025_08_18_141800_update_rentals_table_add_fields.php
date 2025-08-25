<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            if (!Schema::hasColumn('rentals', 'driver_id')) {
                $table->foreignId('driver_id')->nullable()->constrained('users')->nullOnDelete();
            }
            if (!Schema::hasColumn('rentals', 'total_price')) {
                $table->decimal('total_price', 10, 2)->default(0);
            }
            if (!Schema::hasColumn('rentals', 'notes')) {
                $table->text('notes')->nullable();
            }
            // No status default change here to avoid requiring doctrine/dbal.
        });
    }

    public function down(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            if (Schema::hasColumn('rentals', 'driver_id')) {
                $table->dropConstrainedForeignId('driver_id');
            }
            if (Schema::hasColumn('rentals', 'total_price')) {
                $table->dropColumn('total_price');
            }
            if (Schema::hasColumn('rentals', 'notes')) {
                $table->dropColumn('notes');
            }
            // Revert status default to previous if needed (optional)
            // $table->string('status')->default('en cours')->change();
        });
    }
};
