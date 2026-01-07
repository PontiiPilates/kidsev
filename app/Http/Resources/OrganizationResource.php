<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationResource extends JsonResource
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
            'short_name' => $this->short_name,
            'name' => $this->name,
            'code' => $this->code,
            'address' => $this->address,
            'city' => new CityResource($this->city),
            'district' => new DistrictResource($this->district),
        ];
    }
}
