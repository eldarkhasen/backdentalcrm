<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Exceptions\ApiServiceException;
use App\Http\Controllers\ApiBaseController;
use App\Http\Controllers\Controller;
use App\Http\Errors\ErrorCode;
use App\Http\Requests\Api\V1\Auth\LoginApiRequest;
use App\Services\v1\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

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
        // grab credentials from the request
        $credentials = $request->only('email', 'password');

        //Pass credentials to authservice to generate token and send response to user
        return $this->successResponse($this->authService->login($credentials));
    }

    public function me()
    {
        return $this->successResponse(Auth::user());
    }

    public function authFail()
    {
        return $this->failedResponse(['message' => 'Unauthorized', 'errors' => [
            'errorCode' => ErrorCode::UNAUTHORIZED
        ]]);
    }

    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

}
