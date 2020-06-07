<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 7.06.2020
 * Time: 13:27
 */

namespace App\Services\v1\Support\impl;


use App\Models\Patients\Patient;
use App\Services\v1\Support\SupportService;

class SupportServiceImpl implements SupportService
{
    public function isPatientIdCardExists($idCard)
    {
        return !!Patient::where('id_card', '=', $idCard)->first();
    }

    public function isPatientIdNumberExists($idNumber)
    {
        return !!Patient::where('id_number', '=', $idNumber)->first();
    }

    public function isPatientPhoneExists($phone)
    {
        return !!Patient::where('phone', '=', $phone)->first();
    }

}