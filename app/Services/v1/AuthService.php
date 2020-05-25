<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 21.01.2020
 * Time: 20:42
 */

namespace App\Services\v1;

interface AuthService
{
    public function login($credentials);

    public function register($email, $password);
}