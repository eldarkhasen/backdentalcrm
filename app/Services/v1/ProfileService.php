<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 31.05.2020
 * Time: 02:55
 */

namespace App\Services\v1;


interface ProfileService
{
    public function changePassword( $user, $currentPassword, $newPassword);
}