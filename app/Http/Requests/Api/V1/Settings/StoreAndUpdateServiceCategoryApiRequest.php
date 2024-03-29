<?php
/**
 * Created by PhpStorm.
 * User: eldarkhasen
 * Date: 3/24/20
 * Time: 22:42
 */

namespace App\Http\Requests\Api\V1\Settings;


use App\Http\Requests\ApiBaseRequest;

class StoreAndUpdateServiceCategoryApiRequest extends ApiBaseRequest
{

    public function injectedRules()
    {
        return [
            "name"=>['required', 'string']
        ];
    }
}
