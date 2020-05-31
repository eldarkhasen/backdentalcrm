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
        $currentSubscription = $this->relationLoaded('currentSubscription')
            ? new SubscriptionResource($this->currentSubscription)
            : null;
        $subscriptions = $this->relationLoaded('subscriptions')
            ? SubscriptionResource::collection($this->subscriptions)
            : [];
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'phone'=>$this->phone,
            'email'=>$this->email,
            'city' => $this->when($city_loaded, $this->city),
            'city_name' => $this->when($city_loaded, $this->city->name),
            'edit_form_link' => route('organizations.edit', ['organization' => $this->id]),
            'show_item_link' => route('organizations.show', ['organization' => $this->id]),
            'deleted' => isset($this->deleted_at),
            'status' => isset($this->deleted_at) ? 'Удалена' : 'Активна',
            'currentSubscription' => $currentSubscription,
            'subscriptions' => $subscriptions,
            'employees' => $this->when($this->relationLoaded('employees'), $this->employees),
        ];
    }
}
