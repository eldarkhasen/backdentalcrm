<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 31.05.2020
 * Time: 02:54
 */

namespace App\Http\Controllers\Api\V1\Profile;


use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\Api\V1\Profile\ChangePasswordApiRequest;
use App\Services\v1\ProfileService;

class ProfileController extends ApiBaseController
{

    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }


    public function changePassword(ChangePasswordApiRequest $request)
    {
        $this->profileService->changePassword($this->getCurrentUser(), $request->current_password, $request->password);
        return $this->successResponse([
            'message' => 'password changed'
        ]);
    }
}