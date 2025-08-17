<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Créer quatre voitures par défaut
        DB::table('cars')->insert([
                [
                    'brand' => 'Toyota',
                    'model' => 'Camry',
                    'year' => 2022,
                    'registration_number' => 'ABC123',
                    'images' => 'assets/v1.webp',
                    'availability' => 1,
                    'description' => 'Cette voiture est une berline élégante et performante. Avec son design moderne et ses caractéristiques avancées, elle offre une expérience de conduite exceptionnelle.',
                ],
                [
                    'brand' => 'Honda',
                    'model' => 'Accord',
                    'year' => 2021,
                    'registration_number' => 'XYZ456',
                    'images' => 'assets/v2.jpg',
                    'availability' => 1,
                    'description' => 'Cette voiture est une berline élégante et performante. Avec son design moderne et ses caractéristiques avancées, elle offre une expérience de conduite exceptionnelle.',
                ],
                [
                    'brand' => 'Ford',
                    'model' => 'Mustang',
                    'year' => 2023,
                    'registration_number' => 'DEF789',
                    'images' => 'assets/v3.jpg',
                    'availability' => 1,
                    'description' => 'Cette voiture est une berline élégante et performante. Avec son design moderne et ses caractéristiques avancées, elle offre une expérience de conduite exceptionnelle.',
                ],
                [
                    'brand' => 'Chevrolet',
                    'model' => 'Camaro',
                    'year' => 2022,
                    'registration_number' => 'GHI012',
                    'images' => 'assets/v4.jpg',
                    'availability' => 1,
                    'description' => 'Cette voiture est une berline élégante et performante. Avec son design moderne et ses caractéristiques avancées, elle offre une expérience de conduite exceptionnelle.',
                ],
                [
                    'brand' => 'Tesla',
                    'model' => 'Model 3',
                    'year' => 2022,
                    'registration_number' => 'JKL345',
                    'images' => 'assets/v5.jpg',
                    'availability' => 1,
                    'description' => 'Cette voiture est une berline élégante et performante. Avec son design moderne et ses caractéristiques avancées, elle offre une expérience de conduite exceptionnelle.',
                ],          
        ]);
    }
}
