<?php


namespace App\Http\Resources\Diagnosis;


use Illuminate\Http\Resources\Json\ResourceCollection;

class DiagnosisCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => DiagnosisResource::collection($this->collection),
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
