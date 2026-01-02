<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;

use App\Models\About;
use App\Models\Event;
use App\Models\Program;
use App\Models\Promotion;
use App\Models\Timetable;

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
