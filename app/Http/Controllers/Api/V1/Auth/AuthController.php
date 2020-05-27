<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\ApiBaseController;
use App\Http\Errors\ErrorCode;
use App\Http\Requests\Api\V1\Auth\LoginApiRequest;
use App\Models\User;
use App\Services\v1\AuthService;
use Illuminate\Support\Facades\Auth;
use JWTAuth;

class AuthController extends ApiBaseController
{
    protected $authService;

    /**
     * AuthController constructor.
     * @param $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }


    public function authenticate(LoginApiRequest $request)
    {
        return $this->successResponse($this->authService->login($request->all()));
    }

    public function me()
    {
        return $this->successResponse(User::with('permissions')
            ->find($this->getCurrentUserId()));
    }

    public function authFail()
    {
        return $this->failedResponse(['message' => 'Unauthorized', 'errors' => [
            'errorCode' => ErrorCode::UNAUTHORIZED
        ]]);
    }

    public function logout()
    {
        auth()->logout();
        return $this->successResponse(['message' => 'Successfully logged out']);
    }

}
