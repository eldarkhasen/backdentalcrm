<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 28.06.2020
 * Time: 17:21
 */

namespace App\Http\Requests\Api\V1\Patients;


use App\Http\Requests\ApiBaseRequest;

class SearchPatientApiRequest extends ApiBaseRequest
{
    public function injectedRules()
    {
        return [
            'name' => ['nullable', 'string'],
            'surname' => ['nullable', 'string'],
            'patronymic' => ['nullable', 'string'],
            'phone' => ['nullable', 'string'],
        ];
    }

}
