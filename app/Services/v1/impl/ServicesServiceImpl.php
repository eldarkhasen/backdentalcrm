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


    public function getAllServices($perPage)
    {
        return Service::with('category')->paginate($perPage);
    }

    public function getAllServicesByCategory($category_id,$perPage)
    {
        return Service::where('category_id',$category_id)->with('category')->paginate($perPage);
    }

    public function getServiceCategories()
    {
        return ServiceCategory::all();
    }

    public function searchServices($search_key,$perPage)
    {
        return Service::where('name', 'LIKE', '%'.$search_key.'%')
            ->orWhere('description', 'LIKE', '%'.$search_key.'%')
            ->with('category')
            ->paginate($perPage);
    }

    public function searchByCategories($category_id, $search_key,$perPage)
    {
        return Service::where('category_id',$category_id)->where('name', 'LIKE', '%'.$search_key.'%')->with('category')
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
}