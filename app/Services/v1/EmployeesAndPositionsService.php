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
    public function getEmployees($perPage);
    public function getPositions();
    public function searchEmployee($search_key,$perPage);
    public function getEmployeeByPosition($position,$perPage);
    public function searchEmployeeByPosition($search_key,$position,$perPage);
    public function searchPosition($search_key);
    public function storeEmployee(StoreAndUpdateEmployeeApiRequest $request);
    public function storePosition(StoreAndUpdatePositionApiRequest $request);
    public function updatePosition($id, StoreAndUpdatePositionApiRequest $request);
    public function deletePosition($id);
    public function getPositionById($id);
    public function getEmployeeById($id);
    public function updateEmployee(StoreAndUpdateEmployeeApiRequest $request, $id);
}