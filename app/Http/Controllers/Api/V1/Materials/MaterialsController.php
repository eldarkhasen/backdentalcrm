<?php


namespace App\Http\Controllers\Api\V1\Materials;


use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\Api\V1\Materials\MaterialRequest;
use App\Http\Resources\MaterialResource;
use App\Http\Resources\MaterialRestResource;
use App\Services\v1\MaterialsService;

class MaterialsController extends ApiBaseController
{
    protected $service;

    public function __construct(MaterialsService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->successResponse(
            MaterialResource::collection(
                $this->service->getAllMaterials()
            )
        );
    }

    public function show($id)
    {
        return $this->successResponse(
            new MaterialResource(
                $this->service->getMaterialById($id)
            )
        );
    }

    public function store(MaterialRequest $request)
    {
        return $this->successResponse(
            new MaterialResource(
                $this->service->storeMaterial($request)
            )
        );
    }

    public function update(MaterialRequest $request, $id)
    {
        return $this->successResponse(
            new MaterialResource(
                $this->service->updateMaterial($request, $id)
            )
        );
    }

    public function destroy($id)
    {
        $this->service->deleteMaterial($id);
        return $this->successResponse("OK");
    }
}