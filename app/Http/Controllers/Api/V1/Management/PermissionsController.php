<?php

namespace App\Http\Controllers\Api\V1\Management;

use App\Http\Controllers\ApiBaseController;
use App\Http\Controllers\Controller;
use App\Services\v1\PermissionsService;
use Illuminate\Http\Request;

class PermissionsController extends ApiBaseController
{
    protected $permissionService;

    /**
     * PermissionsController constructor.
     * @param $permissionService
     */
    public function __construct(PermissionsService $permissionService)
    {
        $this->permissionService = $permissionService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getPermissionsByUserId($user_id)
    {
        return $this->successResponse($this->permissionService->getUsersPermissions($user_id));
    }

    public function getAllPermissions()
    {
        return $this->successResponse($this->permissionService->getAllPermissions());
    }
}
