<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 25.05.2020
 * Time: 13:08
 */

namespace App\Services\v1\SubscriptionLogic\impl;


use App\Models\Management\SubscriptionType;
use App\Services\v1\SubscriptionLogic\SubscriptionTypeService;
use Illuminate\Http\Request;

class SubscriptionTypeServiceImpl implements SubscriptionTypeService
{

    public function getSubscriptionTypes(Request $request)
    {
        return SubscriptionType::all();
    }

    public function storeSubscriptionType(Request $request)
    {
        return SubscriptionType::create($request->all());
    }

    public function updateSubscriptionType($id, Request $request)
    {
        $subcrType = SubscriptionType::findOrFail($id);
        $input = $request->only(['name','price','expiration_days','employees_count']);
        return $subcrType->update($input);
    }
}