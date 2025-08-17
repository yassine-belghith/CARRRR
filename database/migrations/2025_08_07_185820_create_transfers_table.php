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
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->string('reference_number')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('driver_id')->nullable()->constrained('drivers')->onDelete('set null');
            $table->foreignId('car_id')->nullable()->constrained('cars')->onDelete('set null');
            
            // Informations sur le transfert
            $table->foreignId('pickup_location_id')->constrained('destinations');
            $table->foreignId('dropoff_location_id')->constrained('destinations');
            
            // Dates et heures
            $table->dateTime('pickup_datetime');
            $table->dateTime('return_datetime')->nullable();
            
            // Détails du vol (pour les transferts aéroport)
            $table->string('flight_number')->nullable();
            $table->string('airline')->nullable();
            
            // Détails des passagers
            $table->integer('passenger_count')->default(1);
            $table->integer('luggage_count')->default(1);
            
            // Statut du transfert
            $table->enum('status', [
                'pending', 'confirmed', 'assigned', 'driver_en_route', 
                'driver_arrived', 'in_progress', 'completed', 'cancelled'
            ])->default('pending');
            
            // Prix et paiement
            $table->decimal('price', 10, 2);
            $table->string('currency', 3)->default('EUR');
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');
            $table->string('payment_method')->nullable();
            $table->string('payment_id')->nullable();
            
            // Informations supplémentaires
            $table->text('special_instructions')->nullable();
            $table->text('driver_notes')->nullable();
            $table->text('cancellation_reason')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
