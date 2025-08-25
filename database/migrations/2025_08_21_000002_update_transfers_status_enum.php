<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Only for MySQL-type drivers where ENUM is available
        try {
            DB::statement("
                ALTER TABLE transfers
                MODIFY COLUMN status ENUM(
                    'pending','confirmed','assigned',
                    'on_the_way','driver_en_route','driver_arrived','in_progress',
                    'completed','cancelled','no_show'
                ) NOT NULL DEFAULT 'pending'
            ");
        } catch (\Throwable $e) {
            // Silently ignore if DB driver does not support this exact syntax
        }
    }

    public function down(): void
    {
        try {
            DB::statement("
                ALTER TABLE transfers
                MODIFY COLUMN status ENUM(
                    'pending','confirmed','assigned',
                    'driver_en_route','driver_arrived','in_progress','completed','cancelled'
                ) NOT NULL DEFAULT 'pending'
            ");
        } catch (\Throwable $e) {
            // Ignore on unsupported drivers
        }
    }
};


