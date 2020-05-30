<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 31.05.2020
 * Time: 02:54
 */

namespace App\Http\Requests\Api\V1\Profile;


use App\Http\Requests\Api\ApiBaseRequest;

class ChangePasswordApiRequest extends ApiBaseRequest
{
    public function injectedRules()
    {
        return [
            'current_password' => ['required', 'min:8'],
            'password' => ['required', 'min:8'],
        ];
    }

}