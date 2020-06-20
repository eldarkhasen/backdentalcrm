<?php


namespace App\Services\v1;


use App\Exceptions\ApiServiceException;
use App\Http\Errors\ErrorCode;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\DB;

class BaseServiceImpl
{
    protected function validateUserAccess(Authenticatable $user) {
        if (!($user->isEmployee() || $user->isOwner())) {
            throw new ApiServiceException(400, false, [
                'errors' => [
                    'You are not allowed to do so'
                ],
                'errorCode' => ErrorCode::NOT_ALLOWED
            ]);
        }
    }

    protected function onError($e) {
        DB::rollBack();
        throw new ApiServiceException(400, false, [
            'errors' => [
                'System error',
                $e->getMessage()
            ],
            'errorCode' => ErrorCode::SYSTEM_ERROR
        ]);
    }
}