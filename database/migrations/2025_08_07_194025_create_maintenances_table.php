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
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')->constrained()->onDelete('cascade');
            $table->date('maintenance_date');
            $table->string('type'); // e.g., 'Oil Change', 'Tire Rotation', 'Brake Repair'
            $table->text('description')->nullable();
            $table->decimal('cost', 10, 2)->nullable();
            $table->string('service_provider')->nullable();
            $table->integer('mileage')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};
