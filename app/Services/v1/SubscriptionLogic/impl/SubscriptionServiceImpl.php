<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 25.05.2020
 * Time: 13:08
 */

namespace App\Services\v1\SubscriptionLogic\impl;



use App\Models\Core\Organization;
use App\Models\Management\Subscription;
use App\Services\v1\SubscriptionLogic\SubscriptionService;
use Illuminate\Http\Request;

class SubscriptionServiceImpl implements SubscriptionService
{
    public function storeSubscription(Request $request)
    {
        return Subscription::create($request->all());
    }



    public function updateSubscription($id, Request $request)
    {
        $organization = Organization::findOrFail($id);
        $input = $request->only([
            'actual_price',
            'start_date',
            'end_date',
            'subscription_type_id',
            'organization_id',]);

        return $organization->update($input);

    }


}