<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CashBoxResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'balance'       => $this->balance,
            'is_main'       => $this->is_main,
            'organization'  => $this->relationLoaded('organization')
                                ? new OrganizationResource($this->organization)
                                : null,
        ];
    }
}
