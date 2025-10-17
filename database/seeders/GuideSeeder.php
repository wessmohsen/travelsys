<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Guide;

class GuideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $guideNames = [
            'Ahmed El-Sayed',
            'Mohamed Hassan',
            'Karim Mahmoud',
            'Youssef Adel',
            'Amr Nabil',
            'Hossam Farouk',
            'Tamer Mostafa',
            'Omar Khaled',
            'Mahmoud Fathy',
            'Islam Hegazy',
            'Sherif Ali',
            'Ahmed Tarek',
            'Khaled Samir',
            'Ehab Salah',
            'Ramy Gamal',
            'Walid Ashraf',
            'Ayman Saad',
        ];

        $languages = ['English', 'Arabic', 'French', 'German', 'Italian', 'Spanish', 'Russian'];

        foreach ($guideNames as $guideName) {
            Guide::create([
                'name' => $guideName,
                'language' => fake()->randomElement($languages),
            ]);
        }
    }
}
