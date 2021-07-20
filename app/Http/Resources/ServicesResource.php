<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServicesResource extends JsonResource
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
           'id'=>$this->id,
           'name'=>$this->name,
           'description'=>$this->description,
           'duration'=>$this->duration,
           'price'=>$this->price,
           'max_price'=>$this->max_price,
           'category'=>$this->when(
               $this->relationLoaded('category'),
               new ServiceCategoriesResource($this->category)
           ),
           'organization_id'=>$this->organization_id,
           'pivot' => $this->when(
               $this->pivot,
               $this->pivot
           )
       ];
    }
}
