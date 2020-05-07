<?php
/**
 * Created by PhpStorm.
 * User: eldarkhasen
 * Date: 5/1/20
 * Time: 14:36
 */

namespace App\Services\v1\impl;


use App\Exceptions\ApiServiceException;
use App\Http\Errors\ErrorCode;
use App\Http\Requests\Api\V1\Settings\StoreAndUpdateEmployeeApiRequest;
use App\Http\Requests\Api\V1\Settings\StoreAndUpdatePositionApiRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Settings\Employee;
use App\Models\Settings\Position;
use App\Models\User;
use App\Services\v1\EmployeesAndPositionsService;

class EmployeesAndPositionsServiceImpl implements EmployeesAndPositionsService
{

    public function getEmployees()
    {
        return Employee::with('positions', 'account','services')->paginate(10);
    }

    public function getPositions()
    {
        return Position::all();
    }

    public function searchEmployee($search_key)
    {
        // TODO: Implement searchEmployee() method.
    }

    public function searchPosition($search_key)
    {
        return Position::where('name', $search_key)->paginate(10);
    }

    public function storeEmployee(StoreAndUpdateEmployeeApiRequest $request)
    {
        $employee = Employee::create([
            "name" => $request->name,
            "surname" => $request->surname,
            "patronymic" => $request->patronymic,
            'phone' => $request->phone,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'color' => $request->color
        ]);

        $positions = $request->positions;
        $services = $request->services;
        if (isset($positions)) {
            foreach($positions as $pos){
                $employee->positions()->attach($pos['id']);
            }

        }

        if (isset($services)) {
            foreach ($services as $serv){
                $employee->services()->attach($serv['id']);
            }
        }

        if ($request->create_account) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' =>  bcrypt($request->password),
                'role_id' => $request->role_id
            ]);

            if ($request->role_id == \App\Models\Role::ADMIN_ID) {
                $permissions = Permission::all();
                $user->permissions()->attach($permissions);
            } else {
                $permissions = $request->permissions;
                foreach ($permissions as $permission)
                $user->permissions()->attach($permission['id']);
            }

            $user->employee()->save($employee);
        }

        return $employee;
    }

    public function storePosition(StoreAndUpdatePositionApiRequest $request)
    {
        return Position::create($request->all());
    }

    public function updatePosition($id, StoreAndUpdatePositionApiRequest $request)
    {
        $position = Position::findOrFail($id);
        return $position->update($request->all());
    }

    public function deletePosition($id)
    {
        $position = Position::findOrFail($id);
        if (count($position->employees) > 0) {
            throw new ApiServiceException(400, false,
                ['message' => 'Нельзя удалить данную позицию',
                    'errorCode' => ErrorCode::NOT_ALLOWED]);
        }
        return Position::destroy($id);
    }

    public function getPositionById($id)
    {
        return Position::findOrFail($id);
    }

    public function getEmployeeById($id){
        return Employee::with('positions', 'account','services','account.permissions')->find($id);
    }

    public function updateEmployee(StoreAndUpdateEmployeeApiRequest $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $positions = $request->positions;
        $services = $request->services;
        $p_all = $employee->positions;
        $s_all = $employee->services;
        foreach ($p_all as $p){
            $employee->positions()->detach($p->id);
        }
        foreach ($positions as $pos){
            $employee->positions()->attach($pos['id']);
        }

        foreach ($s_all as $s){
            $employee->services()->detach($s->id);
        }
        foreach ($services as $serv){
            $employee->services()->attach($serv['id']);
        }

        $emp_data = $request->only(['name','surname','patronymic','phone','birth_date','gender','color']);
        $employee->update($emp_data);
        if($employee->hasAccount()){
            if($request->create_account){
                $user = $employee->account;
                $permissions_all = $user->permissions;
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' =>  bcrypt($request->password),
                    'role_id' => $request->role_id
                ]);
                $user->employee()->save($employee);
                foreach($permissions_all as $perm){
                    $user->permissions()->detach($perm->id);
                }

                $new_perms = $request->permissions;
                foreach ($new_perms as $perm){
                    $user->permissions()->attach($perm['id']);
                }

            }else{
                //delete account
            }
        }
        return $employee;
    }
}