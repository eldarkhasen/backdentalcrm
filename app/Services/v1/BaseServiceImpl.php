<?php


namespace App\Services\v1;


use App\Exceptions\ApiServiceException;
use App\Http\Errors\ErrorCode;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\DB;

class BaseServiceImpl
{
    protected function validateUserAccess(Authenticatable $user) {
        if (!$this->userHasAccess($user)) {
            $this->onError(
                new \Exception('Not allowed', 400),
                'You are not allowed to do so',
                ErrorCode::NOT_ALLOWED
            );
        }
    }

    protected function onError($e, $title, $errorCode) {
        DB::rollBack();
        throw new ApiServiceException(400, false, [
            'errors' => [
                $title,
                $e->getMessage()
            ],
            'errorCode' => $errorCode,
        ]);
    }

    protected function userHasAccess(Authenticatable $user)
    {
        return $user->isEmployee() || $user->isOwner();
    }
}