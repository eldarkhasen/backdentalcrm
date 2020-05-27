<?php
/**
 * Created by PhpStorm.
 * User: eldarkhasen
 * Date: 3/24/20
 * Time: 22:42
 */

namespace App\Http\Requests\Api\V1\Settings;


use App\Http\Requests\Api\ApiBaseRequest;

class StoreAndUpdateEmployeeApiRequest extends ApiBaseRequest
{

    public function injectedRules()
    {
        return [
            "name" => ['required', 'string'],
            "surname" => ['required', 'string'],
            "patronymic",
            "positions" => ['required', 'array'],
            "services" => ['required', 'array'],
            "email" => ['unique:users,email'],
            "password",
            "role_id",
            "permissions",
            "phone" => ['required', 'string'],
            "birth_date" => ['required', 'string'],
            "gender" => ['required', 'string'],
            "color" => ['required', 'string'],
            "create_account" => ['required', 'boolean'],
            "organization_id" => ['required', 'exists:organizations,id']
        ];
    }
}