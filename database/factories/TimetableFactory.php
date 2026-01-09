<?php

namespace Database\Factories;

use App\Models\Day;
use App\Models\Event;
use App\Models\Organization;
use App\Models\Program;
use App\Models\Timetable;
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
    public function definition(): array
    {
        $dayCount = Day::count();

        $organization = Organization::find($this->faker->numberBetween(1, Organization::count()));

        $startDate = Carbon::now()->addDays(rand(1, 7));
        $startTime = (clone $startDate)->setTime(rand(8, 21), 0, 0);
        $endTime = (clone $startTime)->addHours(rand(1, 2));

        $baseChunk = [
            'day_id' => $this->faker->numberBetween(1, $dayCount),
            'organization_id' => $organization->id,
            'city_id' => $organization->city_id,
            'district_id' => $organization->district_id,
            'time_start' => $startTime->isoFormat('YYYY-MM-DD HH:mm'),
            'time_end' => $endTime->isoFormat('YYYY-MM-DD HH:mm'),
        ];

        $type = rand(1, 100) <= 80 ? 'program' : 'event';

        if ($type === 'program') {
            return array_merge($baseChunk, [
                'program_id' => $this->getRandomProgramId(),
                'event_id' => null,
            ]);
        }

        return array_merge($baseChunk, [
            'program_id' => null,
            'event_id' => $this->getUniqueEventId(),
        ]);
    }

    /**
     * Получить случайный ID программы
     */
    private function getRandomProgramId(): int
    {
        $programIds = Program::pluck('id')->toArray();

        return $this->faker->randomElement($programIds);
    }

    /**
     * Получить уникальный ID мероприятия, которого еще нет в расписании
     */
    private function getUniqueEventId(): int
    {
        $allEventIds = Event::pluck('id')->toArray();

        $usedEventIds = Timetable::whereNotNull('event_id')
            ->pluck('event_id')
            ->toArray();

        $availableEventIds = array_diff($allEventIds, $usedEventIds);

        if (empty($availableEventIds)) {
            throw new \Exception('Все мероприятия уже используются в расписаниях');
        }

        return $this->faker->randomElement($availableEventIds);
    }
}
