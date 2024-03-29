<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(PermissionsSeeder::class);
         $this->call(UsersAndRolesSeeder::class);
         $this->call(ServicesSeeder::class);
         $this->call(PositionsSeeder::class);
         $this->call(CountriesAndCitiesSeeder::class);
         $this->call(CashFlowSeeder::class);
         $this->call(OrganizationAndOwnerSeeder::class);
    }
}
