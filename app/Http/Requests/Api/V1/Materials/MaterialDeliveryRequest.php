<?php


namespace App\Http\Requests\Api\V1\Materials;


use App\Http\Requests\ApiBaseRequest;

class MaterialDeliveryRequest extends ApiBaseRequest
{

    public function injectedRules()
    {
        return [
            'materialRest.id' => ['required', 'numeric'],
            'quantity' => ['required', 'numeric'],
            'invoice_number' => ['required', 'max:255'],
            'delivery_date' => ['date', 'required'],
            'comments' => ['nullable'],
        ];
    }
}
