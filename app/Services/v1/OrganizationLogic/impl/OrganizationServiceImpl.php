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
use App\Models\Management\SubscriptionType;
use App\Services\v1\OrganizationLogic\OrganizationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrganizationServiceImpl implements OrganizationService

{
    public function getCurrentSubscriptionType($org_id)
    {
        $organization = Organization::with('subscriptions')->findOrFail($org_id);
        return $organization->getCurrentSubscription();
    }

    public function getAllPaginatedOrganizations($perPage)
    {
        return Organization::paginate($perPage);
    }

    public function getAllOrganizations($withRelations = [])
    {
        return Organization::with($withRelations)->get();
    }

    public function getAllOrganizationsArray()
    {
        return Organization::all();
    }

    public function searchPaginatedOrganizations($search_key, $perPage)
    {
        return Organization::search($search_key)
            ->paginate($perPage);
    }

    public function searchOrganizationsArray($search_key)
    {
        return Organization::search($search_key)->get();
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
            'city_id',
            'deleted',
            'email']);

        $subscription_type = SubscriptionType::findOrFail($request->get('subscription_type_id'));

        $organization->subscriptions()->save(new Subscription([
            'subscription_type_id' => $request->get('subscription_type_id'),
            'actual_price' => $request->get('actual_price'),
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addDay(intval($subscription_type->expiration_days)),
        ]));

        return $organization->update($input);
    }

    //TODO FIX TIME_ZONE ISSUE
    public function getCurrentSubscriptionOfOrganization($org_id)
    {
        $carbon = Carbon::now();
        return DB::table('subscriptions as sub')
            ->leftJoin('subscription_types as st', 'st.id', '=', 'sub.subscription_type_id')
            ->where(function ($query) use ($carbon) {
                $query->where(function ($query) use ($carbon) {
                    $query->whereDate('sub.start_date', '<=', $carbon)
                        ->whereDate('sub.end_date', '>=', $carbon);
                });
                $query->orWhere('st.expiration_days', '=', DB::raw(0));
            })
            ->where('sub.organization_id', '=', $org_id)
            ->first();
    }

    public function deleteOrganization($org_id)
    {
        return Organization::findOrFail($org_id)->makeDeleted();
    }
}
