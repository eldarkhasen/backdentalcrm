<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\WebBaseController;
use App\Http\Resources\OrganizationResource;
use App\Models\Core\Organization;
use App\Models\Management\SubscriptionType;
use App\Models\Role;
use App\Models\Support\City;
use App\Services\v1\OrganizationLogic\OrganizationService;
use Illuminate\Http\Request;

class OrganizationController extends WebBaseController
{
    protected $organizationService;

    /**
     * OrganizationController constructor.
     * @param OrganizationService $service
     */
    public function __construct(OrganizationService $service)
    {
        $this->organizationService = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $organizations = OrganizationResource::collection(
            $this->organizationService->getAllOrganizations(['city'])
        )->resolve();

        return view('web.organizations.index', compact('organizations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::with('country')->get();
        $subscriptionTypes = SubscriptionType::all();
        return view('web.organizations.create', compact(['cities','subscriptionTypes']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->organizationService->storeOrganization($request);
        $this->added();
        return redirect()->route('organizations.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Core\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $organization = Organization::with(['subscriptions','city','currentSubscription'])->findOrFail($id);
        $subscriptionTypes = SubscriptionType::all();
        $to = \Carbon\Carbon::now();
        $from = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $organization->currentSubscription->end_date);
        $diff_in_days = $to->diffInDays($from);
        $percentage = ($diff_in_days/$organization->currentSubscription->subscriptionType->expiration_days)*100;
        $sum = 0;
        $roles = Role::where('id','!=',Role::ADMIN_ID)->get();
        foreach ($organization->subscriptions as $subscription) {
            $sum+=$subscription->actual_price;
        }
        return view('web.organizations.show',compact(['organization','subscriptionTypes','diff_in_days','percentage','sum','roles']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Core\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cities = City::with('country')->get();
        $organization = Organization::with(['city', 'currentSubscription'])->findOrFail($id);
        $subscriptionTypes = SubscriptionType::all();

        return view('web.organizations.edit', compact(['cities','organization', 'subscriptionTypes']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Core\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->organizationService->updateOrganization($id, $request);
        $this->edited();
        return redirect()->route('organizations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Core\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->organizationService->deleteOrganization($id);
        $this->deleted();
        return redirect()->route('organizations.index');
    }

    public function addSubscription(Request $request){
        $id = $request->get('organization_id');
        $this->organizationService->addSubscription($id,$request);
        $this->edited();
        return redirect()->route('organizations.show',$id);
    }

    public function addEmployee(Request $request){

        $id = $request->get('organization_id');
        $this->organizationService->addEmployee($id,$request);
        $this->edited();
        return redirect()->route('organizations.show',$id);
    }
}
