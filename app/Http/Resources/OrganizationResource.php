<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $city_loaded = $this->relationLoaded('city');
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'email'=>$this->email,
            'city' => $this->when($city_loaded, $this->city),
            'city_name' => $this->when($city_loaded, $this->city->name),
            'edit_form_link' => route('organizations.edit', ['organization' => $this->id]),
            'show_item_link' => route('organizations.show', ['organization' => $this->id]),
            'deleted' => $this->deleted,
            'status' => $this->deleted ? 'Удалена' : 'Активна',
        ];
    }
}
