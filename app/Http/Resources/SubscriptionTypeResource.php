<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'expiration_days' => $this->expiration_days,
            'employees_count'=> $this->employees_count,
            'edit_form_link' => route('subscriptiontypes.edit', ['subscriptiontype' => $this->id]),
            'deleted' => $this->deleted,
            'status' => $this->deleted ? 'Удален' : 'Активен',
        ];
    }
}
