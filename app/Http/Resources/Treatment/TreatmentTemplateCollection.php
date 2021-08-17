<?php


namespace App\Http\Resources\Treatment;


use Illuminate\Http\Resources\Json\ResourceCollection;

class TreatmentTemplateCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => TreatmentTemplateResource::collection($this->collection),
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
