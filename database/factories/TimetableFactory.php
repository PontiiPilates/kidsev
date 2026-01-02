<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class TimetableFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $eventCount = DB::table('events')->count();
        $programCount = DB::table('programs')->count();
        $organizationCount = DB::table('organizations')->count();

        $startDate = Carbon::now()->addDays(rand(1, 7));
        $startTime = (clone $startDate)->setTime(rand(8, 21), 0, 0);
        $endTime = (clone $startTime)->addHours(rand(1, 2));

        return [
            'day_id' => $this->faker->numberBetween(1, 7),
            'program_id' => $this->faker->numberBetween(1, $programCount),
            'event_id' => $this->faker->numberBetween(1, $eventCount),
            'organization_id' => $this->faker->numberBetween(1, $organizationCount),
            'city_id' => 1,
            'time_from' => $startTime->isoFormat('YYYY-MM-DD HH:mm'),
            'time_to' => $endTime->isoFormat('YYYY-MM-DD HH:mm'),
        ];
    }
}
