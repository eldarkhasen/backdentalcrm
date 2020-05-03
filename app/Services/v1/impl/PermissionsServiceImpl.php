<?php
/**
 * Created by PhpStorm.
 * User: eldarkhasen
 * Date: 4/30/20
 * Time: 12:10
 */

namespace App\Services\v1\impl;


use App\Models\Permission;
use App\Models\User;
use App\Services\v1\PermissionsService;

class PermissionsServiceImpl implements PermissionsService
{

    public function getUsersPermissions($user_id)
    {
       return User::findOrFail($user_id)->permissions();

    }

    public function getAllPermissions()
    {
        return Permission::all();
    }
}