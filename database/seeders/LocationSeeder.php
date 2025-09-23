<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            'United States',
            'Canada',
            'United Kingdom',
            'Australia',
            'Germany',
            'France',
            'India',
            'Pakistan',
            'Philippines',
            'Bangladesh',
            'Brazil',
            'Mexico',
            'Spain',
            'Italy',
            'Netherlands',
            'Poland',
            'Ukraine',
            'China',
            'Japan',
            'South Korea',
            'Singapore',
            'United Arab Emirates',
            'Saudi Arabia',
            'South Africa',
            'Nigeria',
            'Egypt',
            'Turkey',
            'Argentina',
            'Chile',
            'Colombia',
        ];

        foreach ($countries as $country) {
            Location::create(['name' => $country]);
        }
    }
}
