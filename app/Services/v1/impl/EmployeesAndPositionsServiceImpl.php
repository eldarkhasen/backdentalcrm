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
use App\Models\Business\Appointment;
use App\Models\Permission;
use App\Models\Settings\Employee;
use App\Models\Settings\Position;
use App\Models\User;
use App\Services\v1\EmployeesAndPositionsService;
use Illuminate\Support\Facades\DB;

class EmployeesAndPositionsServiceImpl implements EmployeesAndPositionsService
{

    public function getEmployees($currentUser,$perPage)
    {
        if (!($currentUser->isEmployee() || $currentUser->isOwner())) {
            throw new ApiServiceException(400, false, [
                'errors' => [
                    'You are not allowed to do so'
                ],
                'errorCode' => ErrorCode::NOT_ALLOWED
            ]);
        }

        $currentUser->load(['employee', 'employee.organization', 'employee.organization.patients']);
        if (!($currentUser->employee && $currentUser->employee->organization)) {
            throw new ApiServiceException(400, false, [
                'errors' => [
                    'You are not allowed to do so'
                ],
                'errorCode' => ErrorCode::NOT_ALLOWED
            ]);
        }

        $org_id = $currentUser->employee->organization->id;
        return Employee::where('organization_id',$org_id)->with('positions', 'account', 'services')->paginate($perPage);
    }

    public function getEmployeeByPosition($currentUser,$position, $perPage)
    {
        if (!($currentUser->isEmployee() || $currentUser->isOwner())) {
            throw new ApiServiceException(400, false, [
                'errors' => [
                    'You are not allowed to do so'
                ],
                'errorCode' => ErrorCode::NOT_ALLOWED
            ]);
        }

        $currentUser->load(['employee', 'employee.organization', 'employee.organization.patients']);
        if (!($currentUser->employee && $currentUser->employee->organization)) {
            throw new ApiServiceException(400, false, [
                'errors' => [
                    'You are not allowed to do so'
                ],
                'errorCode' => ErrorCode::NOT_ALLOWED
            ]);
        }

        $org_id = $currentUser->employee->organization->id;
        $pos = Position::findOrFail($position);
        return $pos->employees()->where('organization_id',$org_id)->with('positions')->paginate($perPage);
    }

    public function searchEmployeeByPosition($currentUser,$search_key, $position_id, $perPage = 10)
    {
        if (!($currentUser->isEmployee() || $currentUser->isOwner())) {
            throw new ApiServiceException(400, false, [
                'errors' => [
                    'You are not allowed to do so'
                ],
                'errorCode' => ErrorCode::NOT_ALLOWED
            ]);
        }

        $currentUser->load(['employee', 'employee.organization', 'employee.organization.patients']);
        if (!($currentUser->employee && $currentUser->employee->organization)) {
            throw new ApiServiceException(400, false, [
                'errors' => [
                    'You are not allowed to do so'
                ],
                'errorCode' => ErrorCode::NOT_ALLOWED
            ]);
        }

        $org_id = $currentUser->employee->organization->id;
        return Employee::where('organization_id',$org_id)->with(['positions'])
            ->leftJoin('employees_has_positions as pos', 'pos.employee_id', '=', 'employees.id')
            ->where('pos.position_id', '=', $position_id)
            ->where(function ($query) use ($search_key) {
                $query->where('surname', 'LIKE', '%' . $search_key . '%');
                $query->Orwhere('name', 'LIKE', '%' . $search_key . '%');
                $query->Orwhere('patronymic', 'LIKE', '%' . $search_key . '%');
            })
            ->distinct()
            ->select(['employees.*'])
            ->paginate($perPage);
    }

    public function getPositions($currentUser)
    {
        if (!($currentUser->isEmployee() || $currentUser->isOwner())) {
            throw new ApiServiceException(400, false, [
                'errors' => [
                    'You are not allowed to do so'
                ],
                'errorCode' => ErrorCode::NOT_ALLOWED
            ]);
        }

        $currentUser->load(['employee', 'employee.organization', 'employee.organization.patients']);
        if (!($currentUser->employee && $currentUser->employee->organization)) {
            throw new ApiServiceException(400, false, [
                'errors' => [
                    'You are not allowed to do so'
                ],
                'errorCode' => ErrorCode::NOT_ALLOWED
            ]);
        }

        $org_id = $currentUser->employee->organization->id;
        return Position::where('organization_id',$org_id)->get();
    }

    public function searchEmployee($currentUser, $search_key, $perPage)
    {
        if (!($currentUser->isEmployee() || $currentUser->isOwner())) {
            throw new ApiServiceException(400, false, [
                'errors' => [
                    'You are not allowed to do so'
                ],
                'errorCode' => ErrorCode::NOT_ALLOWED
            ]);
        }

        $currentUser->load(['employee', 'employee.organization', 'employee.organization.patients']);
        if (!($currentUser->employee && $currentUser->employee->organization)) {
            throw new ApiServiceException(400, false, [
                'errors' => [
                    'You are not allowed to do so'
                ],
                'errorCode' => ErrorCode::NOT_ALLOWED
            ]);
        }

        $org_id = $currentUser->employee->organization->id;
        return Employee::where('name', 'LIKE', '%' . $search_key . '%')
            ->where('organization_id',$org_id)
            ->orWhere('surname', 'LIKE', '%' . $search_key . '%')
            ->orWhere('patronymic', 'LIKE', '%' . $search_key . '%')
            ->with('positions')
            ->paginate($perPage);
    }

    public function searchPosition($currentUser,$search_key)
    {
        if (!($currentUser->isEmployee() || $currentUser->isOwner())) {
            throw new ApiServiceException(400, false, [
                'errors' => [
                    'You are not allowed to do so'
                ],
                'errorCode' => ErrorCode::NOT_ALLOWED
            ]);
        }

        $currentUser->load(['employee', 'employee.organization', 'employee.organization.patients']);
        if (!($currentUser->employee && $currentUser->employee->organization)) {
            throw new ApiServiceException(400, false, [
                'errors' => [
                    'You are not allowed to do so'
                ],
                'errorCode' => ErrorCode::NOT_ALLOWED
            ]);
        }

        $org_id = $currentUser->employee->organization->id;
        return Position::where('name', $search_key)->where('organization_id',$org_id)->paginate(10);
    }

    public function storeEmployee($currentUser,StoreAndUpdateEmployeeApiRequest $request)
    {
        if (!($currentUser->isEmployee() || $currentUser->isOwner())) {
            throw new ApiServiceException(400, false, [
                'errors' => [
                    'You are not allowed to do so'
                ],
                'errorCode' => ErrorCode::NOT_ALLOWED
            ]);
        }

        $currentUser->load(['employee', 'employee.organization', 'employee.organization.patients']);
        if (!($currentUser->employee && $currentUser->employee->organization)) {
            throw new ApiServiceException(400, false, [
                'errors' => [
                    'You are not allowed to do so'
                ],
                'errorCode' => ErrorCode::NOT_ALLOWED
            ]);
        }

        $org_id = $currentUser->employee->organization->id;
        DB::beginTransaction();
        try {
            $employee = Employee::create([
                "name" => $request->name,
                "surname" => $request->surname,
                "patronymic" => $request->patronymic,
                'phone' => $request->phone,
                'birth_date' => $request->birth_date,
                'gender' => $request->gender,
                'color' => $request->color,
                'organization_id'=>$org_id
            ]);

            $positions = $request->positions;
            $services = $request->services;
            if (isset($positions)) {
                foreach ($positions as $pos) {
                    $employee->positions()->attach($pos['id']);
                }

            }

            if (isset($services)) {
                foreach ($services as $serv) {
                    $employee->services()->attach($serv['id']);
                }
            }

            if ($request->create_account) {
                $user = User::create([
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
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

            DB::commit();
            return $employee;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new ApiServiceException(400, false, [
                'errors' => [
                    $e->getMessage()
                ],
                'errorCode' => ErrorCode::SYSTEM_ERROR
            ]);
        }

    }

    public function storePosition($currentUser, StoreAndUpdatePositionApiRequest $request)
    {
        if (!($currentUser->isEmployee() || $currentUser->isOwner())) {
            throw new ApiServiceException(400, false, [
                'errors' => [
                    'You are not allowed to do so'
                ],
                'errorCode' => ErrorCode::NOT_ALLOWED
            ]);
        }

        $currentUser->load(['employee', 'employee.organization', 'employee.organization.patients']);
        if (!($currentUser->employee && $currentUser->employee->organization)) {
            throw new ApiServiceException(400, false, [
                'errors' => [
                    'You are not allowed to do so'
                ],
                'errorCode' => ErrorCode::NOT_ALLOWED
            ]);
        }

        $org_id = $currentUser->employee->organization->id;
        return Position::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'organization_id'=>$org_id
        ]);
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

    public function getEmployeeById($id)
    {
        return Employee::with('positions', 'account', 'services', 'account.permissions')->find($id);
    }

    public function updateEmployee(StoreAndUpdateEmployeeApiRequest $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $positions = $request->positions;
        $services = $request->services;
        $p_all = $employee->positions;
        $s_all = $employee->services;
        foreach ($p_all as $p) {
            $employee->positions()->detach($p->id);
        }
        foreach ($positions as $pos) {
            $employee->positions()->attach($pos['id']);
        }

        foreach ($s_all as $s) {
            $employee->services()->detach($s->id);
        }
        foreach ($services as $serv) {
            $employee->services()->attach($serv['id']);
        }

        $emp_data = $request->only(['name', 'surname', 'patronymic', 'phone', 'birth_date', 'gender', 'color']);
        $employee->update($emp_data);
        if ($employee->hasAccount()) {
            if ($request->create_account) {
                $user = $employee->account;
                $permissions_all = $user->permissions;
                $user->update([
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'role_id' => $request->role_id
                ]);
                $user->employee()->save($employee);
                foreach ($permissions_all as $perm) {
                    $user->permissions()->detach($perm->id);
                }

                $new_perms = $request->permissions;
                foreach ($new_perms as $perm) {
                    $user->permissions()->attach($perm['id']);
                }

            } else {
                //delete account
            }
        }
        Appointment::where('employee_id','=',$employee->id)->update(['color'=>$employee->color]);
        return $employee;
    }

    public function getEmployeesArray($currentUser)
    {
        if (!($currentUser->isEmployee() || $currentUser->isOwner())) {
            throw new ApiServiceException(400, false, [
                'errors' => [
                    'You are not allowed to do so'
                ],
                'errorCode' => ErrorCode::NOT_ALLOWED
            ]);
        }

        $currentUser->load(['employee', 'employee.organization', 'employee.organization.patients']);
        if (!($currentUser->employee && $currentUser->employee->organization)) {
            throw new ApiServiceException(400, false, [
                'errors' => [
                    'You are not allowed to do so'
                ],
                'errorCode' => ErrorCode::NOT_ALLOWED
            ]);
        }

        $org_id = $currentUser->employee->organization->id;
        return Employee::where('organization_id',$org_id)->get();
    }

    public function deleteEmployee($id)
    {
        return Employee::findOrFail($id)->delete();
    }
}
