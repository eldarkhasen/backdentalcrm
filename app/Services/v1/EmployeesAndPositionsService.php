<?php
/**
 * Created by PhpStorm.
 * User: eldarkhasen
 * Date: 5/1/20
 * Time: 14:36
 */

namespace App\Services\v1;


use App\Http\Requests\Api\V1\Settings\StoreAndUpdateEmployeeApiRequest;
use App\Http\Requests\Api\V1\Settings\StoreAndUpdatePositionApiRequest;

interface EmployeesAndPositionsService
{
    public function getEmployees($currentUser, $perPage);

    public function getEmployeesArray($currentUser);

    public function getPositions($currentUser);

    public function searchEmployee($currentUser, $search_key, $perPage);

    public function getEmployeeByPosition($currentUser,$position, $perPage);

    public function searchEmployeeByPosition($currentUser,$search_key, $position, $perPage = 10);

    public function searchPosition($currentUser,$search_key);

    public function storeEmployee($currentUser,StoreAndUpdateEmployeeApiRequest $request);

    public function storePosition($currentUser, StoreAndUpdatePositionApiRequest $request);

    public function updatePosition($id, StoreAndUpdatePositionApiRequest $request);

    public function deletePosition($id);

    public function getPositionById($id);

    public function getEmployeeById($id);

    public function updateEmployee(StoreAndUpdateEmployeeApiRequest $request, $id);
}