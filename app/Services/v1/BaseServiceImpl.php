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

        if (get_class($e) == ApiServiceException::class) {
            throw $e;
        }

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

    protected function getUserOrganizationId($currentUser){
        if (!($currentUser->isEmployee() || $currentUser->isOwner())) {
            throw new ApiServiceException(400, false, [
                'errors' => [
                    'You are not allowed to do so'
                ],
                'errorCode' => ErrorCode::NOT_ALLOWED
            ]);
        }

        $currentUser->load(['employee', 'employee.organization']);

        if (!($currentUser->employee && $currentUser->employee->organization)) {
            throw new ApiServiceException(400, false, [
                'errors' => [
                    'You are not allowed to do so'
                ],
                'errorCode' => ErrorCode::NOT_ALLOWED
            ]);
        }

        return $currentUser->employee->organization->id;
    }
}