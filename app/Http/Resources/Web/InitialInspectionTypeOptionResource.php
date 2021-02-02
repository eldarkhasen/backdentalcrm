<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class InitialInspectionTypeOptionResource extends JsonResource
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
            'value' => $this->value,
            'edit_form_link' => route('inspectionOptions.edit', ['id' => $this->id]),
            'deleted' => isset($this->deleted_at),
            'status' => isset($this->deleted_at) ? 'Удален' : 'Активен',
        ];
    }
}
