<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 7.06.2020
 * Time: 13:27
 */

namespace App\Services\v1\Support;


interface SupportService
{
    public function isPatientIdCardExists($idCard);

    public function isPatientIdNumberExists($idNumber);

    public function isPatientPhoneExists($phone);
}