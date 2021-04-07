<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 14.03.2020
 * Time: 20:21
 */

namespace App\Http\Requests\Api\V1\Auth;


use App\Http\Requests\ApiBaseRequest;

class RegisterApiRequest extends ApiBaseRequest
{
    public function injectedRules()
    {
        return [
            'password' => ['required', 'min:8'],
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users'],
        ];
    }

}
