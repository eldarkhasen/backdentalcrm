<?php
/**
 * Created by PhpStorm.
 * User: eldarkhasen
 * Date: 5/1/20
 * Time: 14:36
 */

namespace App\Services\v1\impl;


use App\Models\Settings\Service;
use App\Models\Settings\ServiceCategory;
use App\Services\v1\ServicesService;

class ServicesServiceImpl implements ServicesService
{


    public function getAllServices()
    {
        return Service::with('category')->paginate(10);
    }

    public function getAllServicesByCategory($category_id)
    {
        return Service::where('category_id',$category_id)->with('category')->paginate(10);
    }

    public function getServiceCategories()
    {
        return ServiceCategory::all();
    }

    public function searchServices($search_key)
    {
        return Service::where('name', 'LIKE', '%'.$search_key.'%')
            ->orWhere('description', 'LIKE', '%'.$search_key.'%')
            ->with('category')
            ->paginate(10);
    }

    public function searchByCategories($category_id, $search_key)
    {
        return Service::where('category_id',$category_id)->where('name', 'LIKE', '%'.$search_key.'%')->with('category')
            ->paginate(10);
    }

    public function getServiceById($id){
        return Service::with('category')->find($id);
    }
}