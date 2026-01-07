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
        return [
            'day' => $this->day ? new DayResource($this->day) : null,
            'program' => $this->program ? new ProgramResource($this->program) : null,
            'event' => $this->event ? new EventResource($this->event) : null,
            'organization' => $this->organization ? new OrganizationResource($this->organization) : null,
            'city' => new CityResource($this->city),
            'district' => new DistrictResource($this->district),
            'time_start' => $this->time_start,
            'time_end' => $this->time_end,
            'date' => $this->date,
        ];
    }
}
