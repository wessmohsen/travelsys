<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agency;

class AgencySeeder extends Seeder
{
    public function run(): void
    {
        $agencies = [
            'ANNA',
            'CORAL ON',
            'ETS',
            'FLASH',
            'GO VACATION',
            'LOCAL',
            'LOCAL A HASSAN',
            'LOCAL KHALEDMAMFES',
            'LOCAL SHANCE',
            'LOCAL TITO',
            'MAMFES',
            'MARINA VIEW',
            'MARKETA',
            'MASTER',
            'MEETING PO',
            'MINT TOUR',
            'OCEAN AIRE',
            'ORCA IBRAHEM',
            'PARADISE',
            'PLANT',
            'SHABAN',
            'SPRING',
            'SUN INTR',
            'T WAYES',
            'T.WAYES',
            'TRAVICO',
        ];

        foreach ($agencies as $agencyName) {
            Agency::create([
                'name' => $agencyName,
                'email' => strtolower(str_replace([' ', '.'], ['_', ''], $agencyName)) . '@agency.com',
                'phone' => '+20-1' . rand(000000000, 999999999),
                'street' => 'Street for ' . $agencyName,
                'city' => 'Hurghada',
                'country' => 'Egypt',
            ]);
        }
    }
}
