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
use App\Http\Utils\ApiUtil;
use App\Models\Role;
use App\Models\User;
use App\Services\v1\AuthService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use JWTAuth;

class AuthServiceImpl implements AuthService
{
    public function login($credentials)
    {
        $user = User::where('email',$credentials['email'])->first();
        // attempt to verify the credentials and create a token for the user
        if (!$token = JWTAuth::attempt($credentials)) {
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

    public function register($email, $password, $name)
    {
        return User::create([
            'name' => $name,
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
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }

}
