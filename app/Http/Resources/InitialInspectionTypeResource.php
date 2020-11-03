<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InitialInspectionTypeResource extends JsonResource
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
            'edit_form_link' => route('initialInspectionTypes.edit', ['initialInspectionType' => $this->id]),
            'show_item_link' => route('initialInspectionTypes.show', ['initialInspectionType' => $this->id]),
            'deleted' => isset($this->deleted_at),
            'status' => isset($this->deleted_at) ? 'Удален' : 'Активен',
        ];
    }
}
