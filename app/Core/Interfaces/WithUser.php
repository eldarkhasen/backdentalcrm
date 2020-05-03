<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 7.01.2020
 * Time: 08:47
 */

namespace App\Core\Interfaces;


interface WithUser
{
    public function getCurrentUser();

    public function getCurrentUserId();
}