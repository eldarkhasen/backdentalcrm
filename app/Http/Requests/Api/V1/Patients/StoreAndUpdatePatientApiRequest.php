<?php
/**
 * Created by PhpStorm.
 * User: eldarkhasen
 * Date: 3/24/20
 * Time: 22:42
 */

namespace App\Http\Requests\Api\V1\Patients;


use App\Http\Requests\ApiBaseRequest;

class StoreAndUpdatePatientApiRequest extends ApiBaseRequest
{

    public function injectedRules()
    {
        return [
            "name"=>['required', 'string'],
            "surname"=>['required', 'string'],
            "patronymic",
            "phone"=>['required', 'string'],
            "birth_date"=>['string'],
            "gender"=>['string'],
            "id_card",
            "id_number",
            "city",
            "address",
            "workplace",
            "position",
            "discount"
        ];
    }
}
