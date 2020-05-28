<?php

use App\Models\Support\City;
use App\Models\Support\Country;
use Illuminate\Database\Seeder;

class CountriesAndCitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kaz_id = Country::create([
            'name' => 'Kazakhstan'
        ])->id;
        City::create([
            'name' => 'Алматы',
            'timezone' => 6,
            'country_id' => $kaz_id
        ]);
        City::create([
            'name' => 'Астана',
            'timezone' => 6,
            'country_id' => $kaz_id
        ]);
        City::create([
            'name' => 'Талдыкорган',
            'timezone' => 6,
            'country_id' => $kaz_id
        ]);
        City::create([
            'name' => 'Шымкент',
            'timezone' => 6,
            'country_id' => $kaz_id
        ]);
    }
}
