<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $type = $this->relationLoaded('subscriptionType')
            ? new SubscriptionTypeResource($this->subscriptionType)
            : null;

        return [
            'id' => $this->id,
            'start_date' => Carbon::parse($this->start_date)->isoFormat('DD.MM.YYYY'),
            'end_date' => Carbon::parse($this->end_date)->isoFormat('DD.MM.YYYY'),
            'actual_price' => $this->actual_price,
            'subscriptionTypeName' => $this->when(isset($type), $type->name),
            'subscriptionType' => $type,
        ];
    }
}
