<?php

namespace App\Http\Controllers;


use App\Core\Interfaces\WithUser;
use App\Utils\ResponseUtil;
use Illuminate\Support\Facades\Auth;


class ApiBaseController extends Controller implements WithUser
{

    public function makeResponse($code, $other)
    {
        return ResponseUtil::makeResponse($code, $other);
    }

    public function successResponse($other)
    {
        return ResponseUtil::makeResponse(200, $other);
    }

    public function failedResponse($other)
    {
        return ResponseUtil::makeResponse(400, $other);
    }

    public function makeWithSuccessFieldResponse($code, $success, $other)
    {
        return ResponseUtil::makeArrayResponse($code, $success, $other);
    }

    public function successWithSuccessFieldResponse($other)
    {
        return ResponseUtil::makeArrayResponse(200, true, $other);
    }

    public function failedWithSuccessFieldResponse($other)
    {
        return ResponseUtil::makeArrayResponse(400, false, $other);
    }

    public function getCurrentUser()
    {
        return auth()->user();
    }

    public function getCurrentUserId()
    {
        return auth()->id();
    }

}
