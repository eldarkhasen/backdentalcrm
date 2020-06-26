<?php


namespace App\Http\Controllers\Api\V1\Materials;


use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\Api\V1\Materials\MaterialDeliveryRequest;
use App\Http\Requests\Api\V1\Materials\MaterialRestRequest;
use App\Http\Requests\Api\V1\Materials\MaterialUsageRequest;
use App\Http\Resources\MaterialDeliveryResource;
use App\Http\Resources\MaterialRestResource;
use App\Http\Resources\MaterialUsageResource;
use App\Http\Resources\PaginationResource;
use App\Services\v1\impl\MaterialsServiceImpl;
use Illuminate\Http\Request;

class MaterialRestsController extends ApiBaseController
{
    protected $service;

    public function __construct(MaterialsServiceImpl $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->successResponse(
            MaterialRestResource::collection(
                $this->service->getCurrentOrgMaterialRests()
            )
        );
    }

    public function store(MaterialRestRequest $request)
    {
        return $this->successResponse(
            new MaterialRestResource(
                $this->service->storeMaterialRest($request)
            )
        );
    }

    public function update(MaterialRestRequest $request, $id)
    {
        return $this->successResponse(
            new MaterialRestResource(
                $this->service->updateMaterialRest($request, $id)
            )
        );
    }

    public function getDeliveries()
    {
        $items = $this->service->getCurrentOrgMaterialDeliveries();

        return $this->successResponse(
            new PaginationResource(
                $items,
                MaterialDeliveryResource::collection($items)
            )
        );
    }

    public function storeDelivery(MaterialDeliveryRequest $request)
    {
        return $this->successResponse(
            new MaterialRestResource(
                $this->service->storeMaterialDelivery($request)
            )
        );
    }

    public function updateDelivery(MaterialDeliveryRequest $request, $id)
    {
        return $this->successResponse(
            new MaterialRestResource(
                $this->service->updateMaterialDelivery($request, $id)
            )
        );
    }

    public function deleteDelivery($id)
    {
        return $this->successResponse(
            new MaterialRestResource(
                $this->service->deleteMaterialDelivery($id)
            )
        );
    }

    public function getUsages(Request $request)
    {
        $items = $this->service->getCurrentOrgMaterialUsages($request);

        return $this->successResponse(
            new PaginationResource(
                $items,
                MaterialUsageResource::collection($items)
            )
        );
    }

    public function storeUsage(MaterialUsageRequest $request)
    {
        return $this->successResponse(
            new MaterialRestResource(
                $this->service->storeMaterialUsage($request)
            )
        );
    }

    public function updateUsage(MaterialUsageRequest $request, $id)
    {
        return $this->successResponse(
            new MaterialRestResource(
                $this->service->updateMaterialUsage($request, $id)
            )
        );
    }

    public function deleteUsage($id)
    {
        return $this->successResponse(
            new MaterialRestResource(
                $this->service->deleteMaterialUsage($id)
            )
        );
    }
}