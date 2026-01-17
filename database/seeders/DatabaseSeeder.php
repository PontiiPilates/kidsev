<?php

namespace Database\Seeders;

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
        $this->call([
            CitySeeder::class,
            DaySeeder::class,
            DistrictSeeder::class,
            OrganizationSeeder::class,

            ProgramSeeder::class,
            EventSeeder::class,
            TimetableSeeder::class,
        ]);
    }
}
