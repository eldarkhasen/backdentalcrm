<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 7.06.2020
 * Time: 13:25
 */

namespace App\Http\Controllers\Api\V1\Support;


use App\Http\Controllers\ApiBaseController;
use App\Services\v1\Support\SupportService;

class SupportController extends ApiBaseController
{

    protected $supportService;

    /**
     * SupportController constructor.
     * @param $supportService
     */
    public function __construct(SupportService $supportService)
    {
        $this->supportService = $supportService;
    }


    public function checkPatientIdCard()
    {
        return $this->successResponse([
            'exists' => $this->supportService->isPatientIdCardExists(request()->get('id_card'))
        ]);
    }

    public function checkPatientIdNumber()
    {
        return $this->successResponse([
            'exists' => $this->supportService->isPatientIdNumberExists(request()->get('id_number'))
        ]);
    }

    public function checkPatientPhone()
    {
        return $this->successResponse([
            'exists' => $this->supportService->isPatientPhoneExists(request()->get('phone'))
        ]);
    }
}