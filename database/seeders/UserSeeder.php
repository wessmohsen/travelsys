<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userNames = [
            'Mostafa Hassan',
            'Islam Magdy',
            'Nour Eldin Khalaf',
            'Yasser Abdelrahman',
            'Hany Sabry',
            'Walid Moustafa',
            'Sherif El-Badry',
            'Fares Samy',
            'Tarek Mahmoud',
            'Ahmed Gomaa',
            'Eslam Aref',
            'Mahmoud Lotfy',
            'Rami Sayed',
            'Kareem Soliman',
            'Hazem Abdelaziz',
        ];

        foreach ($userNames as $userName) {
            // Generate email from name (lowercase, replace spaces with dots)
            $email = strtolower(str_replace(' ', '.', $userName)) . '@travelsys.com';

            User::create([
                'name' => $userName,
                'email' => $email,
                'password' => Hash::make('password123'), // Default password for all users
            ]);
        }
    }
}
