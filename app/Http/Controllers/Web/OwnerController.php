<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 3.06.2020
 * Time: 04:56
 */

namespace App\Http\Controllers\Web;


use App\Http\Controllers\WebBaseController;
use App\Models\Role;
use App\Models\User;

class OwnerController extends WebBaseController
{
    public function index()
    {
        $users = User::with('employee', 'employee.organization')
            ->has('employee')
            ->where('role_id', '=', Role::OWNER_ID)
            ->paginate(10);
        return view('web.owner.index', compact('users'));
    }
}