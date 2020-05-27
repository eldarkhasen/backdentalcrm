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
use Illuminate\Http\Request;

class OrganizationServiceImpl implements OrganizationService

{
    public function getCurrentSubscriptionType($org_id)
    {
        $organization = Organization::with('subscriptions')->findOrFail($org_id);
        return $organization->getCurrentSubscription();
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

    public function getCurrentSubscription($org_id)
    {
        // TODO: Implement getCurrentSubscription() method.
    }

    public function getCurrentSubscriptionOfOrganization($org_id)
    {
        // TODO: Implement getCurrentSubscriptionOfOrganization() method.
    }
}