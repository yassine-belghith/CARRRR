<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            // Airports
            ['name' => 'Aéroport Djerba', 'address' => 'Djerba-Zarzis Airport', 'city' => 'Djerba', 'country' => 'Tunisia', 'postal_code' => '4120', 'phone' => '+216 75 650 233', 'email' => 'contact@djerba-airport.com', 'opening_hours_weekdays' => '00:00', 'closing_hours_weekdays' => '23:59', 'opening_hours_weekends' => '00:00', 'closing_hours_weekends' => '23:59'],
            ['name' => 'Aéroport Enfidha', 'address' => 'Enfidha-Hammamet Airport', 'city' => 'Enfidha', 'country' => 'Tunisia', 'postal_code' => '4030', 'phone' => '+216 73 103 000', 'email' => 'contact@enfidha-airport.com', 'opening_hours_weekdays' => '00:00', 'closing_hours_weekdays' => '23:59', 'opening_hours_weekends' => '00:00', 'closing_hours_weekends' => '23:59'],
            ['name' => 'Aéroport Monastir', 'address' => 'Habib Bourguiba Airport', 'city' => 'Monastir', 'country' => 'Tunisia', 'postal_code' => '5000', 'phone' => '+216 73 520 000', 'email' => 'contact@monastir-airport.com', 'opening_hours_weekdays' => '00:00', 'closing_hours_weekdays' => '23:59', 'opening_hours_weekends' => '00:00', 'closing_hours_weekends' => '23:59'],
            ['name' => 'Aéroport Tunis Carthage', 'address' => 'Tunis-Carthage Airport', 'city' => 'Tunis', 'country' => 'Tunisia', 'postal_code' => '2035', 'phone' => '+216 71 754 000', 'email' => 'contact@tunis-airport.com', 'opening_hours_weekdays' => '00:00', 'closing_hours_weekdays' => '23:59', 'opening_hours_weekends' => '00:00', 'closing_hours_weekends' => '23:59'],
            // City Centers
            ['name' => 'Djerba', 'address' => 'City Center', 'city' => 'Djerba', 'country' => 'Tunisia', 'postal_code' => '4180', 'phone' => '+216 75 650 123', 'email' => 'djerba@example.com', 'opening_hours_weekdays' => '09:00', 'closing_hours_weekdays' => '18:00', 'opening_hours_weekends' => '10:00', 'closing_hours_weekends' => '16:00'],
            ['name' => 'Hammamet', 'address' => 'City Center', 'city' => 'Hammamet', 'country' => 'Tunisia', 'postal_code' => '8050', 'phone' => '+216 72 280 123', 'email' => 'hammamet@example.com', 'opening_hours_weekdays' => '09:00', 'closing_hours_weekdays' => '18:00', 'opening_hours_weekends' => '10:00', 'closing_hours_weekends' => '16:00'],
            ['name' => 'La marsa', 'address' => 'City Center', 'city' => 'La Marsa', 'country' => 'Tunisia', 'postal_code' => '2070', 'phone' => '+216 71 749 123', 'email' => 'lamarsa@example.com', 'opening_hours_weekdays' => '09:00', 'closing_hours_weekdays' => '18:00', 'opening_hours_weekends' => '10:00', 'closing_hours_weekends' => '16:00'],
            ['name' => 'Monastir', 'address' => 'City Center', 'city' => 'Monastir', 'country' => 'Tunisia', 'postal_code' => '5000', 'phone' => '+216 73 462 123', 'email' => 'monastir@example.com', 'opening_hours_weekdays' => '09:00', 'closing_hours_weekdays' => '18:00', 'opening_hours_weekends' => '10:00', 'closing_hours_weekends' => '16:00'],
            ['name' => 'Nabeul', 'address' => 'City Center', 'city' => 'Nabeul', 'country' => 'Tunisia', 'postal_code' => '8000', 'phone' => '+216 72 285 123', 'email' => 'nabeul@example.com', 'opening_hours_weekdays' => '09:00', 'closing_hours_weekdays' => '18:00', 'opening_hours_weekends' => '10:00', 'closing_hours_weekends' => '16:00'],
            ['name' => 'Sousse', 'address' => 'City Center', 'city' => 'Sousse', 'country' => 'Tunisia', 'postal_code' => '4000', 'phone' => '+216 73 225 123', 'email' => 'sousse@example.com', 'opening_hours_weekdays' => '09:00', 'closing_hours_weekdays' => '18:00', 'opening_hours_weekends' => '10:00', 'closing_hours_weekends' => '16:00'],
            ['name' => 'Tunis', 'address' => 'City Center', 'city' => 'Tunis', 'country' => 'Tunisia', 'postal_code' => '1000', 'phone' => '+216 71 123 456', 'email' => 'tunis@example.com', 'opening_hours_weekdays' => '09:00', 'closing_hours_weekdays' => '18:00', 'opening_hours_weekends' => '10:00', 'closing_hours_weekends' => '16:00'],
        ];

        foreach ($locations as $location) {
            DB::table('locations')->insert($location);
        }
    }
}
