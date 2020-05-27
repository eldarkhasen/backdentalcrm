<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 21.01.2020
 * Time: 20:42
 */

namespace App\Services\v1\impl;

use App\Exceptions\ApiServiceException;
use App\Http\Errors\ErrorCode;
use App\Models\Role;
use App\Models\User;
use App\Services\v1\AuthService;

class AuthServiceImpl implements AuthService
{
    public function login($credentials)
    {
        $user = User::where('email', $credentials['email'])->first();
        if (!($token = $this->guard()->attempt($credentials))) {
            throw new ApiServiceException(400, false,
                ['message' => 'Invalid email or password',
                    'errorCode' => ErrorCode::UNAUTHORIZED]);
        }

        return [
            'token' => $token,
            'role' => $user->role_id,
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ];
    }

    public function register($email, $password)
    {
        return User::create([
            'email' => $email,
            'password' => bcrypt($password),
            'role_id' => Role::EMPLOYEE_ID
        ]);
    }

    /**
     * Refresh a token.
     *
     * @return array
     */
    public function refresh()
    {
        return [
            'token' => $this->guard()->refresh(),
        ];
    }

    public function guard()
    {
        return auth()->guard('api');
    }


}
