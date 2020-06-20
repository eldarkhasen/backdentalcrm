<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CashFlowOperationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,

            'from_cash_box' => $this->when(
                $this->relationLoaded('fromCashBox'),
                new CashBoxResource($this->fromCashBox)
            ),

            'to_cash_box' => $this->when(
                $this->relationLoaded('toCashBox'),
                new CashBoxResource($this->toCashBox)
            ),

            'type' => $this->when(
                $this->relationLoaded('type'),
                new CashFlowOperationTypeResource($this->type)
            ),

            'appointment' => $this->when(
                $this->relationLoaded('appointment'),
                new AppointmentResource($this->appointment)
            ),
        ];
    }
}
