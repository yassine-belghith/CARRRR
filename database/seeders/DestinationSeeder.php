<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Destination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Destination::truncate();
        Schema::enableForeignKeyConstraints();

        $destinations = [
            // Aéroports
            ['name' => 'Aéroport Djerba', 'type' => 'Aéroport', 'address' => 'Aéroport Djerba-Zarzis', 'city' => 'Djerba', 'country' => 'Tunisia', 'is_active' => true],
            ['name' => 'Aéroport Enfidha', 'type' => 'Aéroport', 'address' => 'Aéroport International Enfidha-Hammamet', 'city' => 'Enfidha', 'country' => 'Tunisia', 'is_active' => true],
            ['name' => 'Aéroport Monastir', 'type' => 'Aéroport', 'address' => 'Aéroport International Habib Bourguiba', 'city' => 'Monastir', 'country' => 'Tunisia', 'is_active' => true],
            ['name' => 'Aéroport Tunis Carthage', 'type' => 'Aéroport', 'address' => 'Aéroport de Tunis-Carthage', 'city' => 'Tunis', 'country' => 'Tunisia', 'is_active' => true],

            // Centre ville
            ['name' => 'Djerba', 'type' => 'Centre ville', 'address' => 'Centre ville, Djerba', 'city' => 'Djerba', 'country' => 'Tunisia', 'is_active' => true],
            ['name' => 'Hammamet', 'type' => 'Centre ville', 'address' => 'Centre ville, Hammamet', 'city' => 'Hammamet', 'country' => 'Tunisia', 'is_active' => true],
            ['name' => 'La marsa', 'type' => 'Centre ville', 'address' => 'Centre ville, La Marsa', 'city' => 'La Marsa', 'country' => 'Tunisia', 'is_active' => true],
            ['name' => 'Monastir', 'type' => 'Centre ville', 'address' => 'Centre ville, Monastir', 'city' => 'Monastir', 'country' => 'Tunisia', 'is_active' => true],
            ['name' => 'Nabeul', 'type' => 'Centre ville', 'address' => 'Centre ville, Nabeul', 'city' => 'Nabeul', 'country' => 'Tunisia', 'is_active' => true],
            ['name' => 'Sousse', 'type' => 'Centre ville', 'address' => 'Centre ville, Sousse', 'city' => 'Sousse', 'country' => 'Tunisia', 'is_active' => true],
            ['name' => 'Tunis', 'type' => 'Centre ville', 'address' => 'Centre ville, Tunis', 'city' => 'Tunis', 'country' => 'Tunisia', 'is_active' => true],
        ];

        foreach ($destinations as $destination) {
            Destination::create($destination);
        }
    }
}
