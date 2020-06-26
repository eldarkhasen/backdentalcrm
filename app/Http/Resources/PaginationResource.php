<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaginationResource extends JsonResource
{
    private $data = null;

    public function __construct($resource, $data)
    {
        parent::__construct($resource);

        $this->data = $data;
    }

    public function toArray($request)
    {
        return [
            'total'         => $this->total(),
            'current_page'   => $this->currentPage(),
            'per_page'       => $this->perPage(),
            'last_page'      => $this->lastPage(),
            'data'          => $this->data,
        ];
    }
}
