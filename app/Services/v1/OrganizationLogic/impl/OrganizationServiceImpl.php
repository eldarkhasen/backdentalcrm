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
use App\Models\Permission;
use App\Models\Settings\Employee;
use App\Models\User;
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
        $organization = Organization::create([
            'name'=>$request->name,
            'phone'=>$request->phone,
            'address'=>$request->address,
            'city_id'=>$request->city,
            'email'=>$request->email
        ]);
        $subscription_type = SubscriptionType::findOrFail($request->get('subscription_type_id'));
        $organization->subscriptions()->save(new Subscription([
            'subscription_type_id' => $request->get('subscription_type_id'),
            'actual_price' => $request->get('actual_price'),
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addDay(intval($subscription_type->expiration_days)),
        ]));

        return $organization;
    }

    public function updateOrganization($org_id, Request $request)
    {
        $organization = Organization::with('currentSubscription')->findOrFail($org_id);
        $input = $request->only([
            'name',
            'address',
            'phone',
            'city_id',
            'deleted',
            'email']);


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


    public function addSubscription($org_id, Request $request)
    {
        $organization = Organization::with('currentSubscription')->findOrFail($org_id);
        $subscription_type = SubscriptionType::findOrFail($request->get('subscription_type_id'));
        if(isset($organization->currentSubscription)) {
            if ($organization->currentSubscription->end_date >= Carbon::now()) {
                $organization->subscriptions()->save(new Subscription([
                    'subscription_type_id' => $request->get('subscription_type_id'),
                    'actual_price' => $request->get('actual_price'),
                    'start_date' => $organization->currentSubscription->end_date,
                    'end_date' => Carbon::createFromFormat('Y-m-d H:s:i', $organization->currentSubscription->end_date)->addDay(intval($subscription_type->expiration_days)),
                ]));
            } else {
                $organization->subscriptions()->save(new Subscription([
                    'subscription_type_id' => $request->get('subscription_type_id'),
                    'actual_price' => $request->get('actual_price'),
                    'start_date' => Carbon::now(),
                    'end_date' => Carbon::now()->addDay(intval($subscription_type->expiration_days)),
                ]));
            }
        }else{
            $organization->subscriptions()->save(new Subscription([
                'subscription_type_id' => $request->get('subscription_type_id'),
                'actual_price' => $request->get('actual_price'),
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addDay(intval($subscription_type->expiration_days)),
            ]));
        }
    }

    public function addEmployee($org_id, Request $request)
    {
        $organization = Organization::with('currentSubscription')->findOrFail($org_id);
        DB::beginTransaction();
        try{
            $employee = Employee::create([
                "name" => $request->name,
                "surname" => $request->surname,
                "patronymic" => $request->patronymic,
                'phone' => $request->phone,
                'birth_date' => $request->birth_date,
                'gender' => $request->gender,
                'color' => "#228B22",
                'organization_id' => $request->organization_id
            ]);
            $user = User::create([
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role_id' => $request->role_id
            ]);
            $permissions = Permission::all();
            $user->permissions()->attach($permissions);
            $user->employee()->save($employee);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
}
