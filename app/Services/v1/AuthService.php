<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 21.01.2020
 * Time: 20:42
 */

namespace App\Services\v1;


use App\Http\Requests\Api\V1\Auth\CheckLoginExistenceApiRequest;
use App\Http\Requests\Api\V1\Auth\LoginApiRequest;
use App\Http\Requests\Api\V1\Auth\RegisterApiRequest;

interface AuthService
{
    public function login($credentials);

    public function register($email, $password, $name);
}