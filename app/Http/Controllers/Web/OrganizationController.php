<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\WebBaseController;
use App\Http\Resources\OrganizationResource;
use App\Models\Core\Organization;
use App\Models\Support\City;
use App\Models\Support\Country;
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
        return view('web.organizations.create', compact('cities'));
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
        Organization::create([
            'name'=>$request->name,
            'phone'=>$request->phone,
            'address'=>$request->address,
            'city_id'=>$request->city
        ]);
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
        dd('check');
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
        $organization = Organization::with('city')->findOrFail($id);
        return view('web.organizations.edit', compact(['cities','organization']));
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
}
