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
use App\Models\Settings\Service;
use App\Models\Settings\ServiceCategory;
use App\Services\v1\ServicesService;
use Illuminate\Http\Request;

class ServicesServiceImpl implements ServicesService
{


    public function getAllServices($currentUser,$perPage)
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
        return Service::where('organization_id',$org_id)->with('category')->paginate($perPage);
    }

    public function getAllServicesByCategory($currentUser,$category_id,$perPage)
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
        return Service::where('category_id',$category_id)->where('organization_id',$org_id)->with('category')->paginate($perPage);
    }

    public function getServiceCategories($currentUser)
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
        return ServiceCategory::where('organization_id',$org_id)->get();
    }

    public function searchServices($currentUser,$search_key,$perPage)
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
        return Service::where('organization_id',$org_id)
            ->where('name', 'LIKE', '%'.$search_key.'%')
            ->orWhere('description', 'LIKE', '%'.$search_key.'%')
            ->with('category')
            ->paginate($perPage);
    }

    public function searchByCategories($currentUser,$category_id, $search_key,$perPage)
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
        return Service::where('category_id',$category_id)
            ->where('organization_id',$org_id)
            ->where('name', 'LIKE', '%'.$search_key.'%')
            ->with('category')
            ->paginate($perPage);
    }

    public function getServiceById($id){
        return Service::with('category')->find($id);
    }

    public function deleteCategory($id){
        $category = ServiceCategory::findOrFail($id);
        if(count($category->services)>0){
            throw new ApiServiceException(400, false,
                ['message' => 'Нельзя удалить данную категорию',
                    'errorCode' => ErrorCode::NOT_ALLOWED]);
        }
        return ServiceCategory::destroy($id);
    }

    public function storeServiceCategory($currentUser, $request)
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
        return ServiceCategory::create([
            'name'=>$request->name,
            'organization_id'=>$org_id
        ]);
    }

    public function storeService($currentUser, $request)
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

        return Service::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'duration'=>$request->duration,
            'price'=>$request->price,
            'max_price'=>$request->max_price,
            'category_id'=>$request->category_id,
            'organization_id'=>$org_id
        ]);

    }

    public function updateServiceCategory($currentUser, $request, $id)
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
        $category = ServiceCategory::findOrFail($id);
        return $category->update($request->all());
    }

    public function updateService($currentUser, $request, $id)
    {
        // TODO: Implement updateService() method.
    }

    public function getAllServicesArray($currentUser, $except_id=null)
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
        if($except_id){
            return Service::where('organization_id',$org_id)->with(['category'])->except($except_id)->get();
        }else{
            return Service::where('organization_id',$org_id)->with(['category'])->get();
        }

    }
}