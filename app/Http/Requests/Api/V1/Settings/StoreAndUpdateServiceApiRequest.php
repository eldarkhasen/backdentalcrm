<?php
/**
 * Created by PhpStorm.
 * User: eldarkhasen
 * Date: 3/24/20
 * Time: 22:42
 */

namespace App\Http\Requests\Api\V1\Settings;


use App\Http\Requests\Api\ApiBaseRequest;

class StoreAndUpdateServiceApiRequest extends ApiBaseRequest
{

    public function injectedRules()
    {
        return [
            "name"=>['required', 'string'],
            "description"=>['required', 'string'],
            "duration" =>['required','numeric'],
            "category_id"=>['required','numeric'],
            "price"=>['required','numeric'],
            "max_price",
            "organization_id" => ['required', 'exists:organizations,id']
        ];
    }
}