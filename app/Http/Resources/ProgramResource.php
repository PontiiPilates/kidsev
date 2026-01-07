<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProgramResource extends JsonResource
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
            'organization_id' => $this->organization_id,
            'name' => $this->name,
            'description' => $this->description,
            'age_from' => $this->age_from,
            'age_to' => $this->age_to,
        ];
    }
}
