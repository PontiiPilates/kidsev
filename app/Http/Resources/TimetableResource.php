<?php

namespace App\Http\Resources;

use App\Models\Event;
use Illuminate\Http\Resources\Json\JsonResource;

class TimetableResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $day = $this->day ? (new DayResource($this->day))->name : null;
        $program = $this->program ? (new ProgramResource($this->program))->name : null;
        $event = $this->event ? (new EventResource($this->event))->name : null;

        return [
            'day' => $day,
            'title' => $program ?? $event,
            'type' => $program ? 'program' : 'event',
            'organization' => $this->organization ? (new OrganizationResource($this->organization))->short_name : null,
            'city' => (new CityResource($this->city))->name,
            'district' => (new DistrictResource($this->district))->name,
            'time_start' => $this->time_start,
            'time_end' => $this->time_end,
            'date' => $this->date,
        ];
    }
}
