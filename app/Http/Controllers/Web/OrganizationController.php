<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\v1\OrganizationLogic\OrganizationService;
use Illuminate\Http\Request;

class OrganizationController extends Controller
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

    public function index(Request $request)
    {
        $perPage = $request->get('perPage',10);
        $search_key = $request->has('search') ? $request->get('search') : null;
        $organizations = isset($search_key)
            ? $this->organizationService->searchPaginatedOrganizations($search_key, $perPage)
            : $this->organizationService->getAllPaginatedOrganizations($perPage);

        return view('web.organizations.index', compact('organizations'));
    }

    public function create()
    {
        return view('web.organizations.create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
