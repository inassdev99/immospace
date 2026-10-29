<?php

namespace Database\Seeders;

use App\Models\Property;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    public function run(): void
    {
        $properties = [
            [
                'title' => 'Villa avec piscine',
                'city' => 'Marrakech',
                'district' => 'Route de l’Ourika',
                'type' => 'Villa',
                'transaction' => 'Vente',
                'price' => 3200000,
                'area' => 320,
                'bedrooms' => 4,
                'image' => '/images/villa-marrakech.jpg',
            ],
            [
                'title' => 'Appartement lumineux',
                'city' => 'Marrakech',
                'district' => 'Guéliz',
                'type' => 'Appartement',
                'transaction' => 'Location',
                'price' => 6500,
                'area' => 95,
                'bedrooms' => 2,
                'image' => '/images/appartement-marrakech.jpg',
            ],
            [
                'title' => 'Maison avec jardin',
                'city' => 'Casablanca',
                'district' => 'Californie',
                'type' => 'Maison',
                'transaction' => 'Vente',
                'price' => 2450000,
                'area' => 210,
                'bedrooms' => 3,
                'image' => '/images/maison-casablanca.jpg',
            ],
            [
                'title' => 'Appartement contemporain',
                'city' => 'Rabat',
                'district' => 'Agdal',
                'type' => 'Appartement',
                'transaction' => 'Vente',
                'price' => 1250000,
                'area' => 85,
                'bedrooms' => 2,
                'image' => '/images/appartement-rabat.jpg',
            ],
            [
                'title' => 'Villa familiale',
                'city' => 'Marrakech',
                'district' => 'Targa',
                'type' => 'Villa',
                'transaction' => 'Location',
                'price' => 18000,
                'area' => 280,
                'bedrooms' => 4,
                'image' => '/images/villa-targa.jpg',
            ],
            [
                'title' => 'Maison au calme',
                'city' => 'Rabat',
                'district' => 'Hay Riad',
                'type' => 'Maison',
                'transaction' => 'Location',
                'price' => 12000,
                'area' => 180,
                'bedrooms' => 3,
                'image' => '/images/maison-rabat.jpg',
            ],
        ];

        foreach ($properties as $property) {
            Property::firstOrCreate(
                [
                    'title' => $property['title'],
                    'city' => $property['city'],
                ],
                $property
            );
        }
    }
}