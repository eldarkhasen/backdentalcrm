<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 31.05.2020
 * Time: 02:56
 */

namespace App\Services\v1\impl;


use App\Exceptions\ApiServiceException;
use App\Http\Errors\ErrorCode;
use App\Services\v1\ProfileService;
use Illuminate\Support\Facades\Hash;

class ProfileServiceImpl implements ProfileService
{
    public function changePassword($user, $currentPassword, $newPassword)
    {
        if (Hash::check($currentPassword, $user->getAuthPassword())) {
            $user->password = bcrypt($newPassword);
            $user->save();
        } else {
            throw new ApiServiceException(400, false, [
                'errors' => [
                    'Password do not match'
                ],
                'errorCode' => ErrorCode::PASSWORDS_MISMATCH
            ]);
        }
    }

}