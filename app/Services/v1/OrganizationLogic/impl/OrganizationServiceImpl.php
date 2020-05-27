<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 25.05.2020
 * Time: 13:08
 */

namespace App\Services\v1\OrganizationLogic\impl;


use App\Models\Core\Organization;
use App\Models\Management\Subscription;
use App\Services\v1\OrganizationLogic\OrganizationService;
use App\Services\v1\SubscriptionLogic\SubscriptionService;
use Carbon\Carbon;
use function foo\func;
use Illuminate\Http\Request;

class OrganizationServiceImpl implements OrganizationService

{
    public function getCurrentSubscription($org_id)
    {
        $carbon = Carbon::now();
        $subscription = Organization::with(['subscriptions' => function ($q) use ($carbon) {
            $q->whereDate('start_date', '<=', $carbon)
                ->whereDate('end_date', '>=', $carbon);
        }, 'subscriptions.subscriptionType'])
            ->findOrFail($org_id);
        return $subscription;

//        return $organization->getCurrentSubscription();
    }

    public function getAllOrganizations(Request $request)
    {
        return Organization::with('subscriptions')->all();
    }

    public function getOrganizationById($org_id)
    {
        $organization = Organization::with('subscriptions')->findOrFail($org_id);
        return $organization;
    }

    public function storeOrganization(Request $request)
    {
        return Organization::create($request->all());
    }

    public function updateOrganization($org_id, Request $request)
    {
        $organization = Organization::findOrFail($org_id);
        $input = $request->only([
            'name',
            'address',
            'phone',
            'city_id']);
        return $organization->update($input);
    }
}